@extends("plantillas/master")
@section('encabezado')
    @if(isset($rol))
    @include('roles/secciones/encabezado')
    @else
    @include('secciones/encabezado')
    @endif
@stop

@section("css")
    <style>
        /*.select-wrapper ul,.select-wrapper .select-dropdown,.select-wrapper .caret{
            display: none !important;
        }

        .select-wrapper select{
                display: inline-block !important;
                height: auto !important;
                min-height: 200px !important;
        }*/

        .dropdown-content{
            overflow: auto;
        }
        .dropdown-content li span{
            padding: 0px !important;
            font-size: small;
        }

        .dropdown-content li span label{
            height: 20px !important;
        }

        input[type="checkbox"]+label:before{
            top: 5px !important;
            margin-left: 5px !important;
        }
    </style>
@stop

@if(isset($rol))
    @section('menus')
            @include ('roles/'.$rol.'/secciones/menu')
    @stop
@endif

@section('contenidoPagina')

@if(Session::get("msjEntidad"))
    <script>
        $(function(){
            var mensaje = "{{Session::get('msjEntidad')}}";
            lanzarMensaje("Mensaje",mensaje,4000,4);
        })
    </script>
@endif

<p class="tituloPrincipalPag tituloGrande">Entidades - {{$proyecto->pro_titulo}}</p>
 <div class="col s12 white">
    @if(count($proyecto->entidades))
        <ul class="collection">
            @foreach($proyecto->entidades as $entidad)
                <li class="collection-item col s12">
                    <div class="col s12 m11">
                        <?php
                            $localizacion = $entidad->localizacion;
                            if(!$localizacion)
                             $localizacion = new \App\Models\Localizacion();
                        ?>
                        @if($localizacion->loc_sitio_web != "")
                            <?php
                                $datos = explode(':',$localizacion->loc_sitio_web);
                                $url = $localizacion->loc_sitio_web;
                                if(count($datos)){
                                   if($datos[0] != "http")
                                    $url = "http://".$url;
                                }
                            ?>
                            <a class="title teal-text" href="{{$url}}" target="_blank">{{$entidad->ent_nombre}}</a>
                        @else
                            <span class="title">{{$entidad->ent_nombre}}</span>
                        @endif
                        <p class="texto-informacion-medium">{{$entidad->ent_telefono.' / '.$localizacion->loc_correo}}<br>
                            @if($localizacion->exists)
                                {{$localizacion->direccion->ciudad->ciu_nombre.' - '.$localizacion->direccion->ciudad->departamento->dep_nombre}}
                            @endif
                        </p>
                    </div>

                    @if($proyecto->pro_estado == "proyecto aprobado" && $proyecto->permisoEditar())
                        <div class="col s12 m1">
                            <a href="#!" class="right teal-text col m12 s2" ><i class="material-icons right">send</i></a>
                            <a href="#modal_delete_relacion" class="modal-trigger right red-text darken-3 col m12 s2" onclick="relacionDelete='{{\Illuminate\Support\Facades\Crypt::encrypt($entidad->id)}}'"><i class="material-icons right">delete</i></a>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p class="center">Este proyecto aún no tiene entidades asociadas.</p>
    @endif
    @if($proyecto->permisoEditar() && $proyecto->pro_estado == "proyecto aprobado")
        <div class="col s12" style="margin-top: 25px;">
        <form id="form_relacion_entidad">
            <p class="tituloMediano">Más entidades</p>
            <div class="col s12 divider teal lighten-2" style="margin-top: -15px;margin-bottom: 25px;"></div>
            @if(isset($masEntidades) && count($masEntidades))

                <div class="col s12 m6 l8">
                    <select name="entidad" id="entidad">
                        <option value="">Seleccione</option>
                        @foreach($masEntidades as $ent)
                            <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($ent->id)}}">{{$ent->ent_nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input-field col s12 m6 l4">
                    <input type="text" name="aporte" id="aporte">
                    <label from="aporte">Aporte</label>
                </div>

                <input type="hidden" name="proyecto" id="proyecto" value="{{\Illuminate\Support\Facades\Crypt::encrypt($proyecto->id)}}">
                <div class="col s12">
                        <a class="btn right modal-trigger" href="#modal_relacion_entidad">Agregar</a>
                    <div class="col s12 divider hide-on-med-and-up"></div>
                        <a class="btn right">Ver</a>
                </div>
            @else
                <p class="center">No existen más entidades para seleccionar.</p>
            @endif
            </form>
        </div>

        <div class="col s12" style="margin-top: 25px;">
            <p class="tituloMediano">Crear entidad</p>
            <div class="col s12 divider teal lighten-2" style="margin-top: -15px;margin-bottom: 25px;"></div>
            <form id="form_entidad">
                @include('roles.inv.modulos.perfil.subModulos.formularEntidades')
            </form>
        </div>
    @endif
 </div>
 <!-- Modal Structure -->
   <div id="modal_relacion_entidad" class="modal modal-fixed-footer" style="margin-top: 100px;height: 40% !important;">
     <div class="modal-content">
       <p class="tituloMediano teal-text">¿Esta seguro de guardar la relación seleccionda?</p>
     </div>
     <div class="modal-footer">
        <div class="progress invisible" id="progress-relacion"><div class="indeterminate"></div></div>
        <div class="contenedor-botones-relacion">
            <a href="#!" class="modal-action waves-effect waves-orange btn-flat" onclick="relacionEntidad()">ok</a>
            <a href="#!" class="modal-action modal-close waves-effect waves-orange btn-flat ">cancelar</a>
        </div>
     </div>
   </div>

   <div id="modal_delete_relacion" class="modal modal-fixed-footer" style="margin-top: 100px;height: 40% !important;">
        <div class="modal-content">
          <p class="tituloMediano teal-text">¿Esta seguro de eliminar la relación seleccionda?</p>
        </div>
        <div class="modal-footer">
           <div class="progress invisible" id="progress-relacion-delete"><div class="indeterminate"></div></div>
           <div class="contenedor-botones-relacion-delete">
               <a href="#!" class="modal-action waves-effect waves-orange btn-flat" onclick="deleteRelacion()">ok</a>
               <a href="#!" class="modal-action modal-close waves-effect waves-orange btn-flat ">cancelar</a>
           </div>
        </div>
      </div>
@stop

@section('js')
@parent
    <script src="{{asset('Js/crearEntidad.js')}}"></script>
@stop