<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sistema
 *
 * @author lucho_000
 */

namespace App\Models;

use App\Http\Middleware\AutenticacionAdminv;
use App\Http\Middleware\AutenticacionEval;
use App\Http\Middleware\AutenticacionInv;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
Class Sistema{



    public static function enviarMail($persona,$mensaje,$asunto,$titulo){
        Session::put('correoDestinatario', $persona->per_correo);
        Session::put('nombreDestinatario', $persona->per_nombres . ' ' . $persona->per_apellidos);
        Session::put('asunto', $asunto);

        $datos = array("nombre" => $persona->per_nombres,
            "mensaje" => $mensaje, "titulo" => $titulo);
        Mail::Send('emails.principal', $datos, function ($message) {
            $message->to(session('correoDestinatario'), session('nombreDestinatario'))->subject(session('asunto'));
            Session::forget('correoDestinatario');
            Session::forget('nombreDestinatario');
            Session::forget('asunto');
        });
    }

    public static function getSiglaRolActual(){
        $rol = "";
        if (Session::get('rol actual') == "administrador investigativo")
            $rol = "adminv";
        else if (Session::get('rol actual') == "investigador")
            $rol = "inv";
        else if ((Session::get('rol actual') == "evaluador"))
            $rol = "eval";

        return $rol;
    }

    public static function getPathImgPerfil($id){
        $persona = Persona::find($id);
        $archivo = "imagenes/perfil/" . $persona->id;

        if (file_exists($archivo . '.png')) {
            $archivo .= '.png';
        } else if (file_exists($archivo . '.jpg')) {
            $archivo .= '.jpg';
        } else {
            $archivo = 'imagenes/perfil/user.png';
        }
        return asset($archivo);
    }

    public static function isValidUserDownloadFileProduct($id){
        $producto = Producto::find($id);
        if($producto){
            if(AutenticacionAdminv::check()){
                return true;
            }

            $proyecto= $producto->actividad->componente->proyectoInvestigativo->proyecto;

            if(AutenticacionInv::check()){
                $relacion = ProyectoInvestigador::join("investigador","proyectoinvestigador.investigador_id","=","investigador.id")
                            ->join("persona","investigador.persona_id","=","persona_id")
                            ->where("proyectoinvestigativo_id",$proyecto->proyectoInvestigativo->id)
                            ->where("persona.id",Session::get('idPersona'))->get();
                if(count($relacion)){
                    return true;
                }
            }

            if(AutenticacionEval::check()){
                $relacion = ProyectoInvestigativoEvaluador::join("evaluador","proyectoinvestigativoevaluador.evaluador_id","=","evaluador.id")
                            ->join("persona","evaluador.persona_id","=","persona_id")
                            ->where("proyectoinvestigativo_id",$proyecto->proyectoInvestigativo->id)
                            ->where("persona.id",Session::get('idPersona'))->get();
                if(count($relacion)){
                    return true;
                }
            }
        }
        return false;
    }

    public static function isValidUserTareas($id){

        $proyecto= Proyecto::find($id);

        if(AutenticacionInv::check()){
            $relacion = ProyectoInvestigador::join("investigador","proyectoinvestigador.investigador_id","=","investigador.id")
                ->join("persona","investigador.persona_id","=","persona_id")
                ->where("proyectoinvestigativo_id",$proyecto->proyectoInvestigativo->id)
                ->where("persona.id",Session::get('idPersona'))
                ->where(function($q){
                    $q->whereNull("proyectoinvestigador.pro_inv_estado_solicitud")
                        ->orWhere("proyectoinvestigador.pro_inv_estado_solicitud","aprobado");
                })->get();
            if(count($relacion)){
                return true;
            }
        }

        return false;
    }

    public static function administradores(){
        return  Persona::select("persona.*")
                        ->join("cuenta","persona.id","=","cuenta.persona_id")
                        ->join("cuentatipocuenta","cuenta.id","=","cuentatipocuenta.cuenta_id")
                        ->join("tipocuenta","cuentatipocuenta.tipocuenta_id","=","tipocuenta.id")
                        ->where("cuentatipocuenta.cue_tip_estado","activo")
                        ->where("tipocuenta.tip_cue_nombre","administrador investigativo")->get();
    }
}
