<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'role',
        'is_active',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
            'is_active' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPeternak(): bool
    {
        return $this->role === 'peternak';
    }

    public function isUmum(): bool
    {
        return $this->role === 'umum';
    }

    public function hasRole(string|array ...$roles): bool
    {
        $flattened = [];
        foreach ($roles as $item) {
            if (is_array($item)) {
                $flattened = array_merge($flattened, $item);
            } else {
                $flattened[] = $item;
            }
        }

        return in_array($this->role, $flattened, true);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Admin Dinas Peternakan Jatim',
            'peternak' => 'Peternak Milenial',
            'umum' => 'Masyarakat Umum',
            default => ucfirst((string) $this->role),
        };
    }

    public function peternakProfile(): HasOne
    {
        return $this->hasOne(PeternakProfile::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function emergencyReports(): HasMany
    {
        return $this->hasMany(EmergencyReport::class);
    }

    public function assignedEmergencyReports(): HasMany
    {
        return $this->hasMany(EmergencyReport::class, 'assigned_officer_id');
    }

    public function livestock(): HasMany
    {
        return $this->hasMany(Livestock::class);
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    public function trainingRegistrations(): HasMany
    {
        return $this->hasMany(TrainingRegistration::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function exhibitionRegistrations(): HasMany
    {
        return $this->hasMany(ExhibitionRegistration::class);
    }
}
