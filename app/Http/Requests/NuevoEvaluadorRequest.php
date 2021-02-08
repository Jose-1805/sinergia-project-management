<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NuevoEvaluadorRequest extends Request {

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
        return [
            "Nombres" => "required",
            "Apellidos" => "required",
            "Identidficacion" => "required|unique:persona,per_identificacion|numeric",
            "Telefono" => "required|numeric",
            "Celular" => "required|numeric",
            "FechaDeNacimiento"=>"required|date",
            "Genero"=>"required|numeric|in:1,0",
            "Correo"=>"required|email|unique:persona,per_correo",
            "TipoDeEvaluador"=>"required|in:Técnico,Tecnólogo,Profesional"
        ];
    }

}
