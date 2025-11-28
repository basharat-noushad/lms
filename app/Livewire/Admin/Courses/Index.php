<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $categoryFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['search', 'statusFilter', 'categoryFilter', 'sortField', 'sortDirection'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleFeatured(Course $course)
    {
        $course->update(['is_featured' => !$course->is_featured]);
        session()->flash('message', 'Course featured status updated.');
    }

    public function deleteCourse(Course $course)
    {
        // Check if course has enrollments
        if ($course->enrollments()->exists()) {
            session()->flash('error', 'Cannot delete course with active enrollments.');
            return;
        }

        $course->delete();
        session()->flash('message', 'Course deleted successfully.');
    }

    public function render()
    {
        $courses = Course::query()
            ->with(['instructor', 'category'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhereHas('instructor', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $categories = Category::whereNull('parent_id')->with('subcategories')->get();

        return view('livewire.admin.courses.index', [
            'courses' => $courses,
            'categories' => $categories
        ]);
    }
}
