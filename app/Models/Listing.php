<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static latest()
 * @method static create(array $form)
 * @property mixed $id
 */
class Listing extends Model
{
    use HasFactory;

    // Tag filtering and searching
    public function scopeFilter($query, array $filters): void
    {
        // Filtering by tags
        if($filters['tag'] ?? false)
        {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        // Searching by title, tags and description
        if($filters['search'] ?? false)
        {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('tags', 'like', '%' . request('search') . '%');
        }
    }
}
