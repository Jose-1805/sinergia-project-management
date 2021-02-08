<?php namespace App\Http\Controllers;

use App\Http\Middleware\AutenticacionAdminv;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Support\Facades\DB;
use App\Models\ConfiguracionEvento;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\GuardarEventoRequest;

class EventosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
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

        return view("inicio")->with("mod", "eventos")->with("eventos",$eventos);
	}

    public function getEstablecer(){
        if(AutenticacionAdminv::check()) {
            $configuraciones = ConfiguracionEvento::all();
            $configuracion = new ConfiguracionEvento();
            if (count($configuraciones) > 0) {
                $configuracion = $configuraciones[0];
                $mostrar = $configuracion->con_eve_mostrar;
                if ($mostrar == "todos") {
                    $eventos = DB::table('evento')->orderBy("eve_fecha_creacion","desc")->get();
                } else if ($mostrar == 'hoy') {
                    $fechaInicio = date("Y-m-d")." 00:00:00";
                    $fechaActual = date('Y-m-d')." 23:59:59";
                    $eventos = DB::table('evento')->whereBetween('eve_fecha_creacion', [$fechaInicio, $fechaActual])->orderBy("eve_fecha_creacion","desc")->get();
                } else if ($mostrar == 'ultima semana') {
                    $fechaActual = date('Y-m-d')." 23:59:59";
                    $menosSemana = date('Y-m-d', strtotime('-1 weeks', strtotime($fechaActual)))." 00:00:00";
                    $eventos = DB::table('evento')->whereBetween('eve_fecha_creacion', [$menosSemana, $fechaActual])->orderBy("eve_fecha_creacion","desc")->get();
                } else if ($mostrar == 'ultimo mes') {
                    $fechaActual = date('Y-m-d')." 23:59:59";
                    $menosMes = date('Y-m-d', strtotime('-1 months', strtotime($fechaActual)))." 00:00:00";
                    $eventos = DB::table('evento')->whereBetween('eve_fecha_creacion', [$menosMes, $fechaActual])->orderBy("eve_fecha_creacion","desc")->get();
                } else if ($mostrar == 'numero') {
                    $eventos = DB::table('evento')->take($configuracion->con_eve_numero_mostrar)->orderBy("eve_fecha_creacion","desc")->get();
                }
            } else {
                $eventos = DB::table('evento')->get();
            }
            return view("inicio")->with("mod", "eventos/establecer")->with("eventos",$eventos)
                ->with("configuracion",$configuracion)->with("estado",true)->with("editar",false);
        }
        return redirect("/");
    }

    public function getAdministrar(){
        if(AutenticacionAdminv::check())
        {
            $eventos = Evento::orderBy("eve_fecha_creacion","desc")->paginate(10);
            return view("inicio")->
                        with("mod", "eventos/administrar")->with("eventos",$eventos)
                        ->with("estado",false)->with("editar",true);
        }
        return redirect("/");
    }

    public function postList(Request $request){
        $mostrar = $request->input("eventos");
        $eventos = null;
        if ($mostrar == "todos") {
            $eventos = DB::table('evento')->get();
        } else if ($mostrar == 'hoy') {
            $fechaInicio = date("Y-m-d")." 00:00:00";
            $fechaActual = date('Y-m-d')." 23:59:59";
            $eventos = DB::table('evento')->whereBetween('eve_fecha_creacion', [$fechaInicio, $fechaActual])->orderBy("eve_fecha_creacion","desc")->get();
        } else if ($mostrar == 'ultima semana') {
            $fechaActual = date('Y-m-d')." 23:59:59";;
            $menosSemana = date('Y-m-d', strtotime('-1 weeks', strtotime($fechaActual)))." 00:00:00";;
            $eventos = DB::table('evento')->whereBetween('eve_fecha_creacion', [$menosSemana, $fechaActual])->orderBy("eve_fecha_creacion","desc")->get();
        } else if ($mostrar == 'ultimo mes') {
            $fechaActual = date('Y-m-d')." 23:59:59";;
            $menosMes = date('Y-m-d', strtotime('-1 months', strtotime($fechaActual)))." 00:00:00";;
            $eventos = DB::table('evento')->whereBetween('eve_fecha_creacion', [$menosMes, $fechaActual])->orderBy("eve_fecha_creacion","desc")->get();
        } else if ($mostrar == 'numero') {
            $eventos = DB::table('evento')->where("eve_estado","habilitado")->take($request->input("cantidad_mostrar"))->orderBy("eve_fecha_creacion","desc")->get();
        }
        $editar = false;
        $estado = false;
        if($request->input("editar") == "1"){
            $editar = true;
        }

        if($request->input("estado") == "1"){
            $estado = true;
        }
        return view("modulos/eventos/lista")->with("eventos",$eventos)
            ->with("estado",$estado)->with("editar",$editar);
    }

    public function postSave(Request $request)
    {
        if(AutenticacionAdminv::check()){
            $mostrar = $request->input("eventos");
            $cantidad = $request->input("cantidad_mostrar");
            $conf = ConfiguracionEvento::first();
            $conf->con_eve_mostrar = $mostrar;
            $conf->con_eve_numero_mostrar = $cantidad;
            $conf->save();
            Session::flash("mensaje","La configuración de los eventos ha sido establecida.");
            return "1";
        }
        return "-1";
    }

	public function getEvento($id)
	{
        $eventos = DB::table('evento')->where('eve_estado', 'habilitado')
            ->where('id', $id)
            ->get();
        if (count($eventos) > 0) {
            return view('inicio')->with("mod", "evento")->with("evento", $eventos[0]);
        }
        return redirect('inicio');
	}

    public function postCambiarEstado(Request $request){
        if(AutenticacionAdminv::check()){
            $id = $request->input("id");
            $evento = Evento::find($id);
            if($evento){
                if($evento->eve_estado == "habilitado"){
                    $evento->eve_estado = "inhabilitado";
                    Session::flash("mensaje","El evento ha sido inhabilitado");
                }else if($evento->eve_estado == "inhabilitado"){
                    $evento->eve_estado = "habilitado";
                    Session::flash("mensaje","El evento ha sido habilitado");
                }
                $evento->save();
                return "1";
            }
        }
        return "-1";
    }

    public function getEditar($id){
        if(AutenticacionAdminv::check()) {
            $evento = Evento::find($id);
            if($evento) {
                $action = "editar";
                return view("inicio")->with("mod", "eventos/editar")->with("evento", $evento)->with("action", $action);
            }
        }
        return redirect("/");
    }

    public function getCrear(){
        if(AutenticacionAdminv::check()) {
            $evento = new Evento();
            $action = "crear";
            return view("inicio")->with("mod", "eventos/crear")->with("evento", $evento)->with("action",$action);
        }
        return redirect("/");
    }

    public function postGuardar(GuardarEventoRequest $request){
        if(AutenticacionAdminv::check()){
            DB::beginTransaction();
            $evento = new Evento();
            $evento->eve_titulo = $request->input('titulo');
            $evento->eve_descripcion_corta = $request->input('descripcion_corta');
            $evento->eve_descripcion_detallada = $request->input('descripcion_detallada');
            $evento->eve_estado = $request->input('estado');
            $evento->eve_fecha_creacion = date("Y-m-d H:i:s");
            $evento->save();
            $cantidad_imagenes = $request->input('cantidad_imagenes');
            $path = public_path() . '/imagenes/eventos/';

            $errorTamaño = false;
            $errorExtension = false;
            $errorArchivo = false;
            for($i = 0; $i < $cantidad_imagenes; $i++) {
                if($request->hasFile('imagen_'.($i+1))) {
                    $imagen = $request->all()['imagen_' . ($i + 1)];
                    if ($imagen->getClientOriginalExtension() == 'png' || $imagen->getClientOriginalExtension() == 'jpg' || $imagen->getClientOriginalExtension() == 'jpeg' || $imagen->getClientOriginalExtension() == 'svg') {
                        if ($imagen->getClientSize() > 7000000) {
                            $errorTamaño = true;
                            break;
                        }
                    } else {
                        $errorExtension = true;
                        break;
                    }
                }else{
                    $errorArchivo = true;
                    break;
                }
            }
            if(!$errorTamaño && !$errorArchivo && !$errorExtension){
                mkdir($path . $evento->id);
                for($i = 0; $i < $cantidad_imagenes; $i++) {
                    $imagen = $request->all()['imagen_'.($i + 1)];
                    $name = $i. "." . $imagen->getClientOriginalExtension();
                    if ($i == 0) {
                        $name = "principal." . $imagen->getClientOriginalExtension();
                    }
                    $ruta = $path . $evento->id . "/" . $name;
                    $tmp = $imagen->getPath() . "/" . $imagen->getFileName();
                    copy($tmp, $ruta);
                }
                DB::commit();
                return '1';
            }else{
                if($errorExtension){
                    return '-1';
                }else if($errorArchivo){
                    return '-2';
                } else if($errorTamaño){
                    return '-3';
                }
            }
        }
    }

    public function postEliminarImagen(Request $request){
        if($request->ajax() && AutenticacionAdminv::check()){
            $evento = Evento::find($request->input('evento'));
            $nameFile = $request->input('name');

            if($evento){
                $path = public_path() . '/imagenes/eventos/'.$evento->id;
                $ruta = $path.'/'.$nameFile;
                //echo "Eliminado: ".$ruta;
                @unlink($ruta);

                //se reestructuran los nommbres de los archivos
                $i = 0;//nombre de cada archivo
                $noExists = 0;//cuanta los archivos que no existen

                while($noExists < 2){
                    if($i == 0){
                        $ruta = $path.'/principal.';
                        if(!file_exists($ruta.'jpg') && !file_exists($ruta.'png') && !file_exists($ruta.'jpeg') && !file_exists($ruta.'svg')){
                            //echo "<br>***Principal no existe";
                            $noExists = 2;
                            $i++;
                            $ruta2 = $path.'/'.$i.'.';
                            if(file_exists($ruta2.'jpg')){
                                rename($ruta2.'jpg',$ruta.'jpg');
                                $noExists = 1;
                                //echo "<br>***".$ruta2."jpg renombrado a ".$ruta."jpg";
                            }else if(file_exists($ruta2.'jpeg')){
                                rename($ruta2.'jpeg',$ruta.'jpeg');
                                $noExists = 1;
                                //echo "<br>***".$ruta2."jpeg renombrado a ".$ruta."jpeg";
                            }else if(file_exists($ruta2.'png')){
                                rename($ruta2.'png',$ruta.'png');
                                $noExists = 1;
                                //echo "<br>***".$ruta2."png renombrado a ".$ruta."png";
                            }else if(file_exists($ruta2.'svg')){
                                rename($ruta2.'svg',$ruta.'svg');
                                $noExists = 1;
                                //echo "<br>***".$ruta2."svg renombrado a ".$ruta."svg";
                            }
                        }else{
                            //echo "<br>*** Existe principal.";
                            $i++;
                        }
                    }else{
                        $ruta = $path.'/'.$i.'.';
                        if(!file_exists($ruta.'jpg') && !file_exists($ruta.'png') && !file_exists($ruta.'jpeg') && !file_exists($ruta.'svg')) {
                            //echo "<br>*** No existe ".$ruta;
                            $noExists = 2;
                            $i++;
                            $ruta2 = $path . '/' . $i.'.';
                            if (file_exists($ruta2 . 'jpg')) {
                                rename($ruta2 . 'jpg', $ruta . 'jpg');
                                $noExists = 1;
                                //echo "<br>***".$ruta2."jpg renombrado a ".$ruta."jpg";
                            } else if (file_exists($ruta2 . 'jpeg')) {
                                rename($ruta2 . 'jpeg', $ruta . 'jpeg');
                                $noExists = 1;
                                //echo "<br>***".$ruta2."jpeg renombrado a ".$ruta."jpeg";
                            } else if (file_exists($ruta2 . 'png')) {
                                rename($ruta2 . 'png', $ruta . 'png');
                                $noExists = 1;
                                //echo "<br>***".$ruta2."png renombrado a ".$ruta."png";
                            } else if (file_exists($ruta2 . 'svg')) {
                                rename($ruta2 . 'svg', $ruta . 'svg');
                                $noExists = 1;
                                //echo "<br>***".$ruta2."svg renombrado a ".$ruta."svg";
                            }
                        }else{
                            //echo "<br>*** Existe ".$ruta;
                            $i++;
                        }
                    }

                    //echo "<br>*** Valor de noExists: ".$noExists." __ Valor de i: ".$i;
                }
                Session::flash("mensaje","La imagen se ha eliminado del sistema.");
                return '1';
            }else{
                return '-1';
            }
        }
    }

    public function postEditar(GuardarEventoRequest $request){
        if(AutenticacionAdminv::check()){
            DB::beginTransaction();
            $evento = Evento::find($request->input('evento'));
            $evento->eve_titulo = $request->input('titulo');
            $evento->eve_descripcion_corta = $request->input('descripcion_corta');
            $evento->eve_descripcion_detallada = $request->input('descripcion_detallada');
            $evento->eve_estado = $request->input('estado');
            $evento->save();
            $cantidad_imagenes = $request->input('cantidad_imagenes');
            $path = public_path() . '/imagenes/eventos/';

            $errorTamaño = false;
            $errorExtension = false;
            $errorArchivo = false;

            for($i = 0; $i < $cantidad_imagenes; $i++) {
                if($request->hasFile('imagen_'.($i+1))) {
                    $imagen = $request->all()['imagen_' . ($i + 1)];
                    if ($imagen->getClientOriginalExtension() == 'png' || $imagen->getClientOriginalExtension() == 'jpg' || $imagen->getClientOriginalExtension() == 'jpeg' || $imagen->getClientOriginalExtension() == 'svg') {
                        if ($imagen->getClientSize() > 7000000) {
                            $errorTamaño = true;
                            break;
                        }
                    } else {
                        $errorExtension = true;
                        break;
                    }
                }else{
                    $errorArchivo = true;
                    break;
                }
            }

            if(!$errorTamaño && !$errorArchivo && !$errorExtension){
                if(!is_dir($path . $evento->id))
                    mkdir($path . $evento->id);

                for($i = 0; $i < $cantidad_imagenes; $i++) {
                    $imagen = $request->all()['imagen_'.($i + 1)];
                    $name_principal = $path . $evento->id . "/principal.";
                    $name = "";
                    if(!file_exists($name_principal.'jpg') && !file_exists($name_principal.'jpeg') && !file_exists($name_principal.'png') && !file_exists($name_principal.'svg')){
                        $name = "principal." . $imagen->getClientOriginalExtension();
                    }else{
                        $existe = true;
                        $aux = 1;
                        while($existe){
                            $name_aux = $path . $evento->id . "/".$aux.".";
                            if(!file_exists($name_aux.'jpg') && !file_exists($name_aux.'jpeg') && !file_exists($name_aux.'png') && !file_exists($name_aux.'svg')){
                                $name = $aux.'.'.$imagen->getClientOriginalExtension();
                                $existe = false;
                            }
                            $aux++;
                        }
                    }
                    $ruta = $path . $evento->id . "/" . $name;
                    $tmp = $imagen->getPath() . "/" . $imagen->getFileName();
                    copy($tmp, $ruta);
                }
                DB::commit();
                Session::flash("mensaje","La el evento ha sido editado con exito.");
                return '1';
            }else{
                if($errorExtension){
                    return '-1';
                }else if($errorArchivo){
                    return '-2';
                } else if($errorTamaño){
                    return '-3';
                }
            }
        }
    }

    public function postViewFotos(Request $request){
        if(AutenticacionAdminv::check() && $request->ajax()){
            $evento = Evento::find($request->input('evento'));
            return view('modulos.eventos.fotos')->with('evento',$evento);
        }
    }
}