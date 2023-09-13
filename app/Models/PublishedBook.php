<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PublishedBook extends Model
{
    use HasFactory;

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function format()
    {
        return $this->belongsTo(Format::class);
    }

    public function libraries()
    {
        return $this->hasMany(Library::class);
    }

}
