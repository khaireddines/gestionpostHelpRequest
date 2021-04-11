<?php

namespace App\Traits;

trait  GenerateCode
{
    public function generateCode(){
        $string = "1234567890";
        $lengthString = strlen($string);
        $code = "";
        $lengthPass = 4;
        for ($i = 1; $i <= $lengthPass; $i++) {
            $pos = rand(0, $lengthString - 1);
            $code .= substr($string, $pos, 1);
        }
        return $code;
    }

}
