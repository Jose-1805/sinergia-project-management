<?php
/**
 * Created by PhpStorm.
 * User: Jose Luis
 * Date: 14/02/2016
 * Time: 1:13 PM
 */

namespace App\Models\Pdf;


date_default_timezone_set('America/Bogota');

use FPDF;

class Pdf extends FPDF {

    function __construct($orientation='P', $unit='mm', $size='A4')
    {
        parent::__construct($orientation, $unit, $size);
    }
    var $widths;
    var $aligns;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    //si el tipo es 2: toda la fila se establece como los datos de encabezado de la tabla
    //si el tipo es 1: el primer dato se establece como titulo de la fila
    //si el tipo es 0: se escrible toda la fila normal
    function Row($data,$alineacion,$tipo)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++){
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        }
        $h=5*$nb;
        //Emitir un salto de página en primer lugar, si es necesario
        $this->CheckPageBreak($h);
        //Dibuje las celdas de la fila
        for($i=0;$i<count($data);$i++)
        {
            if($tipo == 1){
                if($i == 0){
                    $this->SetFont('Arial', 'B');
                }else{
                    $this->SetFont('Arial', '');
                }
            }

            if($tipo == 2){
                $this->SetFont('Arial', 'B');
            }

            if($tipo == 0){
                $this->SetFont('Arial', '');
            }
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] :$alineacion[$i];
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Print the text
            /*if (($i==1) && ($tipo=="subseries"))
                $this->SetFont('Arial','B',8);
            else
                $this->SetFont('Arial','',8);*/

            $this->MultiCell($w,5,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
        //Calcula el número de líneas de un MultiCell de anchura w tendrá
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    function LoadData($file)
    {
        //Leer las l�neas del fichero
        $lines=file($file);
        $data=array();

        foreach($lines as $line)
            $data[]=explode(';',chop($line));
        return $data;
    }


    /*function encabezado($con,$tipo,$serie,$subserie)
    {
        //Logo

        //Arial bold 15

        $this->Ln();

        $empresa="select empresa from tbempresa";
        $entidad=$con->TraerDato($empresa);
        $oficina="UNIDAD DE CORRESPONDENCIA Y ARCHIVO";
        $fecha=date("d/m/Y");
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(0);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('Arial','',10);
        $w=array(20,120,20);
        $fill=0;
        $this->Image('../../resources/icono_empresa.jpg',30,15,20);
        $this->Cell($w[0],12,'',0,0,'C',$fill);
        $this->Cell($w[1],12,$entidad,0,0,'C',$fill);
        $this->Cell($w[2],12,"",0,0,'C',$fill);
        $this->Ln(5);
        $this->Cell($w[0],12,'',0,0,'C',$fill);
        $this->Cell($w[1],12,$oficina,0,0,'C',$fill);
        $this->Cell($w[2],12,"",0,0,'C',$fill);
        $this->Ln();
        //$this->Cell(array_sum($w),0,'','T');
        $this->Ln(4);
        $this->SetLineWidth(.0);
        $this->SetFont('Arial','',8);
        $w=array(160);
        $fill=0;
        if ($tipo==1)
        $xx="REPORTE CORRESPONDENCIA RECIBIDA POR SERIE DOCUMENTAL";
        if ($tipo==2)
        $xx="REPORTE CORRESPONDENCIA DESPACHADA POR SERIE DOCUMENTAL";
        if ($tipo==3)
        $xx="REPORTE CORRESPONDENCIA INTERNA POR SERIE DOCUMENTAL";
        $xx=strtoupper($xx);
        $this->Cell($w[0],6,$xx,0,0,'C',$fill);
        $this->Ln(6);
        $this->SetLineWidth(.0);
        $this->SetFont('Arial','',8);
        $w=array(110,28,30);
        $fill=0;
        $this->Ln(3);
        $entidad=strtoupper($entidad);
        $this->Cell($w[0],6,'SERIE DOCUMENTAL: '.$serie,0,0,'L',$fill);
        $this->Cell($w[1],6,'FECHA REPORTE: ',0,0,'L',$fill);
        $this->Cell($w[2],6,$fecha,0,0,'l',$fill);
        $this->Ln(3);
        if ($subserie!="")
        {
            $this->Cell($w[0],6,'SUBSERIE DOCUMENTAL: '.$subserie,0,0,'L',$fill);
             $this->Ln(2);
        }

        //encabezado tablas
        $this->Ln();
        $this->SetFont('Arial','B',6);

        $this->SetWidths(array(16,14,90,50));
        srand(microtime()*1000000);

        $alinea=array('C','C','C','C');
        $this->Row(array('RADICADO','FECHA RADICADO','ASUNTO','FUNCIONARIO/TRAMITE'),$alinea);



    }*/

    function agregad($consulta,$tipo,$con,$serie,$subserie)
    {
        $this->SetFont('Arial','',6);

        $x=1;



        $this->SetWidths(array(16,14,90,50));
        srand(microtime()*1000000);

        $alinea=array('C','C','L','L');
        $datos=$con->EjecutarQuery($consulta);
        while($ag=mysql_fetch_array($datos))

        {
            $this->Row(array($ag[0],$ag[1],$ag[3],$ag[4]." ".$ag[5]),$alinea);
            $x++;
            if ($x==20)
            {
                $this->SetMargins(30,20,5);
                $this->AliasNbPages();
                $this->AddPage();
                $this->encabezado($con,$tipo,$serie,$subserie);
                $this->SetFont('Arial','',6);
                $x=1;
            }

        }
        $this->Ln();
        $this->Ln();
    }

    function texto($mensaje)
    {
        $this->SetFont('Arial','',10);
        $this->Cell(0,10,$mensaje,0,0,'C');
        //Salto de l�nea
        $this->Ln(5);
    }

//Pie de p�gina
    /*function Footer()
    {
        //Posici�n: a 1,5 cm del final
    $this->SetY(-25);
    //Arial italic 8
    //N�mero de p�gina
    //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

        $w=array(80,80);
        $this->SetFont('Arial','',6);
        $this->Cell($w[0],6,'Seguimiento y Control de Correspondencia',0,0,'L',$fill);
        //$this->Ln(4);
        $this->Cell($w[1],6,'Page '.$this->PageNo().'/{nb}',0,0,'R');
        /*$w=array(120);
        $this->Cell($w[0],6,'Jefe de Archivo',0,0,'C',$fill);
        $this->Ln(12);*/
    /*$this->SetFillColor(255,0,0);
    $this->SetTextColor(0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->Ln();

}*/




    function Cerrardatos()
    {
        $w=array(150);
        $this->Cell(array_sum($w),0,'','T');
        $this->Ln(40);
    }
} 