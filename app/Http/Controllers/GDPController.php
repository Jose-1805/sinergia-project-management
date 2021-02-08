<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Middleware\AutenticacionAdminv;
use App\Http\Middleware\AutenticacionEval;
use App\Http\Middleware\AutenticacionInv;
use App\Http\Middleware\AutenticationGDP;
use App\Http\Requests\actionsActividadRequest;
use App\Http\Requests\FormularInfoGeneralRequest;
use App\Models\Actividad;
use App\Models\GDPDocumento;
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
use App\Models\Ciudad;
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
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use PhpSpec\Exception\Exception;
use App\Http\Requests\RelacionEntidadRequest;
use App\Http\Requests\NuevoInvestigadorRelacion;
use UniversalTheme;
use Yajra\Datatables\Facades\Datatables;

class GDPController extends Controller
{
    function __construct()
    {
        //  $this->middleware('autGDP');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        if (Session::has("idPersona")) {
            $rol = "";
                if (Session::get('rol actual') == "administrador investigativo"){
                    $rol = "adminv";
                    $documentos=GDPDocumento::all();//consulta todos los ducumentos  independiente del proyecto
                    return view("roles/" . $rol . "/modulos/GDP/index")->with("index","index")->with('documentos',$documentos);
                }
                    else if (Session::get('rol actual') == "investigador"){
                        $rol = "inv";
                        $docInv=GDPDocumento::all();
                        return view("roles/" . $rol . "/modulos/GDP/index")->with("index","index")->with('documentos',$docInv);
                        }
        }
        return redirect("/");
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
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
