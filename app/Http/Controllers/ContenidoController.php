<?php namespace App\Http\Controllers;

use App\Http\Middleware\AutenticacionAdminv;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Contenido;
use App\Models\ContenidoTipoCuenta;
use App\Models\TipoCuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ConfiguracionContenido;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ContenidoController extends Controller {

	public function getNuevo(){
        if(AutenticacionAdminv::check()){
            return view("inicio")->with('mod','contenido/nuevo');
        }
        return redirect('/');
    }

    public function postSave(Request $request){
        if($request->ajax()){
            $contenido = true;
            if($request->has("contenido_editar")){
                $contenido = Contenido::find($request->input("contenido_editar"));
            }

            if($contenido) {
                if(!$request->has("contenido_editar")) {
                    $nombre = $request->input('nombre');

                    $repetidos = Contenido::where("con_nombre", $nombre)->get();
                    if (!count($repetidos)) {//No existe un contenido con el mismo nombre
                        $html = $request->input('html');
                        $htmlEdit = $request->input('htmlEdit');

                        if ($request->input('administrador') || $request->input('evaluador') || $request->input('investigador') || $request->input('sin_sesion')) {

                            if ($html != "" && $html != null && $htmlEdit != "" && $htmlEdit != null) {
                                $contenido = new Contenido();
                                $contenido->con_nombre = $nombre;
                                $contenido->con_estado = "habilitado";
                                $nombre_archivo = $contenido->generarNombre();
                                $contenido->save();

                                $nuevoarchivo = fopen("contenidos/" . $nombre_archivo, "w+");
                                fwrite($nuevoarchivo, $html);
                                fclose($nuevoarchivo);

                                $nuevoarchivo = fopen("contenidos/" . "edit_" . $nombre_archivo, "w+");
                                fwrite($nuevoarchivo, $htmlEdit);
                                fclose($nuevoarchivo);

                                if ($request->input('administrador')) {
                                    $c = new ContenidoTipoCuenta();

                                    $c->tipocuenta_id = TipoCuenta::where("tip_cue_nombre", "administrador investigativo")->first()->id;
                                    $c->contenido_id = $contenido->id;
                                    $c->save();
                                }

                                if ($request->input('evaluador')) {
                                    $c = new ContenidoTipoCuenta();

                                    $c->tipocuenta_id = TipoCuenta::where("tip_cue_nombre", "evaluador")->first()->id;
                                    $c->contenido_id = $contenido->id;
                                    $c->save();
                                }

                                if ($request->input('investigador')) {
                                    $c = new ContenidoTipoCuenta();

                                    $c->tipocuenta_id = TipoCuenta::where("tip_cue_nombre", "investigador")->first()->id;
                                    $c->contenido_id = $contenido->id;
                                    $c->save();
                                }

                                if ($request->input('sin_sesion')) {
                                    $contenido->con_sin_sesion = "si";
                                    $contenido->save();
                                }
                                Session::flash("mensaje", "El contenido ha sido almacenado con exito");
                                return '1';
                            } else {
                                return "Error en la información enviada.";
                            }
                        } else {
                            return "Seleccione por lo menos un rol al cual mostrar el contenido.";
                        }
                    } else {
                        return "Ya existe un contenido con el nombre ingresado.";
                    }
                }else{
                    $nombre = $request->input('nombre');

                    $repetidos = Contenido::where("con_nombre", $nombre)->get();
                    $contituar = true;
                    foreach($repetidos as $r){
                        if($r->id != $contenido->id){
                            $contituar = false;
                            break;
                        }
                    }

                    if ($contituar) {//No existe un contenido con el mismo nombre
                        $html = $request->input('html');
                        $htmlEdit = $request->input('htmlEdit');

                        if ($request->input('administrador') || $request->input('evaluador') || $request->input('investigador') || $request->input('sin_sesion')) {

                            if ($html != "" && $html != null && $htmlEdit != "" && $htmlEdit != null) {
                                $contenido->con_nombre = $nombre;
                                //$contenido->con_estado = "habilitado";
                                //$nombre_archivo = $contenido->generarNombre();
                                $contenido->save();

                                //File::delete("contenidos/" . $contenido->con_archivo);
                                //File::delete("contenidos/edit_" . $contenido->con_archivo);

                                //$nombre_archivo = $contenido->generarNombre();
                                //$contenido->save();
                                $nombre_archivo = $contenido->con_archivo;

                                $nuevoarchivo = fopen("contenidos/" . $nombre_archivo, "w+");
                                fwrite($nuevoarchivo, $html);
                                fclose($nuevoarchivo);

                                $nuevoarchivo = fopen("contenidos/" . "edit_" . $nombre_archivo, "w+");
                                fwrite($nuevoarchivo, $htmlEdit);
                                fclose($nuevoarchivo);

                                $relaciones = ContenidoTipoCuenta::where("contenido_id",$contenido->id)->get();
                                foreach($relaciones as $r){
                                    $r->delete();
                                }

                                if ($request->input('administrador')) {
                                    $c = new ContenidoTipoCuenta();

                                    $c->tipocuenta_id = TipoCuenta::where("tip_cue_nombre", "administrador investigativo")->first()->id;
                                    $c->contenido_id = $contenido->id;
                                    $c->save();
                                }

                                if ($request->input('evaluador')) {
                                    $c = new ContenidoTipoCuenta();

                                    $c->tipocuenta_id = TipoCuenta::where("tip_cue_nombre", "evaluador")->first()->id;
                                    $c->contenido_id = $contenido->id;
                                    $c->save();
                                }

                                if ($request->input('investigador')) {
                                    $c = new ContenidoTipoCuenta();

                                    $c->tipocuenta_id = TipoCuenta::where("tip_cue_nombre", "investigador")->first()->id;
                                    $c->contenido_id = $contenido->id;
                                    $c->save();
                                }

                                if ($request->input('sin_sesion')) {
                                    $contenido->con_sin_sesion = "si";
                                    $contenido->save();
                                }
                                Session::flash("mensaje", "El contenido ha sido editado con exito");
                                return '1';
                            } else {
                                return "Error en la información enviada.";
                            }
                        } else {
                            return "Seleccione por lo menos un rol al cual mostrar el contenido.";
                        }
                    } else {
                        return "Ya existe un contenido con el nombre ingresado.";
                    }
                }
            }else{
                return "Error en la información enviada.";
            }
        }
        return redirect('/');
    }

    public function getEstablecer(){
        if(AutenticacionAdminv::check()) {
            $configuraciones = ConfiguracionContenido::all();
            if (count($configuraciones) > 0) {
                $configuracion = $configuraciones[0];
                $mostrar = $configuracion->con_con_mostrar;
                if ($mostrar == "todos") {
                    $contenidos = Contenido::orderBy("created_at","desc")->get();
                } else if ($mostrar == 'hoy') {
                    $fechaInicio = date('Y-m-d')." 00:00:00";
                    $fechaActual = date('Y-m-d')." 23:59:59";
                    $contenidos = Contenido::whereBetween('created_at', [$fechaInicio, $fechaActual])->orderBy("created_at","desc")->get();
                } else if ($mostrar == 'ultima semana') {
                    $fechaActual = date('Y-m-d')." 23:59:59";
                    $menosSemana = date('Y-m-d', strtotime('-1 weeks', strtotime($fechaActual)))." 00:00:00";
                    $contenidos = Contenido::whereBetween('created_at', [$menosSemana, $fechaActual])->orderBy("created_at","desc")->get();
                } else if ($mostrar == 'ultimo mes') {
                    $fechaActual = date('Y-m-d')." 23:59:59";
                    $menosMes = date('Y-m-d', strtotime('-1 months', strtotime($fechaActual)))." 00:00:00";
                    $contenidos = Contenido::whereBetween('created_at', [$menosMes, $fechaActual])->orderBy("created_at","desc")->get();
                } else if ($mostrar == 'numero') {
                    $contenidos = Contenido::take($configuracion->con_con_numero_mostrar)->orderBy("created_at","desc")->get();
                }
            } else {
                $contenidos = Contenido::orderBy("created_at","desc")->get();
            }

            return view("inicio")->with("mod", "contenido/establecer")->with("contenidos",$contenidos)
                ->with("configuracion",$configuracion)->with("estado",true)->with("editar",false);
        }
        return redirect("/");
    }

    public function getAdministrar(){
        if(AutenticacionAdminv::check())
        {
            $contenidos = Contenido::orderBy("created_at","desc")->paginate(10);
            return view("inicio")->
            with("mod", "contenido/administrar")->with("contenidos",$contenidos)
                ->with("estado",false)->with("editar",true);
        }
        return redirect("/");
    }

    public function postList(Request $request){
        $mostrar = $request->input("contenidos");
        $contenidos = null;
        if ($mostrar == "todos") {
            $contenidos = Contenido::orderBy("created_at","desc")->get();
        } else if ($mostrar == 'hoy') {
            $fechaInicio = date('Y-m-d')." 00:00:00";
            $fechaActual = date('Y-m-d')." 23:59:59";
            $contenidos = Contenido::whereBetween('created_at', [$fechaInicio, $fechaActual])->orderBy("created_at","desc")->get();
        } else if ($mostrar == 'ultima semana') {
            $fechaActual = date('Y-m-d')." 23:59:59";
            $menosSemana = date('Y-m-d', strtotime('-1 weeks', strtotime($fechaActual)))." 00:00:00";
            $contenidos = Contenido::whereBetween('created_at', [$menosSemana, $fechaActual])->orderBy("created_at","desc")->get();
        } else if ($mostrar == 'ultimo mes') {
            $fechaActual = date('Y-m-d')." 23:59:59";
            $menosMes = date('Y-m-d', strtotime('-1 months', strtotime($fechaActual)))." 00:00:00";
            $contenidos = Contenido::whereBetween('created_at', [$menosMes, $fechaActual])->orderBy("created_at","desc")->get();
        } else if ($mostrar == 'numero') {
            $contenidos = Contenido::where("con_estado","habilitado")->take($request->input("cantidad_mostrar"))->orderBy("created_at","desc")->get();
        }

        $editar = false;
        $estado = false;
        if($request->input("editar") == "1"){
            $editar = true;
        }

        if($request->input("estado") == "1"){
            $estado = true;
        }

        return view("modulos/contenido/lista")->with("contenidos",$contenidos)
            ->with("estado",$estado)->with("editar",$editar);
    }

    public function postCambiarEstado(Request $request){
        if(AutenticacionAdminv::check()){
            $id = $request->input("id");
            $contenido = Contenido::find($id);
            if($contenido){
                if($contenido->con_estado == "habilitado"){
                    $contenido->con_estado = "inhabilitado";
                    Session::flash("mensaje","El contenido ha sido inhabilitado");
                }else if($contenido->con_estado == "inhabilitado"){
                    $contenido->con_estado = "habilitado";
                    Session::flash("mensaje","El contenido ha sido habilitado");
                }
                $contenido->save();
                return "1";
            }
        }
        return "-1";
    }

    public function postSaveConf(Request $request)
    {
        if(AutenticacionAdminv::check()){
            $mostrar = $request->input("contenidos");
            $cantidad = $request->input("cantidad_mostrar");
            $conf = ConfiguracionContenido::first();
            $conf->con_con_mostrar = $mostrar;
            $conf->con_con_numero_mostrar = $cantidad;
            $conf->save();
            Session::flash("mensaje","La configuración de los contenidos ha sido establecida.");
            return "1";
        }
        return "-1";
    }

    public function getEditar($id){
        if(AutenticacionAdminv::check()) {
            $contenido = Contenido::find($id);
            if($contenido) {
                $action = "editar";
                return view("inicio")->with("mod", "contenido/editar")->with("contenido", $contenido)->with("action", $action);
            }
        }
        return redirect("/");
    }
}
