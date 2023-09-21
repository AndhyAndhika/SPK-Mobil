<?php

namespace App\Helpers;

class BobotNilai
{
    public static function NilaiSatuan($nilai)
    {
        switch ($nilai) {
            case 1:
                return "Tidak Penting";
                break;
            case 2:
                return "Kurang Penting";
                break;
            case 3:
                return "Cukup Penting";
                break;
            case 4:
                return "Penting";
                break;
            case 5:
                return "Sangat Penting";
                break;
            default:
                return "Tidak Terdefinisi";
                break;
        }
    }
}
