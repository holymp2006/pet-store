<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     */
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'category_uuid' => $this->category->uuid,
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'metadata' => $this->metadata,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
