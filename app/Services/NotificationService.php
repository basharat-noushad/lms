<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function send(User $user, string $title, string $message, string $type = 'system', array $data = [])
    {
        // 1. Create database notification
        $notification = Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data,
            'read_at' => null
        ]);

        // 2. Send email if applicable (could be queued)
        // For now, we'll skip email implementation to focus on in-app notifications
        // but this is where you'd dispatch an email job.

        return $notification;
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['read_at' => now()]);
    }

    public function markAllAsRead(User $user)
    {
        $user->notifications()->whereNull('read_at')->update(['read_at' => now()]);
    }
}
