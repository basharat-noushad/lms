<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'student';
    public $avatar;
    public $bio = '';
    public $headline = '';
    public $is_active = true;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,instructor,student',
            'avatar' => 'nullable|image|max:2048',
            'bio' => 'nullable|string|max:1000',
            'headline' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }

    public function save(FileUploadService $fileUploadService)
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'bio' => $this->bio,
            'headline' => $this->headline,
            'is_active' => $this->is_active,
            'email_verified_at' => now(),
        ];

        // Handle avatar upload
        if ($this->avatar) {
            $data['avatar'] = $fileUploadService->uploadImage($this->avatar, 'avatars', 200, 200);
        }

        User::create($data);

        session()->flash('message', 'User created successfully.');
        
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.admin.users.create');
    }
}
