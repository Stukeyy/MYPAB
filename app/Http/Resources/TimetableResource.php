<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TimetableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        // Event format to be disaplyed by FullCalendar plugin
        $start_date = Carbon::createFromFormat('d/m/Y H:i', ($this->start_date . ' ' . $this->start_time))->format('Y-m-d H:i');
        $end_date = Carbon::createFromFormat('d/m/Y H:i', ($this->end_date . ' ' . $this->end_time))->format('Y-m-d H:i');

        return [
            'id' => $this->id,
            'title' => $this->name,
            'start' => $start_date,
            'end' => $end_date,
            'eventDisplay' => 'block',
            'backgroundColor' => $this->tag->colour,
            'borderColor' => $this->tag->colour
        ];

    }
}
