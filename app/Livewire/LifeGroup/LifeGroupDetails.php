<?php

namespace App\Livewire\LifeGroup;

use Livewire\Component;
use App\Models\LifeGroup;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class LifeGroupDetails extends Component
{
    public LifeGroup $lifeGroup;
    public $members;

    public function mount(LifeGroup $lifeGroup)
    {
        // Check if user is authorized to view this life group
        if ($lifeGroup->network_leader_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this life group.');
        }

        $this->lifeGroup = $lifeGroup->load('networkLeader');
        $this->loadMembers();
    }

    public function loadMembers()
    {
        $this->members = Member::where('life_group_id', $this->lifeGroup->id)
            ->with(['lifeGroup'])
            ->orderBy('first_name')
            ->get();
    }

    public function removeMember($memberId)
    {
        $member = Member::findOrFail($memberId);

        // Verify the member belongs to the current user's life group
        if ($member->life_group_id !== $this->lifeGroup->id) {
            abort(403, 'Unauthorized action.');
        }

        // Update member's life group association
        $member->update([
            'life_group_id' => null,
            'network_leader_id' => null
        ]);

        $this->loadMembers(); // Refresh the members list
        session()->flash('message', 'Member removed from life group successfully!');
    }

    public function toggleLifeGroupStatus()
    {
        // Verify the life group belongs to the current user
        if ($this->lifeGroup->network_leader_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->lifeGroup->update([
            'is_active' => !$this->lifeGroup->is_active
        ]);

        $this->lifeGroup->refresh();
        session()->flash(
            'message',
            $this->lifeGroup->is_active
                ? 'Life Group activated successfully!'
                : 'Life Group deactivated successfully!'
        );
    }

    public function render()
    {
        return view('livewire.life-groups.life-group-details');
    }
}
