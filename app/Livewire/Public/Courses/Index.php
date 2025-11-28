<?php

namespace App\Livewire\Public\Courses;

use App\Models\Category;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $level = '';
    public $price = '';
    public $sort = 'newest';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'level' => ['except' => ''],
        'price' => ['except' => ''],
        'sort' => ['except' => 'newest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::withCount('courses')->get();

        $courses = Course::published()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('short_description', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                $query->where('category_id', $this->category);
            })
            ->when($this->level, function ($query) {
                $query->where('level', $this->level);
            })
            ->when($this->price, function ($query) {
                if ($this->price === 'free') {
                    $query->where('is_free', true);
                } elseif ($this->price === 'paid') {
                    $query->where('is_free', false);
                }
            })
            ->when($this->sort, function ($query) {
                switch ($this->sort) {
                    case 'price_low':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'price_high':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'rating':
                        // Assuming we have a way to sort by rating, typically requires a join or subquery
                        // For MVP, we might skip complex rating sort or use a simple implementation if available
                        // $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating');
                        break;
                    default:
                        $query->latest();
                        break;
                }
            })
            ->with(['instructor', 'category', 'reviews'])
            ->paginate(12);

        return view('livewire.public.courses.index', [
            'courses' => $courses,
            'categories' => $categories,
        ])->layout('layouts.public');
    }
}
