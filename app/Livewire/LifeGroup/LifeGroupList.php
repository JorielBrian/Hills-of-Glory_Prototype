<?php

namespace App\Livewire\LifeGroup;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LifeGroup;
use Illuminate\Support\Facades\Auth;

class LifeGroupList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
    ];

    public function mount()
    {
        // Check if user is a network leader by seeing if they have any life groups assigned
        $hasLifeGroups = LifeGroup::where('network_leader_id', Auth::id())->exists();

        if (!$hasLifeGroups) {
            abort(403, 'Unauthorized access. You are not assigned as a network leader.');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function getLifeGroupsProperty()
    {
        return LifeGroup::query()
            ->where('network_leader_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('life_group_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                if ($this->statusFilter === 'active') {
                    $query->where('is_active', true);
                } elseif ($this->statusFilter === 'inactive') {
                    $query->where('is_active', false);
                }
            })
            ->withCount(['members as total_members'])
            ->with('networkLeader')
            ->orderBy('life_group_name')
            ->paginate(10);
    }

    public function toggleStatus(LifeGroup $lifeGroup)
    {
        // Verify the life group belongs to the current user
        if ($lifeGroup->network_leader_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $lifeGroup->update([
            'is_active' => !$lifeGroup->is_active
        ]);

        session()->flash(
            'message',
            $lifeGroup->is_active
                ? 'Life Group activated successfully!'
                : 'Life Group deactivated successfully!'
        );
    }

    public function render()
    {
        return view('livewire.life-groups.life-group-list', [
            'lifeGroups' => $this->lifeGroups,
        ]);
    }
}
