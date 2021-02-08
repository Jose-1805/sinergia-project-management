<?php
/**
 * Created by PhpStorm.
 * User: Jose Luis
 * Date: 14/02/2016
 * Time: 1:45 PM
 */

namespace App\Models\Pdf;


class ReporteInformacion extends Pdf{

    function __construct($orientation='P', $unit='mm', $size='A4')
    {
        parent::__construct($orientation, $unit, $size);
    }

    function Header(){
        $this->Image(asset("imagenes/imagen.jpg"), 10, 5, 30, 10);
        $fecha = date('Y-m-d');
        $this->SetFont("Arial","",11);
        $this->SetTextColor(0,0,0);
        $this->Cell(0, 6, $fecha, 0, 1, 'R',false);
        $this->Ln(1);
        $this->SetFont("Arial","B",18);
        $this->SetTextColor(255,255,255);
        $this->SetFillColor(102,153,0);
        $this->MultiCell(0, 20, utf8_decode("Reporte información proyecto SINERGIA"), 0, 'C', true);
        $this->Ln(10);
    }

    function Footer(){
        $this->SetY(-20);
        $this->SetFont("Arial","",11);
        $this->Cell(0,10,"Pagina No. ".$this->PageNo()."/{nb}",0,0,"C");
    }
} 