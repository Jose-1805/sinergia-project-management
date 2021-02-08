<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\Producto;
use App\Models\Seguimiento;
use App\Models\SeguimientoActividad;
use App\Models\SeguimientoProducto;
use App\Models\Sugerencia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\actionsActividadRequest;

class ActividadController extends Controller {

	public function  __construct(){

    }

    public function getView($id){
        $id = Crypt::decrypt($id);
        $actividad = Actividad::find($id);
        if($actividad){
            if (Session::has("idPersona")) {
                $rol = "";
                if (Session::get('rol actual') == "administrador investigativo")
                    $rol = "adminv";
                else if (Session::get('rol actual') == "investigador")
                    $rol = "inv";
                else if ((Session::get('rol actual') == "evaluador"))
                    $rol = "eval";

                return view("plantillas/actividad")->with("actividad", $actividad)->with("rol", $rol);
            }
        }
        return redirect()->back();
    }

    public function postUpdate(actionsActividadRequest $request){
        $idActividad = Crypt::decrypt($request->input("id_actividad"));
        $actividad = Actividad::find($idActividad);
        $componente = $actividad->componente;

        $proyecto = $componente->proyectoInvestigativo->proyecto;
        $error = false;


        if($proyecto->pro_duracion < $request->input('duracion')){
            $error = true;
            $mensajeError = "La duración de una actividad no puede ser mayor a la duración del proyecto, la duración del proyecto es de ".$proyecto->pro_duracion." meses.";
        }

        if(((intval($request->input('mes-inicio')) + $request->input('duracion'))-1) > $proyecto->pro_duracion){
            $error = true;
            $mensajeError = "La duración de la actividad, el mes de inicio de la misma y la duración del proyecto no establecen una relación correcta.";
        }

        if($actividad->act_estado == "delete"){
            $error = true;
            $mensajeError = "No es posible editar la información de esta actividad. Anteriormente usted a descartado esta actividad de su proyecto.";
        }

        if($error){
            return $mensajeError;
        }

        $actividad->act_descripcion = $request->input('descripcion');
        $actividad->act_resultado = $request->input('resultado');
        $actividad->act_indicador = $request->input('indicador');
        $actividad->act_numero_mes_inicio = $request->input('mes-inicio');
        $actividad->act_duracion = $request->input('duracion');

        $actividad->save();
        return '1';
    }

    public function postAddSugerencia(Request $request){
        if($request->has("id_seguimiento")){
            $idSeguimiento = Crypt::decrypt($request->get("id_seguimiento"));
            $seguimiento = Seguimiento::find($idSeguimiento);
        }else{
            $seguimiento = new Seguimiento();
        }

        if($request->has("id_actividad")){
            $idActividad = Crypt::decrypt($request->get("id_actividad"));
            $actividad = Actividad::find($idActividad);
            if($actividad && $actividad->act_estado != "delete"){
                $proyecto = $actividad->componente->proyectoInvestigativo->proyecto;
                $seguimiento->proyecto_id = $proyecto->id;
                $seguimiento->persona_id = Session::get("idPersona");
                $seguimiento->save();

                $sugerencia = new Sugerencia();
                $sugerencia->sug_descripcion = $request->input("sugerencia");
                $sugerencia->sug_importancia= $request->input("importancia");
                $sugerencia->sug_estado = "por revisar";
                $sugerencia->proyecto_id = $proyecto->id;
                $sugerencia->proyecto_estado = $proyecto->pro_estado;
                $sugerencia->sug_elemento_nombre = "actividad";
                $sugerencia->sug_elemento_id = $actividad->id;
                $sugerencia->persona_id = Session::get("idPersona");
                $sugerencia->seguimiento_id = $seguimiento->id;
                $sugerencia->save();

                return [
                    "response"=>"La sugerencia se ha registrado con exito.",
                    "idSeguimiento"=>Crypt::encrypt($seguimiento->id)
                ];
            }
        }
        return -1;
    }

    public function postAddSugerenciaProducto(Request $request){
        if($request->has("id_seguimiento")){
            $idSeguimiento = Crypt::decrypt($request->get("id_seguimiento"));
            $seguimiento = Seguimiento::find($idSeguimiento);
        }else{
            $seguimiento = new Seguimiento();
        }

        if($request->has("id_producto")){
            $idProducto = Crypt::decrypt($request->get("id_producto"));
            $producto = Producto::find($idProducto);
            if($producto && $producto->pro_estado != "delete"){
                $proyecto = $producto->actividad->componente->proyectoInvestigativo->proyecto;
                $seguimiento->proyecto_id = $proyecto->id;
                $seguimiento->persona_id = Session::get("idPersona");
                $seguimiento->save();

                $sugerencia = new Sugerencia();
                $sugerencia->sug_descripcion = $request->input("sugerencia");
                $sugerencia->sug_importancia= $request->input("importancia");
                $sugerencia->sug_estado = "por revisar";
                $sugerencia->proyecto_id = $proyecto->id;
                $sugerencia->proyecto_estado = $proyecto->pro_estado;
                $sugerencia->sug_elemento_nombre = "producto";
                $sugerencia->sug_elemento_id = $producto->id;
                $sugerencia->persona_id = Session::get("idPersona");
                $sugerencia->seguimiento_id = $seguimiento->id;
                $sugerencia->save();

                $ids = [];

                if($producto->investigador->persona){
                    $ids[] = $producto->investigador->persona_id;
                }

                $ids[] = $producto->actividad->componente->proyectoInvestigativo->investigadorLider->persona_id;

                $mensaje = "Nueva sugerencia a un producto del proyecto ".$proyecto->pro_titulo;
                $url = asset("/inv/sugerencia/".Crypt::encrypt($sugerencia->id));

                UsuarioController::registrarNotificacion($mensaje,$url,$ids);

                return [
                    "response"=>"La sugerencia se ha registrado con exito.",
                    "idSeguimiento"=>Crypt::encrypt($seguimiento->id)
                ];
            }
        }
        return -1;
    }

    public function postGuardarCambiosProductos(Request $request){
        $seguimiento = null;
        if($request->has("id_seguimiento")){
            $idSeguimiento = Crypt::decrypt($request->get("id_seguimiento"));
            $seguimiento = Seguimiento::find($idSeguimiento);
        }

        if($request->has("id_actividad")){
            $idActividad = Crypt::decrypt($request->get("id_actividad"));
            $actividad = Actividad::find($idActividad);
            if($actividad && $actividad->act_estado != "delete"){
                $break = false;
                $i = 0;
                $error = false;
                $productos = [];
                while(!$break && !$error){
                    $i++;
                    if($request->has("id_producto".$i)){
                        $producto = Producto::find(Crypt::decrypt($request->input("id_producto".$i)));
                        if($producto){
                            if($request->has("estado_producto".$i)){
                                $estado = "";
                                switch($request->get("estado_producto".$i)){
                                    case '1': $estado = "por revisar";
                                        break;
                                    case '2': $estado ="aprobado";
                                        break;
                                    case '3': $estado = "no aprobado";
                                        break;
                                    default: $estado = "por revisar";
                                        break;

                                }
                                if($producto->pro_estado != $estado){
                                    $estadoPrevio = $producto->pro_estado;
                                    $producto->pro_estado = $estado;
                                    $productos[] = [$producto,$estadoPrevio];
                                }
                            }else{
                                $error = true;
                            }
                        }else{
                            $error = true;
                        }
                    }else{
                        $break = true;
                    }
                }

                if($error){
                    return '-1';
                }

                if(count($productos)){
                    $proyecto = $actividad->componente->proyectoInvestigativo->proyecto;
                    if($seguimiento == null){
                            $seguimiento = new Seguimiento();
                            $seguimiento->proyecto_id = $proyecto->id;
                            $seguimiento->persona_id = Session::get("idPersona");
                            $seguimiento->save();
                    }

                    $actividadFinalizada = "no";
                    for($e = 0;$e < count($productos);$e++){
                        $seguimientoProducto = new SeguimientoProducto();
                        $seguimientoProducto->seguimiento_id = $seguimiento->id;
                        $seguimientoProducto->producto_id = $productos[$e][0]->id;
                        $seguimientoProducto->seg_pro_estado_nuevo = $productos[$e][0]->pro_estado;
                        $seguimientoProducto->seg_pro_estado_previo = $productos[$e][1];
                        $seguimientoProducto->save();
                        if($productos[$e][0]->save()) {
                            $actividadEstadoPrevio = $productos[$e][0]->actividad->act_estado;
                            $var = $productos[$e][0]->actividad->evaluarEstado();
                            if($productos[$e][0]->actividad->act_estado == "finalizado"){
                                $actividadFinalizada = "si";
                            }
                        }
                    }

                    if($actividadFinalizada == "si"){
                        $seguimientoActividad = new SeguimientoActividad();
                        $seguimientoActividad->seguimiento_id = $seguimiento->id;
                        $seguimientoActividad->actividad_id = $actividad->id;
                        $seguimientoActividad->seg_act_estado_previo = $actividadEstadoPrevio;
                        $seguimientoActividad->seg_act_estado_nuevo = "finalizado";
                        $seguimientoActividad->save();
                        Session::flash("mensaje","La actividad evaluada ha sido finalizada.");
                    }
                    return [
                        "idSeguimiento"=>$seguimiento->id,
                        "response"=>"Tarea realizada con exito.<br> Productos modificados: ".count($productos),
                        "actividadFinalizada"=>$actividadFinalizada,
                        "link"=>"link_actividad".$actividad->id
                    ];
                }else{
                    return [
                        "response"=>"No se han realizado cambios en ningún producto."
                    ];
                }
            }
        }
        return -1;

    }

    public function  postFinalizarActividad(Request $request){
        $seguimiento = null;
        if($request->has("id_seguimiento")){
            $idSeguimiento = Crypt::decrypt($request->get("id_seguimiento"));
            $seguimiento = Seguimiento::find($idSeguimiento);
        }

        if($request->has("id_actividad")) {
            $idActividad = Crypt::decrypt($request->get("id_actividad"));
            $actividad = Actividad::find($idActividad);
            if ($actividad && $actividad->act_estado != "delete") {
                if(!count($actividad->productos)){
                    $actividadEstadoPrevio = $actividad->act_estado;
                    $actividad->act_estado = "finalizado";
                    $actividad->save();
                    Session::flash("msjComponente","El estado de la actividad fue cambiado a finalizado");

                    if($seguimiento == null){
                        $proyecto = $actividad->componente->proyectoInvestigativo->proyecto;
                        $seguimiento = new Seguimiento();
                        $seguimiento->proyecto_id = $proyecto->id;
                        $seguimiento->persona_id = Session::get("idPersona");
                        $seguimiento->save();
                    }
                    $seguimientoActividad = new SeguimientoActividad();
                    $seguimientoActividad->seguimiento_id = $seguimiento->id;
                    $seguimientoActividad->actividad_id = $actividad->id;
                    $seguimientoActividad->seg_act_estado_previo = $actividadEstadoPrevio;
                    $seguimientoActividad->seg_act_estado_nuevo = $actividad->act_estado;
                    $seguimientoActividad->save();
                    return "1";
                }
            }
        }
        return "-1";
    }

    public function  postDelete(Request $request){
        if($request->ajax()){
            $id = Crypt::decrypt($request->input("id"));
            $actividad = Actividad::find($id);
            if($actividad){
                $actividad->stateDelete();
                Session::flash("msjComponente","La actividad ha sido eliminada de el componente.");
                return '1';
            }else{
                return '-1';
            }
        }
    }
}