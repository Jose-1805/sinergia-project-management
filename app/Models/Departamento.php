<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Departamento
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Departamento extends Model {

    protected $table = "departamento";
    protected $guarded = ['id', 'account_id'];
    public $timestamps = false;
    

    public function pais(){
        return $this->belongsTo("App\Models\Pais");
    }
    
    public function ciudades() {
        return $this->hasMany("App\Models\Ciudad");
    }
}