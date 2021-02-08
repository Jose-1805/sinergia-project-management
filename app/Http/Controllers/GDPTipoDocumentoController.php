<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\GDPTipoDocumentoRequest;

use App\Models\GDPLog;
use App\Models\GDPLogtipodocumento;
use App\Models\GDPProyectosubserie;
use League\Flysystem\Exception;
use App\Models\Proyecto;
use App\Models\SubSerieTipoDocumeto;
use App\Models\GDPSubserie;
use App\Models\GDPConsecutivodocumental;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Models\GDPTipoDocumento;

class GDPTipoDocumentoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $tiposdocumentos = GDPTipoDocumento::orderBy('id', 'DEC')->paginate(5);
        // Envía a la vista principal del módulo  la   variable que contiene el nombre de la plantilla  y la consulta ejecutada anterior mente.
        return view("roles.adminv.modulos.GDP.index")->with("tipodoc", "index")->with("tiposdocumentos", $tiposdocumentos);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Consulta  los datos de las sub series que por el momento se encuentran asociadas  en la tabla  proyectosubserie.
        $subserie = GDPSubserie::join("proyectosubserie", "proyectosubserie.id_subserie", "=", "subserie.id")->get();
        // Envía a la vista principal del módulo  la   variable que contiene el nombre de la plantilla  y la consulta ejecutada anterior mente.

        return view("roles.adminv.modulos.GDP.index")->with("tipodoc", "frmtipodocumento")->with("subserie", $subserie);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(GDPTipoDocumentoRequest $request)
    {
        try {
            DB::beginTransaction();
            $codigo_tipodoc = "";
            $nombretipo = $request->tido_nombre;
            $tipodocumeto = new GDPTipoDocumento();
            //----------------------------------------------------------------
            // CREAR CODIGO DEL TIPO DE DOCUMENTO
            //----------------------------------------------------------------
            $idtipodocumento = $tipodocumeto->LastTipoDocumentoid() + 1;
            $nombretipo = $request->tido_nombre;
            for ($i = 0; $i < strlen($nombretipo); $i++) {
                if ($i < 4) {
                    $codigo_tipodoc = $codigo_tipodoc . $nombretipo[$i];
                }
            }
            $codigo_tipodoc = $codigo_tipodoc . $idtipodocumento;
            $codigo_tipodoc = strtoupper($codigo_tipodoc);
            //----------------------------------------------------------------
            //guarda el nuevo registro del tipo de documentp
            //----------------------------------------------------------------
            $tipodocumeto->tido_nombre = $request->tido_nombre;
            $tipodocumeto->tido_codigo = $codigo_tipodoc;
            $tipodocumeto->estado ="activa";
            $tipodocumeto->save();
            //----------------------------------------------------------------
            //----------------------------------------------------------------
            //----------------------------------------------------------------
            //guarda el nuevo registro de la asociación de la subserie y nuevo tipo documnetal
            //----------------------------------------------------------------
            $subserietipodoc = new SubSerieTipoDocumeto();
            $subserietipodoc->tipodocumento_id = $tipodocumeto->id;
            $subserietipodoc->subserie_id =Crypt::decrypt($request->id_subserie);
            $subserietipodoc->save();

            // //----------------------------------------------------------------
            //----------------------------------------------------------------
             // guarda el historial del nuevo registro
            // //----------------------------------------------------------------
            //----------------------------------------------------------------
            $idpersona = Session::get("idPersona");
            $rolactual = Session::get("rol actual");
            $fechaactual = date("Y-m-d H:i:s");
            $Log = new GDPLog();
            $Log->log_accion = "Registro";
            $Log->persona_id = $idpersona;
            $Log->log_rol = $rolactual;
            $Log->log_fecha = $fechaactual;
            $Log->save();

            $logtipodocumento = new GDPLogtipodocumento();

            $logtipodocumento = new GDPLogtipodocumento();
            $logtipodocumento->tipodocumento_id = $tipodocumeto->id;
            $logtipodocumento->log_id = $Log->id;
            $logtipodocumento->save();

            // //----------------------------------------------------------------
            //----------------------------------------------------------------
            //genera el nuevo consecutivo para el nuevo tipo de documento
            // //----------------------------------------------------------------
            //----------------------------------------------------------------
            $newccondoc = new GDPConsecutivodocumental();
            $newccondoc->codo_consecutivo = 0;
            $newccondoc->tipodocumento_id = $tipodocumeto->id;
            $newccondoc->save();
            // //----------------------------------------------------------------
            //----------------------------------------------------------------
            // genera de lado servidor los directorios del nuevo tipo documental  a los proyectos que estan asociados a la subserierie ingresado
            // //----------------------------------------------------------------
            //----------------------------------------------------------------
            $proyectosub = GDPProyectosubserie::where("id_subserie",Crypt::decrypt($request->id_subserie))->get();

            foreach ($proyectosub as $pro) {
                $path = public_path() . '/Documentos/Proyectos/proyect';
                $path = $path . $pro->id;
                mkdir($path . '/tipodoc' . $tipodocumeto->id);
            }
            // //----------------------------------------------------------------
            //----------------------------------------------------------------
            DB::commit();
            return 1;
        } catch (Exception $ex) {
            DB::rollback();
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
    public function edit($id)
    {
        $idtipodocumento = Crypt::decrypt($id);

        $edittipodoc = GDPTipoDocumento::find($idtipodocumento);
        // Envía a la vista principal del módulo  la   variable que contiene el nombre de la plantilla  y la consulta ejecutada anterior mente.

        return view("roles.adminv.modulos.GDP.index")->with("tipodoc", "editartipodocumento")->with("edittipodoc", $edittipodoc);


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
            $tipodocumento = GDPTipoDocumento::find($id);
            $tipodocumento->fill($request->all());
            $tipodocumento->save();
            // //----------------------------------------------------------------
            //----------------------------------------------------------------
            // guarda el historial la actualizacion del registro
            // //----------------------------------------------------------------
            //----------------------------------------------------------------
            $idpersona = Session::get("idPersona");
            $rolactual = Session::get("rol actual");
            $fechaactual = date("Y-m-d H:i:s");;

            $Log = new GDPLog();
            $Log->log_accion = "Actualizo";
            $Log->persona_id = $idpersona;
            $Log->log_rol = $rolactual;
            $Log->log_fecha = $fechaactual;
            $Log->save();
            $idlog = $Log->Lastlogid();

            $logtipodocumento = new GDPLogtipodocumento();
            $logtipodocumento->tipodocumento_id = $tipodocumento->id;
            $logtipodocumento->log_id = $Log->id;
            $logtipodocumento->save();
            // //----------------------------------------------------------------
            //----------------------------------------------------------------
            DB::commit();
            return "1";
        } catch (Exception $ex) {

            DB::rollback();
        }


    }

    public function validarnombretipodocumento($nombretipodocumento)
    {
        if ($nombretipodocumento != null) {
            if (DB::table("tipodocumento")->where("tido_nombre", $nombretipodocumento)->count() > 0) {
                return 1;
            } else {
                return 0;
            }
        }


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
