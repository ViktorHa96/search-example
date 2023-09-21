<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Models\Tag;
use App\Models\Category;


class Post extends Model
{
    use HasFactory, Searchable;

    protected $guarded = null;

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }

    public function searchableAs()
    {
        return 'posts';
    }
}
