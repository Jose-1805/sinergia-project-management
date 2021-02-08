<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model {

    protected $table = "perfil";
    protected $guarded = ['id', 'account_id'];

    public function persona(){
        return $this->belongsTo('App\Models\Persona');
    }

    public function lineasInvestigacion(){
        return $this->belongsToMany('App\Models\LineaInvestigacion','perfil_lineas_investigacion');
    }

    public function relacionLineas(){
        return $this->hasMany('App\Models\PerfilLineasInvestigacion');
    }

}