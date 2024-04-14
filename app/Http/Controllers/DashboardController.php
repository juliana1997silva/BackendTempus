<?php

namespace App\Http\Controllers;

use App\Models\Consultations;
use App\Helpers\Tempus;

class DashboardController extends Controller
{
    public function index()
    {

        $consults = Consultations::all();

        $consultations = [];
        $consultations_count = [];
        foreach ( $consults as $consult ) {
            if ( !isset($consultations_count[$consult->status]) )
                $consultations_count[$consult->status] = 1;
            else
                $consultations_count[$consult->status]++;
        }

        foreach ( $consultations_count as $status => $qty ) {
            $situation = Tempus::getSituations($status);

            $consultations[] = [
                mb_convert_encoding($situation['name'], 'UTF-8', 'ISO-8859-1'),
                $consultations_count[$status],
                $situation['color']
            ];
        }    

        return response()->json(
            [
                'consultations' =>
                    [
                        $consultations
                    ],
                'cheats' => 
                    [
                        [
                            "date" => "19/Mar/2023",
                            "status" => "Aprovada"
                        ],
                        [
                            "date" => "20/Mar/2023",
                            "status" => "Aprovada"
                        ],
                        [
                            "date" => "21/Mar/2023",
                            "status" => "Reprovada"
                        ]
                    ]
            ],
        200);
    }

}
