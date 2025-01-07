<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Http\Resources\ChapterResource;

class ChapterController extends Controller
{
    public function show(Chapter $chapter){
        $chapter = $chapter->load('images');
        return new ChapterResource($chapter);
    }
}
