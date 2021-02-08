<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model {

    protected $table = "notificacion";
    protected $guarded = ['id', 'account_id'];

    public function persona() {
        return $this->belongsTo("App\Models\Persona");
    }

    public function relacionPersona(){
        return $this->hasMany("App\Models\PersonaNotificacion");
    }
}
