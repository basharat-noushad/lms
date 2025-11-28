<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'icon', 'image', 'parent_id', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function parent() { return $this->belongsTo(Category::class, 'parent_id'); }
    public function children() { return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order'); }
    public function courses() { return $this->hasMany(Course::class); }
    public function scopeActive($query) { return $query->where('is_active', true); }
}
