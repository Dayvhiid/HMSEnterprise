<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // Where each role lands after login, and how the role is shown on screen.
    // 'user' is the original clinician role; 'reception' and 'optician' only change the landing page for now.
    public const ROLE_HOMES = [
        'admin' => 'admin.dashboard',
        'reception' => 'pages.register',
        'optician' => 'optician.index',
        'user' => 'doctors.index',
    ];

    public const ROLE_LABELS = [
        'admin' => 'Administrator',
        'reception' => 'Front Desk',
        'optician' => 'Optician',
        'user' => 'Clinician',
    ];

    public function homeRoute(): string
    {
        return self::ROLE_HOMES[$this->role] ?? self::ROLE_HOMES['user'];
    }

    public function roleLabel(): string
    {
        return self::ROLE_LABELS[$this->role] ?? self::ROLE_LABELS['user'];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
