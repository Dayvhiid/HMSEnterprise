<?php

namespace App\Support;

use App\Models\User;

/**
 * The app's modules and quick actions, in one place.
 *
 * The top bar reads modules() for its links; the universal search reads actions()
 * so staff can jump to a screen by typing its name. Admin-only entries are hidden
 * from everyone else, matching the routes' own 'admin' middleware.
 */
class Modules
{
    /** Links shown in the top bar, in display order. */
    public static function modules(User $user): array
    {
        $links = [
            ['label' => 'Front Desk', 'route' => 'pages.register'],
            ['label' => 'Patients', 'route' => 'public.records'],
            ['label' => 'Clinical', 'route' => 'doctors.index'],
            ['label' => 'Optician', 'route' => 'optician.index'],
            ['label' => 'Billing', 'route' => 'generate.show'],
            ['label' => 'Stock', 'route' => 'admin.admin2'],
        ];

        if ($user->isAdmin()) {
            $links[] = ['label' => 'Admin', 'route' => 'admin.dashboard'];
        }

        return $links;
    }

    /** Screens reachable from the universal search, with extra words people type for them. */
    public static function actions(User $user): array
    {
        $actions = [
            ['label' => 'Register new patient', 'route' => 'pages.register', 'keywords' => 'front desk new patient registration create'],
            ['label' => 'Patient records', 'route' => 'public.records', 'keywords' => 'patients find chart'],
            ['label' => 'Clinical home', 'route' => 'doctors.index', 'keywords' => 'doctor consultation waiting queue'],
            ['label' => 'Vitals search', 'route' => 'search.vitals', 'keywords' => 'vitals va iop visual acuity'],
            ['label' => 'Treatment search', 'route' => 'search.treatment', 'keywords' => 'treatment prescription diagnosis'],
            ['label' => 'Optician', 'route' => 'optician.index', 'keywords' => 'spectacles glasses dispense'],
            ['label' => 'Generate invoice', 'route' => 'generate.show', 'keywords' => 'billing invoice payment receipt'],
            ['label' => 'Stock', 'route' => 'admin.admin2', 'keywords' => 'inventory store'],
            ['label' => 'Drug list', 'route' => 'doctors.list', 'keywords' => 'drugs medication pharmacy'],
            ['label' => 'Frame list', 'route' => 'frame.list', 'keywords' => 'frames spectacles'],
            ['label' => 'Lens list', 'route' => 'lens.list', 'keywords' => 'lenses'],
            ['label' => 'Case-file images', 'route' => 'images.index', 'keywords' => 'images scans photos upload'],
            ['label' => 'Calendar', 'route' => 'calender', 'keywords' => 'appointments schedule bookings'],
        ];

        if ($user->isAdmin()) {
            $actions[] = ['label' => 'Admin dashboard', 'route' => 'admin.dashboard', 'keywords' => 'admin analytics revenue'];
            $actions[] = ['label' => 'Staff', 'route' => 'admin.staff', 'keywords' => 'users accounts staff roles'];
        }

        return $actions;
    }

    /** Actions whose label or keywords contain every word of the query. */
    public static function matchActions(User $user, string $query): array
    {
        $words = preg_split('/\s+/', mb_strtolower(trim($query)), -1, PREG_SPLIT_NO_EMPTY);
        if ($words === []) {
            return [];
        }

        return array_values(array_filter(self::actions($user), function (array $action) use ($words) {
            $haystack = mb_strtolower($action['label'].' '.$action['keywords']);
            foreach ($words as $word) {
                if (! str_contains($haystack, $word)) {
                    return false;
                }
            }

            return true;
        }));
    }
}
