<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class LifeGroup extends Model
{
    protected $fillable = [
        'life_group_name',
        'network_leader_id',
        'life_group_photo',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $appends = ['life_group_photo_url'];

    public function networkLeader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'network_leader_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'life_group_id');
    }

    public function activeMembers(): HasMany
    {
        return $this->members()->active();
    }

    public function getMemberCountAttribute(): int
    {
        return $this->activeMembers()->count();
    }

    public function getLifeGroupPhotoUrlAttribute(): ?string
    {
        if (!$this->life_group_photo) {
            return null;
        }

        return Storage::url($this->life_group_photo);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
