<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model {
    protected $table = "contenido";
    protected $guarded = ['id', 'account_id'];

    /**
     * genera un nombre aleatorio para el archivo que almacena el contenido
     */
    public function generarNombre() {
        $nombre = "";
        $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJCLMNOPQRSTUVWXYZ1234567890";
        $existe = true;

        while ($existe) {
            //generar el nombre
            $cantAleatorio = rand(10, 25);
            $aleatorio = '';
            for ($i = 0; $i < $cantAleatorio; $i++) {
                $caracter = rand(0, strlen($caracteres));
                $caracter = substr($caracteres, $caracter, 1);
                $aleatorio = $aleatorio . '' . $caracter;
            }

            $nombre = $aleatorio;

            //generar la extension
            $cantAleatorio = rand(3, 9);
            $aleatorio = '';
            for ($i = 0; $i < $cantAleatorio; $i++) {
                $caracter = rand(0, strlen($caracteres));
                $caracter = substr($caracteres, $caracter, 1);
                $aleatorio = $aleatorio . '' . $caracter;
            }

            $nombre .= ".".$aleatorio;

            $contenido = $this->where('con_archivo', $nombre)->get();
            if (count($contenido) < 1) {
                $existe = FALSE;
                $this->con_archivo = $nombre;
            }
        }


        return $nombre;
    }

    public function arrayNameRoles(){
        $tiposCuenta = $this->tiposCuenta;
        $array = [];
        if(count($tiposCuenta)){
            foreach($tiposCuenta as $t){
                $array[] = $t->tip_cue_nombre;
            }
            if($this->con_sin_sesion == "si"){
                $array[] = "Usuarios sin sesión";
            }
        }else{
            if($this->con_sin_sesion == "si"){
                $array[] = "Usuarios sin sesión";
            }else {
                $array[] = "Contenido sin roles";
            }
        }

        return $array;
    }

    public function tiposCuenta(){
        return $this->belongsToMany('App\Models\TipoCuenta','contenidotipocuenta','contenido_id','tipocuenta_id');
    }
}
