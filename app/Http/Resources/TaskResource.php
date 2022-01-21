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

            if ($this->start_date && $this->start_time) {
                
                $carbon_start_date = Carbon::createFromFormat('d/m/Y', $this->start_date);
                $inThePast = $carbon_start_date->isPast();
                $daysUntil = Carbon::now()->diffInDays($carbon_start_date);

                $read_start_date = Carbon::createFromFormat('d/m/Y H:i', ($this->start_date . ' ' . $this->start_time))->format('l \\t\\h\\e jS \\of F Y');
                $read_end_date = Carbon::createFromFormat('d/m/Y H:i', ($this->end_date . ' ' . $this->end_time))->format('l \\t\\h\\e jS \\of F Y');
                // Thursday the 21st October
                $read_start_time = Carbon::createFromFormat('H:i', $this->start_time)->format('H:i');
                $read_end_time = Carbon::createFromFormat('H:i', $this->end_time)->format('H:i');
                // 09:15 24 hour
            }

            return [
                'id' => $this->id,
                'task' => $this->task,
                'tag' => $this->tag->name,
                'priority' => $this->priority,
                'colour' => $this->tag->colour,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'start_date' => $this->start_date,
                'completed' => $this->completed,
                'notes' => $this->notes,
                'checklist' => (count($this->checks) > 0) ? CheckResource::collection($this->checks) : null
            ];

        }

    }
}
