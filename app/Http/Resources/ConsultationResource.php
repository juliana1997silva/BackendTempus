<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Users;

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
        $user = Users::where('user_interpres_code',$this->user_id)->first();

        $response = [
            "request_key" => $this->request_key,
            "user" => $user->name,
            "situation" => $this->status,
            "documentation" => $this->documentation,
            "revision" => $this->revision,
            "bug" => $this->bug,
            "daily" => $this->daily,
            "update" => $this->update,
            "service_forecast" => $this->service_forecast,
            "commit" => $this->commit,
            "link" => $this->link
        ];

        return $response;
    }
}
