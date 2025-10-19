<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\LifeGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreateLifeGroup extends Component
{
    use WithFileUploads;

    // Form fields
    public $life_group_name = '';
    public $life_group_photo;

    protected $rules = [
        'life_group_name' => 'required|string|max:255|unique:life_groups,life_group_name',
        'life_group_photo' => 'nullable|image|max:2048', // 2MB max
    ];

    protected $messages = [
        'life_group_name.required' => 'Life group name is required.',
        'life_group_name.unique' => 'This life group name already exists.',
        'life_group_photo.image' => 'The life group photo must be an image.',
        'life_group_photo.max' => 'The life group photo must not exceed 2MB.',
    ];

    public function save()
    {
        $this->validate();

        try {
            $photoPath = null;
            if ($this->life_group_photo) {
                $photoPath = $this->life_group_photo->store('life-group-photos', 'public');
            }

            // Create the life group
            LifeGroup::create([
                'life_group_name' => $this->life_group_name,
                'network_leader_id' => Auth::id(),
                'life_group_photo' => $photoPath,
                'is_active' => true,
            ]);

            // Reset form
            $this->reset();

            session()->flash('message', 'Life Group created successfully!');
            return redirect()->route('lifegroups');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create life group. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.create-life-group');
    }
}
