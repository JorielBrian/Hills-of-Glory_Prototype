<?php

namespace App\Livewire\Member;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Member;
use App\Models\LifeGroup;
use App\Enums\MemberEnums\Gender;
use App\Enums\MemberEnums\MemberRole;
use App\Enums\MemberEnums\HillsJourney;
use App\Enums\MemberEnums\Ministry;
use App\Enums\MemberEnums\MinistryRole;
use App\Enums\MemberEnums\Status;
use Illuminate\Support\Facades\Storage;

class CreateMember extends Component
{
    use WithFileUploads;

    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $age = '';
    public $gender = '';
    public $birth_date = '';
    public $contact = '';
    public $address = '';
    public $status = '';
    public $invitedBy = '';
    public $member_photo;
    public $member_role = '';
    public $hills_journey = '';
    public $ministry = '';
    public $ministry_role = '';
    public $ministry_assignment = '';
    public $life_group = '';

    // Define the enum arrays as properties
    public $genders;
    public $statuses;
    public $memberRoles;
    public $hills_journeys;
    public $ministries;
    public $ministry_roles;
    public $lifeGroups;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'age' => 'required|integer|min:1',
        'gender' => 'required',
        'birth_date' => 'required|date',
        'contact' => 'required|string|max:20|unique:members,contact',
        'address' => 'required|string|max:500',
        'status' => 'required',
        'member_role' => 'required',
        'hills_journey' => 'required',
        'member_photo' => 'nullable|image|max:2048', // 2MB max
    ];

    public function mount()
    {
        // Initialize the enum arrays
        $this->genders = Gender::cases();
        $this->statuses = Status::cases();
        $this->memberRoles = MemberRole::cases();
        $this->hills_journeys = HillsJourney::cases();
        $this->ministries = Ministry::cases();
        $this->ministry_roles = MinistryRole::cases();
        $this->lifeGroups = LifeGroup::active()->get();
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

            Member::create([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'age' => $this->age,
                'gender' => $this->gender,
                'birth_date' => $this->birth_date,
                'contact' => $this->contact,
                'address' => $this->address,
                'status' => $this->status,
                'invited_by' => $this->invitedBy,
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

            // Reset form fields
            $this->reset();
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating member: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.member.create-member');
    }
}
