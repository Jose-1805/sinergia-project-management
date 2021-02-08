<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaNotificacion extends Model {

    protected $table = "persona_notificacion";
    protected $guarded = ['id', 'account_id'];
    public $timestamps = false;

    public function persona() {
        return $this->belongsTo("App\Models\Persona");
    }

    public function notificacion() {
        return $this->belongsTo("App\Models\Notificacion");
    }
}
