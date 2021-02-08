<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\NuevoPerfilRequest;
use App\Models\Investigador;
use App\Models\Producto;
use App\Models\ProyectoInvestigador;
use App\Models\ProyectoInvestigativo;
use App\Models\Sistema;
use App\Models\Sugerencia;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Models\Proyecto;
use App\Models\Persona;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Contenido;
use App\Models\ConfiguracionContenido;

class InvestigadorController extends Controller {

    public function __construct()
    {
        $this->middleware('autInv');
    }

    public function getIndex()
    {
        $configuraciones = ConfiguracionContenido::all();
        if (count($configuraciones) > 0) {
            $configuracion = $configuraciones[0];
            $mostrar = $configuracion->con_con_mostrar;
            if ($mostrar == "todos") {
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","investigador")->where('con_estado', 'habilitado')->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'hoy') {
                $fechaInicio = date('Y-m-d')." 00:00:00";
                $fechaActual = date('Y-m-d')." 23:59:59";
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","investigador")->where('con_estado', 'habilitado')->whereBetween('created_at', [$fechaInicio, $fechaActual])->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'ultima semana') {
                $fechaActual = date('Y-m-d')." 23:59:59";
                $menosSemana = date('Y-m-d', strtotime('-1 weeks', strtotime($fechaActual)))." 00:00:00";
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","investigador")->where('con_estado', 'habilitado')->whereBetween('created_at', [$menosSemana, $fechaActual])->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'ultimo mes') {
                $fechaActual = date('Y-m-d')." 23:59:59";
                $menosMes = date('Y-m-d', strtotime('-1 months', strtotime($fechaActual)))." 00:00:00";
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","investigador")->where('con_estado', 'habilitado')->whereBetween('created_at', [$menosMes, $fechaActual])->orderBy("created_at","desc")->get();
            } else if ($mostrar == 'numero') {
                $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                    ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                    ->where("tipocuenta.tip_cue_nombre","investigador")->where('con_estado', 'habilitado')->take($configuracion->con_eve_numero_mostrar)->orderBy("created_at","desc")->get();
            }
        } else {
            $contenidos = Contenido::join("contenidotipocuenta","contenido.id","=","contenidotipocuenta.contenido_id")
                ->join("tipocuenta","contenidotipocuenta.tipocuenta_id","=","tipocuenta.id")
                ->where("tipocuenta.tip_cue_nombre","investigador")->where('con_estado', 'habilitado')->orderBy("created_at","desc")->get();
        }

        return View('roles/inv/index')->with("mod","inicio")->with("contenidos",$contenidos);
    }

    public function getNuevoPerfil(){
        return View('roles/inv/index')->with("mod","nuevoPerfil");
    }

    public function postNuevoPerfil(NuevoPerfilRequest $request)
    {

        //datos de la persona
        $persona = Persona::find(Session::get("idPersona"));

        //datos del perfil
        $perfil = new Proyecto;
        //se consulta el codigo sin encriptar // pero al objeto perfil se asigna el codigo encriptado
        $codigo = $perfil->generarCodigo();
        $perfil->pro_titulo = $request->input('titulo');
        $perfil->pro_objetivo_general = $request->input('objetivoGeneral');
        $perfil->pro_justificacion = $request->input('justificacion');
        $perfil->pro_presupuesto_estimado = $request->input('presupuesto');
        $perfil->pro_estado = "propuesta";
        $proyectoInvestigativo = new ProyectoInvestigativo;
        $proyectoInvestigativo->pro_inv_sector = $request->input('sector');
        $proyectoInvestigativo->pro_inv_problema = $request->input('problema');



        DB::beginTransaction();


        $perfil->save();
        $proyectoInvestigativo->proyecto_id = $perfil->id;
        $proyectoInvestigativo->investigador_id = $persona->investigador->id;
        $proyectoInvestigativo->save();

        $proyectoInvestigador = new ProyectoInvestigador;
        $proyectoInvestigador->proyectoinvestigativo_id = $proyectoInvestigativo->id;
        $proyectoInvestigador->investigador_id = $persona->investigador->id;
        $proyectoInvestigador->save();

        $mensaje = "Su propuesta ha sido almacenada en nuestro sistema Aplicativo de Gestión de Proyectos."
            . "Su propuesta o perfil será revisado por el(la) evaluador(a), quien definirá si debe mejorarse, se rechaza o se avala para continuar la fase de formulación, información que se enviará a la cuenta de correo electrónico registrada.<br>"
            . "El código del proyecto es:<br>"
            . "CODIGO: " . $codigo . "<br>"
            . "Este código puede ser utilizado para editar la información de su perfil sin tener una sesion iniciada.";

        Sistema::enviarMail($persona,$mensaje,"Registro perfil SINERGIA","Registro perfil");

        $administradores = Sistema::administradores();
        $ids = [];

        foreach($administradores as $admin){
            $ids[] = $admin->id;
        }

        $ruta = asset("/proyecto/perfil/".Crypt::encrypt($perfil->id));
        $mensaje = "Un nuevo perfil de proyecto ha sido registrado en el sistema.";

        UsuarioController::registrarNotificacion($mensaje,$ruta,$ids);
        DB::commit();

        return 5;
    }

    public function getPerfiles()
    {
        $perfilesRecibidos = Proyecto::proyectosInvestigadorEstado("propuesta", Session::get("idPersona"));
        $perfilesAprobados = Proyecto::proyectosInvestigadorEstado("propuesta aprobada", Session::get("idPersona"));
        $perfilesDescartados = Proyecto::proyectosInvestigadorEstado("propuesta descartada", Session::get("idPersona"));
        $perfilesCompletos = Proyecto::proyectosInvestigadorEstado("propuesta aprobada completa", Session::get("idPersona"));
        return View('roles/inv/index')->with("mod", "perfiles")
                        ->with("perfilesRecibidos", $perfilesRecibidos)
                        ->with("perfilesAprobados", $perfilesAprobados)
                        ->with("perfilesDescartados", $perfilesDescartados)
                        ->with("perfilesCompletos", $perfilesCompletos)
                        ->with("rol","inv");
    }

    public function getProyectos()
    {
        $proyectosAprobados = Proyecto::proyectosInvestigadorEstado("proyecto aprobado", Session::get("idPersona"));
        $proyectosEnDesarrollo = Proyecto::proyectosInvestigadorEstado("proyecto en desarrollo", Session::get("idPersona"));
        $proyectosEnConvocatoria = Proyecto::proyectosInvestigadorEstado("proyecto en convocatoria", Session::get("idPersona"));
        $proyectosDescartados = Proyecto::proyectosInvestigadorEstado("proyecto descartado", Session::get("idPersona"));
        $proyectosCancelados = Proyecto::proyectosInvestigadorEstado("proyecto cancelado", Session::get("idPersona"));
        $proyectosTerminados = Proyecto::proyectosInvestigadorEstado("proyecto terminado", Session::get("idPersona"));
        return View('roles/inv/index')->with("mod","proyectos")
            ->with('proyectosAprobados', $proyectosAprobados)
            ->with('proyectosEnDesarrollo', $proyectosEnDesarrollo)
            ->with('proyectosDescartados', $proyectosDescartados)
            ->with('proyectosTerminados', $proyectosTerminados)
            ->with('proyectosCancelados', $proyectosCancelados)
            ->with('proyectosEnConvocatoria', $proyectosEnConvocatoria)
            ->with("rol","inv");
    }

    public function getEditarPerfil($id){
        $id = Crypt::decrypt($id);
        $perfil = Proyecto::find($id);
        if($perfil){
            return view('roles.inv.index')->with("temp","perfiles.formEditarPerfil")->with('perfil',$perfil);
        }
        return redirect('/');
    }

    public function getPerfil($idPerfil)
    {
        $perfiles = Proyecto::dataProyecto("*");
        return $this->redireccionConPerfil("perfil/perfil", $perfiles, $idPerfil, "perfil");
    }

    public function getPerfilFormular($id)
    {
        $id = Crypt::decrypt($id);
        $perfil = Proyecto::find($id);
        if($perfil){
            $proponente = $perfil->proyectoInvestigativo->investigadorLider->persona;
            if($proponente){
                if($proponente->id == Session::get('idPersona')){
                    return view("roles.inv.index")->with("mod","perfil/formular")->with("objPerfil", $perfil)->with("perfil", $perfil);
                }
            }

        }
        return redirect("/");
    }

    
    public function getSugerencias(){
        $sugerencias = Sugerencia::select('sugerencia.*')
                        ->join('proyecto','sugerencia.proyecto_id','=','proyecto.id')
                        ->join('proyectoinvestigativo','proyecto.id','=','proyectoinvestigativo.proyecto_id')
                        ->join('proyectoinvestigador','proyectoinvestigativo.id','=','proyectoinvestigador.proyectoinvestigativo_id')
                        ->join('investigador','proyectoinvestigador.investigador_id','=','investigador.id')
                        ->join('persona','investigador.persona_id','=','persona.id')
                        ->where(function($q){
                            $q->whereNull("proyectoinvestigador.pro_inv_estado_solicitud")
                                ->orWhere("proyectoinvestigador.pro_inv_estado_solicitud","aprobado");
                        })
                        ->where('persona.id',Session::get('idPersona'))
                        ->where('sugerencia.sug_estado','por revisar')
                        ->whereNotIn('proyecto.pro_estado',['propuesta descartada','proyecto descartado','proyecto cancelado', 'proyecto terminado'])
                        ->orderBy('sugerencia.created_at','DESC')
                        ->orderBy('sugerencia.id','DESC')->get();

        return view("roles.inv.index")->with("mod","sugerencias")->with("sugerencias", $sugerencias);
    }

    public function getSugerencia($id){
        $idSugerencia = Crypt::decrypt($id);
        $sugerencia = Sugerencia::find($idSugerencia);

        if($sugerencia){
            if($sugerencia->proyecto_estado == $sugerencia->proyecto->pro_estado) {
                $proyectoInvestigativo = $sugerencia->proyecto->proyectoInvestigativo;
                $relacion = ProyectoInvestigador::join("investigador", "proyectoinvestigador.investigador_id", "=", "investigador.id")
                    ->join("persona", "investigador.persona_id", "=", "persona.id")
                    ->where(function ($q) {
                        $q->whereNull("proyectoinvestigador.pro_inv_estado_solicitud")
                            ->orWhere("proyectoinvestigador.pro_inv_estado_solicitud", "aprobado");
                    })
                    ->where("persona.id", Session::get('idPersona'))
                    ->where("proyectoinvestigador.proyectoinvestigativo_id", $proyectoInvestigativo->id)->get();
                if (count($relacion))
                    return view("roles.inv.index")->with("temp", "sugerencia")->with("sugerencia", $sugerencia);
            }
        }
        return redirect('/');
    }


    public function getSolicitudes()
    {
        $solicitudes = ProyectoInvestigador::select('proyectoinvestigador.*')
            ->join('investigador', 'proyectoinvestigador.investigador_id', '=', 'investigador.id')
            ->join('persona', 'investigador.persona_id', '=', 'persona.id')
            ->join('proyectoinvestigativo', 'proyectoinvestigador.proyectoinvestigativo_id', '=', 'proyectoinvestigativo.id')
            ->join('proyecto', 'proyectoinvestigativo.proyecto_id', '=', 'proyecto.id')
            ->where('persona.id', Session::get('idPersona'))
            ->where('proyectoinvestigador.pro_inv_estado_solicitud', 'enviado')
            ->where('proyecto.pro_estado', 'proyecto aprobado')
            ->orderBy('proyectoinvestigador.created_at', 'DESC')->get();

        return view("roles.inv.index")->with("mod", "solicitudes")->with("solicitudes", $solicitudes);
    }

    public function getSolicitud($id){
        $idSolicitud = Crypt::decrypt($id);
        $solicitud = ProyectoInvestigador::find($idSolicitud);
        if($solicitud && $solicitud->pro_inv_estado_solicitud == "enviado"){
            return view("roles.inv.index")->with("mod","solicitud")->with("solicitud", $solicitud);
        }
        return redirect('/');
    }

    public function postCambiarEstadoSolicitud(Request $request){
        if($request->has("solicitud")){
            $id = Crypt::decrypt($request->input("solicitud"));
            $solicitud = ProyectoInvestigador::find($id);
            if($solicitud){
                if($request->has("estado")) {
                    $solicitud->pro_inv_estado_solicitud = $request->input("estado");
                    if($request->has("razon_rechazo"))
                        $solicitud->pro_inv_razon_rechazo = $request->input("razon_Rechazo");

                    $solicitud->save();
                    Session::flash("mensaje","El estado de la solicitud ha sido cambiado a ".$request->input("estado"));
                    //return Session::get("mensaje");
                    return "1";
                }
            }
        }
        return "-2";
    }

    public function getAsignacionTareas($id){
        $id = Crypt::decrypt($id);
        $proyecto = Proyecto::find($id);
        if($proyecto){
            if($proyecto->proyectoInvestigativo->investigadorLider->persona->id == Session::get('idPersona')) {
                $investigadores = Investigador::select("investigador.*")
                    ->join("proyectoinvestigador", "investigador.id", "=", "proyectoinvestigador.investigador_id")
                    ->join("proyectoinvestigativo", "proyectoinvestigador.proyectoinvestigativo_id", "=", "proyectoinvestigativo.id")
                    ->join("proyecto", "proyectoinvestigativo.proyecto_id", "=", "proyecto.id")
                    ->where("proyecto.id", $proyecto->id)
                    ->where(function($q){
                        $q->whereNull("proyectoinvestigador.pro_inv_estado_solicitud")
                            ->orWhere("proyectoinvestigador.pro_inv_estado_solicitud","aprobado");
                    })->get();

                foreach($investigadores as $investigador){
                    $relacion = ProyectoInvestigador::where("investigador_id",$investigador->id)
                                                    ->where("proyectoinvestigativo_id",$proyecto->proyectoInvestigativo->id)->first();
                    $investigador->pro_inv_rol = $relacion->pro_inv_rol;
                }
                return view("roles/inv/index")->with("mod", "asignarTareas")->with("proyecto", $proyecto)->with("investigadores",$investigadores);
            }
        }
        return redirect("/");
    }

    public function postAsignarTarea(Request $request){
        if($request->has("producto")){
            if($request->has("investigador")){
                $idInvestigador = Crypt::decrypt($request->input("investigador"));
                $idProducto = Crypt::decrypt($request->input("producto"));

                $producto = Producto::find($idProducto);
                $investigador = Investigador::find($idInvestigador);
                if($producto && $investigador){
                    if(!$producto->investigador_id || $request->has("confirmacion")){
                        $producto->investigador_id = $investigador->id;
                        $producto->save();
                        Session::flash("mensaje","La tarea ha sido asignada al investigador");
                        return "1";
                    }else{
                        return "-1";
                    }
                }
            }else{
                return "Seleccione un invesigador";
            }
        }else{
            return "Seleccione un producto";
        }
        return "-2";
    }

    public function getMisTareas($id){
        $id = Crypt::decrypt($id);
        $proyecto = Proyecto::find($id);
        if($proyecto){
            if(Sistema::isValidUserTareas($proyecto->id)) {
                if($proyecto->isLider()){
                    $productos = $proyecto->allProductos();
                }else{
                    $persona = Persona::find(Session::get("idPersona"));
                    $productos = $proyecto->tareasInvestigador($persona->investigador->id);
                }
                return view("roles/inv/index")->with("mod", "misTareas")->with("proyecto", $proyecto)->with("productos",$productos);
            }
        }
        return redirect("/");
    }

    public function postDesarrolloTarea(Request $request){
        $id = Crypt::decrypt($request->input("producto"));
        $producto  = Producto::find($id);
        if($producto){
            $proyecto = $producto->actividad->componente->proyectoInvestigativo->proyecto;

            if(Sistema::isValidUserTareas($proyecto->id)) {
                $persona = Persona::find(Session::get("idPersona"));
                if($proyecto->isLider() || $producto->investigador_id == $persona->investigador->id){
                    if($request->has('nota') || $request->hasFile('archivo')){
                        if($request->has("nota")){
                            $producto->pro_nota = $request->get("nota");
                        }

                        if($request->hasFile("archivo")){
                            if($producto->pro_ubicacion){
                                Storage::disk("uploads")->delete("/productos/".$producto->id."/".$producto->pro_ubicacion);
                            }

                            $archivo = $request->file("archivo");
                            $extension = $archivo->getClientOriginalExtension();

                            if($archivo->getClientSize() <= 10000000) {
                                $producto->pro_ubicacion = $archivo->getClientOriginalName();
                                Storage::disk('uploads')->put("productos/".$producto->id."/".$archivo->getClientOriginalName(),  File::get($archivo));
                            }else{
                                return "El tamaño del archivo debe ser menor a 10 Mb.";
                            }
                        }

                        $producto->save();
                        Session::flash("mensaje","La información ha sido almacenada con exito");
                        return "1";
                    }else{
                        return '-1';
                    }
                }
            }
        }
        return "-2";
    }
}
