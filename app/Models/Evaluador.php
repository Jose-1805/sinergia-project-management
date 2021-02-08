<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Evaluador
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Evaluador extends Model {

    protected $table = "evaluador";
    protected $guarded = ['id', 'account_id'];

    public function proyectosInvestigativos() {
        return $this->belongsToMany("App\Models\ProyectoInvestigativo","proyectoinvestigativoevaluador","evaluador_id","proyectoinvestigativo_id");
    }

    public function persona() {
        return $this->belongsTo("App\Models\Persona");
    }

    public function seguimientos() {
        return $this->hasMany('App\Models\Seguimiento');
    }
}
?>