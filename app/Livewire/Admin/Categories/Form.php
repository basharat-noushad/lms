<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use App\Services\FileUploadService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Form extends Component
{
    use WithFileUploads;

    public ?Category $category = null;
    
    public $name = '';
    public $slug = '';
    public $description = '';
    public $parent_id = null;
    public $icon;
    public $image;
    public $is_active = true;
    public $sort_order = 0;

    // For file previews/editing
    public $current_icon;
    public $current_image;

    public function mount(?Category $category = null)
    {
        if ($category && $category->exists) {
            $this->category = $category;
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->description = $category->description;
            $this->parent_id = $category->parent_id;
            $this->is_active = $category->is_active;
            $this->sort_order = $category->sort_order;
            $this->current_icon = $category->icon;
            $this->current_image = $category->image;
        }
    }

    public function updatedName($value)
    {
        if (!$this->category) {
            $this->slug = Str::slug($value);
        }
    }

    protected function rules()
    {
        $id = $this->category ? $this->category->id : 'NULL';
        
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|image|max:1024', // 1MB
            'image' => 'nullable|image|max:2048', // 2MB
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function save(FileUploadService $fileUploadService)
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'parent_id' => $this->parent_id ?: null, // Ensure empty string becomes null
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->icon) {
            if ($this->current_icon) {
                $fileUploadService->deleteFile($this->current_icon);
            }
            $data['icon'] = $fileUploadService->uploadImage($this->icon, 'categories/icons', 64, 64);
        }

        if ($this->image) {
            if ($this->current_image) {
                $fileUploadService->deleteFile($this->current_image);
            }
            $data['image'] = $fileUploadService->uploadImage($this->image, 'categories/images', 800, 600);
        }

        if ($this->category) {
            $this->category->update($data);
            session()->flash('message', 'Category updated successfully.');
        } else {
            Category::create($data);
            session()->flash('message', 'Category created successfully.');
        }

        return redirect()->route('admin.categories.index');
    }

    public function render()
    {
        // Get potential parents (exclude self and children if editing)
        $query = Category::whereNull('parent_id');
        
        if ($this->category) {
            $query->where('id', '!=', $this->category->id);
        }
        
        $parents = $query->orderBy('name')->get();

        return view('livewire.admin.categories.form', [
            'parents' => $parents
        ]);
    }
}
