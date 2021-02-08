<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdministradorInvestigativo
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class AdministradorInvestigativo extends Model {

    protected $table = "AdministradorInvestigativo";
    public $timestamps = false;

    public function persona() {
        return $this->belongsTo("App\Models\Persona");
    }
    
    public function centrosFormativos() {
        return $this->belongsToMany("App\Models\CentroFormativo","adminvcenfor","administradorinvestigativo_id","centroformativo_id");
    }
}
?>

