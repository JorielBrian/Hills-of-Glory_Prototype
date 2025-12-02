<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\Member;

class ViewMember extends Component
{
    public Member $member;

    public function mount(Member $member)
    {
        $this->member = $member->load(['lifeGroup', 'networkLeader']);
    }

    public function editMember()
    {
        return redirect()->route('members.edit', $this->member);
    }

    public function removeMember($memberId)
    {
        try {
            $member = Member::findOrFail($memberId);
            $member->update([
                'life_group_id' => null,
                'network_leader_id' => null
            ]);

            session()->flash('message', 'Member removed from life group successfully!');
            return redirect()->route('members');
        } catch (\Exception $e) {
            session()->flash('error', 'Error removing member: ' . $e->getMessage());
        }
    }

    public function backToMembers()
    {
        return redirect()->route('members');
    }

    public function render()
    {
        return view('livewire.member.view-member');
    }
}
