<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Event;
use App\Models\Member;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class EventsTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';
    public $sortField = 'event_date';
    public $sortDirection = 'desc';
    public $showAttendanceModal = false;
    public $selectedEvent = null;
    public $attendanceData = [];
    public $bulkAttendance = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    protected $listeners = [
        'attendanceUpdated' => '$refresh',
        'eventDeleted' => '$refresh',
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function showAttendance($eventId)
    {
        $this->selectedEvent = Event::with(['attendances.member'])->findOrFail($eventId);

        // Initialize attendance data for modal
        $this->attendanceData = [];
        $this->bulkAttendance = [];

        // Get all active members and pre-fill attendance status
        $members = Member::where('isActive', true)->get();

        foreach ($members as $member) {
            $existingAttendance = Attendance::where('event_id', $eventId)
                ->where('member_id', $member->id)
                ->first();

            $this->attendanceData[$member->id] = [
                'status' => $existingAttendance ? $existingAttendance->status : 'absent',
                'notes' => $existingAttendance ? $existingAttendance->notes : '',
                'volunteered' => $existingAttendance ? $existingAttendance->volunteered : false,
            ];

            $this->bulkAttendance[$member->id] = $existingAttendance ? $existingAttendance->status === 'present' : false;
        }

        $this->showAttendanceModal = true;
    }

    public function updateAttendance($memberId)
    {
        $attendance = $this->attendanceData[$memberId];

        if ($attendance['status'] === 'absent') {
            // Remove attendance record if status is absent
            Attendance::where('event_id', $this->selectedEvent->id)
                ->where('member_id', $memberId)
                ->delete();
        } else {
            // Update or create attendance record
            Attendance::updateOrCreate(
                [
                    'event_id' => $this->selectedEvent->id,
                    'member_id' => $memberId,
                ],
                [
                    'status' => $attendance['status'],
                    'notes' => $attendance['notes'],
                    'volunteered' => $attendance['volunteered'],
                    'checked_in_at' => $attendance['status'] === 'present' ? now() : null,
                ]
            );
        }

        $this->emit('attendanceUpdated');
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Attendance updated successfully!'
        ]);
    }

    public function updateBulkAttendance()
    {
        DB::transaction(function () {
            foreach ($this->bulkAttendance as $memberId => $isPresent) {
                if ($isPresent) {
                    Attendance::updateOrCreate(
                        [
                            'event_id' => $this->selectedEvent->id,
                            'member_id' => $memberId,
                        ],
                        [
                            'status' => 'present',
                            'checked_in_at' => now(),
                        ]
                    );
                } else {
                    Attendance::where('event_id', $this->selectedEvent->id)
                        ->where('member_id', $memberId)
                        ->delete();
                }
            }
        });

        $this->emit('attendanceUpdated');
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Bulk attendance updated successfully!'
        ]);

        // Refresh the modal data
        $this->showAttendance($this->selectedEvent->id);
    }

    public function markAllPresent()
    {
        $members = Member::where('isActive', true)->get();

        DB::transaction(function () use ($members) {
            foreach ($members as $member) {
                Attendance::updateOrCreate(
                    [
                        'event_id' => $this->selectedEvent->id,
                        'member_id' => $member->id,
                    ],
                    [
                        'status' => 'present',
                        'checked_in_at' => now(),
                    ]
                );
            }
        });

        $this->emit('attendanceUpdated');
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'All members marked as present!'
        ]);

        $this->showAttendance($this->selectedEvent->id);
    }

    public function deleteEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        $event->delete();

        $this->emit('eventDeleted');
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Event deleted successfully!'
        ]);
    }

    public function getEventsProperty()
    {
        return Event::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->withCount(['attendances as present_count' => function ($query) {
                $query->where('status', 'present');
            }])
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.events-table', [
            'events' => $this->events,
            'totalMembers' => Member::where('isActive', true)->count(),
        ]);
    }
}
