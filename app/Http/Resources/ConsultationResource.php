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

        $situation_list = [
            "1" => " Indefinida",
            "74" => "Acompanhamento",
            "25" => "Aguardando",
            "27" => "Aguardando Aprovação",
            "70" => "Aguardando Cliente",
            "90" => "Aguardando Rollout",
            "13" => "Calculando Métricas",
            "250" => "Cancelada",
            "80" => "Cliente Validando",
            "82" => "Cliente Validou",
            "12" => "Coletando Evidências",
            "60" => "Controle de Qualidade",
            "15" => "CQ de Entrada",
            "62" => "CQ de Saída",
            "21" => "Desenvolvimento",
            "11" => "Detalhamento",
            "72" => "Disponível",
            "30" => "Documentação",
            "23" => "Elaborando Proposta",
            "5" => "Em Analise",
            "41" => "Em execução",
            "92" => "Em Rollout",
            "95" => "Encerrada",
            "61" => "Entrega",
            "20" => "Especificação",
            "251" => "Fechada",
            "10" => "Levantamento",
            "40" => "Não iniciada",
            "22" => "QA",
            "73" => "Respondido",
            "31" => "Revisão"
        ];   

        $response = [
            "request_key" => $this->request_key,
            "user" => $user->name,
            "situation" => isset($situation_list[$this->status]) ? $situation_list[$this->status] : 'NA',
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
