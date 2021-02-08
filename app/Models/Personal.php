<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Personal
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Personal extends Model {

    protected $table = "personal";
    protected $guarded = ['id', 'account_id'];
    public $timestamps = false;
    
    public function entidad() {
        return $this->belongsTo("App\Models\Entidad");
    }
    
}
