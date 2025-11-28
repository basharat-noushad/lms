<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Category;
use App\Models\Course;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Course $course;
    public $activeTab = 'basic';

    // Basic Info
    public $title;
    public $slug;
    public $category_id;
    public $level;

    // Details
    public $description;
    public $requirements;
    public $outcomes;

    // Media
    public $thumbnail;
    public $newThumbnail;
    public $trailer_url;

    // Pricing
    public $price;
    public $is_free;

    public function mount(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403);
        }

        $this->course = $course;
        
        $this->title = $course->title;
        $this->slug = $course->slug;
        $this->category_id = $course->category_id;
        $this->level = $course->level;
        
        $this->description = $course->description;
        $this->requirements = $course->requirements ? implode("\n", json_decode($course->requirements, true)) : '';
        $this->outcomes = $course->outcomes ? implode("\n", json_decode($course->outcomes, true)) : '';
        
        $this->thumbnail = $course->thumbnail;
        $this->trailer_url = $course->trailer_url;
        
        $this->price = $course->price;
        $this->is_free = $course->is_free;
    }

    public function updatedTitle()
    {
        $this->slug = Str::slug($this->title);
    }

    public function save(FileUploadService $fileUploadService)
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:courses,slug,' . $this->course->id,
            'category_id' => 'required|exists:categories,id',
            'level' => 'required|in:beginner,intermediate,advanced',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'outcomes' => 'nullable|string',
            'newThumbnail' => 'nullable|image|max:2048',
            'trailer_url' => 'nullable|url',
            'price' => 'required_unless:is_free,true|numeric|min:0',
            'is_free' => 'boolean',
        ]);

        $thumbnailPath = $this->thumbnail;
        if ($this->newThumbnail) {
            if ($this->thumbnail) {
                $fileUploadService->deleteFile($this->thumbnail);
            }
            $thumbnailPath = $fileUploadService->uploadImage($this->newThumbnail, 'courses/thumbnails');
        }

        $this->course->update([
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'level' => $this->level,
            'requirements' => $this->requirements ? json_encode(explode("\n", $this->requirements)) : null,
            'outcomes' => $this->outcomes ? json_encode(explode("\n", $this->outcomes)) : null,
            'thumbnail' => $thumbnailPath,
            'trailer_url' => $this->trailer_url,
            'price' => $this->is_free ? 0 : $this->price,
            'is_free' => $this->is_free,
        ]);

        session()->flash('message', 'Course updated successfully.');
    }

    public function render()
    {
        return view('livewire.instructor.courses.edit', [
            'categories' => Category::whereNull('parent_id')->with('children')->get(),
        ])->layout('layouts.instructor');
    }
}
