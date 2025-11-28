<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Category;
use App\Models\Course;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 4;

    // Step 1: Basic Info
    public $title = '';
    public $slug = '';
    public $category_id = '';
    public $level = 'beginner';

    // Step 2: Details
    public $description = '';
    public $requirements = '';
    public $outcomes = '';

    // Step 3: Media
    public $thumbnail;
    public $trailer_url = '';

    // Step 4: Pricing
    public $price = 0;
    public $is_free = false;

    public function updatedTitle()
    {
        $this->slug = Str::slug($this->title);
    }

    public function validateStep($step)
    {
        if ($step == 1) {
            $this->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:courses,slug',
                'category_id' => 'required|exists:categories,id',
                'level' => 'required|in:beginner,intermediate,advanced',
            ]);
        } elseif ($step == 2) {
            $this->validate([
                'description' => 'required|string',
                'requirements' => 'nullable|string',
                'outcomes' => 'nullable|string',
            ]);
        } elseif ($step == 3) {
            $this->validate([
                'thumbnail' => 'nullable|image|max:2048', // 2MB Max
                'trailer_url' => 'nullable|url',
            ]);
        } elseif ($step == 4) {
            $this->validate([
                'price' => 'required_unless:is_free,true|numeric|min:0',
                'is_free' => 'boolean',
            ]);
        }
    }

    public function nextStep()
    {
        $this->validateStep($this->currentStep);
        $this->currentStep++;
    }

    public function prevStep()
    {
        $this->currentStep--;
    }

    public function save(FileUploadService $fileUploadService)
    {
        $this->validateStep(4);

        $thumbnailPath = null;
        if ($this->thumbnail) {
            $thumbnailPath = $fileUploadService->uploadImage($this->thumbnail, 'courses/thumbnails');
        }

        $course = Course::create([
            'instructor_id' => Auth::id(),
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
            'status' => 'draft',
        ]);

        session()->flash('message', 'Course created successfully! You can now add curriculum content.');
        return redirect()->route('instructor.courses.curriculum', $course);
    }

    public function render()
    {
        return view('livewire.instructor.courses.create', [
            'categories' => Category::whereNull('parent_id')->with('children')->get(),
        ])->layout('layouts.instructor');
    }
}
