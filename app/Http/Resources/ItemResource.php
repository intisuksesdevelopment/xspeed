<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
{
    return [
        'uuid' => $this->uuid,
        'name' => $this->name,
        'sell_price' => (float) $this->sell_price,
        'stock' => (int) $this->stock,
        'created_at' => $this->created_at,

        'category' => [
            'name' => $this->category->name ?? null,
        ],

        'brand' => [
            'name' => $this->brand->name ?? null,
        ],

        'rack' => [
            'name' => $this->rack->name ?? null,
        ],

        'image' => $this->thumbnail->url ?? null,
    ];
}
}
