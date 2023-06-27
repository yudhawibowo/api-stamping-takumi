<?php

namespace App\Helpers;

class Helper {
    public static function getMessage($status_code)
    {
        switch ($status_code) {
            case 404:
                return 'Halaman tidak ditemukan!';
                break;
            case 500:
                return 'Internal server error!';
                break;
            case 400:
                return 'Mohon maaf kami tidak bisa menerima permintaan anda!';
                break;
            case 401:
                return 'Token sudah expired. Silakan login telebih dahulu!';
                break;
            
            default:
                # code...
                break;
        }
    }
}