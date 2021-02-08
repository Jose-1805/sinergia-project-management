<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class GuardarEventoRequest extends Request {

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
			"titulo"=>"required|max:30",
            "descripcion_corta"=>"required|max:100",
            "descripcion_detallada"=>"required|max:3000",
            "estado"=>"required|in:habilitado,inhabilitado"
		];
	}

}
