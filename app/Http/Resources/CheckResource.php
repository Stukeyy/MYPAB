<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CheckResource extends JsonResource
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

      if ($type === "index" || $type === "view") {
          return [
              "id" => $this->id,
              "check" => $this->check,
              "completed" => $this->completed
          ];
      } 
      else if ($type === "update") {
          return [
              "id" => $this->id,
              "value" => $this->check,
              "error" => false
          ];
      }

    }
}
