<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Serie extends Model
{
    use HasFactory;
    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
