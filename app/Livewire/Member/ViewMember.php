<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\Member;

class ViewMember extends Component
{
    public Member $member;

    public function mount(Member $member)
    {
        $this->member = $member->load(['lifegroup', 'networkLeader']);
    }

    public function editMember()
    {
        return redirect()->route('members.edit', $this->member);
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
