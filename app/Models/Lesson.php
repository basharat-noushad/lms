<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lesson extends Model
{
    protected $fillable = ['uuid', 'section_id', 'title', 'slug', 'content_type', 'description', 'video_url', 'video_provider', 'video_duration', 'text_content', 'is_free_preview', 'is_published', 'sort_order'];
    protected $casts = ['is_free_preview' => 'boolean', 'is_published' => 'boolean'];
    
    protected static function boot() {
        parent::boot();
        static::creating(fn($lesson) => $lesson->uuid = $lesson->uuid ?? (string) Str::uuid());
    }

    public function section() { return $this->belongsTo(Section::class); }
    public function quiz() { return $this->hasOne(Quiz::class); }
    public function resources() { return $this->hasMany(LessonResource::class); }
    public function progress() { return $this->hasMany(LessonProgress::class); }
}
