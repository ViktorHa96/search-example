<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    use HasFactory, Searchable;

    protected $guarded = null;

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function toSearchableArray()
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
        ];
    }

    public function searchableAs()
    {
        return 'tags';
    }
}
