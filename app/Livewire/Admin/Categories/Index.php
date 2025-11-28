<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use App\Services\FileUploadService;
use Livewire\Component;

class Index extends Component
{
    public function updateOrder($list)
    {
        foreach ($list as $item) {
            Category::where('id', $item['value'])->update(['sort_order' => $item['order']]);
        }
        
        session()->flash('message', 'Category order updated successfully.');
    }

    public function deleteCategory($id, FileUploadService $fileUploadService)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has courses
        if ($category->courses()->exists()) {
            session()->flash('error', 'Cannot delete category with associated courses.');
            return;
        }

        // Delete files
        if ($category->icon) {
            $fileUploadService->deleteFile($category->icon);
        }
        if ($category->image) {
            $fileUploadService->deleteFile($category->image);
        }

        // Move subcategories to root or delete them? 
        // For now, let's just delete them or rely on cascade if configured, 
        // but usually we want to prevent deletion if children exist or move them.
        // Let's check for children.
        if ($category->subcategories()->exists()) {
             session()->flash('error', 'Cannot delete category with subcategories. Delete subcategories first.');
             return;
        }

        $category->delete();
        session()->flash('message', 'Category deleted successfully.');
    }

    public function toggleStatus(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        session()->flash('message', 'Category status updated.');
    }

    public function render()
    {
        $categories = Category::whereNull('parent_id')
            ->with(['subcategories' => function($query) {
                $query->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        return view('livewire.admin.categories.index', [
            'categories' => $categories
        ]);
    }
}
