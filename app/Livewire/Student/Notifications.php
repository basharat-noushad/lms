<?php

namespace App\Livewire\Student;

use App\Services\NotificationService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    use WithPagination;

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            app(NotificationService::class)->markAsRead($notification);
            $this->dispatch('notification-received'); // Refresh bell
        }
    }

    public function markAllRead()
    {
        app(NotificationService::class)->markAllAsRead(Auth::user());
        $this->dispatch('notification-received'); // Refresh bell
    }

    public function render()
    {
        $notifications = Auth::user()->notifications()
            ->latest()
            ->paginate(10);

        return view('livewire.student.notifications', [
            'notifications' => $notifications
        ])->layout('layouts.student');
    }
}
