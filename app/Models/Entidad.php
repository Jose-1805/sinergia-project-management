<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Entidad
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Entidad extends Model {

    protected $table = "entidad";
    public $timestamps = false;
    
    public function actividades() {
        return $this->belongsToMany("App\Models\Actividad");
    }
    
    public function proyectos() {
        return $this->belongsToMany("App\Models\Proyecto","proyectoentidad");
    }
    
    public function actividadEconomica() {
        return $this->belongsTo("App\Models\ActividadEconomica","actividadeconomica_id");
    }
    
    public function personals() {
        return $this->hasMany("App\Models\Personal");
    }
    
    public function localizacion() {
        return $this->belongsTo("App\Models\Localizacion");
    }
}
