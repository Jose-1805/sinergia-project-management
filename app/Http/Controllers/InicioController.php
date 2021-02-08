<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\ConfiguracionEvento;
use App\Models\Evento;
use App\Http\Requests\NuevoPerfilRequest;
use App\Models\ConfiguracionContenido;
use App\Models\Contenido;

class InicioController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Welcome Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders the "marketing page" for the application and
      | is configured to only allow guests. Like most of the other sample
      | controllers, you are free to modify or remove it as you desire.
      |
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('autRol',['except' => ['evento','semillero','grupoInvestigacion']]);
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function getIndex() {
        $configuraciones = ConfiguracionEvento::all();
        if (count($configuraciones) > 0) {
            $configuracion = $configuraciones[0];
            $mostrar = $configuracion->con_eve_mostrar;
            if ($mostrar == "todos") {
                $eventos = DB::table('evento')->where('eve_estado', 'habilitado')->orderBy("eve_fecha_creacion","desc")->get();
            } else if ($mostrar == 'hoy') {
                $fechaInicio = date('Y-m-d')." 00:00:00";
                $fechaActual = date('Y-m-d')." 23:59:59";
                $eventos = DB::table('evento')->where('eve_estado', 'habilitado')->whereBetween('eve_fecha_creacion', [$fechaInicio, $fechaActual])->orderBy("eve_fecha_creacion","desc")->get();
            } else if ($mostrar == 'ultima semana') {
                $fechaActual = date('Y-m-d')." 23:59:59";
                $menosSemana = date('Y-m-d', strtotime('-1 weeks', strtotime($fechaActual)))." 00:00:00";
                $eventos = DB::table('evento')->where('eve_estado', 'habilitado')->whereBetween('eve_fecha_creacion', [$menosSemana, $fechaActual])->orderBy("eve_fecha_creacion","desc")->get();
            } else if ($mostrar == 'ultimo mes') {
                $fechaActual = date('Y-m-d')." 23:59:59";
                $menosMes = date('Y-m-d', strtotime('-1 months', strtotime($fechaActual)))." 00:00:00";
                $eventos = DB::table('evento')->where('eve_estado', 'habilitado')->whereBetween('eve_fecha_creacion', [$menosMes, $fechaActual])->orderBy("eve_fecha_creacion","desc")->get();
            } else if ($mostrar == 'numero') {
                $eventos = DB::table('evento')->where('eve_estado', 'habilitado')->take($configuracion->con_eve_numero_mostrar)->orderBy("eve_fecha_creacion","desc")->get();
            }
        } else {
            $eventos = DB::table('evento')->where('eve_estado', 'habilitado')->orderBy("eve_fecha_creacion","desc")->get();
        }

        $configuraciones = ConfiguracionContenido::all();
        if (count($configuraciones) > 0) {
            $configuracion = $configuraciones[0];
            $mostrar = $configuracion->con_con_mostrar;
            if ($mostrar == "todos") {
                $contenidos = Contenido::where("con_sin_sesion","si")->where('con_estado', 'habilitado')->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'hoy') {
                $fechaInicio = date('Y-m-d')." 00:00:00";
                $fechaActual = date('Y-m-d')." 23:59:59";
                $contenidos = Contenido::where("con_sin_sesion","si")->where('con_estado', 'habilitado')->whereBetween('created_at', [$fechaInicio, $fechaActual])->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'ultima semana') {
                $fechaActual = date('Y-m-d')." 23:59:59";
                $menosSemana = date('Y-m-d', strtotime('-1 weeks', strtotime($fechaActual)))." 00:00:00";
                $contenidos = Contenido::where("con_sin_sesion","si")->where('con_estado', 'habilitado')->whereBetween('created_at', [$menosSemana, $fechaActual])->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'ultimo mes') {
                $fechaActual = date('Y-m-d')." 23:59:59";
                $menosMes = date('Y-m-d', strtotime('-1 months', strtotime($fechaActual)))." 00:00:00";
                $contenidos = Contenido::where("con_sin_sesion","si")->where('con_estado', 'habilitado')->whereBetween('created_at', [$menosMes, $fechaActual])->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'numero') {
                $contenidos = Contenido::where("con_sin_sesion","si")->where('con_estado', 'habilitado')->take($configuracion->con_eve_numero_mostrar)->orderBy("created_at","desc")->get();
            }
        } else {
            $contenidos = Contenido::where("con_sin_sesion","si")->where('con_estado', 'habilitado')->orderBy("created_at","desc")->get();
        }

        return view('inicio')->with("eventos", $eventos)->with("contenidos",$contenidos);
    }
    
    public function semillero() {
        return view("inicio")->with("mod", "semillero");
    }
    
    public function contactenos() {
        return view("inicio")->with("mod", "contactenos");
    }

    public function grupoInvestigacion() {
        return view("inicio")->with("mod", "grupoInvestigacion");
    }
    
    public function nuevoPerfil(){
        return view('inicio')->with("mod","nuevoPerfil");
    }

    public function restaurarContrasena(){
        return view('inicio')->with("mod","restaurarContrasena");
    }

    public function editPerfil(){
        return view('inicio')->with("mod","editarPerfil");
    }
    
    public function poo($id, NuevoPerfilRequest $request) {
        
        return "Request";
        /*$persona = \App\Models\Persona::findOrNew($id);
        $cuenta = $persona->cuenta;
        dd($cuenta->tiposCuenta()->where("cuentatipocuenta.cue_tip_estado","activo")->get());*/
    }
    
}
