<?php namespace App\Http\Controllers;

use App\Http\Middleware\AutenticacionAdminv;
use App\Http\Middleware\AutenticacionInv;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CrearEntidadRequest;

use App\Models\Actividad;
use App\Models\ActividadEconomica;
use App\Models\Ciudad;
use App\Models\Direccion;
use App\Models\Entidad;
use App\Models\EntidadActividad;
use App\Models\Localizacion;
use App\Models\Personal;
use App\Models\Proyecto;
use App\Models\ProyectoEntidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EntidadController extends Controller {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	public function postStore(CrearEntidadRequest $request)
	{
        if(AutenticacionAdminv::check() || AutenticacionInv::check()){
            DB::beginTransaction();
            $entidad = new Entidad();
            $direccion = new Direccion();
            $localizacion = new Localizacion();

            $idCiudad = Crypt::decrypt($request->input('ciudad'));
            $ciudad = Ciudad::find($idCiudad);
            if(!$ciudad)return "-1";

            $direccion->dir_calle = $request->input("calle");
            $direccion->dir_carrera = $request->input("carrera");
            $direccion->dir_numero = $request->input("direccion_numero");
            $direccion->ciudad_id = $ciudad->id;
            $direccion->save();

            $localizacion->loc_fax = $request->input("fax");
            $localizacion->loc_sitio_web = $request->input("sitio_web");
            $localizacion->loc_correo = $request->input("correo_entidad");
            $localizacion->direccion_id = $direccion->id;
            $localizacion->save();


            $idActividadEconomica = Crypt::decrypt($request->input("actividad_economica"));
            $actividadEconomica = ActividadEconomica::find($idActividadEconomica);
            if(!$actividadEconomica){return "-1";}
            $entidad->ent_nombre = $request->input("nombre_entidad");
            $entidad->ent_tipo_identificacion = $request->input("tipo_identificacion");
            $entidad->ent_telefono = $request->input("telefono_entidad");
            $entidad->ent_matricula_c_comercio = $request->input("matricula_camara_comercio");
            $entidad->ent_numero_empleados = $request->input("cantidad_empleados");
            $entidad->ent_fecha_constitucion = $request->input("fecha_constitucion");
            $entidad->ent_estado = "ejecutora";
            $entidad->actividadeconomica_id = $actividadEconomica->id;
            $entidad->persona_id = Session::get('idPersona');
            $entidad->localizacion_id = $localizacion->id;
            $entidad->save();

            $personal = new Personal();

            $personal->per_nombre_completo = $request->input("nombre_completo_contacto");
            $personal->per_telefono = $request->input("telefono_contacto");
            $personal->per_cargo = $request->input("cargo");
            $personal->per_correo = $request->input("correo_contacto");
            $personal->entidad_id = $entidad->id;
            $personal->save();

            if(Session::get("rol actual") == "investigador" && !AutenticacionAdminv::check()){
                $proyecto = Proyecto::find(Crypt::decrypt($request->input('proyecto')));

                if(!$proyecto)return "-1";

                $lider = $proyecto->proyectoInvestigativo->investigadorLider->persona;
                if($lider->id != Session::get('idPersona'))return "-1";

                /*$entidadActividad = new EntidadActividad();
                $entidadActividad->ent_act_aporte = $request->input("aporte");
                $entidadActividad->actividad_id = $actividad->id;
                $entidadActividad->entidad_id = $entidad->id;
                $entidadActividad->save();*/

                $proyectoEntidad = new ProyectoEntidad();
                $proyectoEntidad->proyecto_id = $proyecto->id;
                $proyectoEntidad->entidad_id = $entidad->id;
                $proyectoEntidad->pro_ent_aporte = $request->input('aporte');
                $proyectoEntidad->save();
                DB::commit();
                Session::flash("msjEntidad","La entidad ha sido registrada en el sistema.");
                return "1";
            }
            DB::commit();
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
