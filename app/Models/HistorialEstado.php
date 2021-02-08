<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HistorialEstado
 *
 * @author lucho_000
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class HistorialEstado extends Model {

    protected $table = "historialestado";
    protected $guarded = ['id', 'account_id'];
    
    public function proyecto() {
        return $this->belongsTo("App\Models\Proyecto");
    }
    
    public function persona() {
        return $this->belongsTo("App\Models\Persona");
    }
}
?>

