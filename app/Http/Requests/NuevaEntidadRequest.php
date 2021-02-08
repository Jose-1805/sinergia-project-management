<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NuevaEntidadRequest extends Request {

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
        "Nombre" => "required|unique:entidad,ent_nombre",
        "Telefono" => "required|numeric",
        "Identidficacion" => "required",
        "CamaraComercio" => "required|unique:entidad,ent_matricula_c_comercio",
        "SectorEconomico" => "required",
        "NumeroDeEmpleados"=>"required|numeric",
        "FechaDeConstitucion"=>"required|date",
        "Estado"=>"required|in:ejecutora,propuesta",
        "entActividadEco"=>"required|exists:actividadeconomica,id",
        "CiudadDeLocalizacion"=>"required",
        "NumeroDeLaCalle"=>"required",
        "NumeroDeLaCarrera"=>"required",
        "NumeroDeEdificacion"=>"required",
        "CorreoDeLocalizacion"=>"required|email|unique:localizacion,loc_correo",
        "FaxDeLocalizacion"=>"required",
        "SitioWebDeLocalizacion"=>"required|unique:localizacion,loc_sitio_web"
        ];
    }

}
