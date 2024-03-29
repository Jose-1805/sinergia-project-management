<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditarComponenteRequest extends Request {

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
            'nombre' => 'required|max:80',
            'objetivo' => 'required|max:250',
            'equivalente' => 'required|numeric'
		];
	}

}
