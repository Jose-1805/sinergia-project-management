<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\GDPSubserie;
use App\Models\GDPProyectosubserie;
use App\Models\GDPLog;
use App\Models\GDPElementos;
use App\Models\GDPLogproyectosubserie;
use App\Http\Requests\GDPproyectosubserieRequest;
use App\Models\Proyecto;
use App\Models\GDPTipoDocumento;
use App\Models\GDPDocumento;
use App\Models\SubSerieTipoDocumeto;
use Illuminate\Support\Facades\Crypt;
use App\Http\Middleware\AutenticacionAdminv;
use App\Http\Middleware\AutenticacionInv;
use PhpSpec\Exception\Exception;

class GDPproyectosubserieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //Consulta Todos  los datos proyectosubserie, el nombre de la sub serie y el nombre del proyecto en el cual se encuentran asociados.
        if(Session::has("idPersona"))
        {
                $rol = "";
                if(Session::get('rol actual') == "administrador investigativo"){
                $rol = "adminv";
                $gdpps = DB::table('proyectosubserie')
                    ->join('subserie', 'proyectosubserie.id_subserie', '=', 'subserie.id')
                    ->join('proyecto', 'proyectosubserie.id_proyecto', '=', 'proyecto.id')
                    ->select('proyectosubserie.*', 'subserie.sub_nombre', 'proyecto.pro_titulo')
                    ->get();
                // Envía a la vista principal del módulo  la   variable que contiene el nombre de la plantilla  y la consulta ejecutada anterior mente.
                     return view("roles.adminv.modulos.GDP.index")->with("prosub", "index")->with('gdpps', $gdpps);
                }
                    //AJUSTAR CONSULTA PARA INVESTIGADOR
                    else if (Session::get('rol actual') == "investigador"){

                        $gdpps = DB::table('proyectoinvestigativo')
                            ->join('proyecto', 'proyecto.id', '=', 'proyectoinvestigativo.proyecto_id')
                            ->join('investigador', 'investigador.id', '=', 'proyectoinvestigativo.investigador_id')
                            ->join('proyectosubserie', 'proyectosubserie.id_proyecto', '=', 'proyecto.id')
                            ->join('subserie', 'subserie.id', '=', 'proyectosubserie.id_subserie')
                            ->join('persona', 'persona.id', '=', 'investigador.persona_id')
                            ->select('proyecto.pro_titulo','subserie.sub_nombre','proyectosubserie.*')
                            ->where('persona.id','=',12)
                            ->get();



                        // Envía a la vista principal del módulo  la   variable que contiene el nombre de la plantilla  y la consulta ejecutada anterior mente.
                        return view("roles.inv.modulos.GDP.index")->with("miprosub", "index")->with('gdpps', $gdpps);
                    }
        return redirect("/");
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // consulta los datos de las sub series documentales
        $subserie = GDPSubserie::all();

        /*Esta consulta retorna  toda la información de los proyectos  en el cual no se encuentran asociados  en la tabla proyectosubserie
         y que cumplan  con los diferentes estados del proyecto: proyecto terminado, proyecto en desarrollo, proyecto aprobado*/
        $proyectos = Proyecto::select("proyecto.*")
            ->leftJoin("proyectosubserie", "proyecto.id", "=", "proyectosubserie.id_proyecto")->whereNull("proyectosubserie.id_proyecto")
            ->where(function ($q) {
                $q->where("proyecto.pro_estado", "proyecto terminado")
                    ->orWhere("proyecto.pro_estado", "proyecto en desarrollo")
                    ->orWhere("proyecto.pro_estado", "proyecto aprobado");
            })
            ->get();
        // Envía a la vista principal del módulo  la   variable que contiene el nombre de la plantilla  y las consultas ejecutadas anterior mente.

        return view("roles.adminv.modulos.GDP.index")->with("prosub", "frmproyectosubserie")
            ->with("subserie", $subserie)
            ->with("proyecto", $proyectos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store(GDPproyectosubserieRequest $request)
    {


        /*
La tabla elementes  es  donde estan todos los registros  para generar la estructura de carpetas  en el cual tienen estos atributos
-id=auto incremental de la tabla.
-order= consecutivo    que se genera  solo a las   carpetas que son sub series y proyectos.
- parend_id=  hace referencia  cual es la carpeta padre  con el id de algún registro de la tabla elementos.
-label= es la parte del texto que se muestra en la estructura de carpetas.
- have_childrens= hace referencia si la carpeta tiene carpetas hijas.
- references_id=en este campo solo se llenara si el registro que se está realizando  pertenece a la asociación entre la sub serie y el proyecto. En el cual se colocara el id de proyecto sub serie nuevo.
En el caso de que se esté realizando un nuevo requerimiento de agregar sub series estas se deben agregar en la tabla elementos con references_id=0;
Nota la tabla elementos no está relacionada  con ninguna tabla.
Las carpetas que se generan que  pertenecen  a los tipos documentales de cada sub serie están en  otra tabla denominada  subserietipodocumeto.
*/

        if (AutenticacionAdminv::check() || AutenticacionInv::check()) {
            try {
                DB::beginTransaction();
                // gUARDA La Asociacion de el proyecto con su subserie en la BD
                $id_proyecto = Crypt::decrypt($request->id_proyecto);
                $id_subserie = Crypt::decrypt($request->id_subserie);
                $gdpps = new GDPProyectosubserie();
                $gdpps->id_proyecto = $id_proyecto;
                $gdpps->id_subserie = $id_subserie;
                $gdpps->prosub_estado = "activa";
                $gdpps->save();
                $idprosub = $gdpps->id;

                // GUARDA eL NUEVO REGISTRO EN log en la BD

                $idpersona = Session::get("idPersona");
                $rolactual = Session::get("rol actual");
                $fechaactual = date('Y-m-d g:ia');

                $Log = new GDPLog();
                $Log->log_accion = "Registro";
                $Log->persona_id = $idpersona;
                $Log->log_rol = $rolactual;
                $Log->log_fecha = $fechaactual;
                $Log->save();


                $idlog = $Log->id;

                $Logprosub = new GDPLogproyectosubserie();
                $Logprosub->proyectosubserie_id = $idprosub;
                $Logprosub->log_id = $idlog;
                $Logprosub->save();


                // genera un registro donde se almacena en la tabla elementos

                $proyectonom = Proyecto::where("id", $id_proyecto)->first();

                $parenelemid = GDPElementos::join('subserie', 'subserie.sub_nombre', '=', 'elementos.label')->where('subserie.id', $id_subserie)->first();
                $elemtos = GDPElementos::find($parenelemid->id);
                $elemtos->have_childrens = 1;
                $elemtos->save();


                $carpetas = new GDPElementos();
                $order = $carpetas->Lastorder() + 1;
                $carpetas->order = $order;
                $carpetas->parent_id = $parenelemid->id;
                $carpetas->label = $proyectonom->pro_titulo;
                $carpetas->have_childrens = 0;
                $carpetas->references_id = $gdpps->id;
                $carpetas->save();

                ///////////////////////////////////////////////////////////////////
                // genera los directorios de lado servidor de cada proyecto que se asocie  con sus respectivos tipos documentales segun su subserie.
                $path = public_path() . '/Documentos/Proyectos/';
                $proyect = 'proyect' . $idprosub;
                if (mkdir($path . $proyect)) {
                    $tiposdocumentosxsubserie = SubSerieTipoDocumeto::TiposdocumentosXsubserie($id_subserie);
                    $path = $path . $proyect;
                    foreach ($tiposdocumentosxsubserie as $tipodoc) {
                        mkdir($path . '/tipodoc' . $tipodoc->tipodocumento_id);
                    }
                }
                DB::commit();
                return 1;
            } catch (Exception $ex) {
                DB::rollback();
                return $ex;
            }

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
  /*  public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $proyectosubserie = DB::table('proyectosubserie')
            ->join('subserie', 'proyectosubserie.id_subserie', '=', 'subserie.id')
            ->join('proyecto', 'proyectosubserie.id_proyecto', '=', 'proyecto.id')
            ->where('proyectosubserie.id', '=', $id)
            ->select('proyectosubserie.*', 'subserie.sub_nombre', 'proyecto.pro_titulo')
            ->first();
        $editsubserie = GDPSubserie::all();
        $editproyecto = Proyecto::select("proyecto.*")
            ->leftJoin("proyectosubserie", "proyecto.id", "=", "proyectosubserie.id_proyecto")->whereNull("proyectosubserie.id_proyecto")
            ->where(function ($q) {
                $q->where("proyecto.pro_estado", "proyecto terminado")
                    ->orWhere("proyecto.pro_estado", "proyecto en desarrollo")
                    ->orWhere("proyecto.pro_estado", "proyecto aprobado");
            })
            ->get();
        return view("roles.adminv.modulos.GDP.index")
            ->with("prosub", "editarproyectosubserie")
            ->with('proyectosubserie', $proyectosubserie)
            ->with('editsubserie', $editsubserie)
            ->with('editproyecto', $editproyecto);

    }*/

    public function  ProyectoMostrardocumentos(Request $request)
    {
        if(Session::get('rol actual') == "administrador investigativo"){
            // consulta los documentos segun el id del tipo de documento y el proyecto subserie
            $documentos = GDPDocumento::where('tipodocumento_id', $request->idtipodoc)->where('proyectosubserie_id', $request->idprosubserie)->get();
            // se genera un stdclas que contendran el idprosubserie y idtipodoc  se convierten en json y se encripta y se envia segun el condicional
            $idprosub = $request->idprosubserie;
            $idtipodoc = $request->idtipodoc;
            $datos2 = new \stdClass();
            $datos2->idprosub = $idprosub;
            $datos2->idtipodoc = $idtipodoc;
            $datos2 = json_encode($datos2);
            $datos2 = Crypt::encrypt($datos2);
            if ($documentos->count() > 0){
                return response()->json(view('roles.adminv.modulos.GDP.plantillas.documentos.documentosXtipodoc', compact("documentos","datos2"))->render());
            } else {
                $datos = new \stdClass();
                $nemproyect = GDPProyectosubserie::join('proyecto', 'proyectosubserie.id_proyecto', '=', 'proyecto.id')
                    ->where("proyectosubserie.id", $request->idprosubserie)->select('proyecto.pro_titulo')->first();
                $nemtipodoc = GDPTipoDocumento::find($request->idtipodoc);
                $datos->nameproyecto = $nemproyect->pro_titulo;
                $datos->nametipodoc = $nemtipodoc->tido_nombre;
                return response()->json(view('roles.adminv.modulos.GDP.plantillas.documentos.NotFoundDocument', compact("datos", "datos2"))->render());
            }
        }elseif(Session::get('rol actual') == "investigador"){
            // CONSULTA DOCS DEL INVESTIGADOR segun el id del tipo de documento y el proyecto subserie
            $documentos = GDPDocumento::where('tipodocumento_id', $request->idtipodoc)->where('proyectosubserie_id', $request->idprosubserie)->get();
            // se genera un stdclas que contendran el idprosubserie y idtipodoc  se convierten en json y se encripta y se envia segun el condicional
            $idprosub = $request->idprosubserie;
            $idtipodoc = $request->idtipodoc;
            $datos2 = new \stdClass();
            $datos2->idprosub = $idprosub;
            $datos2->idtipodoc = $idtipodoc;
            $datos2 = json_encode($datos2);
            $datos2 = Crypt::encrypt($datos2);
            if ($documentos->count() > 0){
                return response()->json(view('roles.inv.modulos.GDP.misPlatillas.misdocumentos.documentosXtipodoc', compact("documentos","datos2"))->render());
            } else {
                $datos = new \stdClass();
                $nemproyect = GDPProyectosubserie::join('proyecto', 'proyectosubserie.id_proyecto', '=', 'proyecto.id')
                    ->where("proyectosubserie.id", $request->idprosubserie)->select('proyecto.pro_titulo')->first();
                $nemtipodoc = GDPTipoDocumento::find($request->idtipodoc);
                $datos->nameproyecto = $nemproyect->pro_titulo;
                $datos->nametipodoc = $nemtipodoc->tido_nombre;
                return response()->json(view('roles.inv.modulos.GDP.misPlatillas.misdocumentos.NotFoundDocument', compact("datos", "datos2"))->render());
            }
        }


    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function ContenidoProyectos($datos)
    {
        $idproyectosubserie = Crypt::decrypt($datos);
   //consulta los datos del proyecto subserie y del proyecto  segun el id del proyectosubserie
        $proyectosubserie = GDPProyectosubserie::join("proyecto", "proyecto.id", "=", "proyectosubserie.id_proyecto")
            ->select("proyectosubserie.*", "proyecto.pro_titulo")
            ->where("proyectosubserie.id", $idproyectosubserie)->first();
//consulta los tipos documentales segun la subserie que esta asociado el proyectosubserie
        $subserietiposdocumentos = DB::table('subserietipodocumeto')
            ->join('tipodocumento', 'tipodocumento.id', '=', 'subserietipodocumeto.tipodocumento_id')
            ->where("subserietipodocumeto.subserie_id", $proyectosubserie->id_subserie)
            ->where("estado","activa")
            ->select('subserietipodocumeto.*', 'tipodocumento.*')->orderBy('subserie_id', 'ASC')
            ->get();
        if(Session::get('rol actual') == "administrador investigativo"){
            // envia los datos del proyecto subserie y los tipos documentales a la vista contenidoproyecto
            return view("roles.adminv.modulos.GDP.index")
                ->with("prosub", "contenidoproyecto")
                ->with('subserietiposdocumentos', $subserietiposdocumentos)
                ->with('proyecto', $proyectosubserie);

        }elseif(Session::get('rol actual') == "investigador"){
            return view("roles.inv.modulos.GDP.index")
                ->with("miprosub", "contenidoproyecto")
                ->with('subserietiposdocumentos', $subserietiposdocumentos)
                ->with('proyecto', $proyectosubserie);
        }

    }


   /* public function update(GDPproyectosubserieRequest $request, $id)
    {
        Session::flash("msjgdp", "Proyecto asociado actualizado.");
        return redirect()->route('GDP.proyectosubserie.index');
        /////////por definer
        //dd($request->all());
    }
*/
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
