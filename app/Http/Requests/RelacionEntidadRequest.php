<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class RelacionEntidadRequest extends Request {

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
			"proyecto"=>"required",
            "entidad"=>"required",
            "aporte"=>"required|digits_between:5,10"
		];
	}

}
