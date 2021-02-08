<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AutenticacionAdminv;
use App\Http\Middleware\AutenticacionEval;
use App\Http\Middleware\AutenticacionInv;
use App\Http\Requests\actionsActividadRequest;
use App\Http\Requests\FormularInfoGeneralRequest;
use App\Models\Actividad;
use App\Models\Componente;
use App\Models\ComponenteRubro;
use App\Models\Convocatoria;
use App\Models\Entidad;
use App\Models\LineaInvestigacion;
use App\Models\Pdf\Pdf;
use App\Models\Pdf\ReporteGrafico;
use App\Models\Pdf\ReporteInformacion;
use App\Models\Producto;
use App\Models\ProyectoEntidad;
use App\Models\ProyectoLinea;
use App\Models\RespuestaSugerencia;
use App\Models\Rubro;
use App\Models\Sistema;
use BarPlot;
use Graph;
use GroupBarPlot;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use \App\Models\Proyecto;
use \App\Models\Persona;
use App\Models\ProyectoInvestigativo;
use App\Models\ProyectoInvestigativoEvaluador;
use App\Models\Evaluador;
use App\Models\Investigador;
use App\Models\ProyectoInvestigador;
use App\Models\HistorialEstado;
use \Illuminate\Support\Facades\Mail;
use App\Http\Requests\NuevoPerfilRequest;
use App\Http\Requests\EditarPerfilRequest;
use Illuminate\Http\Request;
use App\Models\Sugerencia;
use Illuminate\Support\Facades\Storage;
use PhpSpec\Exception\Exception;
use App\Http\Requests\RelacionEntidadRequest;
use App\Http\Requests\NuevoInvestigadorRelacion;
use UniversalTheme;

class ProyectoController extends Controller
{

    function __construct()
    {
        //establecer un middleware que acepte cuando se halla iniciado sesion
        //$this->middleware("autRol", ["except" => "validarTitulo"]);
        //$this->middleware("autEval",["only"=>["getEvaluar"]]);
        //$this->middleware("autAdminv",["only"=>["getEvaluar"]]);
    }

    public function getPerfil($id)
    {
        if (Session::has("idPersona")) {
            $rol = "";
            if (Session::get('rol actual') == "administrador investigativo")
                $rol = "adminv";
            else if (Session::get('rol actual') == "investigador")
                $rol = "inv";
            else if ((Session::get('rol actual') == "evaluador"))
                $rol = "eval";

            $id = Crypt::decrypt($id);
            $perfil = Proyecto::find($id);
            $convocatorias = Convocatoria::where("con_estado", "abierta")->get();
            if ($perfil && $perfil->permisoVisualizar()) {
                return view("plantillas/perfiles/informacion")->with("perfil", $perfil)->with("rol", $rol)->with("convocatorias", $convocatorias);
            }
        }
        return redirect("/");
    }

    public function getEvaluar($idProyecto)
    {
        if (!AutenticacionEval::check() && !AutenticacionAdminv::check()) {
            return redirect("/");
        }

        if (Session::get('rol actual') == 'evaluador') {
            $rol = 'eval';
        } else if (Session::get('rol actual') == 'administrador investigativo') {
            $rol = 'adminv';
        }
        $idProyecto = Crypt::decrypt($idProyecto);
        $proyecto = Proyecto::find($idProyecto);
        if ($proyecto) {
            if ($proyecto->pro_estado == "proyecto en desarrollo") {
                return view("roles/" . $rol . "/index")->with("temp", "proyectos/seguimiento")->with("proyecto", $proyecto);
            }
        }
        return redirect("/");
    }

    // <editor-fold defaultstate="collapsed" desc="Validacion del titulo de un proyecto">
    /**
     * comprueba si existe un proyecto que tenga el titulo igual al que se recibe como parametro
     *
     * @param type $titulo
     * @return int
     * 1 -> si existe un proyecto con el titulo
     * 2 -> de lo contrario
     */
    public function validarTitulo($titulo, Request $request)
    {
        if ($request->ajax()) {
            if (Proyecto::validarTitulo($titulo)) {
                return 1;
            }
            return 2;
        } else {
            return redirect("/");
        }
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Registro de un perfil">
    /**
     * Registra si es posible la información de un nuevo perfil junto al proponente si aun no esta registrado
     *
     * @param Request $request
     */
    public function registrarPerfil(NuevoPerfilRequest $request)
    {
        $nuevoProponente = true;

        //datos de la persona
        $persona = Persona::firstOrNew(['per_correo' => $request->input('correo')]);
        $persona->per_nombres = $request->input('nombres');
        $persona->per_Apellidos = $request->input('apellidos');

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

        $persCorreo = Persona::where('per_correo', $persona->per_correo)->get();
        if ($persona->investigador) {
            $nuevoProponente = false;
        }

        //existe una persona con el mismo correo
        if (count($persCorreo) > 0) {
            $cuenta = $persona->cuenta;
            if ($cuenta) {
                $passwordValido = $persona->cuenta()->where('cuenta.cue_password', md5($request->input('password')))->get();

                //password incorrecto
                if (isset($passwordValido) && count($passwordValido) < 1) {
                    return 1;
                } else {
                    $cuenta = $persona->cuenta;
                    $rolInvestigador = $cuenta->tiposCuenta()->where('cuentatipocuenta.cue_tip_estado', 'activo')->where('tipocuenta.tip_cue_nombre', 'investigador');

                    //no tiene cuenta de investigador
                    if ($rolInvestigador == null) {
                        return 2;
                    } else {
                        $nuevoProponente = false;
                    }
                }
            }
        }


        DB::beginTransaction();

        //se registra toda la información en la base de datos
        $investigador = new Investigador;
        $idInvestigador = 0;
        if ($nuevoProponente) {
            $persona->save();
            $investigador->persona_id = $persona->id;
            $investigador->inv_tipo = 'proponente';
            $investigador->save();
            $idInvestigador = $investigador->id;
        } else {
            $investigador = Investigador::firstOrNew(['investigador.persona_id' => $persona->id]);
        }

        $perfil->save();
        $proyectoInvestigativo->proyecto_id = $perfil->id;
        $proyectoInvestigativo->investigador_id = $investigador->id;
        $proyectoInvestigativo->save();
        $proyectoInvestigador = new ProyectoInvestigador;
        $proyectoInvestigador->proyectoinvestigativo_id = $proyectoInvestigativo->id;
        $proyectoInvestigador->investigador_id = $investigador->id;
        $proyectoInvestigador->save();
        $nombreCopleto = $persona->per_nombres . ' ' . $persona->per_apellidos;
        $mensaje = "Su perfil de proyecto ha sido almacenado en nuestro sistema Aplicativo de Gestión de Proyectos, y será "
            ."revisado por el(la) evaluador(a), quien definirá si debe mejorarse, se rechaza o se avala para continuar "
            ."la fase de formulación; dicho concepto se enviará a la cuenta de correo electrónico por usted registrada.<br>"
            . "El código del perfil de proyecto es:<br>"
            . "CODIGO: " . $codigo . "<br>"
            . "Este código debe conservarse, le será requerido para editar la información de su perfil.";
        $data = array('nombre' => $persona->per_nombres, 'mensaje' => $mensaje, 'titulo' => 'Registro perfil');
        Session::put('nombreDestinatario', $nombreCopleto);
        Session::put('correoDestinatario', $persona->per_correo);
//dd($data, session('correoDestinatario'), session('nombreDestinatario'));

//if(mail(session('correoDestinatario'), 'Mi título', $mensaje)){ }
        Mail::send('emails.principal', $data, function ($message) {
            $message->to(session('correoDestinatario'), session('nombreDestinatario'))->subject('Registro perfil SINERGIA');
            Session::forget('nombreDestinatario');
            Session::forget('correoDestinatario');
        });

        $administradores = Sistema::administradores();
        $ids = [];

        foreach($administradores as $admin){
            $ids[] = $admin->id;
        }

        $ruta = asset("/proyecto/perfil/".Crypt::encrypt($perfil->id));
        $mensaje = "Un nuevo perfil de proyecto ha sido registrado en el sistema.";

        UsuarioController::registrarNotificacion($mensaje,$ruta,$ids);
//_____________________________________________
// $para = session('correoDestinatario');
//        $nom = session('nombreDestinatario');
        //      Mail::send('emails.principal', $data, function ($message) use ($para ,$nom) {
        //        $message->to($para, $nom)->subject('Registro perfil SINERGIA');
        //      Session::forget('nombreDestinatario');
        //    Session::forget('correoDestinatario');
        //    });
//    Mail::send('emails.principal', ['key' => 'value'], function($message)
//{
//    $message->to('cachapid@misena.edu.co', 'John Smith')->subject('Welcome!');
//});
//______________________________________________
        DB::commit();

        return 5;
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Aprobar un perfil">
    /**
     * Cambia el estado de un perfil a propuesta aprobada
     *
     *
     * @param type $idPerfil -> id encriptado del perfil
     *
     * @return 1 -> si se cambia el estado con exito
     *         2 -> si no es posible cambiar el estado del proyecto
     */
    public function postAprobarPerfil(Request $request)
    {
        if ((Session::has('administrador investigativo') && Session::get('administrador investigativo') == 'activo') || (Session::has('evaluador') && Session::get('evaluador') == 'activo')) {
            $idPerfil = Crypt::decrypt($request->input("perfil"));
            $correo = $request->input("enviarCorreo");
            $persona = new Persona();

            $perfil = Proyecto::find($idPerfil);

            if ($perfil) {
                $response = $perfil->cambiarEstado(Persona::find(Session::get('idPersona')), "propuesta aprobada");
                if ($response == 1) {
                    $investigador = $perfil->proyectoInvestigativo->investigadorLider;
                    $invPersona = $investigador->persona;
                    $persona = $invPersona;
                    $paswword = '';
                    $prop = false;
                    if ($investigador->inv_tipo == "proponente") {
                        $correo = 2;
                        $password = $invPersona->nuevaCuenta('investigador');
                        $investigador->inv_tipo = "investigador";
                        $prop = true;
                        $investigador->save();
                    }
                    if ($correo == 2) {

                        $mensaje = "Revisada la información su perfil (" . $perfil->pro_titulo . "), se ha determinado el cambio de estado a <strong>'EN FORMULACIÓN'</strong>. Se habilitará la plataforma de formulación del proyecto."
                            . "<br>Ingrese a la <a href='".url("/")."'>plataforma de Gestión de proyectos</a>, <br>el usuario es su cuenta de correo o su documento de identificación";
                        if ($prop) {
                            if ($password) {
                                $mensaje .= "<br>la contraseña de ingreso es: " . $password;
                            }
                        }
                        $mensaje .= "<br><br>Una vez ingrese a la plataforma de gestión de proyectos, diríjase al menú <strong>'PERFILES'</strong>  opción <strong>EN FORMULACION</strong>, se habilitarán campos nuevos con información en metodología de Marco Lógico.";

                        Sistema::enviarMail($invPersona, $mensaje, "Cambio de estado", "Cambio de estado perfil");
                    }

                    $mensaje = "Estado de perfil ".$perfil->pro_titulo." cambiado a 'EN FORMULACION'";
                    $url = asset("/proyecto/perfil/".Crypt::encrypt($perfil->id));
                    UsuarioController::registrarNotificacion($mensaje,$url,array($persona->id));
                    return 1;//el estado del proyecto fue cambiado
                }
                return $response;//-1 no se ha encontrado informacion del proponente lider
                //-2 no tiene permisos para cambiar el estado
            }
            return 2;
        }
        return redirect('/');
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="perfil aprobado completo">
    /**
     * Cambia el estado de un perfil a propuesta aprobada completa
     *
     *
     * @param type $idPerfil -> id encriptado del perfil
     *
     * @return 1 -> si se cambia el estado con exito
     *         2 -> si no es posible cambiar el estado del proyecto
     */
    public function postPerfilCompleto(Request $request)
    {

        if ((Session::has('administrador investigativo') && Session::get('administrador investigativo') == 'activo') || (Session::has('evaluador') && Session::get('evaluador') == 'activo')) {
            $idPerfil = Crypt::decrypt($request->input("perfil"));
            $correo = $request->input("enviarCorreo");

            $perfil = Proyecto::find($idPerfil);

            if ($perfil) {
                $response = $perfil->cambiarEstado(Persona::find(Session::get('idPersona')), "propuesta aprobada completa");
                if ($response == 1) {
                    $investigador = $perfil->proyectoInvestigativo->investigadorLider;
                    $invPersona = $investigador->persona;
                    if ($correo == 2) {
                        $mensaje = "El estado de su perfil (" . $perfil->pro_titulo . "), ha cambiado a <strong>'FORMULADO'</strong>."
                            . "<br>El siguiente paso es esperar que su perfil sea marcado como aprobado o enviado a una convocatoria, toda esta información"
                             ." será notificada a usted por medio del sistema SINERGIA o via email si el encargado lo desea.";

                        Sistema::enviarMail($invPersona, $mensaje, "Cambio de estado", "Cambio de estado perfil");
                    }

                    $mensaje = "Estado de perfil ".$perfil->pro_titulo." cambiado a 'FORMULADO'";
                    $url = asset("/proyecto/perfil/".Crypt::encrypt($perfil->id));
                    UsuarioController::registrarNotificacion($mensaje,$url,array($investigador->persona->id));
                    return 1;//el estado del proyecto fue cambiado
                }
                return $response;//-1 no se ha encontrado informacion del proponente lider
                //-2 no tiene permisos para cambiar el estado
            }
            return 2;
        }
        return redirect('/');
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Descartar un perfil">
    /**
     * Cambia el estado de un perfil a propuesta descartada
     *
     *
     * @param type $idPerfil -> id encriptado del perfil
     *
     * @return 1 -> si se cambia el estado con exito
     *         2 -> si no es posible cambiar el estado del proyecto
     */
    public function postDescartarPerfil(Request $request)
    {
        if ((Session::has('administrador investigativo') && Session::get('administrador investigativo') == 'activo') || (Session::has('evaluador') && Session::get('evaluador') == 'activo')) {

            $idPerfil = Crypt::decrypt($request->input("perfil"));
            $correo = $request->input("enviarCorreo");


            $perfil = Proyecto::find($idPerfil);

            $persona = new Persona();
            if ($perfil) {
                $estado = "proyecto descartado";
                if(($perfil->pro_estado == "propuesta") || ($perfil->pro_estado == "propuesta aprobada") || ($perfil->pro_estado == "propuesta aprobada completa")){
                    $estado = "propuesta descartada";
                }
                $response = $perfil->cambiarEstado(Persona::find(Session::get('idPersona')), $estado);
                if ($response == 1) {
                    $investigador = $perfil->proyectoInvestigativo->investigadorLider;
                    $invPersona = $investigador->persona;
                    $persona = $invPersona;
                    if (($correo == 2) || ($investigador->inv_tipo == 'proponente')) {
                        $mensaje = "revisada la información su perfil (" . $perfil->pro_titulo . "), se ha determinado el cambio de estado a <strong>DESCARTADO</strong>."
                            . "<br>Igualmente le recordamos que aún puede registrar más ideas en nuestro sistema";
                        Sistema::enviarMail($invPersona, $mensaje, "Cambio de estado perfil", "Cambio de estado");
                    }

                    $mensaje = "Estado de perfil ".$perfil->pro_titulo." cambiado a '".$estado."'";
                    $url = asset("/proyecto/perfil/".Crypt::encrypt($perfil->id));

                    $investigadores =  $personas = Persona::select("persona.*")
                        ->join("investigador","persona.id","=","investigador.persona_id")
                        ->join("proyectoinvestigador","investigador.id","=","proyectoinvestigador.investigador_id")
                        ->join("proyectoinvestigativo","proyectoinvestigador.proyectoinvestigativo_id","=","proyectoinvestigativo.id")
                        ->join("proyecto","proyectoinvestigativo.proyecto_id","=","proyecto.id")
                        ->where("proyecto.id",$perfil->id)
                        ->where(function($q){
                            $q->whereNull("proyectoinvestigador.pro_inv_estado_solicitud")
                                ->orWhere("proyectoinvestigador.pro_inv_estado_solicitud","aprobado");
                        })->get();

                    $ids = [];

                    foreach($investigadores as $inv){
                        $ids[] = $inv->id;
                    }
                    UsuarioController::registrarNotificacion($mensaje,$url,$ids);
                    return 1;
                }
                return $response;
            }
        }
        return 2;

        return redirect('/');
    }

//</editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Enviar a aconvocatoria">
    /**
     * Cambia el estado de un perfil a proyecto en convocatoria
     *
     *
     * @param type $idPerfil -> id encriptado del perfil
     *
     * @return 1 -> si se cambia el estado con exito
     *         2 -> si no es posible cambiar el estado del proyecto
     */
    public function postEnviarAConvocatoria(Request $request)
    {
        if (Session::has('administrador investigativo') && Session::get('administrador investigativo') == 'activo') {
            $idPerfil = Crypt::decrypt($request->input("perfil"));
            $idConvocatoria = Crypt::decrypt($request->input("convocatoria"));


            $perfil = Proyecto::find($idPerfil);
            $convocatoria = Convocatoria::find($idConvocatoria);
            if ($perfil && $convocatoria) {
                $response = $perfil->cambiarEstado(Persona::find(Session::get('idPersona')), "proyecto en convocatoria");
                if ($response == 1) {
                    $proyectoInvestigativo = $perfil->proyectoInvestigativo;
                    $proyectoInvestigativo->convocatoria_id = $convocatoria->id;
                    $proyectoInvestigativo->save();
                    $investigador = $perfil->proyectoInvestigativo->investigadorLider;
                    $invPersona = $investigador->persona;

                    $mensaje = "El grupo de investigación SINERGIA le informa que su perfil (" . $perfil->pro_titulo . ") ha sido enviado como un proyecto a la convocatoria " .$convocatoria->con_nombre." - ". $convocatoria->con_numero . " de " . strtoupper($convocatoria->con_compania) . ". "
                        . "Una vez se dé a conocer el resultado de la convocatoria le informaremos los pasos a seguir.";

                    Sistema::enviarMail($invPersona, $mensaje, "Proyecto en convocatoria", "Proyecto en convocatoria");

                    $mensaje = "Estado de perfil ".$perfil->pro_titulo." cambiado a 'proyecto en convocatoria'. Convocatoria " . $convocatoria->con_numero . " de " . strtoupper($convocatoria->con_compania) . ". ";
                    $url = asset("/proyecto/perfil/".Crypt::encrypt($perfil->id));
                    UsuarioController::registrarNotificacion($mensaje,$url,array($invPersona->id));
                }
                return $response;//-1 no se ha encontrado informacion del proponente lider
                //-2 no tiene permisos para cambiar el estado
            }
            return 2;
        }
        return -2;
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Aprobar un perfil">
    /**
     * Cambia el estado de un perfil a propuesta aprobada
     *
     *
     * @param type $idPerfil -> id encriptado del perfil
     *
     * @return 1 -> si se cambia el estado con exito
     *         2 -> si no es posible cambiar el estado del proyecto
     */
    public function postAprobarProyecto(Request $request)
    {
        if (Session::has('administrador investigativo') && Session::get('administrador investigativo') == 'activo') {
            $idPerfil = Crypt::decrypt($request->input("perfil"));
            $correo = $request->input("correo");

            $perfil = Proyecto::find($idPerfil);

            if ($perfil) {
                $response = $perfil->cambiarEstado(Persona::find(Session::get('idPersona')), "proyecto aprobado");
                if ($response == 1) {
                    $investigador = $perfil->proyectoInvestigativo->investigadorLider;
                    $invPersona = $investigador->persona;

                    $mensaje = "Estado de perfil ".$perfil->pro_titulo." cambiado a 'proyecto aprobado'";
                    $url = asset("/proyecto/perfil/".Crypt::encrypt($perfil->id));
                    UsuarioController::registrarNotificacion($mensaje,$url,array($invPersona->id));

                    if ($correo == 2) {

                        $mensaje = "El grupo de investigación SINERGIA le informa que su proyecto (" . $perfil->pro_titulo . ") ha sido aprobado en la convocatoria en la cual participo."
                            . " El siguiente paso es registrar o relacionar su proyecto con las entidades promotoras, los investigadores que colaborarán en el proyecto y "
                            ."asignar las tareas correspondientes a los mismos. Una vez el evaluador asignado o el administrador del sistema establezca una fecha de inicio a su proyecto,"
                            ." usted y su grupo de desarrollo tendrán que esperar dicha fecha para realizar las tareas registradas en el proyecto.";

                        Sistema::enviarMail($invPersona, $mensaje, "Proyecto aprobado", "Proyecto aprobado en convocatoria");
                    }
                }//1 el estado del proyecto se cambio
                return $response;//-1 no se ha encontrado informacion del proponente lider
                //-2 no tiene permisos para cambiar el estado
            }
            return 2;
        }
        return -2;
    }

    // </editor-fold>

//<editor-fold defaultstate="collapsed" desc="Asignar un perfil a un evaluador">
    /**
     * asigna un evaluador a un perfil (estado = propuesta)
     *
     * @param Request $request
     * @return
     */
    public function postAsignarPerfil(Request $request)
    {
        if ((Session::has('administrador investigativo') && Session::get('administrador investigativo') == 'activo')) {

            $idEvaluadores = $request->input('evaluadores');
            $ids = [];
            //un evaluador seleccionado
            if (!empty($idEvaluadores)) {
                $idPerfil = Crypt::decrypt($request->input('txtIdPerfil'));
                $proyecto = Proyecto::find($idPerfil);

                if ($proyecto != null) {
                    $response = "1";
                    DB::beginTransaction();
                    foreach ($idEvaluadores as $id) {
                        $idEvaluador = Crypt::decrypt($id);
                        $evaluador = Evaluador::find($idEvaluador);

                        if ($evaluador != null) {
                            //si es una propuesta se borra el evaluador anterior si existe
                            if ($proyecto->pro_estado == "propuesta" || $proyecto->pro_estado == "proyecto aprobado") {
                                $proInvEvalAnterior = ProyectoInvestigativoEvaluador::where(function ($q) {
                                    $q->where("pro_eva_estado_evaluar", "propuesta")
                                        ->orWhere("pro_eva_estado_evaluar", "proyecto aprobado");
                                })->where("proyectoinvestigativo_id", $proyecto->proyectoinvestigativo->id)->first();
                                if ($proInvEvalAnterior) {
                                    $proInvEvalAnterior->delete();
                                }
                            }


                            $proInvEval = new ProyectoInvestigativoEvaluador;
                            $proInvEval->proyectoinvestigativo_id = $proyecto->proyectoinvestigativo->id;
                            $proInvEval->evaluador_id = $evaluador->id;
                            $proInvEval->pro_eva_estado_evaluar = $proyecto->pro_estado;
                            $proInvEval->save();
                            $ids[] = $evaluador->persona->id;
                            //si es propuesta solo se admite un solo evaluador
                            if ($proyecto->pro_estado == "propuesta" || $proyecto->pro_estado == "proyecto aprobado") {
                                break;
                            }
                        } else {
                            $response = 2;
                            break;
                        }
                    }

                    if ($response == 1) {
                        if ($request->input('checkInformarViaCorreo')) {
                            $persona = $evaluador->persona;
                            $mensaje = "El grupo de investigación SINERGIA le informa que el perfil (" . $proyecto->pro_titulo . ") ha sido asignado a su rol de evaluador";
                            $emails = [];
                            foreach ($idEvaluadores as $idEval) {
                                $eval = Evaluador::find(Crypt::decrypt($idEval));
                                $emails[] = $eval->persona->per_correo;
                            }
                            $data = array('nombre' => "Evaluador SINERGIA", 'mensaje' => $mensaje, 'titulo' => 'Perfil asignado');

                            Mail::Send('emails.principal', $data, function ($msj) use ($emails) {
                                $msj->to($emails)->subject('Nuevo perfil asignado');
                            });
                        }

                        $definicion = "proyecto";
                        if ($proyecto->pro_estado == "propuesta") {
                            $definicion = "perfil";
                        }
                        $mensaje = "Un nuevo ".$definicion." en estado '".$proyecto->pro_estado."' ha sido asignado. (".$proyecto->pro_titulo.")";
                        $url = asset("/proyecto/perfil/".Crypt::encrypt($proyecto->id));
                        UsuarioController::registrarNotificacion($mensaje,$url,$ids);
                        DB::commit();
                    }
                    return $response;
                }

            }
            return '2';
        }
        return redirect("/");
    }

//</editor-fold>

    public function postBuscarPerfilCodigo(Request $request)
    {
        $codigo = $request->input("codigo");
        $perfiles = Proyecto::where("pro_estado", "propuesta")->get();
        $perfil = null;
        foreach ($perfiles as $p) {
            if ($codigo == Crypt::decrypt($p->pro_codigo)) {
                $perfil = $p;
            }
        }
        if ($perfil) {
            return view("plantillas.perfiles.formEditarPerfil")->with("perfil", $perfil);
        }
        return '-1';
    }

//<editor-fold defaultstate="collapsed" desc="Edicion de un perfil">
    public function postEditarPerfil(EditarPerfilRequest $request)
    {
        $perfiles = Proyecto::all();
        $perfil = null;
        foreach ($perfiles as $p) {
            if (md5($p->id) == $request->input("id")) {
                $perfil = $p;
                break;
            }
        }

        if ($perfil != null) {
            $perfil->pro_justificacion = $request->input('justificacion');
            $perfil->pro_objetivo_general = $request->input('objetivoGeneral');
            $perfil->pro_presupuesto_estimado = $request->input('presupuesto');
            $perfil->proyectoInvestigativo->pro_inv_sector = $request->input('sector');
            $perfil->proyectoInvestigativo->pro_inv_problema = $request->input('problema');

            $perfil->proyectoInvestigativo->save();
            $perfil->save();
            return 1;
        }
        return 2;
    }

//</editor-fold

//<editor-fold desc="Registrar una sugerencia a un perfil" defaultstate="collapsed">
    public function postRegistrarSugerenciaPerfil(Request $request)
    {
        $elemento = '';
        $idElemento = '';
        if ($request->has('producto')) {
            $elemento = 'producto';
            $idElemento = Crypt::decrypt($request->input('producto'));
            $producto = Producto::find($idElemento);
            if ($producto && $producto->pro_estado == "delete") {
                return 3;
            }
        } else {
            if ($request->has('rubro')) {
                $elemento = 'rubro';
                $idElemento = Crypt::decrypt($request->input('rubro'));
                $rubro = Rubro::find($idElemento);
                if ($rubro && $rubro->pro_estado == "delete") {
                    return 3;
                }
            } else {
                if ($request->has('actividad')) {
                    $elemento = 'actividad';
                    $idElemento = Crypt::decrypt($request->input('actividad'));
                    $actividad = Actividad::find($idElemento);
                    if ($actividad && $actividad->pro_estado == "delete") {
                        return 3;
                    }
                } else {
                    if ($request->has('componente')) {
                        $elemento = 'componente';
                        $idElemento = Crypt::decrypt($request->input('componente'));
                        $componente = Componente::find($idElemento);
                        if ($componente && $componente->pro_estado == "delete") {
                            return 3;
                        }
                    }
                }
            }
        }
        $idPerfil = Crypt::decrypt($request->input("idPerfil"));
        $sugerencia = $request->input("sugerencia");
        $correo = $request->input("enviarCorreo");

        $perfil = Proyecto::find($idPerfil);

        $objSugerencia = new Sugerencia;
        if ($perfil) {
            DB::beginTransaction();
            $objSugerencia->sug_descripcion = $request->input('sugerencia');
            $objSugerencia->sug_importancia = $request->input('importancia');
            $objSugerencia->sug_estado = "por revisar";
            $objSugerencia->persona_id = Session::get('idPersona');
            $objSugerencia->proyecto_id = $perfil->id;
            $objSugerencia->proyecto_estado = $perfil->pro_estado;
            if ($elemento == '') {
                $elemento = 'general';
            }
            $objSugerencia->sug_elemento_nombre = $elemento;
            $objSugerencia->sug_elemento_id = $idElemento;
            $objSugerencia->save();

            //se consulta la información del proponente
            $proponente = $perfil->proyectoInvestigativo->investigadorLider->persona;


            if (($correo == 'on') || ($proponente->investigador->inv_tipo == "proponente")) {
                $nombreCompleto = $proponente->per_nombre . ' ' . $proponente->per_apellidos;
                $mensaje = "Ha recibido una nueva sugerencia para su perfil <strong>{{$perfil->pro_titulo}}</strong>. <br><br>" . $sugerencia;
                $data = array('nombre' => $proponente->per_nombres, 'mensaje' => $mensaje, 'titulo' => 'Sugerencia perfil');
                Session::put('nombreDestinatario', $nombreCompleto);
                Session::put('correoDestinatario', $proponente->per_correo);
                Mail::send('emails.principal', $data, function ($message) {
                    $message->to(session('correoDestinatario'), session('nombreDestinatario'))->subject('Sugerencia perfil');
                    Session::forget('nombreDestinatario');
                    Session::forget('correoDestinatario');
                });
            }

            $personas = Persona::select("persona.*")
                ->join("investigador","persona.id","=","investigador.persona_id")
                ->join("proyectoinvestigador","investigador.id","=","proyectoinvestigador.investigador_id")
                ->join("proyectoinvestigativo","proyectoinvestigador.proyectoinvestigativo_id","=","proyectoinvestigativo.id")
                ->join("proyecto","proyectoinvestigativo.proyecto_id","=","proyecto.id")
                ->where("proyecto.id",$perfil->id)
                ->where(function($q){
                    $q->whereNull("proyectoinvestigador.pro_inv_estado_solicitud")
                        ->orWhere("proyectoinvestigador.pro_inv_estado_solicitud","aprobado");
                })->get();

            if(count($personas)){
                $ids = [];
                foreach($personas as $pp){
                    $ids[] = $pp->id;
                }

                $mensaje = "Nueva sugerencia de tipo ".$elemento." registrada con el proyecto ".$perfil->pro_titulo;
                $url = asset("/inv/sugerencia/".Crypt::encrypt($objSugerencia->id));
                UsuarioController::registrarNotificacion($mensaje,$url,$ids);
            }
            DB::commit();
            return 1;
        } else {
            return 2;
        }
    }

//</editor-fold>

    public function postDataActividad(Request $request)
    {
        $idActividad = Crypt::decrypt($request->input("idActividad"));
        $actividad = Actividad::find($idActividad);
        if ($actividad && $request->ajax() && $actividad->act_estado != "delete") {
            return view("plantillas/proyectos/seguimiento/datosActividad")->with("actividad", $actividad);
        }
        return redirect('/');
    }

    public function postDataActividadEdit(Request $request)
    {
        $idActividad = Crypt::decrypt($request->input("idActividad"));
        $actividad = Actividad::find($idActividad);
        if ($actividad && $request->ajax() && $actividad->act_estado != "delete") {
            return view("plantillas/proyectos/seguimiento/datosActividadEdit")->with("actividad", $actividad);
        }
        return redirect('/');
    }

    public function postCrearActividad(Request $request)
    {
        $idComponente = Crypt::decrypt($request->input("idComponente"));
        $componente = Componente::find($idComponente);
        $actividad = new Actividad();
        if ($componente) {
            if (AutenticacionInv::check()) {
                return view("plantillas/proyectos/formActividad")->with('componente', $componente)->with('actividad', $actividad)->with('action', 'Crear');
            }
        }
        return redirect('/');
    }

    public function postEditarActividad(Request $request)
    {
        $idActividad = Crypt::decrypt($request->input("idActividad"));
        $actividad = Actividad::find($idActividad);
        if ($actividad && $actividad->act_estado != "delete") {
            if (AutenticacionInv::check()) {
                return view("plantillas/proyectos/formActividad")->with('componente', $actividad->componente)->with('actividad', $actividad)->with('action', 'Editar');
            }
        };
    }


    public function postActionsActividad(actionsActividadRequest $request)
    {
        if ($request->input('action') == 'Crear') {
            $idComponente = Crypt::decrypt($request->input("id-componente"));
            $componente = Componente::find($idComponente);
            $actividad = new Actividad();
            $actividad->componente_id = $componente->id;
            $mensaje = "Actividad creada con exito";
        } else if ($request->input('action') == 'Editar') {
            $idActividad = Crypt::decrypt($request->input("id-actividad"));
            $actividad = Actividad::find($idActividad);
            $componente = $actividad->componente;
            $mensaje = "Actividad editada con exito";
        }

        $proyecto = $componente->proyectoInvestigativo->proyecto;
        $error = false;


        if ($proyecto->pro_duracion < $request->input('duracion')) {
            $error = true;
            $mensajeError = "La duración de una actividad no puede ser mayor a la duración del proyecto, la duración del proyecto es de " . $proyecto->pro_duracion . " meses.";
        }

        if (((intval($request->input('mes-inicio')) + $request->input('duracion')) - 1) > $proyecto->pro_duracion) {
            $error = true;
            $mensajeError = "La duración de la actividad, el mes de inicio de la misma y la duración del proyecto no establecen una relación correcta.";
        }

        if ($actividad->act_estado == "delete") {
            $error = true;
            $mensajeError = "No es posible editar la información de esta actividad. Anteriormente usted a descartado esta actividad de su proyecto.";
        }


        if ($error) {
            return $mensajeError;
        }

        $actividad->act_descripcion = $request->input('descripcion');
        $actividad->act_resultado = $request->input('resultado');
        $actividad->act_indicador = $request->input('indicador');
        $actividad->act_meta = $request->input('meta');
        $actividad->act_numero_mes_inicio = $request->input('mes-inicio');
        $actividad->act_duracion = $request->input('duracion');

        $actividad->save();
        Session::flash("msjComponente", $mensaje);
        return '1';
    }

    public function postProductosActividad(Request $request)
    {
        $idActividad = Crypt::decrypt($request->input("idActividad"));
        $actividad = Actividad::find($idActividad);
        if ($actividad && $actividad->act_estado != "delete") {
            if (AutenticacionInv::check()) {
                return view("plantillas/proyectos/formProductos")->with('componente', $actividad->componente)->with('actividad', $actividad);
            }
        }
        return redirect('/');
    }

    public function postRubrosActividad(Request $request)
    {
        $idActividad = Crypt::decrypt($request->input("idActividad"));
        $actividad = Actividad::find($idActividad);
        if ($actividad && $actividad->act_estado != "delete") {
            $rubros = $actividad->rubros;
            if (AutenticacionInv::check()) {
                return view("plantillas/proyectos/formRubros")->with('componente', $actividad->componente)->with('actividad', $actividad)->with('rubros', $rubros);
            }
        }
    }

    public function getHtmlNuevoRubro($numero_rubro)
    {
        return view("plantillas/proyectos/formulario_rubro")->with('rubro', new Rubro())->with('numero_rubro', $numero_rubro);
    }

    public function postActionsRubros(Request $request)
    {
        if (AutenticacionInv::check()) {
            $actividad = Actividad::find(Crypt::decrypt($request->input('id_actividad')));
            if ($actividad->exists && $actividad->act_estado != "delete") {
                DB::beginTransaction();
                foreach ($actividad->rubros as $rubro) {
                    foreach ($rubro->componentesRubro as $item) {
                        $item->delete();
                    }
                    $rubro->delete();
                }

                $errors = [];
                //while(count($errors) == 0){
                $num_rubros = $request->input('cantidad_rubros');
                for ($i = 1; $i <= $num_rubros; $i++) {
                    if ($request->input('nombre_rubro_' . $i)) {
                        $rubro = new Rubro();
                        $rubro->rub_nombre = $request->input('nombre_rubro_' . $i);
                        $rubro->actividad_id = $actividad->id;
                        $rubro->save();
                        $cantidadItems = $request->input('count_rubro_' . $i);
                        for ($e = 1; $e <= $cantidadItems; $e++) {
                            if ($request->input('nombre_item_' . $i . '_' . $e) && $request->input('cantidad_item_' . $i . '_' . $e) && $request->input('valor_unitario_item_' . $i . '_' . $e)) {
                                $componenteRubro = new ComponenteRubro();
                                $componenteRubro->com_rub_nombre = $request->input('nombre_item_' . $i . '_' . $e);
                                $componenteRubro->com_rub_cantidad = $request->input('cantidad_item_' . $i . '_' . $e);
                                $componenteRubro->com_rub_valor_unitario = $request->input('valor_unitario_item_' . $i . '_' . $e);
                                $componenteRubro->rubro_id = $rubro->id;
                                $componenteRubro->save();
                            } else {
                                $errors['error_' . (count($errors) + 1)] = "Es necesario ingresar toda la información de los componentes de un rubro.";
                                break;
                            }
                        }
                    } else {
                        $errors['error_' . (count($errors) + 1)] = "Es necesario ingresar el nombre en cada rubro agregado.";
                        break;
                    }
                }

                if (count($errors)) {
                    return response()->json($errors);
                }
                Session::flash('msjComponente', 'Todos los rubros de la actividad han sido almacenados en el sistema.');
                DB::commit();
                return '1';
            }
        } else {
            return response('Unauthorized.', 401);
        }
        return redirect('/');
    }

    public function postActionsProductos(Request $request)
    {
        if (AutenticacionInv::check()) {
            $actividad = Actividad::find(Crypt::decrypt($request->input('id-actividad')));
            if ($actividad->exists && $actividad->act_estado != "delete") {
                foreach ($actividad->productos as $pr) {
                    $pr->delete();
                }

                $i = 0;
                while (true) {
                    $i++;
                    if ($request->input('descripcion' . $i)) {
                        $producto = new Producto();
                        $producto->actividad_id = $actividad->id;
                        $producto->pro_descripcion = $request->input('descripcion' . $i);
                        $producto->pro_estado = 'por revisar';
                        $producto->save();
                        Session::flash('msjComponente', 'Los productos han sido registrados con exito.');
                    } else {
                        break;
                    }
                }
                return '1';
            }
        } else {
            return response('Unauthorized.', 401);
        }
        return redirect('/');
    }

    public function postFormularInformacionGeneral(FormularInfoGeneralRequest $request)
    {
        $lineas = $request->input('lineas_investigacion');
        if (is_array($lineas)) {
            if (count($lineas) > 0 && count($lineas) < 5) {

                for ($i = 0; $i < count($lineas); $i++) {
                    $id = Crypt::decrypt($lineas[$i]);
                    $linea = LineaInvestigacion::find($id);
                    if (!$linea) {
                        return '-3';
                    }
                }
                if ($request->input('id_perfil')) {
                    $perfil = Proyecto::find(Crypt::decrypt($request->input('id_perfil')));
                    if ($perfil) {
                        $perfil->pro_duracion = $request->input('duracion');
                        $proyectoInvestigativo = $perfil->proyectoInvestigativo;
                        $proyectoInvestigativo->pro_inv_tipo_financiacion = $request->input('tipo_financiacion');
                        $perfil->pro_estado_formulacion = '1';
                        $perfil->save();
                        $proyectoInvestigativo->save();

                        for ($i = 0; $i < count($lineas); $i++) {
                            $id = Crypt::decrypt($lineas[$i]);
                            $proyectoLinea = new ProyectoLinea();
                            $proyectoLinea->proyectoinvestigativo_id = $proyectoInvestigativo->id;
                            $proyectoLinea->lineainvestigacion_id = $id;
                            $proyectoLinea->save();
                        }
                        Session::flash('msjComponente', 'La información general del perfil a sido almacenada');
                        return '1';
                    }
                }
            } else {
                return '-2';
            }
        }
        return '-1';
    }

    public function postGuardarFormularComponenetes(Request $request)
    {
        if ($request->input('id_perfil')) {
            $perfil = Proyecto::find(Crypt::decrypt($request->input('id_perfil')));
            if ($perfil) {
                $aux = 0;
                $fin = true;
                DB::beginTransaction();
                $componentes = $perfil->proyectoInvestigativo->componentes;
                foreach ($componentes as $comp) {
                    $comp->deleteSugerencias();
                    $comp->delete();
                }
                while ($fin) {
                    $aux++;
                    if ($request->input('nombre' . $aux) || $request->input('objetivo' . $aux) || $request->input('equivalente' . $aux)) {
                        $componente = new Componente();
                        $componente->com_nombre = $request->input('nombre' . $aux);
                        $componente->com_objetivo = $request->input('objetivo' . $aux);
                        $componente->com_equivalente = $request->input('equivalente' . $aux);
                        $componente->com_estado = "sin iniciar";
                        $componente->proyectoinvestigativo_id = $perfil->proyectoInvestigativo->id;
                        $componente->save();
                    } else {
                        $fin = false;
                    }
                }
                DB::commit();
                return '1';
            }
        }
        return '-2';
    }

    public function postCompletoFormularComponenetes(Request $request)
    {
        if ($request->input('id_perfil')) {
            $perfil = Proyecto::find(Crypt::decrypt($request->input('id_perfil')));
            if ($perfil) {
                $aux = 0;
                $fin = true;
                $error = false;
                DB::beginTransaction();
                $componentes = $perfil->proyectoInvestigativo->componentes;
                foreach ($componentes as $comp) {
                    $comp->deleteSugerencias();
                    $comp->delete();
                }
                $equivalente = 0;
                while ($fin) {
                    $aux++;
                    if ($request->input('nombre' . $aux) || $request->input('objetivo' . $aux) || $request->input('equivalente' . $aux)) {
                        if ($request->input('nombre' . $aux) && $request->input('objetivo' . $aux) && $request->input('equivalente' . $aux)) {
                            $componente = new Componente();
                            $componente->com_nombre = $request->input('nombre' . $aux);
                            $componente->com_objetivo = $request->input('objetivo' . $aux);
                            $componente->com_equivalente = $request->input('equivalente' . $aux);
                            $componente->com_estado = "sin iniciar";
                            $equivalente += intval($request->input('equivalente' . $aux));
                            $componente->proyectoinvestigativo_id = $perfil->proyectoInvestigativo->id;
                            $componente->save();
                        } else {
                            $fin = true;
                            $error = true;
                        }
                    } else {
                        $fin = false;
                    }
                }
                if (!$error) {
                    if ($equivalente != 100) {
                        return '-3';
                    }
                    DB::commit();
                    $perfil->pro_estado_formulacion = '2';
                    $perfil->save();
                    Session::flash("msjComponente", "La formulación de componentes ha sido registrada con exito.");
                    return '1';
                }
                return '-1';
            }
        }
        return '-2';
    }

    public function postCompletoFormularActividades(Request $request)
    {
        if ($request->input('id_perfil')) {
            $perfil = Proyecto::find(Crypt::decrypt($request->input('id_perfil')));
            if ($perfil) {
                $error = false;
                $componentes = $perfil->proyectoInvestigativo->componentes;
                foreach ($componentes as $comp) {
                    $actividades = $comp->actividades;
                    $aux = 0;
                    foreach ($actividades as $a) {
                        if ($a->act_estado != "delete") {
                            $aux++;
                        }
                    }
                    if (!count($actividades) || $aux == 0) {
                        $error = true;
                        break;
                    }
                }

                if (!$error) {
                    $perfil->pro_estado_formulacion = '3';
                    $perfil->save();
                    Session::flash("mensaje", "La formulación de actividades ha sido registrada con exito.");
                    return '1';
                }
                return '-1';
            }
        }
        return '-2';
    }

    public function postCompletoFormularRubrosProductos(Request $request)
    {
        if ($request->input('id_perfil')) {
            $perfil = Proyecto::find(Crypt::decrypt($request->input('id_perfil')));
            if ($perfil) {
                $error = false;
                $componentes = $perfil->proyectoInvestigativo->componentes;
                foreach ($componentes as $comp) {
                    if ($comp->com_estado != "delete") {
                        $actividades = $comp->actividades;
                        foreach ($actividades as $actividad) {
                            if ($actividad->act_estado != "delete") {
                                $aux = 0;
                                foreach ($actividad->productos as $p) {
                                    if ($p->pro_estado != 'delete')
                                        $aux++;
                                }

                                if ($aux == 0) {
                                    $error = true;
                                    break;
                                }
                            }
                        }
                    }
                    if ($error)
                        break;
                }

                if (!$error) {
                    $perfil->pro_estado_formulacion = '4';
                    $perfil->save();
                    Session::flash("msjComponente", "La formulación de rubros y productos ha sido terminada con exito, ahora su perfil espera la aprobación del evaluador para ser enviado a una convocatoria.");
                    return '1';
                }
                return '-1';
            }
        }
        return '-2';
    }

    public function postSelect(Request $request)
    {
        $select = $request->input('select');
        $id = 0;
        if ($request->input('id') != '' && $request->input('id') != 'Seleccione') {
            $id = Crypt::decrypt($request->input('id'));
        }
        return view("plantillas/selects")->with('select', $select)->with('id', $id);
    }

    public function getEntidades($idProyecto)
    {
        $idProyecto = Crypt::decrypt($idProyecto);
        $proyecto = Proyecto::find($idProyecto);

        if ($proyecto) {
            if($proyecto->permisoEditar() || $proyecto->permisoVisualizar()) {
                $rol = "";
                if (Session::get('rol actual') == "administrador investigativo")
                    $rol = "adminv";
                else if (Session::get('rol actual') == "investigador")
                    $rol = "inv";
                else if ((Session::get('rol actual') == "evaluador"))
                    $rol = "eval";

                $ids = [];
                if (count($proyecto->entidades)) {
                    foreach ($proyecto->entidades as $ent) {
                        $ids[] = $ent->id;
                    }
                }

                $masEntidades = Entidad::where('ent_estado', 'ejecutora')->whereNotIn('id', $ids)->orderBy('ent_nombre')->get();

                return view('plantillas/entidadesProyecto')->with('proyecto', $proyecto)->with('masEntidades', $masEntidades)->with('rol', $rol);
            }
        }
        return redirect("/");
    }

    public function postRelacionEntidad(RelacionEntidadRequest $request)
    {

        $idProyecto = Crypt::decrypt($request->input('proyecto'));
        $idEntidad = Crypt::decrypt($request->input('entidad'));
        $aporte = $request->input('aporte');

        $proyecto = Proyecto::find($idProyecto);
        $entidad = Entidad::find($idEntidad);

        if ($proyecto && $entidad) {
            $proyectoEntidad = new ProyectoEntidad();
            $proyectoEntidad->proyecto_id = $proyecto->id;
            $proyectoEntidad->entidad_id = $entidad->id;
            $proyectoEntidad->pro_ent_aporte = $aporte;
            $proyectoEntidad->save();
            Session::flash("msjEntidad", "La entidad ha sido relacionada con el proyecto.");
            return "1";
        }
        return '-1';
    }

    public function postDeleteRelacionEntidad(Request $request)
    {

        $idProyecto = Crypt::decrypt($request->input('proyecto'));
        $idEntidad = Crypt::decrypt($request->input('entidad'));

        $proyecto = Proyecto::find($idProyecto);
        $entidad = Entidad::find($idEntidad);

        if ($proyecto && $entidad) {
            $proyectosEntidad = ProyectoEntidad::where("proyecto_id", $idProyecto)->where("entidad_id", $idEntidad)->get();

            foreach ($proyectosEntidad as $proEnt) {
                $proEnt->delete();
            }
            Session::flash("msjEntidad", "La relación con la entidad ha sido eliminada.");
            return "1";
        }
        return '-1';
    }

    public function getGrupo($idProyecto)
    {
        $idProyecto = Crypt::decrypt($idProyecto);
        $proyecto = Proyecto::find($idProyecto);

        if ($proyecto) {
            if($proyecto->permisoVisualizar()) {
                $rol = Sistema::getSiglaRolActual();

                $ids = [];

                $relaciones = ProyectoInvestigador::where('proyectoinvestigador.proyectoinvestigativo_id', $proyecto->proyectoInvestigativo->id)->orderBy('created_at')->get();
                if (count($relaciones)) {
                    foreach ($relaciones as $r) {
                        $ids[] = $r->investigador->id;
                    }
                }

                $masInvestigadores = Investigador::where('inv_tipo', 'investigador')->whereNotIn('id', $ids)->get();

                return view('plantillas/proyectoInvestigadores')->with('proyecto', $proyecto)->with('masInvestigadores', $masInvestigadores)->with('relaciones', $relaciones)->with('rol', $rol);
            }
        }
        return redirect('/');

    }

    public function postAgregarInvestigadorRelacion(NuevoInvestigadorRelacion $request)
    {
        $idProyecto = Crypt::decrypt($request->input('proyecto'));
        $proyecto = Proyecto::find($idProyecto);

        if ($proyecto) {

            $relaciones = ProyectoInvestigador::where('proyectoinvestigador.proyectoinvestigativo_id', $proyecto->proyectoInvestigativo->id)->where("pro_inv_estado_solicitud", "aprobado")->get();

            if (count($relaciones) >= 10) {
                return "Este proyecto ya presenta el máximo de integrantes posibles por proyecto.";
            }

            DB::beginTransaction();
            $persona = new Persona();
            $persona->per_nombres = $request->input('nombres');
            $persona->per_apellidos = $request->input('apellidos');
            $persona->per_correo = $request->input('correo');
            $persona->save();

            $password = $persona->nuevaCuenta('investigador');

            $investigador = new Investigador();
            $investigador->persona_id = $persona->id;
            $investigador->inv_tipo = 'investigador';
            $investigador->save();

            $proyectoInvestigador = new ProyectoInvestigador();
            $proyectoInvestigador->proyectoinvestigativo_id = $proyecto->proyectoInvestigativo->id;
            $proyectoInvestigador->investigador_id = $investigador->id;
            $proyectoInvestigador->pro_inv_rol = $request->input('cargo');
            $proyectoInvestigador->pro_inv_estado_solicitud = 'aprobado';
            $proyectoInvestigador->save();

            $personaLider = Persona::find(Session::get('idPersona'));

            $mensaje = "El grupo de investigación SINERGIA SENA, le informa"
                . " que el(la) señor(a) " . $personaLider->per_nombres . " " . $personaLider->per_apellidos . " ha registrado su información "
                . "en el grupo de integrantes del proyecto (" . $proyecto->pro_titulo . ") con el fin de colaborar con el rol de " . $request->input('cargo') . ". Para ver la información del proyecto ingrese a nuestro sistema <a href='" . url('/') . "'>SINERGIA</a> con los siguientes datos de ingreso:<br><br>"
                . "Usuario: correo electrónico<br>Contraseña: " . $password;

                Sistema::enviarMail($persona, $mensaje, "Registro sistema SINERGIA", "Registro");
            Session::flash("msjInvestigador", "Investigador registrado con exito");
            DB::commit();
            return 1;
        }
        return -1;
    }

    public function postEnviarSolicitudProyectoInvestigador(Request $request)
    {
        $idProyecto = Crypt::decrypt($request->input('proyecto'));
        $proyecto = Proyecto::find($idProyecto);

        $idInvestigador = Crypt::decrypt($request->input('investigador'));
        $investigador = Investigador::find($idInvestigador);

        if ($proyecto && $investigador) {

            $relaciones = ProyectoInvestigador::where('proyectoinvestigador.proyectoinvestigativo_id', $proyecto->proyectoInvestigativo->id)->where("pro_inv_estado_solicitud", "aprobado")->get();

            if (count($relaciones) >= 10) {
                return "Este proyecto ya presenta el máximo de integrantes posibles por proyecto.";
            }

            DB::beginTransaction();
            $persona = $investigador->persona;

            $proyectoInvestigador = new ProyectoInvestigador();
            $proyectoInvestigador->proyectoinvestigativo_id = $proyecto->proyectoInvestigativo->id;
            $proyectoInvestigador->investigador_id = $investigador->id;
            $proyectoInvestigador->pro_inv_rol = $request->input('cargo_investigador');
            $proyectoInvestigador->pro_inv_estado_solicitud = 'enviado';
            $proyectoInvestigador->save();

            $personaLider = Persona::find(Session::get('idPersona'));

            $mensaje = "El grupo de investigación SINERGIA SENA, le informa"
                . " que el(la) señor(a) " . $personaLider->per_nombres . " " . $personaLider->per_apellidos . " ha enviado a usted la solicitud para pertenecer "
                . "al grupo de integrantes del proyecto (" . $proyecto->pro_titulo . ") con el fin de colaborar con el rol de " . $request->input('cargo_investigador') . ". Para ver mäs información, ingrese a nuestro sistema <a href='" . url('/') . "'>SINERGIA</a> "
                . " y desde el menú de solicitudes podrá ver la información del proyecto, así como  aprobar o rechazar la solicitud.";

            Sistema::enviarMail($persona, $mensaje, "Solicitud colaboración proyecto", "Solicitud de colaboración");
            Session::flash("msjInvestigador", "Solicitud enviada con exito.");
            $msj = "Nueva solicitud para participar en el proyecto ".$proyecto->pro_titulo." con el rol de ".$request->input('cargo_investigador');
            $ruta = asset("/inv/solicitud/".Crypt::encrypt($proyectoInvestigador->id));
            UsuarioController::registrarNotificacion($msj,$ruta,array($investigador->persona->id));
            DB::commit();
            return 1;
        }
        return -1;
    }

    public function getInicioProyecto($id)
    {
        if (AutenticacionAdminv::check() || AutenticacionEval::check()) {
            $id = Crypt::decrypt($id);
            $proyecto = Proyecto::find($id);

            if ($proyecto && $proyecto->pro_estado == "proyecto aprobado") {
                return view('plantillas.establecerInicioProyecto')->with("rol", Sistema::getSiglaRolActual())->with("proyecto", $proyecto);
            }
        }
        return redirect("/");
    }

    public function postEstablecerFechaInicio(Request $request)
    {
        if (AutenticacionAdminv::check() || AutenticacionEval::check()) {
            $id = Crypt::decrypt($request->input("proyecto"));
            $proyecto = Proyecto::find($id);

            if ($proyecto && $proyecto->pro_estado == "proyecto aprobado") {
                if ($request->has("fecha_inicio")) {
                    $fecha = $request->input("fecha_inicio");
                    $fecha = date("Y-m-d", strtotime($fecha));

                    $f = new \DateTime($fecha);
                    $hoy = new \DateTime(date("Y-m-d"));

                    if ($hoy >= $f) {
                        return "La fecha de inicio del proyecto debe ser posterior a la fecha actual";
                    }

                    $proyecto->pro_fecha_inicio = $fecha;
                    $proyecto->save();
                    $proyecto->establecerFechaInicioFinActividades();
                    Session::flash("mensaje", "La fecha de inicio del proyecto ha sido establecida.");
                    return "1";
                } else {
                    return "El campo fecha de inicio es requerido";
                }

            }
            return "-2";
        }
        return "Usted no tiene permisos para realizar esta tarea";
    }

    public function postGuardarRespuestaSugerencia(Request $request)
    {
        $idSugerencia = Crypt::decrypt($request->input('sugerencia'));
        $sugerencia = Sugerencia::find($idSugerencia);
        if ($sugerencia) {
            if ($request->has("respuesta") && $request->input("respuesta")) {
                $respuesta = new RespuestaSugerencia();
                $respuesta->persona_id = Session::get("idPersona");
                $respuesta->sugerencia_id = $sugerencia->id;
                $respuesta->res_sug_respuesta = $request->input("respuesta");
                $respuesta->save();

                $url = asset("/eval/sugerencia/".Crypt::encrypt($sugerencia->id));

                $proyecto = $sugerencia->proyecto;

                $persona = Persona::find(Session::get('idPersona'));//el que esta registrando la respuesta
                $nombre = $persona->per_nombres." ".$persona->per_apellidos;

                //Si la persona que inicio sesion no es el evaluador que registro la sugerencia
                //se le envia notificacion a el evaluador que la registro
                if($sugerencia->persona_id != Session::get("idPersona")){
                    $ids  = array($sugerencia->persona_id);
                    $mensaje = $nombre." ha registrado una respuesta en una sugerencia enviada por usted al proyecto ".$proyecto->pro_titulo;
                    UsuarioController::registrarNotificacion($mensaje,$url,$ids);
                }

                $investigadores = Persona::select("persona.*")
                    ->join("investigador","persona.id","=","investigador.persona_id")
                    ->join("proyectoinvestigador","investigador.id","=","proyectoinvestigador.investigador_id")
                    ->join("proyectoinvestigativo","proyectoinvestigador.proyectoinvestigativo_id","=","proyectoinvestigativo.id")
                    ->join("proyecto","proyectoinvestigativo.proyecto_id","=","proyecto.id")
                    ->where(function($q){
                        $q->whereNull("proyectoinvestigador.pro_inv_estado_solicitud")
                            ->orWhere("proyectoinvestigador.pro_inv_estado_solicitud","aprobado");
                    })
                    ->where("proyecto.id",$proyecto->id)
                    ->whereNotIn("persona.id",array(Session::get("idPersona")))->get();
                if(count($investigadores)){
                    $ids = [];
                    foreach($investigadores as $inv){
                        $ids[] = $inv->id;
                    }

                    $mensaje = $nombre." ha registrado una respuesta en una sugerencia enviada al proyecto ".$proyecto->pro_titulo;
                    $url = asset("/inv/sugerencia/".Crypt::encrypt($sugerencia->id));

                    UsuarioController::registrarNotificacion($mensaje,$url,$ids);
                }




                Session::flash("mensaje", "Su respuesta ha sido registrada con exito");
                return "1";
            } else {
                return "El campo respuesta es obligatorio";
            }
        }
        return "-2";
    }

    public function postSugerenciaRevisada(Request $request)
    {
        $idSugerencia = Crypt::decrypt($request->input('sugerencia'));
        $sugerencia = Sugerencia::find($idSugerencia);
        if ($sugerencia) {
            if (AutenticacionAdminv::check() || AutenticacionEval::check()) {
                $sugerencia->sug_estado = "revisado";
                $sugerencia->save();
                Session::flash("mensaje", "La sugerencia ha sido marcada como revisada");
                return "1";
            } else {
                return "Usted no tiene permisos para realizar esta acción";
            }
        }
        return "-2";
    }


    public function getDownloadFileProducto($id)
    {
        $id = Crypt::decrypt($id);
        $producto = Producto::find($id);
        if ($producto) {
            if (Sistema::isValidUserDownloadFileProduct($id)) {
                if (Storage::disk('uploads')->exists("productos/" . $producto->id . "/" . $producto->pro_ubicacion)) {
                    $ruta = storage_path() . "\\uploads\\productos\\" . $producto->id . "\\" . $producto->pro_ubicacion;
                    return response()->download($ruta, $producto->pro_ubicacion);
                    //return new Response(Storage::disk("uploads")->get($producto->id."/".$producto->pro_ubicacion),200);
                }
            }
        }
        return redirect("/");
    }

    public function getReporteInformacion($id)
    {

        $id = Crypt::decrypt($id);
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return redirect('/');
        } else {
            $pdf = new ReporteInformacion('P', 'mm', 'letter');
            $pdf->AliasNbPages();
            $pdf->AddPage();

            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetFillColor(213, 213, 213);
            $pdf->Cell(0, 10, utf8_decode("Datos del proyecto"), 1, 10, 'C', true);


            $pdf->SetWidths(Array(51, 145));
            $pdf->SetFont('Arial', '', 11);

            $datos = Array(utf8_decode("Título"), utf8_decode($proyecto->pro_titulo));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Objetivo general "), utf8_decode($proyecto->pro_objetivo_general));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Problema "), utf8_decode($proyecto->proyectoInvestigativo->pro_inv_problema));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Justificación "), utf8_decode($proyecto->pro_justificacion));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Presupuesto estimado "), '$ ' . number_format($proyecto->pro_presupuesto_estimado, 0, ',', '.'));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Tipo de financiación "), utf8_decode($proyecto->proyectoInvestigativo->pro_inv_tipo_financiacion));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Sector "), utf8_decode($proyecto->proyectoInvestigativo->pro_inv_sector));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Fecha de inicio "), utf8_decode($proyecto->pro_fecha_inicio));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Duración "), utf8_decode($proyecto->pro_duracion . ' mes(es)'));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Estado "), utf8_decode($proyecto->pro_estado));
            $pdf->Row($datos, Array('L', 'L'), 1);

            $componentes = $proyecto->proyectoInvestigativo->componentes;

            $pdf->AddPage();
            //$pdf->Ln(15);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'Componentes del proyecto', 0, 10, 'C');
            $pdf->Ln(5);
            if (!$componentes) {
                $pdf->SetFont('Arial', '', 14);
                $pdf->Cell(0, 1, 'No se encontraron componentes relacionados con este proyecto', 0, 1, 'C');
            } else {
                $totalCalculado = 0;
                $numCompo = 0;

                foreach ($componentes as $componente) {
                    $numCompo++;
                    $pdf->SetFont('Arial', 'B', 15);
                    $pdf->SetFillColor(213, 213, 213);
                    $pdf->Cell(0, 10, 'Componente #' . $numCompo, 1, 1, 'C', true);

                    $pdf->SetWidths(Array(51, 145));
                    $pdf->SetFont('Arial', '', 11);

                    $datos = Array(utf8_decode("Nombre del componente"), utf8_decode($componente->com_nombre));
                    $pdf->Row($datos, Array('C', 'L'), 1);

                    $datos = Array(utf8_decode("Objetivo del componente"), utf8_decode($componente->com_objetivo));
                    $pdf->Row($datos, Array('C', 'L'), 1);


                    $pdf->SetFont('Arial', 'B', 14);
                    $pdf->SetFillColor(213, 213, 213);
                    $pdf->Cell(0, 10, 'Actividades del componente #' . $numCompo, 1, 1, 'C', true);

                    $actividades = $componente->actividades;

                    if (!$actividades) {
                        $pdf->SetFont('Arial', '', 14);
                        $pdf->Cell(0, 10, 'No se encontraron actividades relacionadas con este componente', 0, 1, 'C');
                    } else {
                        $numAct = 0;

                        foreach ($actividades as $actividad ){
                            $numAct++;
                            $pdf->SetFont('Arial', 'B', 15);
                            $pdf->SetFillColor(213, 213, 213);
                            $pdf->Cell(0, 10, 'Actividad #' . $numAct, 1, 1, 'C', true);

                            $pdf->SetWidths(Array(51, 145));
                            $pdf->SetFont('Arial', '', 11);

                            $datos = Array(utf8_decode("Descripción"), utf8_decode($actividad->act_descripcion));
                            $pdf->Row($datos, Array('C', 'L'), 1);
                            $datos = Array(utf8_decode("Indicador"), utf8_decode($actividad->act_indicador));
                            $pdf->Row($datos, Array('C', 'L'), 1);
                            $datos = Array(utf8_decode("Resultado"), utf8_decode($actividad->act_resultado));
                            $pdf->Row($datos, Array('C', 'L'), 1);


                            $pdf->SetFont('Arial', 'B', 14);
                            $pdf->SetFillColor(237, 237, 237);
                            $pdf->Cell(0, 10, 'Productos de la actividad #' . $numAct, 1, 1, 'C', true);

                            $productos = $actividad->productos;

                            if (!$productos) {
                                $pdf->SetFont('Arial', '', 14);
                                $pdf->Cell(0, 10, 'No se encontraron productos relacionados con esta actividad', 0, 1, 'C');
                            } else {
                                $pdf->SetFont('Arial', 'B', 14);
                                $pdf->SetFillColor(237, 237, 237);
                                $pdf->Cell(130, 10, utf8_decode("Descripción"), 1, 0, "C", true);
                                $pdf->Cell(0, 10, utf8_decode("Estado"), 1, 0, "C", true);
                                $pdf->Ln();
                                foreach ($productos as $producto) {
                                    $pdf->SetFont('Arial', '', 11);
                                    $pdf->SetWidths(Array(130, 66));
                                    $datos = Array(utf8_decode($producto->pro_descripcion), utf8_decode($producto->pro_estado));
                                    $pdf->Row($datos, Array('J', 'C'), 0);
                                }
                                /*$header = array(utf8_decode('Descripción'),"Estado");
                                    while ($producto = mysqli_fetch_object($productos)){
                                        $data[] = $producto->pro_descripcion;
                                        $data[] = $producto->pro_estado;
                                    }
                                    $pdf->FancyTable($header, $data);*/
                            }//fin del else de si existen productos

                            $pdf->SetFont('Arial', 'B', 14);
                            $pdf->SetFillColor(213, 213, 213);
                            $pdf->Cell(0, 10, 'Rubros de la actividad #' . $numAct, 1, 1, 'C', true);

                            $rubros = $actividad->rubros;

                            if (!$rubros) {
                                $pdf->SetFont('Arial', '', 14);
                                $pdf->Cell(0, 10, 'No se encontraron rubros relacionadas con esta actividad', 0, 1, 'C');
                            } else {
                                $numRubro = 0;

                                foreach ($rubros as $rubro) {
                                    $numRubro++;
                                    $pdf->SetFont('Arial', 'B', 15);
                                    $pdf->SetFillColor(237, 237, 237);
                                    $pdf->Cell(0, 10, 'Rubro #' . $numRubro, 1, 1, 'C', true);
                                    $pdf->SetFont('Arial', 'B', 14);
                                    $pdf->Cell(0, 10, utf8_decode($rubro->rub_nombre), 1, 1, 'C', true);

                                    $pdf->SetFont('Arial', 'B', 14);
                                    $pdf->SetFillColor(237, 237, 237);
                                    $pdf->Cell(0, 10, 'Componentes de este rubro', 1, 1, 'C', true);

                                    $componentesRubro = $rubro->componentesRubro;

                                    if (!$componentesRubro) {
                                        $pdf->SetFont('Arial', '', 14);
                                        $pdf->Cell(0, 10, 'No se encontraron componentes para este rubro', 0, 1, 'C');
                                    } else {
                                        $pdf->SetFont('Arial', 'B', 14);
                                        $pdf->SetFillColor(237, 237, 237);
                                        $pdf->Cell(100, 10, utf8_decode("Nombre"), 1, 0, "C", true);
                                        $pdf->Cell(30, 10, utf8_decode("Cantidad"), 1, 0, "C", true);
                                        $pdf->Cell(36, 10, utf8_decode("valor unitario"), 1, 0, "C", true);
                                        $pdf->Cell(30, 10, utf8_decode("sobTotal"), 1, 0, "C", true);
                                        $pdf->Ln();
                                        $total = 0;
                                        foreach ($componentesRubro as $componenteRubro) {
                                            $pdf->SetFont('Arial', '', 11);
                                            $pdf->Cell(100, 7, utf8_decode($componenteRubro->com_rub_nombre), 1, 0, "C");
                                            $pdf->Cell(30, 7, $componenteRubro->com_rub_cantidad, 1, 0, "C");
                                            $pdf->Cell(36, 7, "$ " . number_format($componenteRubro->com_rub_valor_unitario, 0, ',', '.'), 1, 0, "C");
                                            $pdf->Cell(30, 7, "$ " . number_format(($componenteRubro->com_rub_valor_unitario * $componenteRubro->com_rub_cantidad), 0, ',', '.'), 1, 0, "C");
                                            $total += ($componenteRubro->com_rub_cantidad * $componenteRubro->com_rub_valor_unitario);
                                            $pdf->Ln();
                                        }
                                        $totalCalculado += $total;
                                        $pdf->SetFont('Arial', 'B');
                                        $pdf->Cell(100, 7, utf8_decode("Total"), 1, 0, "C");
                                        $pdf->Cell(0, 7, "$ " . number_format($total, '0', ',', '.'), 1, 0, "C");
                                        $pdf->Ln();

                                        /*$header = array(utf8_decode('Descripción'),"Estado");
                                            while ($producto = mysqli_fetch_object($productos)){
                                                $data[] = $producto->pro_descripcion;
                                                $data[] = $producto->pro_estado;
                                            }
                                            $pdf->FancyTable($header, $data);*/
                                    }//fin de el si existen componentes del rubro
                                }//fin del while de agregar rubros
                            }//fin del else de si existen rubros
                        }//fin del while que agrega actividades
                    }//fin del else de si existen actividades
                }//fin del while que agrega componentes
                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'B');
                $pdf->Cell(0, 7, utf8_decode("Presupuesto total: $ " . number_format($totalCalculado, 2, ',', '.')), 1, 0, "C");
                /*  $header = array("Titulo","daro1","fsd");
                  $data = array(1,2,3,4,5,6);
                  $pdf->FancyTable($header, $data);*/
            }

            $pdf->Output("","reposte_informacion_".$proyecto->pro_titulo.".pdf");
            exit;
        }
        /*for ($i = 0; $i < 100; $i++) {
           $pdf->Cell(100,20,"Dato No.".$i,0,1);
        }*/
    }

    public function getReporteGrafico($id)
    {
        $id = Crypt::decrypt($id);
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return redirect('/');
        } else {
            $pdf = new ReporteGrafico('P', 'mm', 'letter');
            $pdf->AliasNbPages();
            $pdf->AddPage();

            $pdf->SetFont('Arial', 'B', 14);

            $num = strlen($proyecto->pro_fecha_inicio);
            //si la fecha de inicio del proyecto no esta definida
            if ($num == 0) {
                $pdf->Cell(0, 10, utf8_decode('Para ver el reporte gráfico del desarrollo'), 0, 5, 'C');
                $pdf->Cell(0, 10, utf8_decode('de un proyecto, éste debe tener definida su fecha de inicio'), 0, 5, 'C');
                $pdf->Cell(0, 10, utf8_decode('la cual a su vez debe ser anterior a la fecha actual.'), 0, 5, 'C');
            } else {
                //la fecha de inicio no esta definida
                $fechaActual = strtotime(date('Y-m-d'));
                $fechaInicio = strtotime($proyecto->pro_fecha_inicio);
                //si no se ha iniciado el proyecto con respecto a la fecha de inicio
                if ($fechaActual <= $fechaInicio) {
                    $pdf->Cell(0, 10, utf8_decode('La fecha de inicio del proyecto es posterior a la fecha actual'), 0, 5, 'C');
                    $pdf->Cell(0, 10, utf8_decode('Para ver el reporte gráfico del desarrollo de un proyecto,'), 0, 5, 'C');
                    $pdf->Cell(0, 10, utf8_decode('la fecha actual debe ser posterior a la fecha de inicio del proyecto.'), 0, 5, 'C');
                } else {
                    //cuando si es posible crear el pdf con el anáñisis del proyecto
                    $pdf->SetFont('Arial', 'B', 16);
                    $pdf->SetFillColor(213, 213, 213);
                    $pdf->Cell(0, 10, utf8_decode("Datos del proyecto"), 1, 10, 'C', true);

                    //datos generales del proyecto
                    $datos = Array(utf8_decode("Título "), utf8_decode($proyecto->pro_titulo));
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->SetWidths(Array(50, 146));
                    $pdf->Row($datos, Array('L', 'L'), 1);
                    $datos = Array(utf8_decode("Objetivo general "), utf8_decode($proyecto->pro_objetivo_general));
                    $pdf->Row($datos, Array('L', 'L'), 1);
                    $datos = Array(utf8_decode("Problema "), utf8_decode($proyecto->proyectoInvestigativo->pro_inv_problema));
                    $pdf->Row($datos, Array('L', 'L'), 1);
                    $datos = Array(utf8_decode("Justificación "), utf8_decode($proyecto->pro_justificacion));
                    $pdf->Row($datos, Array('L', 'L'), 1);
                    $datos = Array(utf8_decode("Presupuesto estimado "), '$ ' . number_format($proyecto->pro_presupuesto_estimado, 0, ',', '.'));
                    $pdf->Row($datos, Array('L', 'L'), 1);
                    $datos = Array(utf8_decode("Tipo de financiación "), utf8_decode($proyecto->proyectoInvestigativo->pro_inv_tipo_financiacion));
                    $pdf->Row($datos, Array('L', 'L'), 1);
                    $datos = Array(utf8_decode("Sector "), utf8_decode($proyecto->proyectoInvestigativo->pro_inv_sector));
                    $pdf->Row($datos, Array('L', 'L'), 1);
                    $datos = Array(utf8_decode("Fecha de inicio "), utf8_decode($proyecto->pro_fecha_inicio));
                    $pdf->Row($datos, Array('L', 'L'), 1);
                    $datos = Array(utf8_decode("Duración "), utf8_decode($proyecto->pro_duracion . ' mes(es)'));
                    $pdf->Row($datos, Array('L', 'L'), 1);
                    $datos = Array(utf8_decode("Estado "), utf8_decode($proyecto->pro_estado));
                    $pdf->Row($datos, Array('L', 'L'), 1);
                    $pdf->Ln(10);
                    //en caso de que el grafico que se va a pintar sumado con el contenido existente sobrepasen la hoja
                    if ($pdf->GetY() > 166.00125) {
                        $pdf->addPage();
                    }

                    //titulo del primer grafico
                    $pdf->SetFont('Arial', 'B', 16);
                    $pdf->SetFillColor(255, 102, 0);
                    $pdf->SetTextColor(237, 237, 237);
                    $pdf->SetLeftMargin(20);
                    $pdf->SetRightMargin(20);
                    $pdf->Cell(0, 15, utf8_decode("Desarrollo del proyecto"), 0, 1, 'C', true);
                    $pdf->SetLeftMargin(10);
                    $pdf->SetRightMargin(10);

                    $pdf->Ln(5);
                    $pdf->SetFont('Arial', '', 14);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->Cell(0, 10, utf8_decode("En relación a la duración"), 0, 1, 'C', false);
                    //se crea la grafica

                    $fechaInicio = strtotime($proyecto->pro_fecha_inicio);
                    $parar = false;

                    //se suman dias de uno en uno hasta llegar a la fecha actual
                    //el numeri de dias que quede seran los dias transcurridos del proyecto
                    $dias = 0;
                    while (!$parar) {
                        $dias++;
                        if (strtotime("+$dias day", $fechaInicio) == strtotime(date("Y-m-d"))) {
                            $parar = true;
                        }
                    }

                    //se pasa el tiempo transcurrido a meses
                    $transcurrido = $dias / 30;

                    //se pasan los datos al array que los lleva a la grafica
                    $datay = array($proyecto->pro_duracion, $transcurrido);


                    // Create the graph. These two calls are always required
                    $graph = new Graph(450, 250, 'auto');
                    $graph->SetScale("textlin");

                    //$theme_class="DefaultTheme";
                    //$graph->SetTheme(new $theme_class());

                    $meses = array();
                    //$interMeses = array();
                    //se carga en un array(meses) los numeros del 1 a la duracion del proyecto
                    //datos que se muestran como etiquetas a la izquierda del grafico
                    for ($i = 1; $i <= $proyecto->pro_duracion; $i++) {
                        $meses[] = $i;
                    }
                    // set major and minor tick positions manually
                    $graph->yaxis->SetTickPositions($meses);
                    $graph->SetBox(false);

                    //labels de las barras y lado izquierdo de la grafica (meses)
                    //$graph->ygrid->SetColor('orange');//color de los bordes de de las filas del fonfo
                    $graph->ygrid->SetFill(false);//pintar o no las filas de atras
                    $graph->xaxis->SetTickLabels(array('Duración', 'Transcurrido'));
                    $graph->yaxis->HideLine(false);//FALSE-> pinta la linea vertical izquierda del grafico ... TRUE-> lo contrario
                    $graph->yaxis->HideTicks(false, false);
                    $graph->yaxis->title->set('Meses');//texto que aparece como info en la parte izquierda de la grafica

                    // Create the bar plots
                    $b1plot = new BarPlot($datay);

                    // ...and add it to the graPH
                    $graph->Add($b1plot);


                    $b1plot->SetColor("#ff6600");//color del borde de las barras
                    $b1plot->SetFillColor('#FFF');//collor de relleno de las barras
                    //$b1plot->SetFillGradient("#4B80A9","#FFF",GRAD_DIAGONAL);//degradado para el fondo de las barras
                    $b1plot->SetWidth(40);//ancho de las barras

                    // Display the graph
                    $graph->Stroke('grafica1.png');


                    //...........................


                    /*se carga la imagen recien creada en el pdf y posteriormente se elimina*/
                    $pdf->Image("grafica1.png", 30, null, 150, 80);
                    unlink('grafica1.png');

                    //DESARROLLO DE COMPONENTES
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', 'B', 16);
                    $pdf->SetFillColor(255, 102, 0);
                    $pdf->SetTextColor(237, 237, 237);
                    $pdf->SetLeftMargin(20);
                    $pdf->SetRightMargin(20);
                    $pdf->Cell(0, 15, utf8_decode("Desarrollo de componentes"), 0, 1, 'C', true);

                    //se consultan los compoenntes del proyecto
                    $componentes = $proyecto->proyectoInvestigativo->componentes;

                    if (!$componentes) {
                        $pdf->Ln(10);
                        $pdf->SetFont('Arial', '', 11);
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->Cell(0, 10, utf8_decode("No se encontraron componentes relacionados con este proyecto"), 0, 1, 'C', false);
                    } else {
                        $pdf->Ln(5);
                        $pdf->SetFont('Arial', '', 14);
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->Cell(0, 10, utf8_decode("General"), 0, 1, 'C', false);

                        $cantidadComponentes = 0;
                        foreach($componentes as $componente){
                            if($componente->com_estado != "delete"){
                                $cantidadComponentes++;
                            }
                        }
                        //numero total de componentes del proyecto
                        $pdf->SetFont('Arial', '', 12);
                        $pdf->Cell(32, 10, 'Componentes', 1, 0, 'L', false);
                        $pdf->Cell(10, 10, $cantidadComponentes, 1, 0, 'C', false);

                        $terminados = 0;
                        $noTerminados = 0;

                        //se cuentan cuantos componentes estan terminados y cuantos no
                        foreach ($componentes as $componente) {
                            if ($componente->com_estado == "terminado") {
                                $terminados++;
                            } else {
                                $noTerminados++;
                            }
                        }

                        //componentes terminados
                        $pdf->SetFont('Arial', '', 12);
                        $pdf->Cell(52, 10, 'Componentes terminados', 1, 0, 'L', false);
                        $pdf->Cell(10, 10, $terminados, 1, 0, 'C', false);

                        //componentes no terminados
                        $pdf->SetFont('Arial', '', 12);
                        $pdf->Cell(62, 10, 'Componentes NO terminados', 1, 0, 'L', false);
                        $pdf->Cell(10, 10, $noTerminados, 1, 0, 'C', false);


                        //tabla con la informacion de cada uno de los componentes
                        $pdf->Ln(20);
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->Cell(43, 10, '#', 1, 0, 'C', false);
                        $pdf->Cell(83, 10, 'Nombre', 1, 0, 'C', false);
                        $pdf->Cell(25, 10, 'Equivalente', 1, 0, 'C', false);
                        $pdf->Cell(25, 10, 'Desarrollo', 1, 0, 'C', false);


                        $num = 0;//variable que controla el numero del componente


                        $pdf->SetWidths(Array(43, 83, 25, 25));
                        $pdf->SetAligns(Array("C", "C", "C", "C"));
                        //por cada componente se agrega una fila a la tabla
                        foreach ($componentes as $componente) {
                            $num++;
                            if($num == 1)
                            $pdf->Ln();
                            /*$pdf->SetFont('Arial', '', 10);
                            $pdf->Cell(40, 7, 'Componente ' . $num, 1, 0, 'C', false);
                            $pdf->Cell(80, 7, utf8_decode($componente->com_nombre), 1, 0, 'C', false);
                                $pdf->Cell(25, 7, $componente->com_equivalente . '%', 1, 0, 'C', false);
                            $pdf->Cell(25, 7, $componente->porcentajeDesarrolladoComponente() . '%', 1, 0, 'C', false);*/

                            $datos = Array('Componente ' . $num, utf8_decode($componente->com_nombre),$componente->com_equivalente . '%',$componente->porcentajeDesarrolladoComponente() . '%');
                            $pdf->Row($datos, Array('R', 'L'), 1);

                        }


                        //arrays para el grafico
                        $data1y = array();
                        $data2y = array();

                        //por cada commponente se busca su equivalente y porcentaje desarrollado
                        //y se agregan a los array que se envian para cargarlos en la grafica
                        foreach ($componentes as $componente) {
                            $data1y[] = $componente->com_equivalente;
                            $data2y[] = $componente->porcentajeDesarrolladoComponente();
                        }

                        // Create the graph. These two calls are always required
                        $graph = new Graph (350, 200, 'auto');
                        $graph->SetScale("textlin");

                        $theme_class = new UniversalTheme;
                        $graph->SetTheme($theme_class);

                        //porcentajes que se muestran como eqiquetas a la izquierda del grafic
                        //se ponen de una ves del 10 al 100 por que onligatoriamente la suma de los equivalentes debe ser 100
                        $porcentaje = array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100);

                        $graph->yaxis->SetTickPositions($porcentaje);
                        $graph->SetBox(false);


                        //se asignan nombres para cada grupo de datos
                        $componentesNombre = array();
                        $num = 0;
                        foreach ($componentes as $componente) {
                            $num++;
                            $componentesNombre[] = 'Comp ' . $num;
                        }

                        //se agregan las etiquetas que se relaccionan con las barras a la izquierda como abajo(los nombres de acada grupo)
                        $graph->ygrid->SetFill(false);
                        $graph->xaxis->SetTickLabels($componentesNombre);
                        $graph->yaxis->HideLine(false);
                        $graph->yaxis->HideTicks(false, false);
                        $graph->yaxis->title->set("Porcentaje");


                        // Create the bar plots
                        $b1plot = new BarPlot ($data1y);
                        $b2plot = new BarPlot ($data2y);

                        //se agregan los anchos de las barras y leyendas que identifican a cada uno de los tipos de barra
                        $b1plot->SetWidth(25);
                        $b2plot->SetWidth(25);
                        $b1plot->SetLegend('Equivalente/Desarrollo');
                        //$b2plot->SetLegend('Desarrollo');
                        $graph->legend->SetFillColor('#ededed');
                        $graph->legend->Pos(0.2, 0.9);

                        //se agrupan los datos para que cada dos barras pertenescan la información de un componente(equivalente,desarrollo)
                        // Create the grouped bar plot
                        $gbplot = new GroupBarPlot (array($b1plot, $b2plot));
                        // ...and add it to the graPH
                        $graph->Add($gbplot);


                        //se asignan los colores a cada tipo de barra
                        $b1plot->SetColor("#669900");
                        $b1plot->SetFillColor("#FFF");

                        $b2plot->SetColor("#ff6600");
                        $b2plot->SetFillColor("#FFF");

                        // se guarda la imagen
                        // Display the graph
                        $graph->Stroke('grafica2.png');

                        //se muestra la grafica en el pdf y se elimina despues
                        $pdf->Ln(15);
                        $pdf->Image("grafica2.png", 30, null, 150, 80);
                        unlink('grafica2.png');


                        $pdf->Ln(5);
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(10, 5, 'Nota: ', 0, 0, 'C', false);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(0, 5, 'El equivalente corresponde al porcentaje del proyecto que representa un componente, y el desarrollo', 0, 1, 'C', false);
                        $pdf->Cell(0, 5, ' es el porcentaje desarrollado de dicho componente', 0, 1, 'C', false);


                        //por cada uno de los componentes se debe crear una grafica si los datos del componente se pueden mostrar
                        $numC = 0;//numero de componente
                        foreach ($componentes as $componente) {
                            $numC++;
                            $pdf->SetLeftMargin(10);
                            $pdf->SetRightMargin(10);
                            $pdf->AddPage();

                            $pdf->SetFont('Arial', 'B', 16);
                            $pdf->SetFillColor(255, 102, 0);
                            $pdf->SetTextColor(237, 237, 237);
                            $pdf->SetLeftMargin(20);
                            $pdf->SetRightMargin(20);
                            $pdf->Cell(0, 15, utf8_decode("    Componente " . $numC), 0, 0, 'L', true);
                            $pdf->Ln();
                            $pdf->SetTextColor(0, 0, 0);

                            //datos del componente
                            $pdf->SetFont('Arial', '', 10);
                            $pdf->SetWidths(Array(50, 126));
                            $datos = Array(utf8_decode("Nombre "), utf8_decode($componente->com_nombre));
                            $pdf->Row($datos, Array('R', 'L'), 1);
                            $datos = Array(utf8_decode("Objetivo "), utf8_decode($componente->com_objetivo));
                            $pdf->Row($datos, Array('R', 'L'), 1);
                            $datos = Array(utf8_decode("Equivalente "), $componente->com_equivalente . '%');
                            $pdf->Row($datos, Array('R', 'L'), 1);


                            //se busca y muestra la información de las catividades relacionadas con este componente
                            $datos = $componente->actividadesEstado();

                            $datos = explode(',', $datos);
                            $actDesarrolladas = $datos[0];
                            $actNoDesarrolladas = $datos[1];
                            $pdf->Ln();
                            $pdf->Cell(32, 7, 'Actividades', 1, 0, 'C');
                            $pdf->Cell(20, 7, ($actDesarrolladas + $actNoDesarrolladas), 1, 0, 'C');
                            $pdf->Cell(42, 7, 'Desarrolladas', 1, 0, 'C');
                            $pdf->Cell(20, 7, $actDesarrolladas, 1, 0, 'C');
                            $pdf->Cell(42, 7, 'No desarrolladas', 1, 0, 'C');
                            $pdf->Cell(20, 7, $actNoDesarrolladas, 1, 0, 'C');


                            //se buscan todas las actividades de el componente
                            $actividades = $componente->actividades;
                            $data1y = array();
                            $data2y = array();

                            $mayor = 0;//el mayor dato en mostrarse, si este dato al final es 0 no se puede mostrar la grafica

                            foreach ($actividades as $actividad) {
                                if($actividad->act_estado != "delete") {
                                    $porcentajeDesarrollado = 0;
                                    $porcentajeTiempoTranscurrido = 0;

                                    $porcentajeDesarrollado = $actividad->porcentajeActividadDesarrollado();

                                    $porcentajeTiempoTranscurrido = $actividad->calcularPorcentajeTiempoTranscurrido();


                                    if ($porcentajeDesarrollado > $mayor) {
                                        $mayor = $porcentajeDesarrollado;
                                    }

                                    if ($porcentajeTiempoTranscurrido > $mayor) {
                                        $mayor = $porcentajeTiempoTranscurrido;
                                    }

                                    $data1y[] = $porcentajeDesarrollado;
                                    $data2y[] = $porcentajeTiempoTranscurrido;
                                }
                            }

                            if ($mayor > 0) {
                                // Create the graph. These two calls are always required
                                $graph = new Graph (350, 200, 'auto');
                                $graph->SetScale("textlin");

                                $theme_class = new UniversalTheme;
                                $graph->SetTheme($theme_class);


                                $porcentaje = array();
                                for ($i = 1; $i < 11; $i++) {
                                    $medida = $mayor * ($i * 0.1);
                                    $porcentaje[] = $medida;
                                }

                                $graph->yaxis->SetTickPositions($porcentaje);
                                $graph->SetBox(false);

                                $actividadesNombre = array();
                                $num = 0;
                                foreach ($actividades as $actividad) {
                                    if($actividad->act_estado != "delete") {
                                        $num++;
                                        $actividadesNombre[] = 'Act ' . $num;
                                    }
                                }

                                $graph->ygrid->SetFill(false);
                                $graph->xaxis->SetTickLabels($actividadesNombre);
                                $graph->yaxis->HideLine(false);
                                $graph->yaxis->HideTicks(false, false);
                                $graph->yaxis->title->set("Porcentaje");


                                // Create the bar plots
                                $b1plot = new BarPlot ($data1y);
                                $b2plot = new BarPlot ($data2y);

                                $b1plot->SetWidth(25);

                                $b2plot->SetWidth(25);
                                $b1plot->SetLegend('Desarrollo/Tiempo transcurrido');

                                $graph->legend->SetFillColor('#ededed');
                                $graph->legend->Pos(0.2, 0.9);

                                // Create the grouped bar plot
                                $gbplot = new GroupBarPlot (array($b1plot, $b2plot));
                                // ...and add it to the graPH
                                $graph->Add($gbplot);


                                $b1plot->SetColor("#ff6600");
                                $b1plot->SetFillColor("#FFF");

                                $b2plot->SetColor("#669900");
                                $b2plot->SetFillColor("#FFF");


                                // Display the graph
                                $nombre = 'graficaComponente' . $numC . '.png';
                                $graph->Stroke($nombre);
                                $pdf->Ln(15);
                                $pdf->Image($nombre, 30, null, 150, 80);
                                unlink($nombre);
                            } else {
                                $pdf->Ln(15);
                                $pdf->SetFont('Arial', '', 14);
                                $pdf->Cell(0, 5, 'El porcentaje de desarrollo y tiempo transcurrido de las actividades de', 0, 1, 'C');
                                $pdf->Cell(0, 5, utf8_decode('este componente es 0%, esto hace imposible realizar el gráfico.'), 0, 1, 'C');
                            }
                        }
                    }
                }
            }

            $pdf->Output("","reposte_grafico_".$proyecto->pro_titulo.".pdf");
            exit;
        }
        /*for ($i = 0; $i < 100; $i++) {
           $pdf->Cell(100,20,"Dato No.".$i,0,1);
        }*/
    }
}
?>