<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\GDPProyectosubserie;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\GDPDocumentoRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\GDPTipoDocumento;
use App\Models\GDPDocumento;
use App\Models\GDPConsecutivodocumental;
use App\Models\GDPLog;
use App\Models\Tree;
use App\Models\GDPRadicado;
use App\Models\SubSerieTipoDocumeto;
use App\Models\GDPLogdocumento;
use App\Models\GDPLogAlerta;
use App\Models\GDPAlerta;
use App\Models\Persona;

use Illuminate\Http\Response;


class GDPDocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //consulta todos los registros de la asociación  de los tipos documentales con su respectiva sub-serie
        $subserietiposdocumentos = DB::table('subserietipodocumeto')
            ->join('tipodocumento', 'tipodocumento.id', '=', 'subserietipodocumeto.tipodocumento_id')
            ->where("estado", "activa")
            ->select('subserietipodocumeto.*', 'tipodocumento.*')->orderBy('subserie_id', 'ASC')
            ->get();
       //Genera los arreglos que contendrán los tipos documentales según su subserie.
        $_elementiposdocumetos = array();
        $_elementiposdocumetos["DEP"] = $_elementiposdocumetos["IA"] = $_elementiposdocumetos["DIT"] = $_elementiposdocumetos["SL"] = array();
        foreach ($subserietiposdocumentos as $element) {
            if ($element->subserie_id == 1) {
                array_push($_elementiposdocumetos["DEP"], $element);/// Diseño y elaboración de prototipos
            } else {
                if ($element->subserie_id == 2) { //investigación aplicada
                    array_push($_elementiposdocumetos["IA"], $element);
                } else {
                    if ($element->subserie_id == 3) {
                        array_push($_elementiposdocumetos["DIT"], $element); //Divulgacion e informacion tecnologica
                    } else {
                        if ($element->subserie_id == 4) {
                            array_push($_elementiposdocumetos["SL"], $element);// servicios de laboratorio
                        }
                    }
                }
            }
        }
        $tree = new Tree();
        $elements = $tree->get();
        $masters = $elements["masters"];
        $childrens = $elements["childrens"];
        // envia los tipos documentales segun su subserie, los elementos (carpetas master e childrens )  a la vista index de la carpeta documentos
        return view("roles.adminv.modulos.GDP.index")->with("documento", "index")->with("masters", $masters)->with("childrens", $childrens)
            ->with('_elementiposdocumetos', $_elementiposdocumetos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        $tiposdocumentos = GDPTipoDocumento::orderBy('id', 'ASC')->get();
        return view("roles.adminv.modulos.GDP.index")->with("documento", "frmcreatedocumento")->with("tiposdocumentos", $tiposdocumentos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {//los return en negativo representan errores
        try {
            DB::beginTransaction();
            //----------------------------------------------------------
            //validación metadatos del documento
            //----------------------------------------------------------
            $noexistedocumento = false;
            $errorextension = false;
            $errortamanio = false;
            $documentofile = $request->file('documento');
            $extefile = strtolower($documentofile->getClientOriginalExtension());
            if ($request->hasFile('documento')) {
                if ($extefile == 'pdf') {
                    if ($documentofile->getClientSize() <= 4000000) {
                    } else {
                        $errortamanio = true;
                        return "-3";
                    }
                } else {
                    $errorextension = true;
                    return "-2";
                }
            } else {
                $noexistedocumento = true;
                return "-1";
            }
            //----------------------------------------------------------
            //----------------------------------------------------------
            if (!$noexistedocumento && !$errorextension && !$errortamanio) {
                //----------------------------------------------------------
                // este cogido es para generar el consecutivo a un documento
                // y actualizarlo en la tabla consecutivodocumental
                //----------------------------------------------------------
                $consecutivodocumental = "";
                $nombrearchivo = "";
                $idtipodocumento = Crypt::decrypt($request->idtipodoc);
                $tipodocconse = GDPConsecutivodocumental::join('tipodocumento', 'tipodocumento.id', '=', 'consecutivodocumental.tipodocumento_id')
                    ->where('tipodocumento_id', $idtipodocumento)
                    ->select('tipodocumento.tido_nombre', 'tipodocumento.tido_codigo', 'consecutivodocumental.codo_consecutivo', 'consecutivodocumental.id')->first();
                $datos = new \stdClass();
                $datos->tipodocconse = $tipodocconse;
                $codconse = $datos->tipodocconse->codo_consecutivo + 1;
                $consecutivodocumental = $datos->tipodocconse->tido_nombre . " " . $codconse;
                $conse = GDPConsecutivodocumental::find($datos->tipodocconse->id);
                $conse->codo_consecutivo = $codconse;
                $conse->save();
                //----------------------------------------------------------
                //  Nombre del Documento
                //----------------------------------------------------------
                $nombrearchivo = "";
                $arrayN = explode('.', $documentofile->getClientOriginalName());
                $ext = $arrayN[count($arrayN) - 1];
                $ultimo = count($arrayN);
                $nombre = $arrayN[count($arrayN) - $ultimo];
                $nombrearchivo = $nombre . '-' . time() . '.' . $ext;
                //----------------------------------------------------------
                // Generar el codigo del documento:radicado y agrega el registro
                // en la tabla radicados
                //----------------------------------------------------------
                $radicado = new GDPRadicado();
                $numradicado = "";
                $codigo_tipodoc = "";
                $lastradicado = $radicado->Lastradicado();
                $longitudcadena = "000000";
                $añobd = (int)$lastradicado->ra_anio;
                $añoactual = (int)date('Y');
                if ($añobd == $añoactual) {
                    $numradicado = $lastradicado->ra_numradicado;
                } else {
                    if ($añobd < $añoactual) {
                        $numradicado = $longitudcadena;
                    }
                }
                $numradicado = (int)$numradicado;
                $numradicado = $numradicado + 1;
                $diferencia = strlen($longitudcadena) - strlen($numradicado);
                for ($i = 0; $i < $diferencia; $i++) {
                    $codigo_tipodoc = $codigo_tipodoc . $longitudcadena[$i];
                }

                $añoactual = (string)$añoactual;
                $ra_numradicado = $codigo_tipodoc . $numradicado;
                $radicado->ra_anio = $añoactual;
                $radicado->ra_numradicado = $ra_numradicado;
                $radicado->save();
                //----------------------------------------------------------
                // guardar documento en BD
                //----------------------------------------------------------
                $codigo = $añoactual . "-" . $codigo_tipodoc . $numradicado;
                $documento = new GDPDocumento();
                $documento->doc_objetivo = $request->doc_objetivo;
                $documento->doc_descripcion = $request->doc_descripcion;
                $documento->doc_fechacreacion = $request->doc_fechacreacion;
                $documento->doc_estado = "activo";
                $documento->tipodocumento_id = $idtipodocumento;
                $documento->doc_asunto = $request->doc_asunto;
                $documento->doc_consecutivo = $consecutivodocumental;
                $documento->proyectosubserie_id = Crypt::decrypt($request->idprosub);
                $documento->doc_nombrearchivo = $nombrearchivo;
                $documento->doc_codigo = $codigo;
                $documento->save();

                //-----------------------------------------------------
                // guardar el historial del documento en BD
                //-----------------------------------------------------
                $idpersona = Session::get("idPersona");
                $rolactual = Session::get("rol actual");
                $fechaactual = date('Y-m-d g:ia');

                $Log = new GDPLog();
                $Log->log_accion = "Registro";
                $Log->persona_id = $idpersona;
                $Log->log_rol = $rolactual;
                $Log->log_fecha = $fechaactual;
                $Log->save();

                $logdocumento = new GDPLogdocumento();
                $logdocumento->documento_id = $documento->id;
                $logdocumento->log_id = $Log->id;
                $logdocumento->save();
                //-----------------------------------------------------
                //proceso para generar las alertas
                //
                //-----------------------------------------------------
                $existealetas = $request->aler_compromiso;
                $existealetas[0];
                if ($existealetas[0] !== "") {
                    $fechasinicio = $request->doc_fechacreacion;
                    $fechasfin = $request->aler_fechafin;
                    $compromisos = $request->aler_compromiso;
                    $responsables = $request->aler_responsable;
                    $documentoid = $documento->id;

                    for ($i = 0; $i < count($compromisos); $i++) {
                        $alertaobj = new GDPAlerta();
                        $alertaobj->aler_fechainicio = $fechasinicio;
                        $alertaobj->aler_fechafin = $fechasfin[$i];
                        $alertaobj->aler_compromiso = $compromisos[$i];
                        $alertaobj->aler_responsable = Crypt::decrypt($responsables[$i]);
                        $alertaobj->aler_estado = "Vigente";
                        $alertaobj->documento_id = $documentoid;
                        $alertaobj->save();
                        //-----------------------------------------------------
                        // guardar el historial de la alerta en BD
                        //-----------------------------------------------------
                        $idpersona = Session::get("idPersona");
                        $rolactual = Session::get("rol actual");
                        $fechaactual = date('Y-m-d g:ia');
                        $Log = new GDPLog();
                        $Log->log_accion = "Registro";
                        $Log->persona_id = $idpersona;
                        $Log->log_rol = $rolactual;
                        $Log->log_fecha = $fechaactual;
                        $Log->save();

                        $logalerta = new GDPLogAlerta();
                        $logalerta->alerta_id = $alertaobj->id;
                        $logalerta->log_id = $Log->id;
                        $logalerta->save();
                        //--
                        //--
                    }
                }
                //-----------------------------------------------------
                //-----------------------------------------------------
                //-----------------------------------------------------
                // guardar el documento de lado servidor
                $path = public_path() . '/Documentos/Proyectos/proyect' . Crypt::decrypt($request->idprosub) . '/tipodoc' . $idtipodocumento . '/';
                $documentofile->move($path,$documento->id.".pdf");
                //--
            }
            DB::commit();
            return '1';
        } catch (Exception $ex) {
            DB::rollback();
        }
    }

    public function MostrarDocumentos(Request $request)
    {
        //consulta los documentos segun el tipo documental y su proyectosubserie
        $documentos = GDPDocumento::where('tipodocumento_id', $request->idtipodoc)->where('proyectosubserie_id', $request->idprosubserie)->get();
        $idprosub = $request->idprosubserie;
        $idtipodoc = $request->idtipodoc;
        //se genera un stdclas para que almacene los datos
        $datos2 = new \stdClass();
        $datos2->idprosub = $idprosub;
        $datos2->idtipodoc = $idtipodoc;
        // el stdclass se convierte en json
        $datos2 = json_encode($datos2);
        // se encripta
        $datos2 = Crypt::encrypt($datos2);
        // dependiendo de la condición se e envia lo encriptado

        if ($documentos->count() > 0){

            return response()->json(view('roles.adminv.modulos.GDP.plantillas.documentos.documentosXtipodoc',compact("documentos", "datos2"))->render());
        } else {
            $datos = new \stdClass();
            $nemproyect = GDPProyectosubserie::join('proyecto', 'proyectosubserie.id_proyecto', '=', 'proyecto.id')
                ->where("proyectosubserie.id", $request->idprosubserie)->select('proyecto.pro_titulo')->first();
            $nemtipodoc = GDPTipoDocumento::find($request->idtipodoc);
            $datos->nameproyecto = $nemproyect->pro_titulo;
            $datos->nametipodoc = $nemtipodoc->tido_nombre;
            return response()->json(view('roles.adminv.modulos.GDP.plantillas.documentos.NotFoundDocument', compact("datos", "datos2"))->render());

        }
    }

    public  function  Verdocumento($datos)
    {
        $id = Crypt::decrypt($datos);
        //consulta el documento por id
        $documento=GDPDocumento::find($id);
        //envia los datos del documento a la vista mostrardocumentos
        if(Session::get('rol actual') == "administrador investigativo"){
            return view("roles.adminv.modulos.GDP.index")->with("documento", "mostrardocumento")->with("mostdocumento",$documento);
        } elseif(Session::get('rol actual') == "investigador"){
            return view("roles.inv.modulos.GDP.index")->with("misDocs", "mostrardocumento")->with("mostdocumento",$documento);
        }

    }

    /** FUNCIONES INVESTIGADOR */

    /** Ver informacion de sus documentos */
    public  function  Ver_doc_Inv($datos)
    {
        $id = Crypt::decrypt($datos);
        //consulta el documento por id
        $docInv=GDPDocumento::find($id);
        //envia los datos del documento a la vista mostrardocumentos
        return view("roles.inv.modulos.GDP.index")->with("documento", "mostrardocumento")->with("mostdocumento",$docInv);
    }

    /** FIN FUNCIONES INVESTIGADOR */

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($ids)
    {// consulta todas las persona para cuando se requiera para las alertas
        $personas = Persona::all();
        $ids = Crypt::decrypt($ids);
        $ids = json_decode($ids);
        if(Session::get('rol actual') == "administrador investigativo"){
            //$ids contiene los id de proyectosubserie y el tipo
            return view("roles.adminv.modulos.GDP.index")->with("documento", "frmcreatedocumento")->with("ids", $ids)->with("personas", $personas);
        }elseif(Session::get('rol actual') == "investigador"){
            return view("roles.inv.modulos.GDP.index")->with("misDocs", "frmcreatedocumento")->with("ids", $ids)->with("personas", $personas);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
        $iddocumento = Crypt::decrypt($id);
        $editdocumento = GDPDocumento::find($iddocumento);
        // Envía a la vista principal del módulo  la   variable que contiene el nombre de la plantilla  y la consulta ejecutada anterior mente.
        return view("roles.adminv.modulos.GDP.index")->with("documento", "frmeditDocumento")->with("editdocumento", $editdocumento);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            // guarda la actualizacion del documento
            $documento = GDPDocumento::find($id);
            $documento->fill($request->all());
            $documento->save();

            $idpersona = Session::get("idPersona");
            $rolactual = Session::get("rol actual");
            $fechaactual = date('Y-m-d g:ia');
            //-----------------------------------------------------
            // guardar el historial de la actualizacion documento en BD
            //-----------------------------------------------------
            $Log = new GDPLog();
            $Log->log_accion = "Actualizo";
            $Log->persona_id = $idpersona;
            $Log->log_rol = $rolactual;
            $Log->log_fecha = $fechaactual;
            $Log->save();

            $logdocumento = new GDPLogdocumento();
            $logdocumento->documento_id = $documento->id;
            $logdocumento->log_id = $Log->id;
            $logdocumento->save();

            DB::commit();
            return '1';
        } catch (Exception $ex) {
            DB::rollback();
        }
        //

    }

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
