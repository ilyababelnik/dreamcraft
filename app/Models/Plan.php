<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en',
        'title_uk',
        'duration',
        'price',
        'description_en',
        'description_uk',
        'restrictions_en',
        'restrictions_uk',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
