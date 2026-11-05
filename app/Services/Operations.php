<?php

namespace App\Services;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Operations
{

    public static function decryptId($value)
        {
                return Crypt::decrypt($value);

        }

    public static function encryptId($value)
        {
            return Crypt::encrypt($value);
        }

    // Igual ao decryptId, mas devolve null em vez de lançar exceção
    // (usado nos Form Requests para saber qual registro ignorar no unique)
    public static function tryDecryptId($value)
        {
            try {
                return Crypt::decrypt($value);
            } catch (\Throwable $e) {
                return null;
            }
        }

}
