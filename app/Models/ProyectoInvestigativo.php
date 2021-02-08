<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProyectoInvestigativo
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoInvestigativo extends Model {

    //put your code here
    protected $table = "proyectoinvestigativo";
    protected $guarded = ['id', 'account_id'];
    public $timestamps = false;

    
    public function proyecto() {
        return $this->belongsTo('App\Models\Proyecto');
    }
    
    public function evaluadores() {
        return $this->belongsToMany("App\Models\Evaluador","proyectoinvestigativoevaluador","proyectoinvestigativo_id","evaluador_id");
    }
    
    public function investigadores(){
        return $this->belongsToMany("App\Models\Investigador","proyectoinvestigador","proyectoinvestigativo_id","investigador_id");
    }
    
    public function investigadorLider() {
        return $this->belongsTo("App\Models\Investigador","investigador_id","id");
    }
    
    public function componentes() {
        return $this->hasMany("App\Models\Componente","proyectoinvestigativo_id","id");
    }
    
    public function lineasInvestigacion() {
        return $this->belongsToMany("App\Models\LineaInvestigacion","proyectolinea","proyectoinvestigativo_id","lineainvestigacion_id");
    }
}
