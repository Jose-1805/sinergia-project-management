<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Convocatoria;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ConvocatoriaController extends Controller {


    public function __construct() {
        $this->middleware('autNoti');
    }

    public function getIndex() {
        $convocatorias = Convocatoria::orderBy("con_estado")
            ->orderBy("con_fecha_apertura")->paginate(8);
        if (Session::has("idPersona")) {
            $rol = "";
            if (Session::get('rol actual') == "administrador investigativo")
                $rol = "adminv";
            else if (Session::get('rol actual') == "investigador")
                $rol = "inv";
            else if ((Session::get('rol actual') == "evaluador"))
                $rol = "eval";
            return view("plantillas/convocatorias")->with("convocatorias",$convocatorias)->with("rol",$rol);
        }

        return view("plantillas/convocatorias")->with("convocatorias",$convocatorias);
    }

    public function getInfo($id){
        $convocatoria = Convocatoria::find($id);
        if($convocatoria){
            return view("plantillas/convocatoria_info")->with("convocatoria",$convocatoria);       
        }
        return redirect('');
    }
}
