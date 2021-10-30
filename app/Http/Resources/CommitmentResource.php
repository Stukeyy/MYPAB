<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CommitmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {   
        // Creates string format for JS new Date() method
        $js_start_date_object = Carbon::createFromFormat('d/m/Y', $this->start_date)->format('Y/m/d');
        $js_end_date_object = Carbon::createFromFormat('d/m/Y', $this->end_date)->format('Y/m/d');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'tag_id' => $this->tag->id,
            'tag' => $this->tag->name,
            'tag_colour' => $this->tag->colour,
            'occurance' => $this->occurance,
            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'start_date_object' => $js_start_date_object,
            'end_date_object' => $js_end_date_object
        ];
    }
}
