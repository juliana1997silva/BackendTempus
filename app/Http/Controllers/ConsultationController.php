<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
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

            $consults = Consultations::where("request_key",$consulta)->where("user_id",$user)->first();
            if ( $consults != NULL )
                return response()->json($consults,  200);

            // $response = Http::
            //     withOptions([
            //         'verify' => false
            //     ])
            //     ->withHeaders([
            //         "accept"  => 'application/json;charset=iso-8859-1',
            //         "content-type" => "multipart/form-data;",
            //         "Authorization" => "Basic d2ZlbGl4OmZlbGl4MTcwMTEz",
            //         "Cookie"  => "PHPSESSID=v2h1dchcjnb8mgik2fh6ipaa95"
            //     ])
            //     ->post("https://interpres.conecto.com.br/get_data.php",
            //         [
            //             "query" => "task",
            //             "action" => "extra",
            //             "request_key" => "$consulta",
            //             "_" => "1710176337413"
            //         ]
            //     );

            
            $resultado = $this->client->post('/get_data.php',
                [
                    "query" => "task",
                    "action" => "extra",
                    "request_key" => "$consulta",
                    "_" => "1710176337413"
                ]
            );

            // return response()->json($resultado,  200);s
            $data = [];


            if ( !isset($resultado['attachment_list']) ) {
                $data['attachment_list']['qty'] = 0;
            }
            else {
                foreach ($resultado['attachment_list'] as $key => $attachment) {
                    $data['attachment'][$key]['name'] = $attachment['name'];
                    $data['attachment'][$key]['description'] = $attachment['description'];
                    $data['attachment'][$key]['insertion'] = $attachment['insertion'];
                }
            }
            
            if ( !isset($resultado['event_list']) ) {
                $data['event_list']['qty'] = 0;
            }
            else {
                // print_r($resultado['event_list']);
                foreach ($resultado['event_list'] as $key => $event) {
                    if ( isset($event['type']) ) {
                        switch ($event['type']) {
                            case '100':
                            case '111':
                                foreach ($data['attachment'] as $key => $attachment) {
                                    if ( $attachment['insertion'] == $event['insertion'] ) {
                                        $data['attachment'][$key]['user'] = $event['user_id'];
                                    }
                                }
                                break;
                            case '10':
                            case '102':    
                                if ( strstr($event['message'],"Dado \"Situação\" alterado de") || strstr($event['message'],"Situação alterada de") ) {
                                    if ( !isset($data['event']['status']['qty']) ) {
                                        $data['event']['status']['qty'] = 1;
                                        $data['event']['status']['start'] = $event['insertion'];
                                        $data['event']['status']['history'][$key]['message'] = $event['message'];
                                        $data['event']['status']['history'][$key]['date'] = $event['insertion'];
                                    }
                                    else {
                                        $data['event']['status']['qty']++;
                                    }
                                    if ( !isset($data['event']['status']['last']) ) {
                                        $data['event']['status']['last'] = $event['insertion'];
                                        $data['event']['status']['history'][$key]['message'] = $event['message'];
                                        $data['event']['status']['history'][$key]['datetime'] = $event['insertion'];
                                        $data['event']['status']['history'][$key]['user'] = $event['user_id'];
                                    }
                                    else{
                                        $data['event']['status']['last'] = $event['insertion'];
                                        $data['event']['status']['history'][$key]['message'] = $event['message'];
                                        $data['event']['status']['history'][$key]['datetime'] = $event['insertion'];
                                        $data['event']['status']['history'][$key]['user'] = $event['user_id'];
                                    }
                                }
            
                                if ( strstr($event['message'],"Dado \"Categoria\" alterado d") ) {
                                    if ( !isset($data['event']['category']['qty']) ) {
                                        $data['event']['category']['qty'] = 1;
                                        $data['event']['category']['start'] = $event['insertion'];
                                        $data['event']['category']['history'][$key]['message'] = $event['message'];
                                        $data['event']['category']['history'][$key]['datetime'] = $event['insertion'];
                                    }
                                    else {
                                        $data['event']['category']['qty']++;
                                    }
                                    if ( !isset($data['event']['category']['last']) ) {
                                        $data['event']['category']['last'] = $event['insertion'];
                                        $data['event']['category']['history'][$key]['message'] = $event['message'];
                                        $data['event']['category']['history'][$key]['datetime'] = $event['insertion'];
                                        $data['event']['category']['history'][$key]['user'] = $event['user_id'];
                                    }
                                    else{
                                        $data['event']['category']['last'] = $event['insertion'];
                                        $data['event']['category']['history'][$key]['message'] = $event['message'];
                                        $data['event']['category']['history'][$key]['datetime'] = $event['insertion'];
                                        $data['event']['category']['history'][$key]['user'] = $event['user_id'];
                                    }
                                }

                                if ( strstr($event['message'],"Início previsto de") || strstr($event['message'],"Fim previsto de") ) {
                                    $data['event']['status']['history'][$key]['message'] = $event['message'];
                                    $data['event']['status']['history'][$key]['datetime'] = $event['insertion'];
                                    $data['event']['status']['history'][$key]['user'] = $event['user_id'];
                                }
                                break;
                            case '104':
                                if ( $event['user_id'] == $user) {
                                    if ( !isset($data['event']['qty']) ) {
                                        $data['event']['qty'] = 1;
                                        $data['event']['start'] = $event['insertion'];
                                    }
                                    else {
                                        $data['event']['qty']++;
                                    }
                                    if ( !isset($data['event']['last']) ) {
                                        $data['event']['last'] = $event['insertion'];
                                    }
                                    else{
                                        $data['event']['last'] = $event['insertion'];
                                    }
                                }
                                break;
                            default:
                                // $data['event']['status']['history'][$key]['message'] = $event['message'];
                                // $data['event']['status']['history'][$key]['datetime'] = $event['insertion'];
                                // $data['event']['status']['history'][$key]['user'] = $event['user_id'];
                                break;
                        }
                    }
                }
            }

            $resultado = $this->client->post('/get_data.php',
                [
                    "query" => "cvs",
                    "action" => "list",
                    "request_key" => "$consulta",
                    "dates" => "no",
                    "_" => "1710176337413"
                ]
            );

            $data['cvs']['qty'] = 0;

            foreach ($resultado['data'] as $key => $cvs_item) {
                if ( !isset($data['cvs']['qty']) ) {
                    $data['cvs']['qty'] = 1;
                }
                else {
                    $data['cvs']['qty']++;
                }
                if ( !isset($data['cvs']['program']) ) {
                    $data['cvs']['program'][$key]['version'] = $cvs_item['version'];
                    $data['cvs']['program'][$key]['file'] = $cvs_item['file'];
                    $data['cvs']['program'][$key]['user'] = $cvs_item['user'];
                }
                else{
                    $data['cvs']['program'][$key]['version'] = $cvs_item['version'];
                    $data['cvs']['program'][$key]['file'] = $cvs_item['file'];
                    $data['cvs']['program'][$key]['user'] = $cvs_item['user'];
                }
            }

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
            
            $data['points']['after_dev'] = 0;
            $data['points']['documentation'] = 0;
            $data['points']['revision'] = 0;
            $data['points']['bug'] = 0;
            $data['points']['daily'] = 0;
            $data['points']['update'] = 0;
            $data['points']['service_forecast'] = 0;
            $data['points']['commit'] = 0;            
            $data['unknown'] = "unknown";
            
            //return response()->json($data,  200);
            //////////// VERIFICAÇÃO DO STATUS
            foreach ( $data as $key => $value) {
                switch ($key) {
                    case 'status_description':
                        if ( strstr($value,$user) ) {
                            $data['points']['daily']++;
                        }
                        break;
                    case 'event':
                        // TRATAR SITUAÇÃO
                        if ( is_array($value) && isset($value['status']) )  {
                            if ( isset($value['status']['history']) )  {
                                $history_list = $value['status']['history'];
                                foreach ($history_list as $history_item) {
                                    $history_item['message'] = str_replace(["\"","'"],"",$history_item['message']);
            
                                    if ( strstr($history_item['message'],"para Desenvolvimento") ) {
                                        $data['points']['update']++;
                                    }
            
                                    if ( strstr($history_item['message'],"alterado de Desenvolvimento para") ) {
                                        $data['points']['after_dev']++;
                                    }
            
                                    if ( strstr($history_item['message'],"alterado de Desenvolvimento para") ) {
                                        $data['points']['after_dev']++;
                                    }
            
                                    if ( strstr($history_item['message']," para Revisão") ) {
                                        $data['points']['revision']++;
                                    }
                                    
                                    if ( strstr($history_item['message'],"Início previsto de") ) {
                                        $data['points']['service_forecast']++;
                                    }

                                    if ( strstr($history_item['message'],"Fim previsto de") ) {
                                        $data['points']['service_forecast']++;
                                    }
                                    

                                }
                                
                            }
                        }
                        break;
                }
                
            }
            
            foreach ( $data as $key => $value) {
                switch ($key) {
                    case 'cvs':
                        if ( is_array($value) && isset($value['program']) )  {
                            $program_list = $value['program'];
                            foreach ($program_list as $program_item) {
                                if ( $program_item['user'] == $user ) {
                                    $data['points']['commit']++;
                                }
                            }
                        }
                        break;
                    case 'attachment':
                        if ( is_array($value) )  {
                            $attachment_list = $value;
                            foreach ($attachment_list as $attachment_item) {
                                if ( strstr(strtoupper($attachment_item['name']),"GUIA") || strstr(strtoupper($attachment_item['description']),"GUIA")  ) {
                                    if ( $attachment_item['user'] == $user ) {
                                        $data['points']['documentation']++;
                                    }
                                }
                            }
                        }
                      
                        break;
                }
                
            }


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
                    'documentation' => ($data['points']['documentation'] > 0) ? true : false,
                    'revision' => ($data['points']['revision'] > 0) ? true : false,
                    'bug' => ($data['points']['bug'] > 0) ? true : false,
                    'daily' => ($data['points']['daily'] > 0) ? true : false,
                    'update' => ($data['points']['update'] > 0) ? true : false,
                    'service_forecast' => ($data['points']['service_forecast'] > 0) ? true : false,
                    'commit' => ($data['points']['commit'] > 0) ? true : false
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
