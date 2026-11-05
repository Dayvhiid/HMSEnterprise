<?php

namespace App\Http\Controllers;

use App\Models\PatientInfo;
use App\Support\Modules;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Universal search from the top bar: finds patients (by name, patient ID or phone)
 * and screens (by name). Returns JSON for the type-ahead, or a results page.
 */
class GlobalSearchController extends Controller
{
    private const MIN_LENGTH = 2;

    public function __invoke(Request $request)
    {
        $query = trim((string) $request->query('q', ''));
        $tooShort = mb_strlen($query) < self::MIN_LENGTH;
        $limit = $request->wantsJson() ? 8 : 50;

        $patients = $tooShort ? collect() : $this->patients($query, $limit);
        $actions = $tooShort ? [] : Modules::matchActions($request->user(), $query);

        if ($request->wantsJson()) {
            return response()->json([
                'patients' => $patients->map(fn (PatientInfo $p) => [
                    'name' => $this->displayName($p),
                    'patient_id' => $p->patient_id,
                    'gender' => $p->gender,
                    'phone' => $p->phone,
                    'url' => route('patient.show', $p->id),
                ])->values(),
                'actions' => array_map(fn (array $a) => [
                    'label' => $a['label'],
                    'url' => route($a['route']),
                ], $actions),
            ]);
        }

        return view('search.results', [
            'query' => $query,
            'tooShort' => $tooShort,
            'minLength' => self::MIN_LENGTH,
            'patients' => $patients,
            'actions' => $actions,
            'limit' => $limit,
            'displayName' => fn (PatientInfo $p) => $this->displayName($p),
        ]);
    }

    /** See PatientInfo::scopeMatching for how names, IDs and phone numbers match. */
    private function patients(string $query, int $limit)
    {
        return PatientInfo::query()->matching($query)
            // An exact patient ID always comes first, so "1/11/2026" isn't pushed out by 11/11/2026, 21/11/2026 ...
            ->orderByRaw('CASE WHEN patient_id = ? THEN 0 ELSE 1 END', [trim($query)])
            ->orderByDesc('updated_at')
            ->limit($limit)
            ->get();
    }

    private function displayName(PatientInfo $patient): string
    {
        return $patient->displayName();
    }
}
