<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sugerencia
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sugerencia extends Model {

    //put your code here
    protected $table = "sugerencia";
    protected $guarded = ['id', 'account_id'];

    public function persona() {
        return $this->belongsTo("App\Models\Persona");
    }
    
    public function seguimientoProducto() {
        return $this->hasOne("App\Models\SeguimientoProducto");
    }

    public function proyecto(){
        return $this->belongsTo("App\Models\Proyecto");
    }

    public function respuestas(){
        return $this->hasMany("App\Models\RespuestaSugerencia");
    }
}