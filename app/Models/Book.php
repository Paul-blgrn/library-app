<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    // on ajoute la variable "path" à l'affichage
    //protected $appends = ['path'];
    protected $hidden = ['author_id'];

    // les relations

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function published_books()
    {
        return $this->hasMany(PublishedBook::class);
    }

    public function comments()
    {
        return $this->belongsToMany(Book::class, 'comments');
    }

    public function getImagePath($inDB = null) {
        // example : images/test.png

        $default = 'http://via.placeholder.com/640x480.png/00ff00?text=' . Str::snake($this->title);

        if(!$inDB) {
            return $default;
        }

        $path = Storage::disk('public')->exists($inDB)
            ? Storage::disk('public')->url($inDB)
            : $default;
        return $path;

        // if(Storage::disk('public')->exists($inDB)) {
        //     return Storage::disk('public')->url($inDB);
        // } else {
        //     return $default;
        // }
    }

    protected function image(): Attribute {
        return Attribute::make(
            get: fn($value) => $this->getImagePath($value)
        );
    }

    protected function path(): Attribute {
        return Attribute::make(
            get: fn($value, $attributes) => $this->getImagePath($attributes['image'])
        );
    }

    // public function toArray()
    // {
    //     $original = parent::toArray();

    //      $original['path'] = $this->getImagePath();

    //     return $original;
    // }
}
