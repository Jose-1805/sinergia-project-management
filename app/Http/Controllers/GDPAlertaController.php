<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\GDPDocumento;
use App\Models\GDPLog;
use App\Models\GDPLogAlerta;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\GDPAlerta;
use App\Models\Persona;


class GDPAlertaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function AlertasXDocumento($id)
    {
        $iddoc = Crypt::decrypt($id);
// consulta las alertas ralacionadas a un documento
        $alertas = GDPAlerta::join("persona", "persona.id", "=", "alerta.aler_responsable")->where("documento_id", $iddoc)
            ->select("alerta.*", "persona.per_nombres", "persona.per_apellidos")->get();
        // envia las alertas a la vista AlertasXDocumento
        return view("roles.adminv.modulos.GDP.index")->with("alerta", "AlertasXDocumento")->with('alertas', $alertas);


    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

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
     * Show the form for editing the specified resource.doc
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $personas = Persona::all();
        $idalerta = Crypt::decrypt($id);
 //consulta la elerta por id y envia los datos a la vista frmeditAlerta

        $edialerta = GDPAlerta::join("persona", "persona.id", "=", "alerta.aler_responsable")
            ->join("documento","documento.id","=","alerta.documento_id")
            ->where("alerta.id", $idalerta)
            ->select("alerta.*","persona.id as idpersona" ,"persona.per_correo","persona.per_nombres", "persona.per_apellidos","documento.doc_fechacreacion")->first();

        return view("roles.adminv.modulos.GDP.index")->with("alerta","frmeditAlerta")->with('edialerta',$edialerta)->with("personas",$personas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Request $request,$id)
    {

        try {
            DB::beginTransaction();
            // guarda la actualizacion de la alerta
            $alerta = GDPAlerta::find($id);
            $alerta->fill($request->all());
            $alerta->save();

            //-----------------------------------------------------
            // guardar el historial de la actualizacion de la alerta en BD
            //-----------------------------------------------------
            $idpersona = Session::get("idPersona");
            $rolactual = Session::get("rol actual");
            $fechaactual = date('Y-m-d g:ia');
            $Log = new GDPLog();
            $Log->log_accion = "Actualizo";
            $Log->persona_id = $idpersona;
            $Log->log_rol = $rolactual;
            $Log->log_fecha = $fechaactual;
            $Log->save();

            $logalerta = new GDPLogAlerta();
            $logalerta->alerta_id = $alerta->id;
            $logalerta->log_id = $Log->id;
            $logalerta->justificacion = $request->justificacion;
            $logalerta->save();

            DB::commit();
            return '1';
        } catch (Exception $ex) {
            DB::rollback();
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
