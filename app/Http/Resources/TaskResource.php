<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TaskResource extends JsonResource
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

            return [
                'id' => $this->id,
                'task' => $this->task,
                'tag' => $this->tag->name,
                'priority' => $this->priority,
                'colour' => $this->tag->colour,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'start_date' => $this->start_date,
                'completed' => $this->completed
            ];

        } 
        else if ($type === "view") {

            $carbon_start_date = Carbon::createFromFormat('d/m/Y', $this->start_date);
            $inThePast = $carbon_start_date->isPast();
            $daysUntil = Carbon::now()->diffInDays($carbon_start_date);

            return [
                'id' => $this->id,
                'task' => $this->task,
                'tag' => $this->tag->name,
                'priority' => $this->priority,
                'colour' => $this->tag->colour,
                'inThePast' => $inThePast,
                'daysUntil' => $daysUntil,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'start_date' => $this->start_date,
                'completed' => $this->completed,
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
                'task' => $this->task,
                'tag_id' => $this->tag->id,
                'priority' => $this->priority,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'all_day' => $this->all_day,
                'start_date' => $start_date,
                'notes' => $this->notes,
                'noChecklist' => (count($this->checks) === 0),
                'checklist' => CheckResource::collection($this->checks)
            ];

        }

    }
}
