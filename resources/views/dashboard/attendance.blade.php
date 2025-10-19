<?php

// use App\Models\Member;
// use App\Models\Event;

// // MARK MEMBER ATTENDANCE
// $member = Member::find(1);
// $event = Event::find(1);

// // Method 1: Using the relationship
// $member->events()->attach($event->id, [
//     'status' => 'present',
//     'checked_in_at' => now(),
//     'service_unit' => 'Ushering',
//     'volunteered' => true,
// ]);

// // Method 2: Using Attendance model
// Attendance::create([
//     'member_id' => $member->id,
//     'event_id' => $event->id,
//     'status' => 'present',
//     'checked_in_at' => now(),
// ]);

// // GET ATTENDANCE REPORT
// $event = Event::with(['members', 'attendances'])->find(1);

// // Present members
// $presentMembers = $event->members()->wherePivot('status', 'present')->get();

// // Attendance statistics
// $totalPresent = $event->present_count;
// $attendancePercentage = $event->attendance_percentage;

// // MEMBER ATTENDANCE HISTORY
// $member = Member::with(['events' => function($query) {
//     $query->orderBy('event_date', 'desc');
// }])->find(1);

// $attendanceHistory = $member->events;
// $totalEventsAttended = $member->events_attended_count;
?>

{{-- In your navigation file --}}
<a href="{{ route('events.create') }}" 
   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
    </svg>
    New Event
</a>

<x-layouts.dashboard_layout :title="__('Attendance')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl text-black">
        <h1 class="text-6xl p-10">Attendance</h1>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <livewire:events-table>
        </div>
    </div>
</x-layouts.dashboard_layout>
