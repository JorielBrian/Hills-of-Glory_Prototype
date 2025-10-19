<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use App\Enums\MemberEnums\CoreRole;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'gender',
        'email',
        'core_role',
        'is_admin',
        'profile_photo',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'core_role' => CoreRole::class,
        'is_admin' => 'boolean',
    ];

    public function initials()
    {
        $firstInitial = substr($this->first_name, 0, 1);
        $lastInitial = substr($this->last_name, 0, 1);
        return strtoupper($firstInitial . $lastInitial);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    public function getProfilePhotoUrlAttribute()
    {
        if (!$this->profile_photo) {
            return null;
        }

        // If it's already a full URL, return as is
        if (filter_var($this->profile_photo, FILTER_VALIDATE_URL)) {
            return $this->profile_photo;
        }

        // If it's a storage path, convert to URL
        return Storage::url($this->profile_photo);
    }

    public function ledLifeGroups(): HasMany
    {
        return $this->hasMany(LifeGroup::class, 'network_leader_id');
    }

    public function memberProfile(): HasOne
    {
        return $this->hasOne(Member::class, 'user_id');
    }

    public function getIsNetworkLeaderAttribute(): bool
    {
        return $this->ledLifeGroups()->exists();
    }

    // Check if user is admin
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    // Scopes
    public function scopeNetworkLeaders($query)
    {
        return $query->whereHas('ledLifeGroups');
    }

    // Scope for admin users
    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true);
    }
}
