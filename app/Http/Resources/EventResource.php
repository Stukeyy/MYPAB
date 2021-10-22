<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {   

        // Date formated for element ui date picker
        $start_date = Carbon::createFromFormat('d/m/Y', $this->start_date);

        $noChecklist = [[
            'key' => 0,
            'value' => '',
            'error' => false
        ]];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'tag_id' => $this->tag->id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'start_date' => $start_date,
            'notes' => ($this->notes) ? $this->notes : '',
            'checklist' => $this->checks
        ];

    }
}
