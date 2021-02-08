<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SeccionActividadEconomica
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class SeccionActividadEconomica extends Model {

    protected $table = "seccionactividadeconomica";
    public $timestamps = false;
    
    
    //DEFINICION DE RELACIONES ///////////
    
    public function divisionesActividadesEconomicas() {
        return $this->hasMany("App\Models\DivisionActividadEconomica","seccionactividadeconomica_id");
    }
    
}
?>

