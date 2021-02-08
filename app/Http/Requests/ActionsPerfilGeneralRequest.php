<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ActionsPerfilGeneralRequest extends Request {

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
		return [
			"identificacion"=>"required|digits_between:8,15",
            "nombres"=>"required|max:45",
            "apellidos"=>"required|max:45",
            "correo"=>"required|max:50",
            "celular"=>"required|digits_between:8,12",
            "telefono"=>"digits_between:6,12",
            "nueva_contrasena"=> "max:50|min:6",
            "nueva_contrasena_verificacion" => "required_with:nueva_contrasena|max:50|min:6"
		];
	}

}
