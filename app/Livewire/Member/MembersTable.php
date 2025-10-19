<?php

namespace App\Livewire\Member;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Member;
use App\Enums\MemberEnums\NetworkLeaders;

class MembersTable extends Component
{
    use WithPagination;

    public $network_leader = '';
    public $search = '';

    // Reset pagination when filter changes
    public function updated($property)
    {
        if (in_array($property, ['network_leader', 'search'])) {
            $this->resetPage();
        }
    }

    public function viewMember($memberId)
    {
        return redirect()->route('members.show', $memberId);
    }

    public function editMember($memberId)
    {
        return redirect()->route('members.edit', $memberId);
    }

    public function render()
    {
        $query = Member::with(['lifegroup', 'networkLeader'])
            ->orderBy('first_name');

        // Apply network leader filter
        if (!empty($this->network_leader)) {
            $query->where('network_leader_id', $this->network_leader);
        }

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('contact', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.member.members-table', [
            'members' => $query->paginate(10),
            'network_leaders' => NetworkLeaders::cases(),
        ]);
    }
}
