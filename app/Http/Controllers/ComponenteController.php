<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Componente;
use Illuminate\Http\Request;
use App\Http\Requests\EditarComponenteRequest;
use Illuminate\Support\Facades\Crypt;

class ComponenteController extends Controller {


    public function __construct(){

    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postUpdate(EditarComponenteRequest $request)
	{
        $idComponente = Crypt::decrypt($request->input('idComponente'));
        $componente = Componente::find($idComponente);

        if($componente->com_estado == "delete"){
            return "EL componente que esta intentando editar ha sido descartado del proyecto anteriormente.";
        }
        $componentes = Componente::where('proyectoinvestigativo_id',$componente->proyectoinvestigativo_id)
        ->where("com_estado","<>","delete")
        ->whereNotIn('id',[$componente->id])->get();
        $totalEquivalente = 0;
        foreach($componentes as $comp){
            $totalEquivalente += $comp->com_equivalente;
        }

        if(($totalEquivalente +  $request->input('equivalente')) != 100){
            return 'El resultado de la suma del equivalente de todos los componentes debe ser 100, pero actualmente es '.$totalEquivalente;
        }
        $componente->com_nombre = $request->input('nombre');
        $componente->com_objetivo = $request->input('objetivo');
        $componente->com_equivalente = $request->input('equivalente');
        $componente->save();
        return '1';
	}

}
