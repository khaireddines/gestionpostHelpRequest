<?php
namespace App\Traits;

trait  GeneratePassword{

    public function generateRegistrationPassword($length=4){

            $string = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            $lengthString = strlen($string);
            $pass = "";
            $lengthPass = $length;
            for ($i = 1; $i <= $lengthPass; $i++) {
                $pos = rand(0, $lengthString - 1);
                $pass .= substr($string, $pos, 1);
            }

            return $pass;
    }
}
