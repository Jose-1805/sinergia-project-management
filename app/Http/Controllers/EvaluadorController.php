<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Crypt;
use App\Models\Sugerencia;
use App\Models\Contenido;
use App\Models\ConfiguracionContenido;

class EvaluadorController extends Controller{
    
    
    public function __construct() {
        $this->middleware('autEval');
    }
    
    public function getIndex() {
        //return $this->perfiles();
        $configuraciones = ConfiguracionContenido::all();
        if (count($configuraciones) > 0) {
            $configuracion = $configuraciones[0];
            $mostrar = $configuracion->con_con_mostrar;
            if ($mostrar == "todos") {
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","evaluador")->where('con_estado', 'habilitado')->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'hoy') {
                $fechaInicio = date('Y-m-d')." 00:00:00";
                $fechaActual = date('Y-m-d')." 23:59:59";
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","evaluador")->where('con_estado', 'habilitado')->whereBetween('created_at', [$fechaInicio, $fechaActual])->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'ultima semana') {
                $fechaActual = date('Y-m-d')." 23:59:59";
                $menosSemana = date('Y-m-d', strtotime('-1 weeks', strtotime($fechaActual)))." 00:00:00";
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","evaluador")->where('con_estado', 'habilitado')->whereBetween('created_at', [$menosSemana, $fechaActual])->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'ultimo mes') {
                $fechaActual = date('Y-m-d')." 23:59:59";
                $menosMes = date('Y-m-d', strtotime('-1 months', strtotime($fechaActual)))." 00:00:00";
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","evaluador")->where('con_estado', 'habilitado')->whereBetween('created_at', [$menosMes, $fechaActual])->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'numero') {
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","evaluador")->where('con_estado', 'habilitado')->take($configuracion->con_eve_numero_mostrar)->orderBy("created_at","desc")->get();
            }
        } else {
            $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                ->where("tipocuenta.tip_cue_nombre","evaluador")->where('con_estado', 'habilitado')->orderBy("created_at","desc")->get();
        }

        return View('roles/eval/index')->with("mod","inicio")->with("contenidos",$contenidos);
    }

    public function getPerfiles() {
        return $this->perfiles();
    }

    public function perfiles(){
        $perfilesRecibidos = Proyecto::proyectosEvaluadorEstado("propuesta",Session::get("idPersona"));
        $perfilesAprobados = Proyecto::proyectosEvaluadorEstado("propuesta aprobada",Session::get("idPersona"));
        $perfilesDescartados = Proyecto::proyectosEvaluadorEstado("propuesta descartada",Session::get("idPersona"));
        $perfilesCompletos = Proyecto::proyectosEvaluadorEstado("propuesta aprobada completa",Session::get("idPersona"));

        return View('roles/eval/index')->with("mod","perfiles")->with('perfilesRecibidos', $perfilesRecibidos)
            ->with('perfilesAprobados', $perfilesAprobados)
            ->with('perfilesDescartados', $perfilesDescartados)
            ->with('perfilesCompletos',$perfilesCompletos)
            ->with("rol","eval");
    }

    public function getProyectos(){
            return $this->proyectos();
    }

    public function getSugerencias(){
        $sugerencias = Sugerencia::where("persona_id",Session::get("idPersona"))
            ->where("sug_estado","<>","revisado")
            ->orderBy('sugerencia.created_at','DESC')
            ->orderBy('sugerencia.id','DESC')->get();

        return view("roles.eval.index")->with("temp","sugerencias")->with("sugerencias", $sugerencias);
    }

    public function proyectos(){
        $proyectosAprobados = Proyecto::proyectosEvaluadorEstado("proyecto aprobado",Session::get("idPersona"));
        $proyectosEnDesarrollo = Proyecto::proyectosEvaluadorEstado("proyecto en desarrollo",Session::get("idPersona"));
        $proyectosDescartados = Proyecto::proyectosEvaluadorEstado("proyecto descartado",Session::get("idPersona"));
        $proyectosTerminados = Proyecto::proyectosEvaluadorEstado("proyecto terminado",Session::get("idPersona"));
        $proyectosCancelados = Proyecto::proyectosEvaluadorEstado("proyecto cancelado",Session::get("idPersona"));

        return View('roles/eval/index')->with("mod","proyectos")
            ->with('proyectosAprobados', $proyectosAprobados)
            ->with('proyectosEnDesarrollo', $proyectosEnDesarrollo)
            ->with('proyectosDescartados', $proyectosDescartados)
            ->with('proyectosTerminados', $proyectosTerminados)
            ->with('proyectosCancelados', $proyectosCancelados)
            ->with("rol","eval");
    }

    public function getPerfilSugerir($idPerfil) {
        $idPerfil = Crypt::decrypt($idPerfil);
        $perfil = Proyecto::find($idPerfil);
        if($perfil)
            return view("roles/eval/index")->with("temp","perfiles/sugerir")->with("perfil",$perfil);

        return redirect("/");
    }

    public function getSugerencia($id){
        $idSugerencia = Crypt::decrypt($id);
        $sugerencia = Sugerencia::find($idSugerencia);
        if($sugerencia){
            if($sugerencia->proyecto_estado == $sugerencia->proyecto->pro_estado) {
                return view("roles.eval.index")->with("temp", "sugerencia")->with("sugerencia", $sugerencia);
            }
        }
        return redirect("/");
    }
}