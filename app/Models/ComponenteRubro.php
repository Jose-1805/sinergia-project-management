<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComponenteRubro
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class ComponenteRubro extends Model {

    protected $table = "componenterubro";
    public $timestamps = false;
    
    public function rubro() {
        return $this->belongsTo("App\Models\Rubro");
    }

    public function stateDelete(){
        $this->com_rub_estado = "delete";
        $this->save();
    }
}