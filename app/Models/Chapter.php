<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Chapter extends Model
{
    use HasFactory;
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class, 'serie_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
