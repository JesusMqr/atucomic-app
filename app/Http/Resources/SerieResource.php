<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ChapterCollection;
class SerieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'type'=>'serie',
            'attributes'=>[
                'title'=>$this->title,
                'description'=>$this->description,
                'banner_image'=>$this->banner_image_url,
                'cover_image'=>$this->cover_image_url,
                'author' =>$this->owner->name,
                'updated_at'=>$this->updated_at,
                'total_chapters'=>$this->chapters->count(),
                'type'=>$this->type,
                'status'=>$this->status,

            ],
            'relationships'=>[
                'chapters'=>new ChapterCollection($this->chapters)
            ]
        ];
    }
}
