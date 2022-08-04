<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ReminderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // type is sent from Frontend pag making event request
        $type = $request["type"];

        if ($type === "update") {

            // Date formated for element ui date picker
            // date_to_send has not been casted yet so is still a carbon object
            $date_string = $this->date_to_send->format('d/m/Y');

            // element ui date picker can automatically format the date provided to display in field but the actual value will remain as PHP date format
            // if the date is not changed in update form, then it will still be in PHP date format and break JS code
            // timestamp is attached so if reminder not changed, the timestamp can be parsed to make JS date format from PHP format and not break code
            $timestamp = strtotime($this->date_to_send);

            // structure needs to match default prop in vue reminder component to loop and display
            return [
                "key" => $this->id,
                "id" => $this->id,
                "date_object" => $this->date_to_send,
                "timestamp" => $timestamp,
                "time" => $this->time_to_send,
                "date" => $date_string,
                "error" => false
            ];
        }
        else if ($type === "view") {

            // Date formated
            // date_to_send has not been casted yet so is still a carbon object
            $date_string = $this->date_to_send->format('d/m/Y');

            return [
                "id" => $this->id,
                "date" => $date_string,
                "time" => $this->time_to_send
            ];
        }

    }
}
