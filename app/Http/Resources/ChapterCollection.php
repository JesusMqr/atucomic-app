<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ChapterCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function($chapter){
            return [
                'id'=>$chapter->id,
                'type'=>'chapter',
                'attributes'=>[
                    'order'=>$chapter->order_number,
                    'created_at'=>$chapter->created_at,
                ]
            ];
        })->toArray();
    }
}
