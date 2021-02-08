<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Seguimiento
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seguimiento extends Model {

    //put your code here
    protected $table = "seguimiento";
    protected $guarded = ['id', 'account_id'];
    
    public function productos() {
        return $this->belongsToMany("App\Models\Producto","seguimientoproducto");
    }
    
    public function persona() {
        return $this->belongsTo('App\Models\Evaluador');
    }
    
    public function proyecto() {
        return $this->belongsTo("App\Models\Proyecto");
    }
}
