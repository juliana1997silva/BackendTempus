<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Request;

class Tempus
{
    public static function uuid()
    {
        return strtoupper(sprintf('%s-%s-%04x-%04x-%s',
            bin2hex(openssl_random_pseudo_bytes(2)),
            bin2hex(openssl_random_pseudo_bytes(4)),
            hexdec(bin2hex(openssl_random_pseudo_bytes(3))) & 0x0fff | 0x5692 | 0x0312,
            hexdec(bin2hex(openssl_random_pseudo_bytes(2))) & 0x3fff | 0x2403,
            bin2hex(openssl_random_pseudo_bytes(6))
        ));
    }

    public static function getSituations($situation = NULL) {
        $data = [
            "255" => [ "name" => "Aberta", "color" => "#FFFFF" ],
            "0" => [ "name" => "Todas", "color" => "#FFFFF" ],
            "1" => [ "name" => " Indefinida", "color" => "#FFFFF" ],
            "74" => [ "name" => "Acompanhamento", "color" => "#FFFFF" ],
            "25" => [ "name" => "Aguardando", "color" => "#ff6d01" ],
            "27" => [ "name" => "Aguardando Aprovação", "color" => "#ff6d01" ],
            "70" => [ "name" => "Aguardando Cliente", "color" => "#ff6d01" ],
            "90" => [ "name" => "Aguardando Rollout", "color" => "#ff6d01" ],
            "13" => [ "name" => "Calculando Métricas", "color" => "#FFFFF" ],
            "250" => [ "name" => "Cancelada", "color" => "#FFFFF" ],
            "80" => [ "name" => "Cliente Validando", "color" => "#FFFFF" ],
            "82" => [ "name" => "Cliente Validou", "color" => "#FFFFF" ],
            "12" => [ "name" => "Coletando Evidências", "color" => "#FFFFF" ],
            "60" => [ "name" => "Controle de Qualidade", "color" => "#5f58c6" ],
            "15" => [ "name" => "CQ de Entrada", "color" => "#FFFFF" ],
            "62" => [ "name" => "CQ de Saída", "color" => "#FFFFF" ],
            "21" => [ "name" => "Desenvolvimento", "color" => "#fbbc04" ],
            "11" => [ "name" => "Detalhamento", "color" => "#FFFFF" ],
            "72" => [ "name" => "Disponível", "color" => "#FFFFF" ],
            "30" => [ "name" => "Documentação", "color" => "#FFFFF" ],
            "23" => [ "name" => "Elaborando Proposta", "color" => "#FFFFF" ],
            "5" => [ "name" => "Em Analise", "color" => "#FFFFF" ],
            "41" => [ "name" => "Em execução", "color" => "#FFFFF" ],
            "92" => [ "name" => "Em Rollout", "color" => "#FFFFF" ],
            "95" => [ "name" => "Encerrada", "color" => "#FFFFF" ],
            "61" => [ "name" => "Entrega", "color" => "#FFFFF" ],
            "20" => [ "name" => "Especificação", "color" => "#FFFFF" ],
            "251" => [ "name" => "Fechada", "color" => "#1976D2" ],
            "10" => [ "name" => "Levantamento", "color" => "#FFFFF" ],
            "40" => [ "name" => "Não iniciada", "color" => "#d9d9d9" ],
            "22" => [ "name" => "QA", "color" => "#FFFFF" ],
            "73" => [ "name" => "Respondido", "color" => "#FFFFF" ],
            "31" => [ "name" => "Revisão" , "color" => "#FFFFF" ] 
        ];

        if ( $situation != NULL ) return ( isset($data[$situation]) ) ? $data[$situation] : NULL;
        return $data;
    }

}
