<?php

namespace App\Enums;

use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum DocumentEnum: string
{
    use UsefulEnums;

    case pks                    = "PKS";
    case tor                    = "TOR";
    case rab                    = "RAB";
    case sptjm                  = "SPTJM";
    case mou                    = "MOU";
    case bank_transfer_proceeds = "Bukti Transfer Bank";
    case sk_uls                 = "SK Pendirian ULS";
    case sk_pengelola_kerjasama = "SK Pengelola Kerjasama";
    case ia                     = "Implementation of Agreement (IA)";

    public static function fromName(string $name)
    {
        return constant("self::$name");
    }
}
