<?php

namespace App\Support;

use App\Models\Notification;
use App\Models\PatientInfo;
use App\Models\Treat;
use App\Models\Vital;
use Carbon\Carbon;
use Carbon\CarbonInterface;

/**
 * Read-only facts about one patient for the chart layout: the banner (who this is) and the
 * context panel (what you must not forget while working). Built once per request and passed
 * to the patient-banner / patient-context components.
 */
class PatientChart
{
    private ?array $latestVisit = null;
    private bool $latestVisitLoaded = false;

    public function __construct(public readonly PatientInfo $patient)
    {
    }

    public static function for(PatientInfo $patient): self
    {
        return new self($patient);
    }

    /** Looks the patient up by their clinic patient ID (e.g. "413/07/2026"); null when unknown. */
    public static function forPatientId(?string $patientId): ?self
    {
        if (blank($patientId)) {
            return null;
        }

        $patient = PatientInfo::where('patient_id', $patientId)->first();

        return $patient ? new self($patient) : null;
    }

    public function name(): string
    {
        $name = trim(($this->patient->first_name ?? '').' '.($this->patient->last_name ?? ''));

        return $name !== '' ? $name : (string) $this->patient->fullname;
    }

    /** Date of birth from registration, or null when missing or not a real date. */
    public function dateOfBirth(): ?CarbonInterface
    {
        $raw = $this->patient->date;
        if (blank($raw)) {
            return null;
        }

        try {
            $dob = Carbon::parse($raw);
        } catch (\Throwable) {
            return null;
        }

        return $dob->isFuture() ? null : $dob;
    }

    /** Age worked out from the date of birth; falls back to the age typed on the edit form. */
    public function age(): ?string
    {
        if ($dob = $this->dateOfBirth()) {
            return $dob->age.'y';
        }

        $typed = trim((string) $this->patient->age);

        return $typed !== '' ? $typed : null;
    }

    public function sex(): ?string
    {
        $gender = trim((string) $this->patient->gender);

        return $gender !== '' ? ucfirst(strtolower($gender)) : null;
    }

    /** When today's check-in was recorded, or null if the patient has not been checked in today. */
    public function checkedInToday(): ?CarbonInterface
    {
        $at = Notification::where('pid', $this->patient->patient_id)
            ->where('message', Notification::RETURNING_PATIENT)
            ->whereDate('created_at', today())
            ->latest()
            ->value('created_at');

        return $at ? Carbon::parse($at) : null;
    }

    public function counts(): array
    {
        $vitals = Vital::where('patient_code', $this->patient->patient_id);
        $treatments = Treat::where('patient_id', $this->patient->patient_id);

        return [
            'vitalsCount' => $vitals->count(),
            'latestVital' => $vitals->max('created_at'),
            'treatmentsCount' => $treatments->count(),
            'latestTreatment' => $treatments->max('created_at'),
        ];
    }

    /**
     * The most recent examination: date, final Rx and VA per eye, and IOP.
     * Right-eye values live on the vitals row, left-eye final Rx on its paired vital2s row.
     */
    public function latestVisit(): ?array
    {
        if ($this->latestVisitLoaded) {
            return $this->latestVisit;
        }
        $this->latestVisitLoaded = true;

        $vital = Vital::where('patient_code', $this->patient->patient_id)
            ->orderByDesc('created_at')->orderByDesc('id')->first();
        if (! $vital) {
            return null;
        }
        $left = $vital->pairedVital2();

        $rx = [
            'OD' => $this->rxRow($vital->fodsph, $vital->fodcyl, $vital->fodaxis, $vital->fodadd, $vital->fodva),
            'OS' => $this->rxRow($left?->fossph, $left?->foscyl, $left?->fosaxis, $left?->fosadd, $left?->fosva),
        ];
        $iop = [
            'OD' => $this->firstFilled($vital->odnct, $vital->odccct),
            'OS' => $this->firstFilled($vital->osnct, $vital->oscct),
        ];

        return $this->latestVisit = [
            'date' => $vital->created_at,
            'complaint' => filled($vital->cc) ? (string) $vital->cc : null,
            'va' => [
                'OD' => $this->firstFilled($vital->odunaided),
                'OS' => $this->firstFilled($vital->osunaided),
            ],
            'rx' => array_filter($rx) ? $rx : null,
            'iop' => array_filter($iop) ? $iop : null,
            'iopTakenAt' => $vital->iop_taken_at,
        ];
    }

    public function latestTreatment(): ?Treat
    {
        return Treat::where('patient_id', $this->patient->patient_id)
            ->orderByDesc('created_at')->orderByDesc('id')->first();
    }

    private function rxRow(...$values): ?array
    {
        [$sph, $cyl, $axis, $add, $va] = array_map(fn ($v) => $this->firstFilled($v), $values);

        return ($sph || $cyl || $axis || $add || $va)
            ? compact('sph', 'cyl', 'axis', 'add', 'va')
            : null;
    }

    private function firstFilled(...$values): ?string
    {
        foreach ($values as $value) {
            if (filled($value)) {
                return trim((string) $value);
            }
        }

        return null;
    }
}
