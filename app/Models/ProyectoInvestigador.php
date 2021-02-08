<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProyectoInvestigador
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class ProyectoInvestigador extends Model {

    protected $table = "proyectoinvestigador";

    public function investigador(){
        return $this->belongsTo('App\Models\Investigador');
    }

    public function proyectoInvestigativo(){
        return $this->belongsTo('App\Models\ProyectoInvestigativo','proyectoinvestigativo_id');
    }
}
