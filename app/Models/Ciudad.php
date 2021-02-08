<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ciudad
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Ciudad extends Model {

    protected $table = "ciudad";
    protected $guarded = ['id', 'account_id'];
    public $timestamps = false;
    
    
    public function departamento() {
        return $this->belongsTo("App\Models\Departamento");
    }

    public function direcciones() {
        return $this->hasMany("App\Models\Direccion");
    }
}
