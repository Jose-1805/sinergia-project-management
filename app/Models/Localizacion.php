<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Localizacion
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Localizacion extends Model {

    protected $table = "localizacion";
    protected $guarded = ['id', 'account_id'];
    public $timestamps = false;
    

    //DECLARACION DE RELACIONES////////////////
    
    public function direccion() {
        return $this->belongsTo("App\Models\Direccion");
    }
    
    
    public function entidad() {
        return $this->hasOne("App\Models\Entidad");
    }  
    
}
