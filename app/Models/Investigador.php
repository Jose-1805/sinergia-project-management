<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Investigador
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Investigador extends Model {

    protected $table = "investigador";
    protected $guarded = ['id', 'account_id'];
    public $timestamps = false;

    
    
    //DECLARACION DE RELACIONES//////////////
    
    public function persona() {
        return $this->belongsTo("App\Models\Persona");
    }
    
    public function proyectosInvestigativos() {
        return $this->belongsToMany("App\Models\ProyectoInvestigativo","proyectoinvestigador","investigador_id","proyectoinvestigativo_id");
    }
    
    public function proyectosInvestigativosLider() {
        return $this->hasMany("App\Models\ProyectoInvestigativo");
    }
}
