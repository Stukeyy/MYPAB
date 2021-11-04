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
        // type is sent from Frontend page making event request
        $type = $request["type"];

        if ($type === "index") {
            
            $read_start_date = Carbon::createFromFormat('d/m/Y H:i', ($this->start_date . ' ' . $this->start_time))->format('d/m/Y');
            $read_end_date = Carbon::createFromFormat('d/m/Y H:i', ($this->end_date . ' ' . $this->end_time))->format('d/m/Y');
            // 01/12/2021
            $read_start_time = Carbon::createFromFormat('H:i', $this->start_time)->format('h:ia');
            $read_end_time = Carbon::createFromFormat('H:i', $this->end_time)->format('h:ia');
            // 09:15am

            return [
                'id' => $this->id,
                'name' => $this->name,
                'tag' => $this->tag->name,
                'colour' => $this->tag->colour,
                'start_time' => $read_start_time,
                'end_time' => $read_end_time,
                'start_date' => $read_start_date,
                'end_date' => $read_end_date,
                'notes' => $this->notes,
                'checklist' => (count($this->checks) > 0) ? CheckResource::collection($this->checks) : null
            ];

        }
        else if ($type === "view") {

            $carbon_start_date = Carbon::createFromFormat('d/m/Y', $this->start_date);
            $inThePast = $carbon_start_date->isPast();
            $daysUntil = Carbon::now()->diffInDays($carbon_start_date);
            
            $read_start_date = Carbon::createFromFormat('d/m/Y H:i', ($this->start_date . ' ' . $this->start_time))->format('l \\t\\h\\e jS \\of F Y');
            $read_end_date = Carbon::createFromFormat('d/m/Y H:i', ($this->end_date . ' ' . $this->end_time))->format('l \\t\\h\\e jS \\of F Y');
            // Thursday the 21st October
            $read_start_time = Carbon::createFromFormat('H:i', $this->start_time)->format('h:ia');
            $read_end_time = Carbon::createFromFormat('H:i', $this->end_time)->format('h:ia');
            // 09:15am

            return [
                'id' => $this->id,
                'name' => $this->name,
                'tag' => $this->tag->name,
                'colour' => $this->tag->colour,
                'inThePast' => $inThePast,
                'daysUntil' => $daysUntil,
                'start_time' => $read_start_time,
                'end_time' => $read_end_time,
                'start_date' => $read_start_date,
                'end_date' => $read_end_date,
                'notes' => $this->notes,
                'checklist' => (count($this->checks) > 0) ? CheckResource::collection($this->checks) : null
            ];
        } 
        else if ($type === "update") {

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
                'notes' => $this->notes,
                'noChecklist' => (count($this->checks) === 0),
                'checklist' => CheckResource::collection($this->checks)
            ];

        }

    }
}
