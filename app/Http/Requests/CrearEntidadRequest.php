<?php namespace App\Http\Requests;

use App\Http\Middleware\AutenticacionAdminv;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Session;

class CrearEntidadRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        $rules = [];

        $rules["nombre_entidad"] = "required|unique:entidad,ent_nombre";
        $rules["actividad_economica"] = "required";
        $rules["matricula_camara_comercio"] = "required";
        $rules["telefono_entidad"] = "required|digits_between:6,15";
        $rules["correo_entidad"] = "required|email";
        $rules["sitio_web"] = "regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/";
        $rules["ciudad"] = "required";
        $rules["direccion_numero"] = "required";
        $rules["nombre_completo_contacto"] = "required";
        $rules["telefono_contacto"] = "required|digits_between:6,15";
        $rules["correo_contacto"] = "required|email";
        $rules["fecha_constitucion"] = "date";

        if(Session::has('investigador') && Session::get('investigador') == "activo" && !AutenticacionAdminv::check()) {
            //$rules["actividad"] = "required";
            $rules["aporte"] = "required|digits_between:5,10";
        }
		return $rules;
	}

}
