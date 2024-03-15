<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

use App\Http\CustomHttpClient;
use App\Http\Requests\ConsultationRequest;
use App\Http\Resources\ConsultationResource;
use App\Models\Consultations;

class ConsultationController extends Controller
{
    public $url_base= "https://interpres.conecto.com.br";
    public $client = NULL;

    public function __construct() {
        $this->client = new CustomHttpClient($this->url_base);
    }

    public function index()
    {
        try {

            $consults = Consultations::all();
            if ( $consults != NULL )
                return response()->json(ConsultationResource::collection($consults),  200);

        } catch (\Exception $e) {
            return response()->json(["error" => $e], 500);
        }
    }

    public function store($consulta,$user)
    {
         try {

            $consults = Consultations::find($consulta);
            if ( $consults != NULL )
                return response()->json($consults,  200);

            $resultado = $this->client->post('/get_data.php',
                [
                    "query" => "task",
                    "action" => "extra",
                    "request_key" => "$consulta",
                    "_" => "1710176337413"
                ]
            );

            $data = [];

            $resultado = $this->client->post('/get_data.php',
                [
                    "query" => "task",
                    "action" => "get",
                    "request_key" => "$consulta",
                    "_" => "1710176337413"
                ]
            );

            $situation_after = isset($resultado['data'][0]['status_description'])  ? $resultado['data'][0]['status_description'] : "";

            $data['description'] = $resultado['data'][0]['description'];
            $data['status'] = $resultado['data'][0]['status'];
            $data['status_description'] = $situation_after;
            $data['planned_begin_time'] = $resultado['data'][0]['planned_begin_time'];
            if ( $data['planned_begin_time'] == 'indefinida' ) {
                $data['planned_begin_time'] = NULL;
            }
            else {
                $data['planned_begin_time'] = Carbon::createFromFormat('d/m/Y H:i:s', $data['planned_begin_time'])->format('Y-m-d H:i:s');
            }
            
            $data['planned_end_time'] = $resultado['data'][0]['planned_end_time'];
            if ( $data['planned_end_time'] == 'indefinida' ) {
                $data['planned_end_time'] = NULL;
            }
            else{
                $data['planned_end_time'] = Carbon::createFromFormat('d/m/Y H:i:s', $data['planned_end_time'])->format('Y-m-d H:i:s');
            }
            
            $data['begin_time'] = $resultado['data'][0]['begin_time'];
            if ( $data['begin_time'] == 'indefinida' ) {
                $data['begin_time'] = NULL;
            }
            else {
                $data['begin_time'] = Carbon::createFromFormat('d/m/Y H:i:s', $data['begin_time'])->format('Y-m-d H:i:s');
            }

            $data['end_time'] = $resultado['data'][0]['end_time'];
            if ( $data['end_time'] == 'indefinida' ) {
                $data['end_time'] = NULL;
            }
            else {
                $data['end_time'] = Carbon::createFromFormat('d/m/Y H:i:s', $data['end_time'])->format('Y-m-d H:i:s');
            }

            $data['agreed_begin_time'] = $resultado['data'][0]['agreed_begin_time'];
            if ( $data['agreed_begin_time'] == 'indefinida' ) {
                $data['agreed_begin_time'] = NULL;
            }
            else {
                $data['agreed_begin_time'] = Carbon::createFromFormat('d/m/Y H:i:s', $data['agreed_begin_time'])->format('Y-m-d H:i:s');
            }

            $data['agreed_end_time'] = $resultado['data'][0]['agreed_end_time'];
            if ( $data['agreed_end_time'] == 'indefinida' ) {
                $data['agreed_end_time'] = NULL;
            }
            else {
                $data['agreed_end_time'] = Carbon::createFromFormat('d/m/Y H:i:s', $data['agreed_end_time'])->format('Y-m-d H:i:s');
            }
            
            $data['unknown'] = "unknown";
            
            $create =
                [
                    'id' => (string) Str::uuid(),
                    'user_id' => $user,
                    'registry_id' => NULL,
                    'queries' => $consulta,
                    'description' => $data['description'],
                    'link' => "https://interpres.conecto.com.br/task.php?task_key=$consulta",
                    'request_key' => $consulta,
                    'agreed_begin_time' => $data['agreed_begin_time'],
                    'agreed_end_time' => $data['agreed_end_time'],
                    'begin_time' => $data['begin_time'],
                    // 'category' => $data['unknown'],
                    // 'complexity' => $data['unknown'],
                    // 'current_department' => $data['unknown'],
                    // 'customer_key' => $data['unknown'],
                    // 'customer_priority' => $data['unknown'],
                    // 'department_begin_time' => $data['unknown'],
                    // 'department_end_time' => $data['unknown'],
                    // 'department_insertion' => $data['unknown'],
                    'end_time' => $data['end_time'],
                    // 'insertion' => $data['unknown'],
                    // 'long_description' => $data['unknown'],
                    'planned_begin_time' => $data['planned_begin_time'],
                    'planned_end_time' => $data['planned_end_time'],
                    // 'priority' => $data['unknown'],
                    // 'severity' => $data['unknown'],
                    'status' => $data['status'],
                    'status_description' => $data['status_description'],
                    // 'summary_text' => $data['unknown'],
                    // 'task_type' => $data['unknown'],
                    'documentation' => false,
                    'revision' => false,
                    'bug' => false,
                    'daily' => false,
                    'update' => false,
                    'service_forecast' => false,
                    'commit' => false
                ];

                $create_rsl = Consultations::create($create);
            

            return response()->json($create_rsl,  200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e], 500);
        }
    }

    public function update(ConsultationRequest $request, $id)
    {
        try {
            $consults = Consultations::find($consulta);
            if ( $consults != NULL )
                return response()->json($consults,  200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e], 500);
        }
    }

    public function destroy($id)
    {
        Consultations::find($id)->delete();

        return response()->json("Deletado com sucesso.",  200);
    }
}
