<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Componente
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Componente extends Model {

    protected $table = "componente";
    public $timestamps = false;
    
    public function actividades() {
        return $this->hasMany("App\Models\Actividad");
    }
    
    public function proyectoInvestigativo() {
        return $this->belongsTo("App\Models\ProyectoInvestigativo","proyectoinvestigativo_id");
    }

    public function evaluarEstado(){
        $actividades = $this->actividades;
        $componenteFinalizado = true;
        if(count($actividades)){
            foreach($actividades as $actividad){
                if($actividad->act_estado != "delete") {
                    if (!$actividad->act_estado || $actividad->act_estado == "iniciado") {
                        $componenteFinalizado = false;
                        break;
                    }
                }
            }

            if($componenteFinalizado){
                $this->com_estado =  "terminado";
                $this->save();

                $proyecto = $this->proyectoInvestigativo->proyecto;
                $var = $proyecto->evaluarEstadoEnDesarrollo();
                return "1";
            }
        }
        return "-1";
    }

    public function stateDelete(){
        $actividades = $this->actividades;
        foreach ($actividades as $actividad) {
            $actividad->stateDelete();
        }

        $this->com_estado = "delete";
        $this->save();
    }

    public function actividadesEstado(){
        $noDesarrolladas = 0;
        $desarrolladas = 0;
        $actividades = $this->actividades;
        if($actividades){
            foreach ($actividades as $actividad) {
                if($actividad->act_estado != "delete") {
                    if ($actividad->act_estado == "finalizado") {
                        $desarrolladas++;
                    } else {
                        $noDesarrolladas++;
                    }
                }
            }
            return $desarrolladas.','.$noDesarrolladas;
        }
        return "sin actividades";
    }

    public function porcentajeDesarrolladoComponente(){
        $actividades = $this->actividades;
        $totalDesarrollo = 0;
        $totalDesarrollado = 0;

        if($actividades){
            $totalDesarrollo = 100 * count($actividades);
            foreach ($actividades as $actividad) {
                if($actividad->act_estado != "delete") {
                    if ($actividad->act_estado == 'finalizado') {
                        $totalDesarrollado += 100;
                    } else {
                        $totalDesarrollado += $actividad->porcentajeActividadDesarrollado();
                    }
                }
            }

            return 100 * $totalDesarrollado/$totalDesarrollo;
        }else{
            return 'sin actividades';
        }
    }

    public function deleteSugerencias(){
        $sugerencias = Sugerencia::where("sug_elemento_nombre","componente")
            ->where("sug_elemento_id",$this->id)->get();
        if(count($sugerencias)){
            foreach($sugerencias as $s){
                $respuesras = $s->respuestas;
                if(count($respuesras)){
                    foreach($respuesras as $r){
                        $r->delete;
                    }
                }
                $s->delete();
            }
        }
    }
}