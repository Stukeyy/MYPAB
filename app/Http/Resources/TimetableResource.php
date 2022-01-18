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
            // If a start date and start time have been picked and end time updated via balance or calender drag and drop
            if (isset($this->start_date) && isset($this->start_time) && isset($this->end_time)) {
                $start_date = Carbon::createFromFormat('d/m/Y H:i', ($this->start_date . ' ' . $this->start_time))->format('Y-m-d H:i');
                $end_date = Carbon::createFromFormat('d/m/Y H:i', ($this->start_date . ' ' . $this->end_time))->format('Y-m-d H:i');
                $all_day = false;
            }
            // If a start date and start time have been picked
            else if (isset($this->start_date) && isset($this->start_time)) {
                $start_date = Carbon::createFromFormat('d/m/Y H:i', ($this->start_date . ' ' . $this->start_time))->format('Y-m-d H:i');
                $end_date = $start_date;
                $all_day = false;
            // If a start date but no start time has been picked
            } else if (isset($this->start_date) && !isset($this->start_time)) {
                $start_date = Carbon::createFromFormat('d/m/Y', ($this->start_date))->format('Y-m-d');
                $end_date = $start_date;
                $all_day = true;
            }
        }
        // Individual Events and Commitment Events
        else {
            // Commitments and Events require a start date and time and end date and time
            $type = 'event';
            $title = $this->name;
            $start_date = Carbon::createFromFormat('d/m/Y H:i', ($this->start_date . ' ' . $this->start_time))->format('Y-m-d H:i');
            $end_date = Carbon::createFromFormat('d/m/Y H:i', ($this->end_date . ' ' . $this->end_time))->format('Y-m-d H:i');
            $all_day = false;
        }


        return [
            'id' => $this->id,
            'title' => $title,
            'start' => $start_date,
            'end' => $end_date,
            'allDay' => $all_day,
            'eventDisplay' => 'block',
            'backgroundColor' => $this->tag->colour,
            'borderColor' => $this->tag->colour,
            'type' => $type
        ];

    }
}
