<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public User $user;
    
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role;
    public $avatar;
    public $current_avatar;
    public $bio;
    public $headline;
    public $website;
    public $twitter;
    public $linkedin;
    public $youtube;
    public $is_active;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->current_avatar = $user->avatar;
        $this->bio = $user->bio;
        $this->headline = $user->headline;
        $this->website = $user->website;
        $this->twitter = $user->twitter;
        $this->linkedin = $user->linkedin;
        $this->youtube = $user->youtube;
        $this->is_active = $user->is_active;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:admin,instructor,student',
            'avatar' => 'nullable|image|max:2048',
            'bio' => 'nullable|string|max:1000',
            'headline' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'is_active' => 'boolean',
        ];
    }

    public function save(FileUploadService $fileUploadService)
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'bio' => $this->bio,
            'headline' => $this->headline,
            'website' => $this->website,
            'twitter' => $this->twitter,
            'linkedin' => $this->linkedin,
            'youtube' => $this->youtube,
            'is_active' => $this->is_active,
        ];

        // Update password if provided
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        // Handle avatar upload
        if ($this->avatar) {
            // Delete old avatar
            if ($this->current_avatar) {
                $fileUploadService->deleteFile($this->current_avatar);
            }
            $data['avatar'] = $fileUploadService->uploadImage($this->avatar, 'avatars', 200, 200);
        }

        $this->user->update($data);

        session()->flash('message', 'User updated successfully.');
        
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.admin.users.edit');
    }
}
