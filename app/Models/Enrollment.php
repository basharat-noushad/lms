<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
        'completed_at',
        'progress',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'progress' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }

    /**
     * Update the course completion progress
     */
    public function updateProgress(): void
    {
        $totalLessons = $this->course->lessons()->count();
        
        if ($totalLessons === 0) {
            return;
        }

        $completedLessons = $this->lessonProgress()->where('completed', true)->count();
        $progress = round(($completedLessons / $totalLessons) * 100);

        $this->update(['progress' => $progress]);

        // If 100% complete, mark as completed and generate certificate
        if ($progress >= 100 && !$this->completed_at) {
            $this->update(['completed_at' => now()]);
            
            // Auto-generate certificate
            app(\App\Services\CertificateService::class)->autoGenerate($this);

            // Send notification
            app(\App\Services\NotificationService::class)->send(
                $this->user,
                'Course Completed',
                "Congratulations! You have completed the course {$this->course->title}.",
                'course_completion',
                ['course_id' => $this->course->id, 'certificate_id' => $this->certificate?->id]
            );
        }
    }
}
