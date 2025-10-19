<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\EventsEnums\EventType;
use App\Enums\EventsEnums\EventStatus;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'type',
        'status',
        'with_ticket',
        'ticket_price',
        'ticket_count',
        'ticket_category',
        // REMOVED: 'expected_attendance', 'notes', 'requires_attendance' 
        // These don't exist in the migration
    ];

    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'type' => EventType::class,
        'status' => EventStatus::class,
        'with_ticket' => 'boolean',
        'ticket_price' => 'decimal:2',
        'ticket_count' => 'integer',
    ];

    // RELATIONSHIPS
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'attendances')
            ->withPivot('status', 'checked_in_at', 'checked_out_at', 'notes', 'service_unit', 'volunteered')
            ->withTimestamps();
    }

    // SCOPES
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString())
            ->where('status', EventStatus::SCHEDULED);
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->toDateString())
            ->orWhere('status', EventStatus::COMPLETED);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // ATTRIBUTES - FIXED TO USE STRING INSTEAD OF MISSING ATTENDANCESTATUS ENUM
    public function getPresentCountAttribute()
    {
        return $this->attendances()->where('status', 'present')->count();
    }

    public function getAttendancePercentageAttribute()
    {
        $totalMembers = Member::where('isActive', true)->count();
        return $totalMembers > 0 ? round(($this->present_count / $totalMembers) * 100, 2) : 0;
    }

    public function getFormattedEventDateAttribute()
    {
        return $this->event_date->format('F j, Y');
    }
}
