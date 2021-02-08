<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Proyecto
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Proyecto extends Model {

    //put your code here
    protected $table = "proyecto";
    protected $guarded = ['id', 'account_id'];

    /**
     * genera un codigo aleatorio para el proyecto
     */
    public function generarCodigo() {
        $cantProyectos = $this->all()->count();
        $codigo = "";
        $codigoEncript = "";
        $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJCLMNOPQRSTUVWXYZ1234567890";
        $existe = true;

        while ($existe) {
            $cantAleatorio = rand(5, 8);
            $aleatorio = '';
            for ($i = 0; $i < $cantAleatorio; $i++) {
                $caracter = rand(0, strlen($caracteres));
                $caracter = substr($caracteres, $caracter, 1);
                $aleatorio = $aleatorio . '' . $caracter;
            }

            $codigo = "pro_invs_" . $cantProyectos. '_' . $aleatorio;
            $codigoEncript = Crypt::encrypt($codigo);

            $pr = $this->where('pro_codigo', $codigoEncript)->get();
            if (count($pr) < 1) {
                $existe = FALSE;
                $this->pro_codigo = $codigoEncript;
                return $codigo;
            }
        }
    }

    /**
     * Comprueba si ya existe un proyecto con el titulo especificado
     * 
     * @param type $titulo
     * @return 
     * true -> si ya existe un proyecto con el titulo especificado
     * false -> si np existe un proyecto con el titulo especificado
     */
    public static function validarTitulo($titulo) {
        $data = array("titulo" => $titulo);
        $rules = array(
            "titulo" => "unique:proyecto,pro_titulo"
        );

        $v = Validator::make($data, $rules);
        if ($v->fails()) {
            return true;
        }
        return false;
    }

    /**
     * determina si un usuario puede cambiar el estado de un proyecto
     *
     * @param type $cuentas // cuantas del usuario
     * @param type $estadoInicial // estado en el que se encuentra actualmente el proyecto
     * @return boolean // true -> si el usuario puede cambiar este estado // false de lo contrario
     */
    public function permitirCambioEstado($cuenta) {
        $roles = $cuenta->tiposCuenta()->where('cuentatipocuenta.cue_tip_estado', 'activo')->get();

        foreach ($roles as $rol) {
            if ($rol->tip_cue_nombre == 'administrador investigativo') {
                return true;
            }

            if ($rol->tip_cue_nombre == 'evaluador') {
                $evaluador = $cuenta->persona->evaluador;
                $proInv = $evaluador->proyectosInvestigativos()->where('proyectoinvestigativoevaluador.pro_eva_estado_evaluar', $this->pro_estado)
                                ->where('proyectoinvestigativoevaluador.proyectoinvestigativo_id', $this->proyectoinvestigativo->id)->get();

                if (count($proInv) > 0) {
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * Cambia el estado de un proyecto o perfil y realiza los cambios necesarios en la base de datos
     *
     * @param Persona $persona -> objeto persona que esta realizando el cambio de estado
     * @param $estadoNuevo
     * @return
     */
    public function cambiarEstado(Persona $persona,$estadoNuevo){
        //investigador lider del perfil
        $investigador = $this->proyectoInvestigativo->investigadorLider;

        if ($investigador != null) {
            $cuentaEval = $persona->cuenta;

            //se define si al usuario que inicio sesion le esta permitido cambiar el estado de este perfil
            if ($this->permitirCambioEstado($cuentaEval)) {
                $historialEstado = new HistorialEstado;
                $historialEstado->his_est_estado_inicial = $this->pro_estado;
                $historialEstado->his_est_estado_final = $estadoNuevo;
                $historialEstado->proyecto_id = $this->id;
                $historialEstado->persona_id = $persona->id;
                $historialEstado->save();

                $this->pro_estado = $estadoNuevo;
                $this->save();
                return 1;//estado cambiado
            }
            return -2;//no tiene permisos para realizar este cambio
        }
        return -1;//no se ha encontrado informacion del proponente lider
    }

    public static function proyectosPorEstado($estado) {
        return Proyecto::where("pro_estado",$estado)->get();
    }


    /**
     * Busca la información de proyectos asignados a un evaluador en
     * un estado determinado
     *
     * @param type $estado -> el estado de los proyectos que se consultarán
     *
     * return resultado de la consulta
     */
    public static function proyectosEvaluadorEstado($estado,$id) {

        return Proyecto::where('pro_estado',$estado)
            ->join('proyectoinvestigativo','proyecto.id','=','proyectoinvestigativo.proyecto_id')
            //las siguientes son para relacion de muchos a muchos entre evaluador y proyecto investigativo
            ->join('proyectoinvestigativoevaluador','proyectoinvestigativo.id','=','proyectoinvestigativoevaluador.proyectoinvestigativo_id')
            ->join('evaluador','proyectoinvestigativoevaluador.evaluador_id','=','evaluador.id')
            //evaluador
            ->join('persona','evaluador.persona_id','=','persona.id')
            ->select("proyecto.*")
            ->where("persona.id",$id)
            ->where("proyectoinvestigativoevaluador.pro_eva_estado_evaluar",$estado)
            ->get();
    }


    /**
     * Busca la información proyectos relacionados con determinado investigador
     * y que esten determinado estado
     *
     * @param type $estado -> el estado de los proyectos que se consultarán
     * $id -> id del investigador que debe estar relacionado con el proyecto
     *
     * return resultado de la consulta
     */
    public static function proyectosInvestigadorEstado($estado,$id) {
        return Proyecto::where('pro_estado',$estado)
                    ->join('proyectoinvestigativo','proyecto.id','=','proyectoinvestigativo.proyecto_id')
                    ->join('proyectoinvestigador','proyectoinvestigativo.id','=','proyectoinvestigador.proyectoinvestigativo_id')
                    ->join('investigador','proyectoinvestigador.investigador_id','=','investigador.id')
                    ->join('persona','investigador.persona_id','=','persona.id')
                    ->where(function($q){
                        $q->whereNull("proyectoinvestigador.pro_inv_estado_solicitud")
                            ->orWhere("proyectoinvestigador.pro_inv_estado_solicitud","aprobado")
                            ->orWhere("proyectoinvestigador.pro_inv_estado_solicitud","");
                    })
                    ->where("persona.id",$id)
                    ->select("proyecto.*")
                    ->get();
    }

    //DECLARACION DE RELACIONES ////////////

    public function proyectoInvestigativo() {
        return $this->hasOne('App\Models\ProyectoInvestigativo');
    }

    public function centroFormativo() {
        return $this->belongsTo("App\Models\CentroFormativo", "centroformativo_id");
    }

    protected function entidades() {
        return $this->belongsToMany("App\Models\Entidad", "proyectoentidad","proyecto_id","entidad_id");
    }

    public function seguimientos() {
        return $this->hasMany("App\Models\Seguimiento");
    }

    public function historialesEstados() {
        return $this->hasMany("App\Models\HistorialEstado");
    }

    public function tareasInvestigador($idInvestigador){
        return Producto::select("producto.*")
            ->join("actividad","producto.actividad_id","=","actividad.id")
            ->join("componente","actividad.componente_id","=","componente.id")
            ->join("proyectoinvestigativo","componente.proyectoinvestigativo_id","=","proyectoinvestigativo.id")
            ->join("proyecto","proyectoinvestigativo.proyecto_id","=","proyecto.id")
            ->join("proyectoinvestigador","proyectoinvestigativo.id","=","proyectoinvestigador.proyectoinvestigativo_id")
            ->join("investigador","proyectoinvestigador.investigador_id","=","investigador.id")
            ->where(function($q){
                $q->where("producto.pro_estado","por revisar")
                    ->orWhere("producto.pro_estado","no aprobado");
            })
            ->where(function($q){
                $q->whereNull("actividad.act_estado")
                    ->orWhere("actividad.act_estado","iniciado");
            })
            ->where(function($q){
                $q->whereNull("componente.com_estado")
                    ->orWhere("componente.com_estado","sin iniciar")
                    ->orWhere("componente.com_estado","iniciado");
            })
            ->where("producto.investigador_id",$idInvestigador)
            ->where("investigador.id",$idInvestigador)
            ->where("proyecto.id",$this->id)
            ->orderBy("producto.pro_estado","ASC")
            ->orderBy("actividad.act_fecha_inicio","ASC")->get();
    }

    public function allProductos(){
        return Producto::select("producto.*")
            ->join("actividad","producto.actividad_id","=","actividad.id")
            ->join("componente","actividad.componente_id","=","componente.id")
            ->join("proyectoinvestigativo","componente.proyectoinvestigativo_id","=","proyectoinvestigativo.id")
            ->join("proyecto","proyectoinvestigativo.proyecto_id","=","proyecto.id")
            ->where(function($q){
                $q->where("producto.pro_estado","por revisar")
                    ->orWhere("producto.pro_estado","no aprobado");
            })
            ->where(function($q){
                $q->whereNull("actividad.act_estado")
                    ->orWhere("actividad.act_estado","iniciado");
            })
            ->where(function($q){
                $q->whereNull("componente.com_estado")
                    ->orWhere("componente.com_estado","sin iniciar")
                    ->orWhere("componente.com_estado","iniciado");
            })
            ->where("proyecto.id",$this->id)
            ->orderBy("producto.pro_estado","ASC")
            ->orderBy("actividad.act_fecha_inicio","ASC")->get();
    }

    public function isLider(){
        $persona = Persona::find(Session::get("idPersona"));
        if($persona->investigador && ($this->proyectoInvestigativo->investigador_id == $persona->investigador->id)){
            return true;
        }
        return false;
    }

    public function establecerFechaInicioFinActividades(){
        if($this->pro_fecha_inicio) {
            $componentes = $this->proyectoInvestigativo->componentes;
            if($componentes && count($componentes)) {
                foreach ($componentes as $componente){
                    $actividades = $componente->actividades;
                    if ($actividades && count($actividades)) {
                        foreach ($actividades as $actividad) {
                            $dias = $actividad->act_numero_mes_inicio * 30;
                            $dias = $dias - 30;
                            $dias = intval($dias);

                            $fechaInicio = date('Y-m-d', strtotime('+' . $dias . ' days', strtotime($this->pro_fecha_inicio)));
                            $dias = $actividad->act_duracion * 30;
                            $dias = intval($dias);

                            $fechaFin = date('Y-m-d', strtotime('+' . $dias . ' days', strtotime($fechaInicio)));
                            $actividad->act_fecha_inicio = $fechaInicio;
                            $actividad->act_fecha_fin = $fechaFin;
                            $actividad->save();
                        }

                    }
                }
            }
        }
    }

    public function evaluarEstadoEnDesarrollo(){
        $completo = true;
        if($this->pro_estado == "proyecto en desarrollo"){
            $componentes = $this->proyectoInvestigativo->componentes;
            if(count($componentes)){
                foreach($componentes as $componente){
                    if($componente->com_estado == "iniciado" || $componente->com_estado == "sin iniciar"){
                        $completo = false;
                    }
                }

                if($completo){
                    $this->pro_estado = "proyecto terminado";
                    $this->save();
                    return "1";
                }
            }
        }
        return "-1";
    }

    public function permisoEditar(){
        return $this->isLider();
    }

    public function permisoVisualizar(){
        if(Session::has('idPersona')){
            switch(Sistema::getSiglaRolActual()){
                case "adminv":
                    return true;
                    break;
                case "inv":
                    if($this->isLider()){
                        return true;
                    }else{
                        $investigador = Persona::find(Session::get('idPersona'))->investigador;
                        if($investigador) {
                            $relacion = ProyectoInvestigador::where("proyectoinvestigativo_id", $this->proyectoInvestigativo->id)
                                ->where("investigador_id", $investigador->id)
                                ->where(function ($q) {
                                    $q->whereNull("pro_inv_estado_solicitud")
                                        ->orWhere("pro_inv_estado_solicitud", "aprobado");
                                })->get();
                            if (count($relacion)) {
                                return true;
                            }
                        }
                    }
                    break;
                case "eval":
                    $evaluador = Persona::find(Session::get("idPersona"))->evaluador;
                    if($evaluador) {
                        $relacion = Proyecto::join("proyectoinvestigativo", "proyecto.id", "=", "proyectoinvestigativo.proyecto_id")
                            ->join("proyectoinvestigativoevaluador", "proyectoinvestigativo.id", "=", "proyectoinvestigativoevaluador.proyectoinvestigativo_id")
                            ->join("evaluador", "proyectoinvestigativoevaluador.evaluador_id", "=", "evaluador.id")
                            ->join("persona", "evaluador.persona_id", "=", "persona.id")
                            ->where("persona.id", Session::get("idPersona"))
                            ->where("proyectoinvestigativoevaluador.pro_eva_estado_evaluar", $this->pro_estado)
                            ->where("proyecto.id", $this->id)->get();
                        if (count($relacion)) {
                            return true;
                        }
                    }
                    break;
            }
        }
        return false;
    }
}