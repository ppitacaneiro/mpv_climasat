<?php
namespace App\Traits;

trait PhoneNormalization
{
    public function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[\s\-\(\)]/', '', $phone);
        $phone = str_replace(['whatsapp:', '+'], '', $phone);
        return $phone;
    }
}
