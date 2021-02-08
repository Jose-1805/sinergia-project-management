<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class actionsActividadRequest extends Request {

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
			'id-componente'=>'required',
            'descripcion'=>'required|max:200',
            'indicador'=>'required|max:150',
            'resultado'=>'required|max:150',
            'mes-inicio'=>'required|numeric',
            'duracion'=>'required|numeric'
		];
	}

}
