<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CentroFormativo
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class CentroFormativo extends Model {

    protected $table = "centroformativo";
    
    public function direccion() {
        return $this->belongsTo("App\Models\Direccion");
    }
    
    public function administradoresinvestigativos() {
        return $this->belongsToMany("App\Models\AdministradorInvestigativo","adminvcenfor","centroformativo_id","administradorinvestigativo_id");
    }
    
    public function proyectos() {
        return $this->hasMany("App\Models\Proyecto","centroformativo_id");
    }
}
?>

