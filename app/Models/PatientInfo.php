<?php

namespace App\Models;

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
}
