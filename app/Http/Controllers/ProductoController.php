<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;

class ProductoController extends Controller {


    public function __construct(){

    }

    public function postUpdate(Request $request){
        $idProducto = Crypt::decrypt($request->input('idProducto'));
        $producto = Producto::find($idProducto);
        if($producto && $producto->pro_estado != "delete"){
            if($request->has('descripcion') && $request->input('descripcion') != ''){
                $producto->pro_descripcion = $request->input('descripcion');
                $producto->save();
                return '1';
            }
        }
        return '-1';
    }

}
