<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class GDPDocumentoRequest extends Request {

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
       'doc_objetivo'=>'max:120|required',
       'doc_descripcion'=>'max:120|required',
       'doc_asunto'=>'max:120|required',
       'documento'=>'mimes:pdf|required|between:100,4000000',
       'doc_fechacreacion'=>"required|date"
        ];

	}
}
