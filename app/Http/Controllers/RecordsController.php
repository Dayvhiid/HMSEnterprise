<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\PatientInfo;
use App\Models\Vital;
use Illuminate\Http\Request;

/**
 * Patients list: search, filter and page through every registered patient.
 * /records and /records/search are the same screen; ?query= is kept for old links.
 */
class RecordsController extends Controller
{
    private const PER_PAGE = 25;

    private const SORTS = [
        'recent' => 'Recently updated',
        'name' => 'Name A–Z',
        'registered' => 'Newest registered',
        'last_exam' => 'Most recent exam',
    ];

    public function index(Request $request)
    {
        $filters = [
            'query' => trim((string) $request->query('query', '')),
            'sex' => in_array($request->query('sex'), ['male', 'female'], true) ? $request->query('sex') : '',
            'checked_in' => $request->boolean('checked_in'),
            'from' => $this->date($request->query('from')),
            'to' => $this->date($request->query('to')),
            'sort' => array_key_exists($request->query('sort'), self::SORTS) ? $request->query('sort') : 'recent',
        ];

        $checkedInToday = Notification::where('message', Notification::RETURNING_PATIENT)
            ->whereDate('created_at', today())
            ->pluck('pid')->unique()->values()->all();

        $patients = PatientInfo::query()
            ->select('patient_infos.*')
            ->addSelect(['last_exam_at' => Vital::select('created_at')
                ->whereColumn('patient_code', 'patient_infos.patient_id')
                ->orderByDesc('created_at')
                ->limit(1)])
            ->when($filters['query'] !== '', fn ($q) => $q->matching($filters['query']))
            ->when($filters['sex'], fn ($q, $sex) => $q->where('gender', 'LIKE', $sex))
            ->when($filters['checked_in'], fn ($q) => $q->whereIn('patient_id', $checkedInToday))
            ->when($filters['from'], fn ($q, $from) => $q->whereDate('created_at', '>=', $from))
            ->when($filters['to'], fn ($q, $to) => $q->whereDate('created_at', '<=', $to))
            ->when($filters['sort'] === 'name', fn ($q) => $q->orderBy('first_name')->orderBy('last_name')->orderBy('fullname'))
            ->when($filters['sort'] === 'registered', fn ($q) => $q->orderByDesc('created_at'))
            ->when($filters['sort'] === 'last_exam', fn ($q) => $q->orderByDesc('last_exam_at'))
            ->when($filters['sort'] === 'recent', fn ($q) => $q->orderByDesc('updated_at'))
            ->orderByDesc('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('records.records', [
            'patients' => $patients,
            'filters' => $filters,
            'sorts' => self::SORTS,
            'checkedInToday' => array_flip($checkedInToday),
            'filtered' => $filters['query'] !== '' || $filters['sex'] || $filters['checked_in'] || $filters['from'] || $filters['to'],
        ]);
    }

    /** Old search URL; same screen. */
    public function search(Request $request)
    {
        return $this->index($request);
    }

    private function date(mixed $value): ?string
    {
        return is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) ? $value : null;
    }
}
