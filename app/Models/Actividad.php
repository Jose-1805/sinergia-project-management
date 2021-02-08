<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Actividad
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Actividad extends Model {

    protected $table = "actividad";
    public $timestamps = false;
    
    
    //DEFINICION DE RELACIONES ///////////
    
    public function entidades() {
        return $this->belongsToMany("App\Models\Entidad","entidadactividad","actividad_id","entidad_id");
    }
    
    
    public function productos() {
        return $this->hasMany("App\Models\Producto");
    }
    
    public function rubros() {
        return $this->hasMany("App\Models\Rubro");
    }
    
    public function componente() {
        return $this->belongsTo("App\Models\Componente");
    }

    public function evaluarEstado(){
        $productos = $this->productos;
        $actividadFinalizada = true;
        if(count($productos)){
            foreach($productos as $producto){
                if($producto->pro_estado != "aprobado"){
                    $actividadFinalizada = false;
                    break;
                }
            }

            if($actividadFinalizada){
                $this->act_estado =  "finalizado";
                $this->act_fecha_fin_real = date("Y-m-d");
                $this->save();
                $var = $this->componente->evaluarEstado();
                return "1";
            }
        }
        return "-1";
    }

    public function stateDelete(){
        $rubros = $this->rubros;
        $productos = $this->productos;

        foreach($rubros as $rubro){
            $rubro->stateDelete();
        }

        foreach($productos as $producto){
            $producto->stateDelete();
        }

        $this->act_estado = "delete";
        $this->save();
    }

    public function estadoProductos()
    {
        $productos = $this->productos;
        if($productos){
            $prodAprobados = 0;
            $prodNoAprobados = 0;
            $prodPorRevisar = 0;
            foreach ($productos as $producto) {
                if($producto->pro_estado == 'aprobado'){
                    $prodAprobados++;
                }else if($producto->pro_estado == 'no aprobado'){
                    $prodNoAprobados++;
                }else if($producto->pro_estado == 'por revisar'){
                    $prodPorRevisar++;
                }
            }
            $retorno = $prodAprobados.','.$prodNoAprobados.','.$prodPorRevisar;
            return $retorno;
        }else{
            return'sin productos';
        }
    }

    /**
     *Analiza y retorn el porcentaje de la actividad que se ha desarrollado
     */
    public function porcentajeActividadDesarrollado(){
        $estados = $this->estadoProductos();

        if($this->act_estado == 'finalizado'){
            return 100;
        }else{
            $aprobados=0;
            $noAprobados=0;
            $porRevisar = 0;
            if($estados == 'sin productos'){
                return 0;
            }else{
                $estados = explode(',', $estados);
                $aprobados = $estados[0];
                $noAprobados = $estados[1];
                $porRevisar = $estados[2];
                if($aprobados == 0){
                    return 0;
                }else{
                    return $aprobados * 100/($aprobados + $noAprobados + $porRevisar);
                }
            }
        }
    }

    /**
     * calcula el porcentaje de tiempo transcurrido de una actividad
     * los atributos fechaInicio y fechaFin ya deben estar definidos(tener un valor)
     */
    public function calcularPorcentajeTiempoTranscurrido(){
        $porcentaje = '0';
        if($this->act_fecha_fin || $this->act_fecha_inicio){
            $porcentaje = '0';
        }else{
            $fechaActual = date('Y-m-d');
            $datetime1 = new DateTime($this->act_fecha_inicio);
            $datetime2 = new DateTime($this->act_fecha_fFin);
            $datetime3 = new DateTime($fechaActual);

            if(strtotime($fechaActual) < strtotime($this->act_fecha_inicio)){
                $porcentaje = '0';
            }else{
                $dias = $datetime1->diff($datetime2);
                $dias = $dias->format('%a');
                if($fechaActual > $this->act_fecha_fin){
                    $porcentaje = 100;
                }else{
                    $diasTransc = $datetime1->diff($datetime3);
                    $diasTransc = $diasTransc->format('%a');
                    $porcentaje = ($diasTransc * 100)/$dias;
                    $datos = explode('.', $porcentaje);
                    if(count($datos)>1){
                        $porcentaje = $datos[0].'.'.substr($datos[1], 1,2);
                    }
                }
            }

        }
        return $porcentaje;
    }
}
?>