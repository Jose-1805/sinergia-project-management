<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DivisionActividadEconomica
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class DivisionActividadEconomica extends Model {

    protected $table = "divisionactividadeconomica";
    public $timestamps = false;
    
    
    //DEFINICION DE RELACIONES ///////////
    
    public function actividadesEconomicas() {
        return $this->hasMany("App\Models\ActividadEconomica","divisionactividadeconomica_id");
    }
    
    public function seccionActividadEconomica() {
        return $this->belongsTo("App\Models\SeccionActividadEconomica","seccionactividadeconomica_id");
    }
    
}
?>

