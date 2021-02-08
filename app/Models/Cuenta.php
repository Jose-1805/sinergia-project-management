<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cuenta
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Cuenta extends Model {

    protected $table = "cuenta";
    
    public function persona() {
        return $this->belongsTo("App\Models\Persona");
    }
    
    public function tiposCuenta(){
        return $this->belongsToMany("App\Models\TipoCuenta","cuentatipocuenta","cuenta_id","tipocuenta_id");
    }

    public static function generarPassword() {
        $passEncript = "";
        $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJCLMNOPQRSTUVWXYZ1234567890";

        $cantAleatorio = rand(10, 15);
        $pass = '';
        for ($i = 0; $i < $cantAleatorio; $i++) {
            $caracter = rand(0, strlen($caracteres));
            $caracter = substr($caracteres, $caracter, 1);
            $pass = $pass . '' . $caracter;
        }

        $passEncript = md5($pass);

        return array("pass"=>$pass,"passEncript"=>$passEncript);
    }
}
