<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(PostObserver::class)]
class Post extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    /**
     * @return array{
     *     meta_description: 'array',
     *     is_published: 'boolean',
     *     is_featured: 'boolean',
     *     published_at: 'datetime'
     * }
     */
    protected function casts(): array
    {
        return [
            'meta_description' => 'array',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    public function publish(): bool
    {
        if ($this->is_published) {
            return false;
        }

        $this->is_published = true;
        $this->published_at = now();
        $this->save();
        return true;
    }

    public function unpublish(): bool
    {
        if (!$this->is_published) {
            return false;
        }
        $this->is_published = false;
        $this->published_at = null;
        $this->save();
        return true;
    }


}
