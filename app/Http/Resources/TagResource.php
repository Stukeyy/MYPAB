<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $children = $this->children;
        $child = $this->children->first();
        return $child;
        if ($child->name === 'Work' || $child->name === 'Life') {
            $children = $this->children->skip(1);
        }
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'global' => $this->global,
            'colour' => $this->colour,
            'children' => TagResource::collection($children)
        ];

    }
}
