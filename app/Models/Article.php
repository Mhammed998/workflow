<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $guardrd = [];

    protected function casts(): array
    {
        return [
            'show_on_hero' => 'boolean',
            'is_featured' => 'boolean',
            'is_breaking' => 'boolean',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function image()
    {
        return Storage::url($this->image_path);
    }

    /**
     * Get the user's first name.
     */
    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::limit(strip_tags($value), 30),
        );
    }

}
