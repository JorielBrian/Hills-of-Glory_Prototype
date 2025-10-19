<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use App\Enums\MemberEnums\Gender;
use App\Enums\MemberEnums\Status;
use App\Enums\MemberEnums\MemberRole;
use App\Enums\MemberEnums\HillsJourney;
use App\Enums\MemberEnums\Ministry;
use App\Enums\MemberEnums\MinistryRole;

class Member extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'gender',
        'birth_date',
        'address',
        'contact',
        'status',
        'invited_by',
        'member_photo',
        'member_role',
        'hills_journey',
        'ministry',
        'ministry_role',
        'ministry_assignment',
        'life_group_id',
        'network_leader_id',
        'is_active'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active' => 'boolean',
        'gender' => Gender::class,
        'status' => Status::class,
        'member_role' => MemberRole::class,
        'hills_journey' => HillsJourney::class,
        'ministry' => Ministry::class,
        'ministry_role' => MinistryRole::class,
    ];

    protected $appends = ['full_name', 'member_photo_url'];

    public function lifeGroup(): BelongsTo
    {
        return $this->belongsTo(LifeGroup::class, 'life_group_id');
    }

    public function networkLeader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'network_leader_id');
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    public function getMemberPhotoUrlAttribute(): ?string
    {
        if (!$this->member_photo) {
            return null;
        }

        return Storage::url($this->member_photo);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByLifeGroup($query, $lifeGroupId)
    {
        return $query->where('life_group_id', $lifeGroupId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
