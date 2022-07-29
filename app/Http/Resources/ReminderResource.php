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

            // structure needs to match default prop in vue reminder component to loop and display
            return [
                "key" => $this->id,
                "date_object" => $this->date_to_send,
                "time" => $this->time_to_send,
                "date" => $date_string,
                "error" => false
            ];
        }

    }
}
