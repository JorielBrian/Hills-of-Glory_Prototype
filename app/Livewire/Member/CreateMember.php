<?php

namespace App\Livewire\Member;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Member;
use App\Models\LifeGroup;
use App\Enums\MemberEnums\Gender;
use App\Enums\MemberEnums\MemberRole;
use App\Enums\MemberEnums\HillsJourney;
use App\Enums\MemberEnums\MemberType;
use App\Enums\MemberEnums\Ministry;
use App\Enums\MemberEnums\MinistryRole;
use App\Enums\EventsEnums\Event;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CreateMember extends Component
{
    use WithFileUploads;

    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $gender = '';
    public $birth_date = '';
    public $contact = '';
    public $email = '';
    public $address = '';
    public $member_type = '';
    public $is_married = false;
    public $invited_by = '';
    public $date_invited = '';
    public $service_invited = '';
    public $facebook_account = '';
    public $member_photo;
    public $member_role = '';
    public $hills_journey = '';
    public $ministry = '';
    public $ministry_role = '';
    public $ministry_assignment = '';
    public $life_group = '';

    // Define the enum arrays as properties
    public $genders;
    public $memberTypes;
    public $memberRoles;
    public $hillsJourneys;
    public $ministries;
    public $ministryRoles;
    public $lifeGroups;
    public $serviceEvents;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'gender' => 'required',
        'birth_date' => 'required|date',
        'contact' => 'required|string|max:20|unique:members,contact',
        'email' => 'nullable|email|unique:members,email',
        'address' => 'required|string|max:500',
        'member_type' => 'required',
        'member_role' => 'required',
        'hills_journey' => 'required',
        'invited_by' => 'required|string|max:255',
        'date_invited' => 'required|date',
        'service_invited' => 'required',
        'member_photo' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $this->initializeEnums();
    }

    /**
     * Initialize enum arrays
     */
    protected function initializeEnums(): void
    {
        // Initialize the enum arrays with proper variable names
        $this->genders = Gender::cases();
        $this->memberTypes = MemberType::cases();
        $this->memberRoles = MemberRole::cases();
        $this->hillsJourneys = HillsJourney::cases();
        $this->ministries = Ministry::cases();
        $this->ministryRoles = MinistryRole::cases();
        $this->serviceEvents = Event::cases();
        $this->lifeGroups = LifeGroup::active()->get();
    }

    /**
     * Computed property for age
     */
    public function getComputedAgeProperty()
    {
        if ($this->birth_date) {
            return Carbon::parse($this->birth_date)->age;
        }
        return null;
    }

    public function updatedBirthDate($value)
    {
        // This will trigger when birth_date is updated
        // The computed age will automatically update
    }

    public function updatedLifeGroup($value)
    {
        // This will automatically set the network leader when a life group is selected
    }

    public function save()
    {
        $this->validate();

        try {
            $photoPath = null;
            if ($this->member_photo) {
                $photoPath = $this->member_photo->store('member-photos', 'public');
            }

            // Get network leader from selected life group
            $networkLeaderId = null;
            if ($this->life_group) {
                $lifeGroup = LifeGroup::find($this->life_group);
                $networkLeaderId = $lifeGroup->network_leader_id;
            }

            // Member Model
            Member::create([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'gender' => $this->gender,
                'birth_date' => $this->birth_date,
                'contact' => $this->contact,
                'email' => $this->email,
                'address' => $this->address,
                'member_type' => $this->member_type,
                'is_married' => $this->is_married,
                'invited_by' => $this->invited_by,
                'date_invited' => $this->date_invited,
                'service_invited' => $this->service_invited,
                'facebook_account' => $this->facebook_account,
                'member_photo' => $photoPath,
                'member_role' => $this->member_role,
                'hills_journey' => $this->hills_journey,
                'ministry' => $this->ministry,
                'ministry_role' => $this->ministry_role,
                'ministry_assignment' => $this->ministry_assignment,
                'life_group_id' => $this->life_group ?: null,
                'network_leader_id' => $networkLeaderId,
            ]);

            session()->flash('message', 'Member created successfully!');

            // Reset only form fields, not enum arrays
            $this->resetFormFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating member: ' . $e->getMessage());
        }
    }

    /**
     * Reset only form fields, preserve enum arrays
     */
    protected function resetFormFields(): void
    {
        $this->first_name = '';
        $this->middle_name = '';
        $this->last_name = '';
        $this->gender = '';
        $this->birth_date = '';
        $this->contact = '';
        $this->email = '';
        $this->address = '';
        $this->member_type = '';
        $this->is_married = false;
        $this->invited_by = '';
        $this->date_invited = '';
        $this->service_invited = '';
        $this->facebook_account = '';
        $this->member_photo = null;
        $this->member_role = '';
        $this->hills_journey = '';
        $this->ministry = '';
        $this->ministry_role = '';
        $this->ministry_assignment = '';
        $this->life_group = '';
    }

    public function render()
    {
        // Ensure enum arrays are always initialized
        if (!$this->genders || !$this->memberTypes || !$this->memberRoles) {
            $this->initializeEnums();
        }

        return view('livewire.member.create-member');
    }
}
