<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ActionsHabilidadesRequest extends Request {

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
        /*return [
            'nueva_contrasena'=> 'max:50',
            'nueva_contrasena_verificacion' => 'required_with:nueva_contrasena|max:50',
            'identificacion' => 'required|max:250',
            'nombres' => 'required|numeric',
            'apellidos' => '',
            'correo' => '',
            'celular' => ''
        ];*/

        return [
            'cargos'=> 'required|max:200',
            'perfil' => 'required|max:5000',
            'habilidades' => 'required|max:5000'
        ];
	}

}
