<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description_en',
        'description_uk',
        'image',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
