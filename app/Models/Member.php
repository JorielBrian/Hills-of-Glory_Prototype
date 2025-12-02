<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Enums\MemberEnums\Gender;
use App\Enums\MemberEnums\MemberRole;
use App\Enums\MemberEnums\HillsJourney;
use App\Enums\MemberEnums\MemberType;
use App\Enums\MemberEnums\Ministry;
use App\Enums\MemberEnums\MinistryRole;
use App\Enums\EventsEnums\Event;

class Member extends Model
{
    // fillables are changable inputs: mga pwedeng baguhin ng user or mga initial inputs
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'birth_date',
        'address',
        'contact',
        'email',
        'member_type',
        'is_married',
        'invited_by',
        'date_invited',
        'service_invited',
        'facebook_account',
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

    // Data type conversion - automatically converts field values to specific data types; same siya ng casting
    protected $casts = [
        'birth_date' => 'date',
        'date_invited' => 'date',
        'is_active' => 'boolean',
        'is_married' => 'boolean',
        'gender' => Gender::class,
        'member_type' => MemberType::class,
        'member_role' => MemberRole::class,
        'hills_journey' => HillsJourney::class,
        'ministry' => Ministry::class,
        'ministry_role' => MinistryRole::class,
        'service_invited' => Event::class,
    ];

    // these fields don't exist in database, but are added when converting model to array/JSON
    protected $appends = [
        'full_name',
        'member_photo_url',
        'age'
    ];

    // RELATIONSHIPS
    public function lifeGroup(): BelongsTo
    {
        return $this->belongsTo(LifeGroup::class, 'life_group_id');
    }

    public function networkLeader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'network_leader_id');
    }

    // FROM $appends
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}"); // merging  first_name, middle_name, and last_name to be full_name
    }

    public function getMemberPhotoUrlAttribute(): ?string
    {
        if (!$this->member_photo) {
            return null;
        }

        return Storage::url($this->member_photo);
    }

    /**
     * Calculate age based on birth date
     * This will automatically update as time passes
     */
    public function getAgeAttribute(): int
    {
        return Carbon::parse($this->birth_date)->age;
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

    public function scopeByMemberType($query, $memberType)
    {
        return $query->where('member_type', $memberType);
    }
}
