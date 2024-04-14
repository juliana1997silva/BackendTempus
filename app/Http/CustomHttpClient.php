<?php
namespace App\Http;
use Illuminate\Support\Facades\Http;

class CustomHttpClient
{
    protected $baseUrl;
    protected $ch;

    public function __construct($baseUrl)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->ch = curl_init();
    }

    public function post($uri, $data = [])
    {
        $url = $this->baseUrl . '/' . ltrim($uri, '/');

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_VERBOSE, false);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json;charset=iso-8859-1'
        ));
        $cookie = 'PHPSESSID=ja3v2ejt5hla9ulonh6ap1db9u';
        curl_setopt($this->ch, CURLOPT_COOKIE, $cookie);

        $jsonString = curl_exec($this->ch);

        $response = json_decode(mb_convert_encoding($jsonString, 'UTF-8', 'ISO-8859-1'),true);
        // $response = json_decode($jsonString,true);

        if ($response === false) {
            throw new \RuntimeException('cURL error: ' . curl_error($this->ch));
        }
        
        return $response;
        
        // $response = Http::withHeaders([
        //     'Accept' => 'application/json;charset=iso-8859-1',
        //     'Authorization' => "Basic d2ZlbGl4OmZlbGl4MTcwMTEz",
        //     // 'Content-Type' => 'application/json;charset=iso-8859-1',
        //     'Cookie' => 'PHPSESSID=ja3v2ejt5hla9ulonh6ap1db9u',
        //     // 'Referer' => 'https://interpres.conecto.com.br/task_home.php?request_key=59128',
        //     // 'X-Requested-With' => 'XMLHttpRequest'
        // ])
        // // ->withoutVerifying()
        // // ->asForm()               
        // // ->post($this->baseUrl."/get_data.php", $data);
        // ->post($this->baseUrl."/get_data.php?query=task&action=extra&request_key=59128&_=1712496348515");

        // return $response->json();
    }

    // Métodos para outros tipos de requisição (get, put, delete, etc) podem ser adicionados aqui conforme necessário

    public function __destruct()
    {
        curl_close($this->ch);
    }
}
