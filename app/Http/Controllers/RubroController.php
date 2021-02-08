<?php namespace App\Http\Controllers;

use App\Http\Middleware\AutenticacionInv;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\ComponenteRubro;
use App\Models\Rubro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RubroController extends Controller {

	public function __construct(){

    }
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function postUpdate(Request $request)
	{
        if(AutenticacionInv::check()) {
            $rubro = Rubro::find(Crypt::decrypt($request->input('id_rubro')));
            if ($rubro->exists && $rubro->rub_estado != "delete") {
                DB::beginTransaction();
                foreach ($rubro->componentesRubro as $item) {
                    $item->delete();
                }

                $rubro->rub_nombre = $request->input('nombre');
                $rubro->save();
                $cantidadComponentes = $request->input('cantidadComponentes');

                $errors = [];
                //while(count($errors) == 0){
                for ($e = 1; $e <= $cantidadComponentes; $e++) {
                    if ($request->input('nombre'. $e) && $request->input('cantidad'.$e) && $request->input('valorUnitario'.$e)) {
                        $componenteRubro = new ComponenteRubro();
                        $componenteRubro->com_rub_nombre = $request->input('nombre'. $e);
                        $componenteRubro->com_rub_cantidad = $request->input('cantidad'. $e);
                        $componenteRubro->com_rub_valor_unitario = $request->input('valorUnitario'. $e);
                        $componenteRubro->rubro_id = $rubro->id;
                        $componenteRubro->save();
                    } else {
                        $errors['error_' . (count($errors) + 1)] = "Es necesario ingresar toda la información de los componentes de un rubro.";
                        break;
                    }
                }

                if (count($errors)) {
                    return response()->json($errors);
                }
                DB::commit();
                return '1';
            }
        }else{
            return response('Unauthorized.', 401);
        }
   	}


}
