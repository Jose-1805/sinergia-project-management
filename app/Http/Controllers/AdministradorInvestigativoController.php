<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdministradorInvestigativoController
 *
 * @author lucho_000
 */

namespace App\Http\Controllers;

use App\Models\ConfiguracionContenido;
use App\Models\Contenido;
use App\Models\Sistema;
use App\Http\Requests\NuevoEvaluadorRequest;
use App\Http\Requests\ActualizarEvaluadorRequest;
use App\Http\Requests\NuevoInvestigadorRequest;
use App\Http\Requests\ActualizarInvestigadorRequest;
use App\Http\Requests\NuevaEntidadRequest;
use App\Http\Requests\ActualizarEntidadRequest;
use App\Models\ActividadEconomica;
use App\Models\Convocatoria;
use App\Models\Cuenta;
use Illuminate\Support\Facades\Session;
use App\Models\Direccion;
use App\Models\Proyecto;
use App\Models\Entidad;
use App\Models\Investigador;
use App\Models\Localizacion;
use App\Models\Persona;
use App\Models\SeccionActividadEconomica;
use App\Http\Controllers\Controller;
use App\Models\Evaluador;
use PhpSpec\Exception\Exception;
use App\Models\ProyectoInvestigativoEvaluador;
use App\Models\ProyectoInvestigativo;
use App\Http\Requests\Request;
use App\Http\Requests\ConvocatoriaRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class AdministradorInvestigativoController extends Controller {

    //put your code here

    public function __construct() {
        $this->middleware('autAdminv');
    }

    public function getIndex() {
        $configuraciones = ConfiguracionContenido::all();
        if (count($configuraciones) > 0) {
            $configuracion = $configuraciones[0];
            $mostrar = $configuracion->con_con_mostrar;
            if ($mostrar == "todos") {
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","administrador investigativo")->where('con_estado', 'habilitado')->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'hoy') {
                $fechaInicio = date('Y-m-d')." 00:00:00";
                $fechaActual = date('Y-m-d')." 23:59:59";
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","administrador investigativo")->where('con_estado', 'habilitado')->whereBetween('created_at', [$fechaInicio, $fechaActual])->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'ultima semana') {
                $fechaActual = date('Y-m-d')." 23:59:59";
                $menosSemana = date('Y-m-d', strtotime('-1 weeks', strtotime($fechaActual)))." 00:00:00";
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","administrador investigativo")->where('con_estado', 'habilitado')->whereBetween('created_at', [$menosSemana, $fechaActual])->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'ultimo mes') {
                $fechaActual = date('Y-m-d')." 23:59:59";
                $menosMes = date('Y-m-d', strtotime('-1 months', strtotime($fechaActual)))." 00:00:00";
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","administrador investigativo")->where('con_estado', 'habilitado')->whereBetween('created_at', [$menosMes, $fechaActual])->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'numero') {
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","administrador investigativo")->where('con_estado', 'habilitado')->take($configuracion->con_eve_numero_mostrar)->orderBy("created_at","desc")->get();
            }
        } else {
            $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                ->where("tipocuenta.tip_cue_nombre","administrador investigativo")->where('con_estado', 'habilitado')->orderBy("created_at","desc")->get();
        }

            return view("roles/adminv/index")->with("mod","inicio")->with("contenidos",$contenidos);
    }

    public function getPerfiles() {
            return $this->perfiles();
    }

    public function perfiles(){
        $perfilesRecibidos = Proyecto::proyectosPorEstado("propuesta");
        $perfilesAprobados = Proyecto::proyectosPorEstado("propuesta aprobada");
        $perfilesDescartados = Proyecto::proyectosPorEstado("propuesta descartada");
        $perfilesCompletos = Proyecto::proyectosPorEstado("propuesta aprobada completa");

        return View("roles/adminv/index")->with('mod', 'perfiles')
            ->with('perfilesRecibidos', $perfilesRecibidos)
            ->with('perfilesAprobados', $perfilesAprobados)
            ->with('perfilesDescartados', $perfilesDescartados)
            ->with('perfilesCompletos',$perfilesCompletos)
            ->with('rol',"adminv");
    }

    public function getProyectos(){
        return $this->proyectos();
    }
    public function proyectos(){
        $proyectosAprobados = Proyecto::proyectosPorEstado("proyecto aprobado");
        $proyectosEnDesarrollo = Proyecto::proyectosPorEstado("proyecto en desarrollo");
        $proyectosTerminados = Proyecto::proyectosPorEstado("proyecto terminado");
        $proyectosCancelados = Proyecto::proyectosPorEstado("proyecto cancelado");
        $proyectosDescartados = Proyecto::proyectosPorEstado("proyecto descartado");
        $proyectosEnConvocatoria = Proyecto::proyectosPorEstado("proyecto en convocatoria");

        return View("roles/adminv/index")->with("mod","proyectos")
            ->with('proyectosAprobados', $proyectosAprobados)
            ->with('proyectosEnDesarrollo', $proyectosEnDesarrollo)
            ->with('proyectosDescartados', $proyectosDescartados)
            ->with('proyectosTerminados', $proyectosTerminados)
            ->with('proyectosCancelados', $proyectosCancelados)
            ->with('proyectosEnConvocatoria', $proyectosEnConvocatoria)
            ->with('rol',"adminv");
    }

    public function getPerfilSugerir($idPerfil) {
        $idPerfil = Crypt::decrypt($idPerfil);
        $perfil = Proyecto::find($idPerfil);
        if($perfil)
            return view("roles/adminv/index")->with("temp","perfiles/sugerir")->with("perfil",$perfil);

        return redirect()->back();
    }

    public function getPerfilAsignar($idPerfil) {
            $idPerfil = Crypt::decrypt($idPerfil);
            $perfil = Proyecto::find($idPerfil);
            if($perfil) {
                $asignados = Evaluador::join('proyectoinvestigativoevaluador','evaluador.id','=','proyectoinvestigativoevaluador.evaluador_id')
                    ->join('proyectoinvestigativo','proyectoinvestigativoevaluador.proyectoinvestigativo_id','=','proyectoinvestigativo.id')
                    ->join('persona','evaluador.persona_id','=','persona.id')
                    ->where('proyectoinvestigativo.proyecto_id',$perfil->id)
                    ->where('proyectoinvestigativoevaluador.pro_eva_estado_evaluar',$perfil->pro_estado)
                    ->select('evaluador.*')->get();

                $idAsignados = [];
                foreach($asignados as $eval){
                    $idAsignados[] = $eval->id;
                }
                $evaluadores = Evaluador::join('persona', 'evaluador.persona_id', '=', 'persona.id')
                    ->join('cuenta', 'persona.id', '=', 'cuenta.persona_id')
                    ->join('cuentatipocuenta', 'cuenta.id', '=', 'cuentatipocuenta.cuenta_id')
                    ->join('tipocuenta', 'cuentatipocuenta.tipocuenta_id', '=', 'tipocuenta.id')
                    ->where('cuentatipocuenta.cue_tip_estado', 'activo')
                    ->where('tipocuenta.tip_cue_nombre', 'evaluador')
                    ->whereNotIn("evaluador.id",$idAsignados)
                    ->orderBy('persona.per_nombres')
                    ->select("evaluador.*")->get();


                $proponente = $perfil->proyectoInvestigativo->investigadorLider->persona;
                return view("roles/adminv/index")->with("mod", "perfil/asignar")->with("perfil", $perfil)->with('evaluadores', $evaluadores)->with('asignados', $asignados)->with("proponente", $proponente);

            }
        return redirect()->back();
    }

    public function getConvocatoriaRegistrar(){
        return view("roles/adminv/index")->with("mod","registrarConvocatoria");
    }

    public function getConvocatoriaEditar($id){
        $convocatoria = Convocatoria::find($id);
        if($convocatoria)
            return view("roles/adminv/index")->with("mod","editarConvocatoria")->with('convocatoria',$convocatoria);

        return redirect('/');
    }

    public function postConvocatoriaRegistrar(ConvocatoriaRequest $request){
        $convocatoria = new Convocatoria();
        $convocatoria->con_nombre = $request->input('nombre');
        $convocatoria->con_compania = $request->input('compania');
        $convocatoria->con_numero = $request->input('numero');
        $convocatoria->con_objetivo = $request->input('objetivo');
        $convocatoria->con_fecha_apertura = $request->input('fecha_apertura');
        $convocatoria->con_fecha_cierre = $request->input('fecha_cierre');
        if($request->has('tipo'))$convocatoria->con_tipo = $request->input('tipo');
        if($request->has('dirigida'))$convocatoria->con_dirigida = $request->input('dirigida');
        if($request->has('contacto'))$convocatoria->con_contacto = $request->input('contacto');
        if($request->has('cuantia'))$convocatoria->con_cuantia = $request->input('cuantia');
        $convocatoria->save();
        return 1;
    }

    public function postConvocatoriaEditar(ConvocatoriaRequest $request){
        if($request->has('id')){
            $convocatoria = Convocatoria::find($request->input('id'));
            if($convocatoria){
                $convocatoria->con_nombre = $request->input('nombre');
                $convocatoria->con_compania = $request->input('compania');
                $convocatoria->con_numero = $request->input('numero');
                $convocatoria->con_objetivo = $request->input('objetivo');
                $convocatoria->con_fecha_apertura = $request->input('fecha_apertura');
                $convocatoria->con_fecha_cierre = $request->input('fecha_cierre');
                $convocatoria->con_tipo = $request->input('tipo');
                $convocatoria->con_dirigida = $request->input('dirigida');
                $convocatoria->con_contacto = $request->input('contacto');
                $convocatoria->con_cuantia = $request->input('cuantia');
                $convocatoria->save();
                return 1;
            }
        }
        return -1;
    }

    //10_Nov_2015
    //    SECCION ENTIDADES
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//CRUD
    public function getEntidades()
    {
        $entidades = Entidad::all();
        return view("roles/adminv/index")->with("ent", "entidades")->with("entidades", $entidades);
    }

    public function getNuevaentidad()
    {
        $listSeccActEcos = DB::table('seccionactividadeconomica')->orderBy('sec_act_descripcion', 'asc')->get();
        $listaDep = DB::table("departamento")->orderBy('dep_nombre', 'asc')->get();
        return view("roles/adminv/index")
            ->with("ent", "nuevaEntidad")
            ->with("listSeccActEcos", $listSeccActEcos)
            ->with("listaDep", $listaDep);
    }

    //Aqui de registra una nueva entidad si los datos son validos
//    de lo contrario se envia el mensaje de error adecuado
    public function postRegistrarEntidad(NuevaEntidadRequest $request)
    {
//        1. Se crea el objeto de la direccion
//        2. Se crea el objeto de tipo Localizacion y se le asigna el ID de la dirección asignada
//        3. Se crea el objeto de tipo Entidad y se le pasa el ID de la Localización

//        Datos de la Direccion
//        ________________________________
        DB::beginTransaction();
        try {
            $direccion = new Direccion();
            $direccion->dir_calle = $request->input("NumeroDeLaCalle");
            $direccion->dir_carrera = $request->input("NumeroDeLaCarrera");
            $direccion->dir_numero = $request->input("NumeroDeEdificacion");
            $direccion->ciudad_id = $request->input("CiudadDeLocalizacion");
            $direccion->save();
//        dd($direccion->getKey()); Obtine el valor del ID de la Direccion
//        ________________________________
//        Datos de la Localización
//        ________________________________
            $localizacion = new Localizacion();
            $localizacion->loc_fax = $request->input("FaxDeLocalizacion");
            $localizacion->loc_sitio_web = $request->input("SitioWebDeLocalizacion");
            $localizacion->loc_correo = $request->input("CorreoDeLocalizacion");
            // averiguar id de la direccion
            $localizacion->direccion_id = $direccion->getKey();
            $localizacion->save();
//        ________________________________
//        Datos de la Entidad
//        ________________________________
            $entidad = new Entidad();
            $entidad->ent_nombre = $request->input("Nombre");
            $entidad->ent_telefono = $request->input("Telefono");
            $entidad->ent_tipo_identificacion = $request->input("Identidficacion");
            $entidad->ent_matricula_c_comercio = $request->input("CamaraComercio");
            $entidad->ent_sector = $request->input("SectorEconomico");
            $entidad->ent_numero_empleados = $request->input("NumeroDeEmpleados");
            $entidad->ent_fecha_constitucion = $request->input("FechaDeConstitucion");
            $entidad->ent_estado = $request->input("Estado");
            $entidad->actividadeconomica_id = $request->input("entActividadEco");
            $entidad->localizacion_id = $localizacion->getKey();
            $entidad->save();
            DB::commit();
//            dd($direccion, $localizacion, $entidad);
            return "1";
        } catch (Exception $e) {
//            Si ocurre algun error se borran los cambios en la Base de datos
            DB::rollBack();
//            dd($e);
            return "0";
        }
    }

//    CONSULTAS

    public function getDepartamentos()
    {
        return DB::table("departamento")->orderBy('dep_nombre', 'asc')->get();
    }

    public function getTraerdivacteco($id)
    {
        $lista = DB::table('divisionactividadeconomica')
            ->where('divisionactividadeconomica.seccionactividadeconomica_id', $id)
            ->orderBy('div_act_descripcion', 'asc')->get();
        return response()->json($lista);
    }

    public function getTraeracteco($id)
    {
        $lista = DB::table('actividadeconomica')
            ->where('divisionactividadeconomica_id', $id)
            ->orderBy('act_eco_descripcion', 'asc')->get();
        return response()->json($lista);
    }

    public function getTraermunicipios($id)
    {
        $muncicipio = DB::table('ciudad')
            ->where('ciudad.departamento_id', $id)
            ->orderBy('ciu_nombre', 'asc')->get();
        return $muncicipio;
    }

//    VALIDACIONES

    public function getValidarnombre($nombre = null)
    {
        if ($nombre != null) {
            if (DB::table('entidad')->where("ent_nombre", $nombre)->count() > 0) {
//        devuelve 1 si ya esta el nombre registrado
                return "1";
            } else {
//        0 si no esta registrado el nombre
                return "0";
            }
        }
    }

    public function getValidarCamaraComercio($camara = null)
    {

        if ($camara != null) {
            if (DB::table("entidad")->where("ent_matricula_c_comercio", $camara)->count() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function getValidarCorreoEntidad($correo = null)
    {
        if ($correo != null) {
            if (DB::table('localizacion')->where("loc_correo", $correo)->count() > 0) {
//        devuelve 1 si ya esta el correo registrado
                return "1";
            } else {
//        0 si no esta registrado el correo
                return "0";
            }
        } else {
            return "2";
        }
    }

    public function getVerEntidad($idEntidad = 0)
    {
        $correcto = false;
        $datos = new \stdClass();
        $entidad = DB::table('entidad')->where('id', "=", $idEntidad)->first();
        if ($entidad != null) {

            $actividad = DB::table('actividadeconomica')->where('id', "=", $entidad->actividadeconomica_id)->first();
            if ($actividad != null) {
                $datos->actividad = $actividad;
            } else {
                $datos->actividad = $actividad;
            }
            $loc = DB::table('localizacion')->where('id', "=", $entidad->localizacion_id)->first();

            if ($loc != null && $actividad != null) {
                $dir = DB::table('direccion')->where("id", "=", $loc->direccion_id)->first();
                if ($dir != null) {
                    $ciu = DB::table('ciudad')->where("id", "=", $dir->ciudad_id)->first();
                    if ($ciu != null) {
                        $dep = DB::table('departamento')->where("id", "=", $ciu->departamento_id)->first();
                        if ($dep != null) {
                            $datos->entidad = $entidad;
                            $datos->localizacion = $loc;
                            $datos->direccion = $dir;
                            $datos->ciudad = $ciu;
                            $datos->departamento = $dep;
                            $correcto = true;
                        }
                    }
                }
            }
            if ($correcto) {
                return view("roles/adminv/index")
                    ->with("ent", "verEntidad")
                    ->with('datos', $datos);
            } else {
                return redirect()->back();
            }
        }
        return redirect()->back();
    }


    public function getActualizarEntidad($idEntidad = 0)
    {
        $correcto = false;
        $datos = new \stdClass();
        $entidad = DB::table('entidad')->where('id', "=", $idEntidad)->first();
        if ($entidad != null) {
            $actividad = DB::table('actividadeconomica')->where('id', "=", $entidad->actividadeconomica_id)->first();
            $loc = DB::table('localizacion')->where('id', "=", $entidad->localizacion_id)->first();
            if ($loc != null && $actividad != null) {
                $dir = DB::table('direccion')->where("id", "=", $loc->direccion_id)->first();
                if ($dir != null) {
                    $ciu = DB::table('ciudad')->where("id", "=", $dir->ciudad_id)->first();
                    if ($ciu != null) {
                        $dep = DB::table('departamento')->where("id", "=", $ciu->departamento_id)->first();
                        if ($dep != null) {
                            $datos->entidad = $entidad;
                            $datos->actividad = $actividad;
                            $datos->localizacion = $loc;
                            $datos->direccion = $dir;
                            $datos->ciudad = $ciu;
                            $datos->departamento = $dep;
                            $listSeccActEcos = DB::table('seccionactividadeconomica')->orderBy('sec_act_descripcion', 'asc')->get();
                            $listaDep = DB::table("departamento")->orderBy('dep_nombre', 'asc')->get();
                            $correcto = true;
                        }
                    }
                }
            }
        }
        if ($correcto) {
//            dd($datos);
            return view("roles/adminv/index")
                ->with("ent", "actualizarEntidad")
                ->with('datos', $datos)
                ->with("listSeccActEcos", $listSeccActEcos)
                ->with("listaDep", $listaDep);
        } else {
            return redirect()->back();
        }
    }

    public function postActualizarEntidad(ActualizarEntidadRequest $request)
    {
        DB::beginTransaction();
        try {
            $datos = $request->all();
            $entidad = Entidad::find($datos["entidad_id"]);
            $direccion = Direccion::find($datos["direccion_id"]);
            $localizacion = Localizacion::find($datos["localizacion_id"]);

            $entidad->ent_nombre = $datos["Nombre"];
            $entidad->ent_tipo_identificacion = $datos["Identidficacion"];
            $entidad->ent_telefono = $datos["Telefono"];
            $entidad->ent_sector = $datos["SectorEconomico"];
            $entidad->ent_matricula_c_comercio = $datos["CamaraComercio"];
            $entidad->ent_numero_empleados = $datos["NumeroDeEmpleados"];
            $entidad->ent_fecha_constitucion = $datos["FechaDeConstitucion"];
            $entidad->ent_estado = $datos["Estado"];
            $entidad->actividadeconomica_id = $datos["entActividadEco"];

            $direccion->dir_calle = $datos["NumeroDeLaCalle"];
            $direccion->dir_carrera = $datos["NumeroDeLaCarrera"];
            $direccion->dir_numero = $datos["NumeroDeEdificacion"];
            if($datos["CiudadDeLocalizacion"] == 0)
                return response(['error'=>['Seleccione una ciudad']],422);
            $direccion->ciudad_id = $datos["CiudadDeLocalizacion"];

            $localizacion->loc_fax = $datos["FaxDeLocalizacion"];
            $localizacion->loc_sitio_web = $datos["SitioWebDeLocalizacion"];
            $localizacion->loc_correo = $datos["CorreoDeLocalizacion"];

            $entidad->save();
            $localizacion->save();
            $direccion->save();
            DB::commit();
            return "1";
        } catch (Exception $e) {
//            Si ocurre algun error se borran los cambios en la Base de datos
            DB::rollBack();
            return json_encode($e);
        }
    }
//        FIN SECCION ENTIDADES
//    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //15_Dic_2015
    //    SECCION EVALUADOR
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//CRUD

    public function getEvaluadores()
    {
        $evaluadores = Evaluador::join('persona', 'evaluador.persona_id', '=', 'persona.id')->select('evaluador.id as idEva',"persona.*", "evaluador.eva_tipo as eva_tipo")->get();
//        dd($evaluadores);
        return view("roles/adminv/index")->with("eva", "evaluadores")->with("evaluadores", $evaluadores);
    }

    public function getNuevoEvaluador()
    {
        return view("roles/adminv/index")->with("eva", "nuevoEvaluador");
    }

    public function getValidarCorreoPersona($correo = null)
    {
        if ($correo != null) {
            if (DB::table('persona')->where("per_correo", $correo)->count() > 0) {
//        devuelve 1 si ya esta el correo registrado
                return "1";
            } else {
//        0 si no esta registrado el correo
                return "0";
            }
        } else {
            return "2";
        }
    }

    public function postRegistrarEvaluador(NuevoEvaluadorRequest $request)
    {

        DB::beginTransaction();
        try {
            $datos = $request->all();
            $persona = new Persona();
            $persona->per_nombres = $datos["Nombres"];
            $persona->per_apellidos = $datos["Apellidos"];
            $persona->per_identificacion = $datos["Identidficacion"];
            $persona->per_numero_telefono = $datos["Telefono"];
            $persona->per_numero_celular = $datos["Celular"];
            $persona->per_fecha_nacimiento = $datos["FechaDeNacimiento"];
            $persona->per_genero = $datos["Genero"];
            $persona->per_correo = $datos["Correo"];
            $persona->save();

            $evaluador = new Evaluador();
            $evaluador->persona_id = $persona->getKey();
            $evaluador->eva_tipo = $datos["TipoDeEvaluador"];
            $evaluador->save();

            $evaPersona = $evaluador->persona;
            $password = $evaPersona->nuevaCuenta('evaluador');


            $mensaje = "Bienvenido a Gestión Proyectos – Sinergia, sus datos han sido registrado satisfactoriamente, lo invitamos a que ingrese a nuestro sistema
                    <a href='http://gestionproyectos.ticscomercio.edu.co'><h3 style='color: green'>
                        Gestión Proyectos – Sinergia</h3></a><br>El usuario es su cuenta de correo o su documento de identificación";
            $mensaje .= "<br>La contraseña de ingreso es: " . $password;


            Sistema::enviarMail($evaPersona, $mensaje, "Registro exitoso", "Registro exitoso en el sistema");
            DB::commit();
//            dd($direccion, $localizacion, $entidad);
            return "1";
        } catch (Exception $e) {
//            Si ocurre algun error se borran los cambios en la Base de datos
            DB::rollBack();
//            dd($e);
            return "0";
        }
    }

    public function getVerEvaluador($idEvaluador = 0)
    {
        $datos = new \stdClass();
        $evaluador = Evaluador::join('persona', 'evaluador.persona_id', '=', 'persona.id')->where("evaluador.id", "=", $idEvaluador)->SELECT("persona.*", "evaluador.id as idEva", "evaluador.eva_tipo as eva_tipo")->first();
//        dd($evaluador);
        if ($evaluador != null) {
            $datos = $evaluador;
            return view("roles/adminv/index")
                ->with("eva", "verEvaluador")
                ->with('datos', $datos);
        }
        return redirect()->back();
    }

    public function getActualizarEvaluador($idEvaluador = 0){
//        dd($idEvaluador);
        $datos = Evaluador::join('persona', 'evaluador.persona_id', '=', 'persona.id')->where("evaluador.id", "=", $idEvaluador)->SELECT("persona.*", "evaluador.id as idEva", "evaluador.eva_tipo as eva_tipo")->first();

        return view("roles/adminv/index")
            ->with("eva", "actualizarEvaluador")
            ->with('datos', $datos);
    }

    public function postActualizarEvaluador(ActualizarEvaluadorRequest $request){
        DB::beginTransaction();
        try {
            $datos = $request->all();
            $evaluador = Evaluador::find($datos["evaluador_id"]);
            $persona = Persona::find($evaluador->persona_id);

            $evaluador->eva_tipo= $datos["TipoDeEvaluador"];

            $persona->per_nombres= $datos["Nombres"];
            $persona->per_apellidos = $datos["Apellidos"];
            $persona->per_identificacion = $datos["Identidficacion"];
            $persona->per_numero_telefono = $datos["Telefono"];
            $persona->per_numero_celular = $datos["Celular"];
            $persona->per_fecha_nacimiento = $datos["FechaDeNacimiento"];
            $persona->per_genero = $datos["Genero"];
            $persona->per_correo = $datos["Correo"];

            $persona->save();
            $evaluador->save();

            DB::commit();
            return "1";
        } catch (Exception $e) {
//            Si ocurre algun error se borran los cambios en la Base de datos
            DB::rollBack();
            return json_encode($e);
        }
    }
//        FIN SECCION EVALUADOR
//    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

//15_Dic_2015
    //    SECCION INVESTIGADOR
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//CRUD

    public function getInvestigadores()
    {
        $investigadores = Investigador::join('persona', 'investigador.persona_id', '=', 'persona.id')->select("persona.*",'investigador.id as idInv', "investigador.inv_tipo as inv_tipo")->get();
//        dd($investigadores);
        return view("roles/adminv/index")->with("inv", "investigadores")->with("investigadores", $investigadores);
    }

    public function getNuevoInvestigador()
    {
        return view("roles/adminv/index")->with("inv", "nuevoInvestigador");
    }

    public function postRegistrarInvestigador(NuevoInvestigadorRequest $request)
    {

        DB::beginTransaction();
        try {
            $datos = $request->all();
            $persona = new Persona();
            $persona->per_nombres = $datos["Nombres"];
            $persona->per_apellidos = $datos["Apellidos"];
            $persona->per_identificacion = $datos["Identidficacion"];
            $persona->per_numero_telefono = $datos["Telefono"];
            $persona->per_numero_celular = $datos["Celular"];
            $persona->per_fecha_nacimiento = $datos["FechaDeNacimiento"];
            $persona->per_genero = $datos["Genero"];
            $persona->per_correo = $datos["Correo"];
            $persona->save();

            $investigador = new Investigador();
            $investigador->persona_id = $persona->getKey();
            $investigador->inv_tipo = $datos["TipoDeInvestigador"];
            $investigador->save();

            $invPersona = $investigador->persona;
            $password = $invPersona->nuevaCuenta('investigador');


            $mensaje = "Bienvenido a Gestión Proyectos – Sinergia, sus datos han sido registrado satisfactoriamente, lo invitamos a que ingrese a nuestro sistema
                    <a href='http://gestionproyectos.ticscomercio.edu.co'><h3 style='color: green'>
                        Gestión Proyectos – Sinergia</h3></a><br>El usuario es su cuenta de correo o su documento de identificación";
            $mensaje .= "<br>La contraseña de ingreso es: " . $password;


            Sistema::enviarMail($invPersona, $mensaje, "Registro exitoso", "Registro exitoso en el sistema");
            DB::commit();
//            dd($direccion, $localizacion, $entidad);
            return "1";
        } catch (Exception $e) {
//            Si ocurre algun error se borran los cambios en la Base de datos
            DB::rollBack();
//            dd($e);
            return "0";
        }
    }

    public function getVerInvestigador($idInvestigador = 0)
    {
        $datos = new \stdClass();
        $investigador = Investigador::join('persona', 'investigador.persona_id', '=', 'persona.id')->where("investigador.id", "=", $idInvestigador)->SELECT("persona.*", "investigador.id as idInv", "investigador.inv_tipo as inv_tipo")->first();
//        dd($evaluador);
        if ($investigador != null) {
            $datos = $investigador;
            return view("roles/adminv/index")
                ->with("inv", "verInvestigador")
                ->with('datos', $datos);
        }
        return redirect()->back();
    }

    public function getActualizarInvestigador($idInvestigador = 0){
//        dd($idEvaluador);
        $datos = Investigador::join('persona', 'investigador.persona_id', '=', 'persona.id')->where("investigador.id", "=", $idInvestigador)->SELECT("persona.*", "investigador.id as idInv", "investigador.inv_tipo as inv_tipo")->first();

        return view("roles/adminv/index")
            ->with("inv", "actualizarInvestigador")
            ->with('datos', $datos);
    }

    public function postActualizarInvestigador(ActualizarInvestigadorRequest $request){
        DB::beginTransaction();
        try {
            $datos = $request->all();
            $investigador = Investigador::find($datos["investigador_id"]);
            $persona = Persona::find($investigador->persona_id);

            $investigador->inv_tipo= $datos["TipoDeInvestigador"];

            $persona->per_nombres= $datos["Nombres"];
            $persona->per_apellidos = $datos["Apellidos"];
            $persona->per_identificacion = $datos["Identidficacion"];
            $persona->per_numero_telefono = $datos["Telefono"];
            $persona->per_numero_celular = $datos["Celular"];
            $persona->per_fecha_nacimiento = $datos["FechaDeNacimiento"];
            $persona->per_genero = $datos["Genero"];
            $persona->per_correo = $datos["Correo"];

            $persona->save();
            $investigador->save();

            DB::commit();
            return "1";
        } catch (Exception $e) {
//            Si ocurre algun error se borran los cambios en la Base de datos
            DB::rollBack();
            return json_encode($e);
        }
    }
//        FIN SECCION EVALUADOR
//    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


    public function getAdministrar(){
        return view("roles.adminv.index")->with("mod","administrar.index");
    }
}
