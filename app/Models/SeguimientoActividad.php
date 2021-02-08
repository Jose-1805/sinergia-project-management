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

class SeguimientoActividad extends Model {

    //put your code here
    protected $table = "seguimientoactividad";
    protected $guarded = ['id', 'account_id'];
    
    public function actividad() {
        return $this->belongsTo("App\Models\Actividad");
    }
}
