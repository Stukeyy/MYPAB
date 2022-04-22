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

        // Event format to be displayed by FullCalendar plugin
        // Merged collection passed to resource is made up of 3 different models
        // individual events, commitment events and user tasks

        // Tasks
        if (isset($this->task)) {
            $type = 'task';
            $title = $this->task;
            $completed = $this->completed;
        }
        // Individual Events and Commitment Events
        else {
            $type = 'event';
            $title = $this->name;
            $completed = false;
        }

        // If a start date, start time and end time have been set
        if (isset($this->start_date) && isset($this->start_time) && isset($this->end_time)) {
            $start_date = Carbon::createFromFormat('d/m/Y H:i', ($this->start_date . ' ' . $this->start_time))->format('Y-m-d H:i');
            $end_date = Carbon::createFromFormat('d/m/Y H:i', ($this->start_date . ' ' . $this->end_time))->format('Y-m-d H:i');
        }
        // If a start date and start time have been picked but no end time - automatically shown as an hour long on calendar
        // this applies to tasks only as events require a start and end time if not all day
        else if (isset($this->start_date) && isset($this->start_time) && !isset($this->end_time)) {
            $start_date = Carbon::createFromFormat('d/m/Y H:i', ($this->start_date . ' ' . $this->start_time))->format('Y-m-d H:i');
            $end_date = $start_date;
        // If a start date but no start time or end time has been picked - all day
        } else if (isset($this->start_date) && !isset($this->start_time) && !isset($this->end_time)) {
            $start_date = Carbon::createFromFormat('d/m/Y', ($this->start_date))->format('Y-m-d');
            $end_date = $start_date;
        }

        // If the event or task has been generated in the balancer, then show the suggested tag colour
        // which is a translucent version of the same colour to identify it is suggested and temporary until confirmation
        if ($this->suggested) {
            $colour = $this->tag->suggested;
        } else {
            $colour = $this->tag->colour;
        }

        return [
            'id' => $this->id,
            'title' => $title,
            'start' => $start_date,
            'end' => $end_date,
            'allDay' => $this->all_day,
            'display' => 'block',
            'backgroundColor' => $colour,
            'borderColor' => $colour,
            'type' => $type,
            'completed' => $completed,
            'suggested' => $this->suggested,
            'colour' => $this->tag->colour
        ];

    }
}
