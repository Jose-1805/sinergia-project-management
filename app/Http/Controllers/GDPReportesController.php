<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Models\Pdf\Pdf;
use App\Models\Pdf\GDPReporte;
use App\Models\GDPProyectosubserie;
use App\Models\GDPLogproyectosubserie;
use App\Models\SubSerieTipoDocumeto;
use App\Models\GDPDocumento;
use App\Models\GDPAlerta;

class GDPReportesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {


    }

    public function  MostrarReporte($id)
    {

        $id = Crypt::decrypt($id);//id del proyectosubserie

        //consulta todos los datos de proyecto subserie ,datos del proyectos y datos se la subserie que esta relacionado con el proyecto
        $proyectosubserie = GDPProyectosubserie::join("proyecto", "proyecto.id", "=", "proyectosubserie.id_proyecto")
            ->join("subserie", "subserie.id", "=", "proyectosubserie.id_subserie")
            ->select("proyectosubserie.*", "proyecto.pro_titulo", "proyecto.pro_estado", "subserie.sub_nombre", "subserie.id as idsubserie")
            ->where("proyectosubserie.id", $id)->first();

//consulta el historial del proyecto subserie y quien realizo el registro .
        $log = GDPLogproyectosubserie::join("log", "log.id", "=", "logproyectosubserie.log_id")
            ->join("persona", "persona.id", "=", "log.persona_id")
            ->select("log.*", "persona.per_nombres", "persona.per_apellidos", "persona.per_correo")
            ->where("logproyectosubserie.proyectosubserie_id", $id)
            ->first();



        if ((!$proyectosubserie) && (!$log)) { //valida que si las variables contengan algo
            return redirect('/');
            
        } 
        else {
            $pdf = new GDPReporte('P', 'mm', 'letter');
            
            $pdf->AliasNbPages();
            $pdf->AddPage();

            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetFillColor(213, 213, 213);
            $pdf->Cell(0, 10, utf8_decode("Datos del proyecto"), 1, 10, 'C', true);


            $pdf->SetWidths(Array(51, 145));
            $pdf->SetFont('Arial', '', 11);
// genera la tabla con los datos del proyecto y parte del log.
            $datos = Array(utf8_decode("Título"), utf8_decode($proyectosubserie->pro_titulo));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Sub-Serie:"), utf8_decode($proyectosubserie->sub_nombre));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Fecha De Registro:"), utf8_decode($log->log_fecha));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Responsable:"), utf8_decode($log->per_nombres . " " . $log->per_apellidos));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Estado "), utf8_decode($proyectosubserie->pro_estado));
            $pdf->Row($datos, Array('L', 'L'), 1);

///////////////////////////////////////
            // consulta los tipos documentales segun el proyectosubserie
            $tipodocumentalesxsub = SubSerieTipoDocumeto::join("tipodocumento", "tipodocumento.id", "=", "subserietipodocumeto.tipodocumento_id")->where("subserie_id", $proyectosubserie->idsubserie)
                ->where("tipodocumento.estado", "activa")
                ->select("tipodocumento.*")->get();
///////////////////////////////////////
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Ln(5);

            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetFillColor(213, 213, 213);
            $pdf->Cell(0, 10, utf8_decode("Tipos documentales y Cantidad de Documentos"), 1, 10, 'C', true);
            $pdf->SetWidths(Array(51, 145));
            $pdf->SetFont('Arial', '', 11);

            foreach ($tipodocumentalesxsub as $tipodoct) {
                $numdocumentos = "";
                //consulta la cantidad de documentos que contiene cada tipo documental segun el proyecto subserie
                $numdocumentos = GDPDocumento::where("documento.proyectosubserie_id", $id)->where("documento.tipodocumento_id", $tipodoct->id)
                    ->select("documento.id")->count();
                $datos = Array(utf8_decode($tipodoct->tido_nombre . ":"), utf8_decode("# " . $numdocumentos));
                $pdf->Row($datos, Array('L', 'L'), 1);
            }
            //////////////////////////////////
            //consulta las alertas generadas relacionadas con el proyecto subserie.

            $alertasXproyecto = GDPAlerta:: join("documento", "alerta.documento_id", "=", "documento.id")
                ->join("proyectosubserie", "proyectosubserie.id", "=", "documento.proyectosubserie_id")
                ->join("persona", "persona.id", "=", "alerta.aler_responsable")
                ->where("proyectosubserie.id", $id)
                ->select("alerta.*", "persona.per_nombres", "persona.per_apellidos", "persona.per_correo")->get();
            // se generan las variables que contendran el numero  de alertas segun el estado
            // se generan las arreglos  que contendran las alertas segun el estado
            $totalvigentes = 0;
            $totalrealizadas = 0;
            $totalvencidas = 0;
            $totalalertas = 0;
            $arreglovigente = [];
            $arreglorealizada = [];
            $arreglovencida = [];
            foreach ($alertasXproyecto as $alertas) {
                if ($alertas->aler_estado == "Vigente") {
                    $arreglovigente[$totalvigentes] = $alertas;
                    $totalvigentes++;
                } else {
                    if ($alertas->aler_estado == "Vencida") {
                        $arreglovencida[$totalvencidas] = $alertas;
                        $totalvencidas++;
                    } else {
                        $arreglorealizada[$totalrealizadas] = $alertas;
                        $totalrealizadas++;
                    }
                }
            }
            $totalalertas = $totalvigentes + $totalrealizadas + $totalvencidas;

            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetFillColor(213, 213, 213);
            $pdf->Cell(0, 10, utf8_decode("Alertas Generadas Del Proyecto"), 1, 10, 'C', true);
            $pdf->SetWidths(Array(51, 145));
            $pdf->SetFont('Arial', '', 11);

            $datos = Array(utf8_decode("Vigentes"), utf8_decode($totalvigentes));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Realizadas"), utf8_decode($totalrealizadas));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Vencidas"), utf8_decode($totalvencidas));
            $pdf->Row($datos, Array('L', 'L'), 1);
            $datos = Array(utf8_decode("Total Alertas"), utf8_decode($totalalertas));
            $pdf->Row($datos, Array('L', 'L'), 1);


            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetFillColor(213, 213, 213);
            $pdf->Cell(0, 10, utf8_decode("Alertas vigentes"), 1, 10, 'C', true);
            if ($arreglovigente) {
                $pdf->SetWidths(Array(35, 35, 35, 35));
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(49, 5, utf8_decode("Responsable"), 1, 0, "C", true);
                $pdf->Cell(49, 5, utf8_decode("Compromiso"), 1, 0, "C", true);
                $pdf->Cell(49, 5, utf8_decode("Fecha inicio"), 1, 0, "C", true);
                $pdf->Cell(49, 5, utf8_decode("Fecha fin"), 1, 0, "C", true);
                $pdf->Ln();
                foreach ($arreglovigente as $vigentes) {
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetWidths(Array(49, 49, 49, 49));
                    $datos = Array(utf8_decode($vigentes->per_nombres . "(" . $vigentes->per_correo . ")"), utf8_decode($vigentes->aler_compromiso), utf8_decode($vigentes->aler_fechainicio), utf8_decode($vigentes->aler_fechafin));
                    $pdf->Row($datos, Array('J', 'J', 'J', 'J'), 0);
                }


            } else {
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(0, 10, 'No se encontraron alertas Vigentes relacionadas con este Proyecto', 0, 1, 'C');
            }
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetFillColor(213, 213, 213);
            $pdf->Cell(0, 10, utf8_decode("Alertas Realizadas"), 1, 10, 'C', true);
            if ($arreglorealizada) {
                $pdf->SetWidths(Array(35, 35, 35, 35));
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(49, 5, utf8_decode("Responsable"), 1, 0, "C", true);
                $pdf->Cell(49, 5, utf8_decode("Compromiso"), 1, 0, "C", true);
                $pdf->Cell(49, 5, utf8_decode("Fecha inicio"), 1, 0, "C", true);
                $pdf->Cell(49, 5, utf8_decode("Fecha fin"), 1, 0, "C", true);
                $pdf->Ln();
                foreach ($arreglorealizada as $realizada) {
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetWidths(Array(49, 49, 49, 49));
                    $datos = Array(utf8_decode($realizada->per_nombres . "(" . $realizada->per_correo . ")"), utf8_decode($realizada->aler_compromiso), utf8_decode($realizada->aler_fechainicio), utf8_decode($realizada->aler_fechafin));
                    $pdf->Row($datos, Array('J', 'J', 'J', 'J'), 0);
                }


            } else {

                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(0, 10, 'No se encontraron alertas Realizadas relacionadas con este Proyecto', 0, 1, 'C');
            }
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetFillColor(213, 213, 213);
            $pdf->Cell(0, 10, utf8_decode("Alertas Vencidas"), 1, 10, 'C', true);
            if ($arreglovencida) {
                $pdf->SetWidths(Array(35, 35, 35, 35));
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(49, 5, utf8_decode("Responsable"), 1, 0, "C", true);
                $pdf->Cell(49, 5, utf8_decode("Compromiso"), 1, 0, "C", true);
                $pdf->Cell(49, 5, utf8_decode("Fecha inicio"), 1, 0, "C", true);
                $pdf->Cell(49, 5, utf8_decode("Fecha fin"), 1, 0, "C", true);
                $pdf->Ln();
                foreach ($arreglovencida as $vencida) {
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetWidths(Array(49, 49, 49, 49));
                    $datos = Array(utf8_decode($vencida->per_nombres . "(" . $vencida->per_correo . ")"), utf8_decode($vencida->aler_compromiso), utf8_decode($vencida->aler_fechainicio), utf8_decode($vencida->aler_fechafin));
                    $pdf->Row($datos, Array('J', 'J', 'J', 'J'), 0);
                }


            } else {
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(0, 10, 'No se encontraron alertas Vencidas relacionadas con este Proyecto', 0, 1, 'C');
            }


            //////////////////////////////////////////////
            $pdf->AddPage();
            $pdf->Output("", "reporte_DocumentaciónProyecto_" . $proyectosubserie->pro_titulo . ".pdf");

            exit;
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
  

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
 

}
