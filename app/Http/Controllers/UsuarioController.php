<?php
namespace App\Http\Controllers;

use App\Http\Middleware\AutenticacionAdminv;
use App\Http\Middleware\AutenticacionEval;
use App\Http\Middleware\AutenticacionInv;
use App\Models\Cuenta;
use App\Models\Notificacion;
use App\Models\PersonaNotificacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Session;
use \App\Models\Persona;
use App\Models\Sistema;

class UsuarioController extends Controller {
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
        //$this->middleware("autNoti",["only"=>["notificaciones"]]);
    }

    public function login(Request $request) {

        $persona = Persona::firstOrNew(['per_correo' => $request->input('txtLogin')]);
        if ($persona->per_nombres == null) {
            $persona = Persona::firstOrNew(['per_identificacion' => $request->input('txtLogin')]);
        }        

        if ($persona->per_nombres != null) {
            $roles = $persona->validar($request->input('txtPassword'));
            if ($roles) {
                Session::flush();
                foreach ($roles as $rol) {
                    Session::put($rol, "activo");
                }
                Session::put('idPersona', $persona->id);
                Session::put('nombres', $persona->per_nombres);
                Session::put('apellidos', $persona->per_apellidos);
                if (Session::has('administrador investigativo')) {
                    return '1';
                } else if (Session::has('investigador')) {
                    return '2';
                } else if (Session::has('evaluador')) {
                    return '3';
                }
            } else {
                return '4';
            }
        }
        return '5';
    }

    public function restaurarContrasena(Request $request){
        $persona = Persona::where("per_identificacion",$request->get("usuario"))
                            ->orWhere("per_correo",$request->get("usuario"))->first();
        if($persona){
            $cuenta = $persona->cuenta;
            if($cuenta){
                if($cuenta->cue_password_restaurar != ''){
                    return '-3';
                }
                $datos = Cuenta::generarPassword();
                $cuenta->cue_password_restaurar = $datos["passEncript"];
                $cuenta->save();

                $mensaje = "El grupo de investigación SINERGIA le informa que su solicitud de restauración de contraseña ha sido atendida, si usted no ha realizado esta solicitud, puede hacer caso omiso a este mensaje y continuar utilizando nuestro sistema como lo ha hecho siempre."
                    . "<br> Para restaurar su contraseña debe ingresar al sistema como lo hace habitualmente pero con la contraseña que le daremos a continuación, en caso de que recuerde su contraseña antigua, puede utilizarla normalmente siempre y cuando no haya utilizado la asignada en este correo."
                    . "<br><br>Contraseña asignada: ".$datos['pass']
                    . "<br><br>Recuerde que usted puede personalizar su contraseña en nuestro sistema <a href='".url('/')."'>SINERGIA</a>, iNgresando al menú flotante que aparece dando click en su nombre (parte superior derecha) y seleccionando la opción <strong>Configurar cuenta</strong>";

                Sistema::enviarMail($persona, $mensaje, "Solicitud restaurar contraseña", "Restauración de contraseña");
                return '1';
            }else{
                return '-2';
            }
        }else{
            return '-1';
        }
    }
    
    public function validarCorreoInvestigador($correo,Request $request) {
        if($request->ajax()){
        $persona = Persona::firstOrNew(['per_correo' => $correo]);
        return $persona->estadoCorreoInvestigador();
        }else{
            return redirect("/");
        }
    }

    /**
     * valida si el passwor que recibe como parametro corresponde al correo especificado como
     * segundo parametro
     * 
     * @param type $password
     * @param type $correo
     * @return string
     * 1 -> si el password es correcto
     * 2 -> si el password no es correcto
     */
    public function validarPassword($password, $correo) {
        $resultado = Persona::join('cuenta', 'persona.id', '=', 'cuenta.persona_id')
                ->where('persona.per_correo', $correo)
                ->where('cuenta.cue_password', md5($password))
                ->get();
        if (count($resultado) > 0) {
            return '1';
        } else {
            return '2';
        }
    }

    public static function registrarNotificacion($descripcion,$url,$destinatarios){
            if(is_array($destinatarios)) {
                $notificacion = new Notificacion();
                $notificacion->not_url = $url;
                $notificacion->not_descripcion = $descripcion;
                if(Session::has("idPersona"))
                $notificacion->persona_id = Session::get("idPersona");

                $notificacion->save();

                for ($i = 0; $i < count($destinatarios); $i++) {
                    $personaNotificacion = new PersonaNotificacion();
                    $personaNotificacion->notificacion_id = $notificacion->id;
                    $personaNotificacion->persona_id = $destinatarios[$i];
                    $personaNotificacion->per_not_estado = "enviado";
                    $personaNotificacion->save();
                }
                return true;
        }
        return false;
    }

    public function notificaciones(Request $request)
    {

        /*header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        echo "data: ".$_SERVER['HTTP_ACCEPT']." \n\n";
        flush();*/
       if($_SERVER['HTTP_ACCEPT'] == "text/event-stream"){
            if(Session::has("idPersona")) {
                $resultado = Notificacion::join("persona_notificacion","notificacion.id","=","persona_notificacion.notificacion_id")
                    ->where("persona_notificacion.persona_id",Session::get("idPersona"))
                    ->orderBy("notificacion.created_at","DESC")->skip(0)->take(5)->get();
                if(count($resultado)) {
                    return view("plantillas.notificaciones")->with("notificaciones", $resultado);
                }else{
                    header('Content-Type: text/event-stream');
                    header('Cache-Control: no-cache');
                    echo "data: <p>No hay notificaciones</p>  \n\n";
                    flush();
                    return false;
                }
            }
        }

        return redirect('/');
    }

    public function notificacionesNuevas(){
        if(Session::has("idPersona")) {
            $resultado = Notificacion::join("persona_notificacion","notificacion.id","=","persona_notificacion.notificacion_id")
                ->where("persona_notificacion.persona_id",Session::get("idPersona"))
                ->where("persona_notificacion.per_not_estado","enviado")->get();
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            echo "data: ".count($resultado)."\n\n";
            flush();
        }
        return redirect('/');
    }

    public function notificacionesRevisadasOk(){
        if(Session::has("idPersona")) {
            $resultado = PersonaNotificacion::where("persona_id",Session::get("idPersona"))
                ->where("per_not_estado","enviado")->get();

            if(count($resultado)){
                foreach($resultado as $notificacion){
                    $notificacion->per_not_estado = "revisado";
                    $notificacion->save();
                }
            }
        }
        return redirect('/');
    }

    public function masNotificaciones($index){
        if(Session::has("idPersona")) {
            $resultado = Notificacion::join("persona_notificacion","notificacion.id","=","persona_notificacion.notificacion_id")
                ->where("persona_notificacion.persona_id",Session::get("idPersona"))
                ->orderBy("notificacion.created_at","DESC")->skip($index)->take(5)->get();

            $datos = "";
            if(count($resultado)){
                foreach ($resultado as $notificacion)
                {
                    $ruta = "#";
                    if($notificacion->not_url != ""){
                        $ruta = $notificacion->not_url;
                    }
                    $datos .= "<a class='".$notificacion->per_not_estado." notificacion' href='".$ruta."'>".$notificacion->not_descripcion."<i>".date("Y-m-d",strtotime($notificacion->created_at))."</i></a>";
                }
                return $datos;
            }else{
                return "no-notificaciones";
            }
        }
    }

}
