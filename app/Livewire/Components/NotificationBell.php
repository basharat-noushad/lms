<?php

namespace App\Livewire\Components;

use App\Services\NotificationService;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $notifications = [];

    protected $listeners = ['notification-received' => 'loadNotifications'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (Auth::check()) {
            $this->unreadCount = Auth::user()->notifications()->whereNull('read_at')->count();
            $this->notifications = Auth::user()->notifications()
                ->latest()
                ->take(5)
                ->get();
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            app(NotificationService::class)->markAsRead($notification);
            $this->loadNotifications();
            return redirect($this->getNotificationUrl($notification));
        }
    }

    public function markAllRead()
    {
        if (Auth::check()) {
            app(NotificationService::class)->markAllAsRead(Auth::user());
            $this->loadNotifications();
        }
    }

    private function getNotificationUrl($notification)
    {
        // Define logic to redirect based on notification type/data
        // For now, default to notifications page or specific resource
        return route('student.notifications');
    }

    public function render()
    {
        return view('livewire.components.notification-bell');
    }
}
