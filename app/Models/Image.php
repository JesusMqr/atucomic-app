<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Image extends Model
{
    use HasFactory;
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
}
