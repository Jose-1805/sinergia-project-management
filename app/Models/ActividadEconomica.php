<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActividadEconomica
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class ActividadEconomica extends Model {

    protected $table = "actividadeconomica";
    public $timestamps = false;
    
    
    //DEFINICION DE RELACIONES ///////////
    
    public function entidades() {
        return $this->hasMany("App\Models\Entidad","actividadeconomica_id");
    }
    
    public function divisionActividadEconomica() {
        return $this->belongsTo("App\Models\DivisionActividadEconomica","divisionactividadeconomica_id");
    }
    
}
?>

