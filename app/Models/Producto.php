<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Producto
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Producto extends Model {

    protected $table = "producto";
    
    public function seguimientos() {
        return $this->belongsToMany("App\Models\Seguimiento","seguimientoproducto");
    }
    
    public function seguimientosProducto() {
        return $this->hasMany("App\Models\SeguimientoProducto");
    }
    
    public function actividad() {
        return $this->belongsTo("App\Models\Actividad");
    }

    public function stateDelete(){
        $this->pro_estado = "delete";
        $this->save();
    }

    public function investigador(){
        return $this->belongsTo("App\Models\Investigador");
    }
}