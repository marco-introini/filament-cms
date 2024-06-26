<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(PostObserver::class)]
class Post extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'title',
        'content',
        'meta_description',
        'featured_image',
        'is_featured',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'meta_description' => 'array',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }
}
