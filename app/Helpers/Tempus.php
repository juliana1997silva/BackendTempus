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
}
