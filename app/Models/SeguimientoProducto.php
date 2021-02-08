<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SeguimientoProducto
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguimientoProducto extends Model {

    //put your code here
    protected $table = "seguimientoproducto";
    protected $guarded = ['id', 'account_id'];    
    
    public function sugerencia() {
        return $this->belongsTo("App\Models\Sugerencia");        
    }
    
    public function producto() {
        return $this->belongsTo("App\Models\Producto");
    }
}
