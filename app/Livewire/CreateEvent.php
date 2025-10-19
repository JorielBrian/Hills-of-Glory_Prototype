<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Enums\EventsEnums\EventType;
use App\Enums\EventsEnums\EventStatus;
use Carbon\Carbon;

class CreateEvent extends Component
{
    public $title;
    public $description;
    public $event_date;
    public $start_time;
    public $end_time;
    public $location;
    public $type;
    public $status = 'scheduled';
    public $expected_attendance;
    public $notes;
    public $requires_attendance = true;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'event_date' => 'required|date|after_or_equal:today',
        'start_time' => 'nullable|date_format:H:i',
        'end_time' => 'nullable|date_format:H:i|after:start_time',
        'location' => 'nullable|string|max:255',
        'type' => 'required|in:sunday_service,wednesday_service,friday_service,prayer_meeting,cell_group,outreach,training,special_event,conference,baptism',
        'status' => 'required|in:scheduled,ongoing,completed,cancelled,postponed',
        'expected_attendance' => 'nullable|integer|min:1',
        'notes' => 'nullable|string',
        'requires_attendance' => 'boolean',
    ];

    protected $messages = [
        'event_date.after_or_equal' => 'The event date cannot be in the past.',
        'end_time.after' => 'The end time must be after the start time.',
        'type.required' => 'Please select an event type.',
    ];

    public function mount()
    {
        // Set default values
        $this->event_date = now()->format('Y-m-d');
        $this->start_time = '09:00';
        $this->end_time = '11:00';
        $this->type = 'sunday_service';
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        try {
            $event = Event::create([
                'title' => $this->title,
                'description' => $this->description,
                'event_date' => $this->event_date,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'location' => $this->location,
                'type' => $this->type,
                'status' => $this->status,
                'expected_attendance' => $this->expected_attendance,
                'notes' => $this->notes,
                'requires_attendance' => $this->requires_attendance,
            ]);

            session()->flash('success', 'Event created successfully!');

            // Redirect to events list or show page
            return redirect()->route('events.index'); // Change this to your actual route

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create event: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        return redirect()->route('events.index'); // Change this to your actual route
    }

    public function render()
    {
        return view('livewire.create-event', [
            'eventTypes' => array_map(fn($case) => $case->value, EventType::cases()),
            'eventStatuses' => array_map(fn($case) => $case->value, EventStatus::cases()),
        ]);
    }
}
