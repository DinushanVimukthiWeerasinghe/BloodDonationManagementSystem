<?php

namespace App\model\Utils;

class Security
{
    public static function Encrypt($data): bool|string
    {
        return openssl_encrypt($data,ENCRYPTION_METHOD,ENCRYPTION_KEY,0,ENCRYPTION_IV);
    }

    public static function Decrypt($data): bool|string
    {
        return openssl_decrypt($data,ENCRYPTION_METHOD,ENCRYPTION_KEY,0,ENCRYPTION_IV);
    }

    public static function HashData($data): string
    {
        return hash_hmac(HASH_ALGORITHM,$data,ENCRYPTION_KEY);
    }

    public static function VerifyHash($data,$hash): bool
    {
        return hash_equals($hash,hash_hmac(HASH_ALGORITHM,$data,ENCRYPTION_KEY));
    }




}