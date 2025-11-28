<?php

namespace App\Livewire\Admin\Settings;

use App\Services\SettingService;
use App\Services\FileUploadService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $activeTab = 'general';
    public $settings = [];
    public $uploads = [];

    public function mount(SettingService $settingService)
    {
        $this->settings = $settingService->getAllGrouped();
    }

    public function save(SettingService $settingService, FileUploadService $fileUploadService)
    {
        // Handle file uploads
        foreach ($this->uploads as $key => $file) {
            if ($file) {
                // Delete old file if exists
                $oldPath = $this->settings['general'][$key]['value'] ?? null;
                if ($oldPath) {
                    $fileUploadService->deleteFile($oldPath);
                }
                
                $path = $fileUploadService->uploadImage($file, 'settings');
                $this->settings['general'][$key]['value'] = $path;
            }
        }

        // Save all settings
        foreach ($this->settings as $group => $groupSettings) {
            foreach ($groupSettings as $key => $data) {
                $settingService->set($key, $data['value'], $data['type'], $group);
            }
        }

        $this->uploads = []; // Reset uploads
        
        session()->flash('message', 'Settings saved successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings.index');
    }
}
