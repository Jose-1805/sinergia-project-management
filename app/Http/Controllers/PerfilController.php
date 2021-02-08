<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LineaInvestigacion;
use App\Models\Perfil;
use App\Models\PerfilLineasInvestigacion;
use App\Models\Persona;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Requests\ActionsHabilidadesRequest;
use App\Http\Requests\ActionsPerfilGeneralRequest;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getView($id)
	{
        $id = Crypt::decrypt($id);
        if (Session::has("idPersona")) {

            $persona = Persona::find($id);
            if ($persona) {
                $perfil = $persona->perfil;
                $rol = "";
                if (Session::get('rol actual') == "administrador investigativo")
                    $rol = "adminv";
                else if (Session::get('rol actual') == "investigador")
                    $rol = "inv";
                else if ((Session::get('rol actual') == "evaluador"))
                    $rol = "eval";

                return view("plantillas/perfil")->with("perfil", $perfil)->with("persona", $persona)->with("rol", $rol);
            }
        }
        return redirect("/");
	}


	public function getEdit($id)
	{
		$id = Crypt::decrypt($id);
        $persona = Persona::find($id);
        if($persona){
            $rol = "";
            if (Session::get('rol actual') == "administrador investigativo")
                $rol = "adminv";
            else if (Session::get('rol actual') == "investigador")
                $rol = "inv";
            else if ((Session::get('rol actual') == "evaluador"))
                $rol = "eval";
            return view('plantillas/perfilEdit')->with("persona",$persona)->with("rol",$rol);
        }
        return redirect()->back();
	}


    public function postActionsHabilidades(ActionsHabilidadesRequest  $request){
        $id = Crypt::decrypt($request->input('id'));
        $persona = Persona::find($id);
        $action = "editar";
        $lineas = $request->input('lineas_investigacion');
        $num_lineas = 0;

        /*if(is_array($lineas)) {
            for ($i = 0; $i < count($lineas); $i++) {
                $num_lineas++;
            }
        }

        if($num_lineas > 4){
            return response()->json(array("error"=>["Seleccione maximo 4 lineas de investigación"]));
        }*/

        if ($persona) {
            $perfil = $persona->perfil;
            if (!$perfil) {
                $perfil = new Perfil();
                $action = "guardar";
            }

            $perfil->persona_id = $persona->id;
            $perfil->per_cargo = $request->input('cargos');
            $perfil->per_perfil = $request->input('perfil');
            $perfil->per_habilidades = $request->input('habilidades');
            $perfil->save();

            $relaciones = $perfil->relacionLineas;
            foreach ($relaciones as $r) {
                $r->delete();
            }

            for($i = 0; $i < count($lineas); $i++){
                $id = Crypt::decrypt($lineas[$i]);
                $line = LineaInvestigacion::find($id);
                if($line){
                    $perfilLinea = new PerfilLineasInvestigacion;
                    $perfilLinea->linea_investigacion_id = $line->id;
                    $perfilLinea->perfil_id = $perfil->id;
                    $perfilLinea->save();
                }
            }


            if ($action == "editar") {
                Session::flash("msjPerfilCuenta", "La información ha sido editada con exito.");
            } else {
                Session::flash("msjPerfilCuenta", "La información ha sido almacenada con exito.");
            }

            return '1';
        }
    }

    public function postActionsGeneral(ActionsPerfilGeneralRequest $request){
        $id = Crypt::decrypt($request->input('id'));
        $persona = Persona::find($id);

        if($persona){
            DB::beginTransaction();
            if($request->has('nueva_contrasena')){
                if($request->input('nueva_contrasena') == $request->input('nueva_contrasena_verificacion')){
                    $cuenta = $persona->cuenta;
                    if($cuenta){
                        $cuenta->cue_password = md5($request->input('nueva_contrasena'));
                        $cuenta->save();
                    }
                }else{
                    return "-2";
                }
            }

            $persona->per_identificacion = $request->input('identificacion');
            $persona->per_nombres = $request->input('nombres');
            $persona->per_apellidos = $request->input('apellidos');
            $persona->per_correo = $request->input('correo');
            $persona->per_numero_celular = $request->input('celular');
            $persona->per_numero_telefono = $request->input('telefono');
            $persona->per_fecha_nacimiento = $request->input('fecha_nacimiento');
            $persona->per_genero = $request->input('genero');
            $persona->save();
            if($request->input('img') == '1'){
                $path = public_path().'/imagenes/perfil/'.$persona->id.'.jpg';
                if(file_exists($path)){
                    @unlink($path);
                }

                $path = public_path().'/imagenes/perfil/'.$persona->id.'.png';
                if(file_exists($path)){
                    @unlink($path);
                }
            }
            DB::commit();
            Session::flash("msjPerfilCuenta", "La información ha sido editada con exito.");
            return "1";
        }
    }

    public function postUploadImagen(Request $request){

        $id = Crypt::decrypt($request->input('id'));
        $persona = Persona::find($id);
        if($persona) {
            $imagen = $request->all()['archivo'];
            $path = public_path() . '/imagenes/perfil/' . $persona->id . '.'.$imagen->getClientOriginalExtension();
            if ($imagen->getClientOriginalExtension() == 'png' || $imagen->getClientOriginalExtension() == 'jpg') {
                if($imagen->getClientSize() <= 4000000) {
                    $ruta = public_path() . '/imagenes/perfil/' . $persona->id . '.jpg';
                    @unlink($ruta);
                    $ruta = public_path() . '/imagenes/perfil/' . $persona->id . '.png';
                    @unlink($ruta);
                    $tmp = $imagen->getPath() . "/" . $imagen->getFileName();
                    copy($tmp, $path);
                    return '1';
                }else{
                    return '-2';
                }
            }else{
                return '-1';
            }
        }
    }
}
