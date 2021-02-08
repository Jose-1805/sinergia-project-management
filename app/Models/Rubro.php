<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rubro
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Rubro extends Model {

    protected $table = "rubro";
    public $timestamps = false;

    public function componentesRubro() {
        return $this->hasMany("App\Models\ComponenteRubro");
    }
    
    public function actividad() {
        return $this->belongsTo("App\Models\Actividad");
    }

    public function stateDelete(){
        $componentes = $this->componentesRubro;
        foreach($componentes as $componente){
            $componente->stateDelete();
        }
        $this->rub_estado = "delete";
        $this->save();
    }

}