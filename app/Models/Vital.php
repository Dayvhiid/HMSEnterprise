<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    use HasFactory;

    // Sections of the vitals form, with the columns (from vitals and vital2s) each one fills in.
    // A section counts as "taken" when any of its columns has a value.
    public const EXAM_SECTIONS = [
        // odaxis / osaxis are Near VA. Old rows hold a copy of the lensometry axis there, so those only count when they differ.
        'Visual Acuity' => ['odunaided', 'odpinhole', 'osunaided', 'ospinhole', 'near_va_od', 'near_va_os'],
        'Lensometry' => ['lodsph', 'lodcyl', 'lodaxis', 'lodva', 'lossph', 'loscyl', 'losaxis', 'losva', 'addsph', 'addcyl', 'addaxis', 'addva'],
        'Auto-Refraction' => ['arodsphere', 'arodcyl', 'arodaxis', 'arossphere', 'aroscyl', 'arosaxis', 'arpd'],
        'Retinoscope' => ['rodsph', 'rodcyl', 'rodaxis', 'rossph', 'roscyl', 'rosaxis'],
        'Subjective Refraction' => ['srodsphere', 'srodcyl', 'srodaxis', 'srodva', 'srodadd', 'srodnva', 'srosphere', 'sroscyl', 'srosaxis', 'srosva', 'srosadd', 'srosnva'],
        'Final RX' => ['fodsph', 'fodcyl', 'fodaxis', 'fodva', 'fodadd', 'fodnva', 'fossph', 'foscyl', 'fosaxis', 'fosva', 'fosadd', 'fosnva'],
        'IOP' => ['odccct', 'odnct', 'oscct', 'osnct', 'iop_taken_at'],
        'External Examination' => ['eyelidod', 'eyelidos', 'conjuctivaod', 'conjuctivaos', 'corneaod', 'corneaos', 'pupilod', 'pupilos', 'irisod', 'irisos', 'lensod', 'lensos'],
        'Internal Examination' => ['vitreousod', 'vitreousos', 'cdratiood', 'cdratioos', 'macularod', 'maculaos'],
    ];

    /**
     * The vital2s row saved together with this visit (left-eye subjective refraction and final RX).
     * Both rows are created in the same request, so they share patient_code and created_at; older rows
     * whose timestamps differ fall back to position: the nth vitals row pairs with the nth vital2 row.
     */
    public function pairedVital2(): ?vital2
    {
        $sameTime = vital2::where('patient_code', $this->patient_code)
            ->where('created_at', $this->created_at)
            ->orderBy('id')
            ->first();
        if ($sameTime) {
            return $sameTime;
        }

        $position = self::where('patient_code', $this->patient_code)->where('id', '<', $this->id)->count();

        return vital2::where('patient_code', $this->patient_code)->orderBy('id')->skip($position)->first();
    }

    /**
     * Which form sections were filled in for this visit.
     * $vital2 is the matching vital2s row saved in the same request (left-eye subjective and final RX).
     *
     * @return array<string, bool>
     */
    public function examSectionsTaken(?Model $vital2 = null): array
    {
        $values = array_merge($vital2?->getAttributes() ?? [], $this->getAttributes());
        $values['near_va_od'] = $this->odaxis !== $this->lodaxis ? $this->odaxis : null;
        $values['near_va_os'] = $this->osaxis !== $this->losaxis ? $this->osaxis : null;

        $taken = [];
        foreach (self::EXAM_SECTIONS as $section => $columns) {
            $taken[$section] = collect($columns)->contains(fn ($column) => filled($values[$column] ?? null));
        }

        return $taken;
    }
    protected $fillable = [
        'patient_code',
        'cc',
        'pohx',
        'lee',
        'pmhx',
        'pfohx',
        'odunaided',
        'odpinhole',
        'odaxis',
        'osunaided',
        'ospinhole',
        'osaxis',
        'lodsph',
        'lodcyl',
        'lodaxis',
        'lodva',
        'lossph',
        'loscyl',
        'losaxis',
        'losva',
        'addsph',
        'addcyl',
        'addaxis',
        'addva',
        'arodsphere',
        'arodcyl',
        'arodaxis',
        'arossphere',
        'aroscyl',
        'arosaxis',
        'arpd',
        'rodsph',
        'rodcyl',
        'rodaxis',
        'rossph',
        'roscyl',
        'rosaxis',
        'srodsphere',
        'srodcyl',
        'srodaxis',
        'srodva',
        'srodadd',
        'srodnva',
        'srossphere',
        'sroscyl',
        'srosaxis',
        'srosva',
        'srosadd',
        'srosnva',
        'fodsph',
        'fodcyl',
        'fodaxis',
        'fodva',
        'fodadd',
        'fodnva',
        'fossph',
        'foscyl',
        'fosaxis',
        'fosva',
        'fosadd',
        'fosnva',
        'eyelidod',
        'eyelidos',
        'conjuctivaod',
        'conjuctivaos',
        'corneaod',
        'corneaos',
        'pupilod',
        'pupilos',
        'irisod',
        'irisos',
        'lensod',
        'lensos',
        'vitreousod',
        'vitreousos',
        'cdratiood',
        'cdratioos',
        'macularod',
        'maculaos',
        'odccct',
        'odnct',
        'oscct',
        'osnct',
        'iop_taken_at',
    ];

    protected $casts = [
        'iop_taken_at' => 'datetime',
    ];
}
