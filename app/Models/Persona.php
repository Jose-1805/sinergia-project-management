<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Persona
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cuenta;
use App\Models\TipoCuenta;
use App\Models\CuentaTipoCuenta;

Class Persona extends Model {

    protected $table = "persona";
    protected $guarded = ['id', 'account_id'];
    public $timestamps = false;

    /**
     * Valida la informacion de ingreso un usuario
     * 
     * @param type $password
     * @return array con los nombres de las cuenrtas activas 
     * false si el passsword es incorrecto
     */
    public function validar($password) {
        $cuenta = $this->cuenta;
        $roles = null;
        if ($cuenta) {
            if ($cuenta->cue_password == md5($password) || $cuenta->cue_password_restaurar == md5($password)) {
                if($cuenta->cue_password_restaurar == md5($password)){
                    $cuenta->cue_password = md5($password);
                }
                $cuenta->cue_password_restaurar = "";
                $cuenta->save();
                $tiposCuenta = $cuenta->tiposCuenta()->where('cuentatipocuenta.cue_tip_estado', 'activo')->get();
                foreach ($tiposCuenta as $c) {
                    $roles[] = $c->tip_cue_nombre;
                }
            } else {
                return false;
            }
        }
        return $roles;
    }

    /**
     * Valida el estado de un investigador según su correo electronico
     * 
     * @return 1 -> si el correo pertenece a un usuario tipo investigador y su cuenta esta activa
     * 2 -> si el correo pertenece a un usuario tipo investigador y su cuenta no esta activa
     * 3 -> si el correo pertenece a un usuario pero no es de tipo investigador 
     * 4 -> si el correo pertenece a un usuario que aún no tiene una cuenta creada
     * 5 -> si el correo no pertenece a un usuario
     */
    public function estadoCorreoInvestigador() {
        if ($this->id != null && $this->id != "") {
            $cuenta = $this->cuenta;
            if ($cuenta) {
                foreach ($cuenta->tiposCuenta()->where("cuentatipocuenta.cue_tip_estado","activo")->get() as $rol) {
                    if ($rol->tip_cue_nombre == 'investigador') {
                            return '1';
                    }
                }
                
                foreach ($cuenta->tiposCuenta()->where("cuentatipocuenta.cue_tip_estado","inactivo")->get() as $rol) {
                    if ($rol->tip_cue_nombre == 'investigador') {
                            return '2';
                    }
                }
                return '3';
            } else {
                return '4';
            }
        }
        return '5';
    }

    /**
     * Crea una cuenta que se relaciona con los datos que posee el objto Persona
     * 
     * @param type string tipo -> nombre del tipo de cuenta que se desea crear
     * 
     * @return Boolean/string
     * String -> Si se crea la cuenta se retorna el password
     * False -> si no es posible crear la cuenta
     */
    public function nuevaCuenta($tipo) {
        $tipoCuenta = TipoCuenta::firstOrNew(['tip_cue_nombre' => $tipo]);
        $password = '';
        if ($tipoCuenta->id != '') {
            $cuenta = new Cuenta;
            $password = $this->generarPassword();
            $cuenta->cue_password = md5($password);
            $cuenta->persona_id = $this->id;
            $cuenta->save();

            $cuentaTipoCuenta = new CuentaTipoCuenta;
            $cuentaTipoCuenta->cue_tip_estado = 'activo';
            $cuentaTipoCuenta->cuenta_id = $cuenta->id;
            $cuentaTipoCuenta->tipocuenta_id = $tipoCuenta->id;
            $cuentaTipoCuenta->save();
            return $password;
        }

        return false;
    }

    /**
     * genera un password aleatorio
     * 
     * @return string password generado
     */
    public function generarPassword() {
        $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJCLMNOPQRSTUVWXYZ1234567890";

        $aleatorio = '';
        for ($i = 0; $i < 5; $i++) {
            $caracter = rand(0, strlen($caracteres));
            $caracter = substr($caracteres, $caracter, 1);
            $aleatorio = $aleatorio . '' . $caracter;
        }

        return md5($aleatorio);
    }

//DECLARACION DE RELACIONES /////////////////////

    public function administradorinvestigativo() {
        return $this->hasOne("App\Models\AdministradorInvestigativo");
    }

    public function evaluador() {
        return $this->hasOne("App\Models\Evaluador");
    }

    public function investigador() {
        return $this->hasOne("App\Models\Investigador");
    }

    public function perfil() {
        return $this->hasOne("App\Models\Perfil");
    }

    public function cuenta() {
        return $this->hasOne("App\Models\Cuenta");
    }

    public function histotialEstado() {
        return $this->hasOne("App\Models\HistorialEstado");
    }

    public function sugerencias() {
        return $this->hasMany("\App\Models\Sugerencia");
    }

    public function relacionNotificaion(){
        return $this->hasMany("App\Models\PersonaNotificacion");
    }

    public function notificaiones(){
        return $this->belongsToMany("App\Models\Notificacion","App\Models\PersonaNotificacion");
    }

}
