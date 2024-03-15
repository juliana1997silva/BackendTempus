<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $response = [
            "request_key" => $this->request_key,
            "user" => $this->user_id,
            "situation" => $this->status,
            "documentation" => $this->documentation,
            "revision" => $this->revision,
            "bug" => $this->bug,
            "daily" => $this->daily,
            "update" => $this->update,
            "service_forecast" => $this->service_forecast,
            "commit" => $this->commit
        ];

        return $response;
    }
}
