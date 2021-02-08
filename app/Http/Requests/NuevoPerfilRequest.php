<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Session;

class NuevoPerfilRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules =  [
            "titulo" => "required|unique:proyecto,pro_titulo",
            "objetivoGeneral"=>"required",
            "problema"=>"required",
            "justificacion"=>"required",
            "presupuesto"=>"required|numeric",
            "sector"=>"required"
        ];

        if(!Session::has("idPersona")){
            $rules["nombres"] = "required";
            $rules["apellidos"] = "required";
            $rules["correo"] = "required|email";
        }
        return $rules;
    }

}
