<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Direccion
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Direccion extends Model {

    protected $table = "direccion";
    protected $guarded = ['id', 'account_id'];
    public $timestamps = false;
    

    public function localizacion() {
        return $this->hasOne("App\Models\Localizacion");
    }
    
    public function ciudad() {
        return $this->belongsTo("App\Models\Ciudad");
    }
    
    
    public function centroFormativo() {
        return $this->hasOne("App\Models\CentroFormativo");
    }
}
