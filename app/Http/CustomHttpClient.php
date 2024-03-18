<?php
namespace App\Http;

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
        $cookie = 'PHPSESSID=v2h1dchcjnb8mgik2fh6ipaa95';
        curl_setopt($this->ch, CURLOPT_COOKIE, $cookie);

        $jsonString = curl_exec($this->ch);

        $response = json_decode(utf8_encode($jsonString),true);

        if ($response === false) {
            throw new \RuntimeException('cURL error: ' . curl_error($this->ch));
        }

        return $response;
    }

    // Métodos para outros tipos de requisição (get, put, delete, etc) podem ser adicionados aqui conforme necessário

    public function __destruct()
    {
        curl_close($this->ch);
    }
}
