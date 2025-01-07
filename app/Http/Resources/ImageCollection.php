<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ImageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function($image){
            return [
                'id' => $image->id,
                'type' => 'image',
                'attributes' => [
                    'order'=>$image->order_number,
                    'image' => $image->image_url,
                ]
            ];
        })->toArray();
    }
}
