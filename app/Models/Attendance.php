<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\EventsEnums\AttendanceStatus;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'event_id',
        'status',
        'checked_in_at',
        'checked_out_at',
        'notes',
        'service_unit',
        'volunteered',
    ];

    protected $casts = [
        'status' => AttendanceStatus::class,
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'volunteered' => 'boolean',
    ];

    // RELATIONSHIPS
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // SCOPES
    public function scopePresent($query)
    {
        return $query->where('status', AttendanceStatus::PRESENT);
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', AttendanceStatus::ABSENT);
    }

    public function scopeForEvent($query, $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeForMember($query, $memberId)
    {
        return $query->where('member_id', $memberId);
    }
}
