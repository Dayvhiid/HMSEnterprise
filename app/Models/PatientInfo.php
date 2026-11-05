<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientInfo extends Model
{

    use Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'occupation',
        'phone',
        'email',
        'street',
        'state',
        'emergency_phone',
        'emergency_fullname',
        'patient_id',
        'fullname',
        'datee',
        'age',
        'summary',
        'summary_updated_by',
        'summary_updated_at',
    ];

    protected $casts = [
        'summary_updated_at' => 'datetime',
    ];

    /**
     * Patients matching what staff type: every word must match a name field (so "ada obi" finds Ada Obi);
     * the patient ID matches as typed; phone numbers match on their digits (4 or more).
     * Shared by the top-bar search and the Patients list so both always find the same people.
     */
    public function scopeMatching(Builder $query, string $text): Builder
    {
        $text = trim($text);
        $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        $digits = preg_replace('/\D+/', '', $text);

        return $query->where(function (Builder $q) use ($text, $words, $digits) {
            $q->where('patient_id', 'LIKE', "%{$text}%")
                ->orWhere(function (Builder $names) use ($words) {
                    foreach ($words as $word) {
                        $names->where(function (Builder $w) use ($word) {
                            $w->where('first_name', 'LIKE', "%{$word}%")
                                ->orWhere('last_name', 'LIKE', "%{$word}%")
                                ->orWhere('fullname', 'LIKE', "%{$word}%");
                        });
                    }
                });

            if (strlen($digits) >= 4) {
                // Phones are stored as typed ("0803 555 1234"), so ignore spaces and dashes when comparing.
                $q->orWhereRaw("REPLACE(REPLACE(phone, ' ', ''), '-', '') LIKE ?", ["%{$digits}%"]);
            }
        });
    }

    /** First and last name, or the older single fullname field when those are empty. */
    public function displayName(): string
    {
        $name = trim(($this->first_name ?? '').' '.($this->last_name ?? ''));

        return $name !== '' ? $name : (string) $this->fullname;
    }
}
