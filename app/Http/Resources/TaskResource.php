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

            $noChecklist = true;
            $checklistRatio = false;
            if (count($this->checks) > 0) {
                $completedChecks = 0;
                foreach ($this->checks as $check) {
                    if ($check->completed) {
                        $completedChecks++;
                    }
                }
                $noChecklist = false;
                $checklistRatio = $completedChecks . '/' . count($this->checks);
            }

            $taskUrgency = "future";
            if (!($this->completed) && $this->start_date) {
                $today = Carbon::now();
                $start_date = Carbon::createFromFormat('d/m/Y', $this->start_date);
                if ($today->isSameDay($start_date)) {
                    $taskUrgency = 'imminent';
                }
                else if ($start_date->isPast()) {
                    $taskUrgency = 'overdue';
                }
                else if (!$start_date->isPast()) {
                    $daysUntilTask = $today->diffInDays($start_date);
                    // task is today or tommorrow
                    if ($daysUntilTask <= 1) {
                        $taskUrgency = 'imminent';
                    // task is within a week
                    } else if ($daysUntilTask > 1 && $daysUntilTask < 7) {
                        $taskUrgency = 'thisWeek';
                    // task is next week
                    } else if ($daysUntilTask >= 7 && $daysUntilTask < 14) {
                        $taskUrgency = 'nextWeek';
                    }
                }
            }

            return [
                'id' => $this->id,
                'task' => $this->task,
                'tag_id' => $this->tag->id,
                'tag' => $this->tag->name,
                'tagColour' => $this->tag->colour,
                'priority' => $this->priority,
                'priorityColour' => $this->priorityColour(),
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'start_date' => $this->start_date,
                'completed' => $this->completed,
                'noChecklist' => $noChecklist,
                'checklistRatio' => $checklistRatio,
                'taskUrgency' => $taskUrgency,
                'checklist' => CheckResource::collection($this->checks)
            ];

        }
        else if ($type === "view") {

            $hasDate = isset($this->start_date);
            $hasTime = isset($this->start_time);
            if ($this->start_date) {
                $carbon_start_date = Carbon::createFromFormat('d/m/Y', $this->start_date);
                $inThePast = $carbon_start_date->isPast();
                $daysUntil = Carbon::now()->diffInDays($carbon_start_date);
            }

            return [
                'id' => $this->id,
                'task' => $this->task,
                'tag_id' => $this->tag->id,
                'tag' => $this->tag->name,
                'priority' => $this->priority,
                'colour' => $this->tag->colour,
                'hasDate' => $hasDate,
                'hasTime' => $hasTime,
                'inThePast' => ($hasDate) ? $inThePast : null,
                'daysUntil' => ($hasDate) ? $daysUntil : null,
                'all_day' => $this->all_day,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'start_date' => $this->start_date,
                'completed' => $this->completed,
                'hasNotes' => (strlen($this->notes) > 0),
                'notes' => $this->notes,
                'hasChecks' => (count($this->checks) > 0),
                'checklist' => CheckResource::collection($this->checks),
                'hasReminders' => (count($this->reminders) > 0),
                'reminders' => ReminderResource::collection($this->reminders)
            ];

        }
        else if ($type === "update") {

            $hasDate = isset($this->start_date);
            $hasTime = isset($this->start_time);
            if ($this->start_date) {
                // Date formated for element ui date picker
                $start_date = Carbon::createFromFormat('d/m/Y', $this->start_date);
            }

            return [
                'id' => $this->id,
                'task' => $this->task,
                'tag_id' => $this->tag->id,
                'priority' => $this->priority,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'hasDate' => $hasDate,
                'hasTime' => $hasTime,
                'all_day' => $this->all_day,
                'start_date' => ($hasDate) ? $start_date : '',
                'start_date_object' => ($hasDate) ? $start_date : '',
                'hasNotes' => (strlen($this->notes) > 0),
                'notes' => $this->notes,
                'hasChecks' => (count($this->checks) > 0),
                'checklist' => CheckResource::collection($this->checks),
                'hasReminders' => (count($this->reminders) > 0),
                'reminders' => ReminderResource::collection($this->reminders)
            ];

        }

    }
}
