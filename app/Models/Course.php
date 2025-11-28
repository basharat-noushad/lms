<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid', 'instructor_id', 'category_id', 'title', 'slug', 'subtitle',
        'description', 'requirements', 'what_you_learn', 'target_audience',
        'level', 'language', 'thumbnail', 'preview_video', 'price', 'sale_price',
        'sale_start_date', 'sale_end_date', 'is_free', 'is_featured', 'is_published',
        'status', 'rejection_reason', 'total_duration', 'total_lessons',
        'total_students', 'average_rating', 'total_reviews', 'published_at',
    ];

    protected $casts = [
        'sale_start_date' => 'datetime',
        'sale_end_date' => 'datetime',
        'published_at' => 'datetime',
        'is_free' => 'boolean',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'average_rating' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($course) {
            if (empty($course->uuid)) {
                $course->uuid = (string) Str::uuid();
            }
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }
        });
    }

    // Relationships
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('sort_order');
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Section::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating'), 1);
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }



    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public static function getPublishedCourses()
    {
        return cache()->remember('published_courses', 3600, function () {
            return self::with(['category', 'instructor'])
                ->where('is_published', true)
                ->latest()
                ->get();
        });
    }

    public static function getPopularCourses()
    {
        return cache()->remember('popular_courses', 3600, function () {
            return self::with(['category', 'instructor'])
                ->where('is_published', true)
                ->withCount('enrollments')
                ->orderByDesc('enrollments_count')
                ->take(6)
                ->get();
        });
    }

    protected static function booted()
    {
        static::saved(function ($course) {
            cache()->forget('published_courses');
            cache()->forget('popular_courses');
        });

        static::deleted(function ($course) {
            cache()->forget('published_courses');
            cache()->forget('popular_courses');
        });
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->where('status', 'approved');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByInstructor($query, $instructorId)
    {
        return $query->where('instructor_id', $instructorId);
    }

    // Accessors
    public function getCurrentPriceAttribute()
    {
        if ($this->isOnSale()) {
            return $this->sale_price;
        }
        return $this->price;
    }

    public function isOnSale()
    {
        if (!$this->sale_price || $this->sale_price >= $this->price) {
            return false;
        }

        $now = now();
        $startValid = !$this->sale_start_date || $now->gte($this->sale_start_date);
        $endValid = !$this->sale_end_date || $now->lte($this->sale_end_date);

        return $startValid && $endValid;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->isOnSale()) {
            return 0;
        }
        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }
}
