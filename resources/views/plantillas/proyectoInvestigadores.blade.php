<?php
    $persona = \App\Models\Persona::find(\Illuminate\Support\Facades\Session::get('idPersona'));
    $inv = $persona->investigador;
?>
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

@if(Session::get("msjInvestigador"))
    <script>
        $(function(){
            var mensaje = "{{Session::get('msjInvestigador')}}";
            lanzarMensaje("Mensaje",mensaje,4000,4);
        })
    </script>
@endif

<p class="tituloPrincipalPag tituloGrande">Investigadores - {{$proyecto->pro_titulo}}</p>
 <div class="col s12 white">
 @if(\Illuminate\Support\Facades\Session::get('rol actual') == 'investigador' && $inv && $proyecto->proyectoInvestigativo->investigador_id == $inv->id)
    <p class="texto-informacion-medium"><strong>Nota: </strong>Su proyecto podrá tener un máximo de 10 integrantes, cada investigador creado por usted será vinculado al proyecto inmediatamente despues de su registro,
     puede enviar cuantas solicitudes quiera. pero una vez se encuentren 10 personas vinculadas a su proyecto
     no podrán ser enviadas mas solicitudes y tampoco podrá registrar mas investigadores.</p>
 @endif
    @if(count($relaciones))
        <table class="highlight centered responsive-table">
            <thead>
                <tr>
                    <th>Investigador <p class="texto-informacion-medium">(clic perfil)</p></th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Fecha solicitud</th>
                    <th>Estado solicitud</th>
                </tr>
            </thead>

            <tbody>
                @foreach($relaciones as $relacion)
                    <tr>
                        <?php $persona =  $relacion->investigador->persona;?>
                        <td><a class="teal-text" target="_blank" href="{{url('/').'/perfil/view/'.\Illuminate\Support\Facades\Crypt::encrypt($persona->id)}}">{{$persona->per_nombres.' '.$persona->per_apellidos}}</a></td>
                        <td>{{$persona->per_correo}}</td>
                        <td>{{$relacion->pro_inv_rol}}</td>
                        <td>{{date('Y-m-d',strtotime($relacion->created_at))}}</td>
                        <td>{{$relacion->pro_inv_estado_solicitud}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="center">Este proyecto aún no investigadores asociados.</p>
    @endif
    @if(\Illuminate\Support\Facades\Session::get('rol actual') == 'investigador' && $inv && $proyecto->proyectoInvestigativo->investigador_id == $inv->id && $proyecto->pro_estado == "proyecto aprobado")
        <div class="col s12" style="margin-top: 25px;">
            <p class="tituloMediano">Más investigadores</p>
            <div class="col s12 divider teal lighten-2" style="margin-top: -15px;margin-bottom: 25px;"></div>
            @if(isset($masInvestigadores) && count($masInvestigadores))
                <table class="highlight centered responsive-table">
                    <thead>
                        <tr>
                            <th>Investigador <p class="texto-informacion-medium">(clic perfil)</p></th>
                            <th>Correo</th>
                            <th>Solicitud</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($masInvestigadores as $inv)
                            <tr>
                                <?php $per =  $inv->persona;?>
                                <td><a class="teal-text" target="_blank" href="{{url('/').'/perfil/view/'.\Illuminate\Support\Facades\Crypt::encrypt($per->id)}}">{{$per->per_nombres.' '.$per->per_apellidos}}</a></td>
                                <td>{{$per->per_correo}}</td>
                                <td><a class="btn modal-trigger relacion_investigador" href="#modal_relacion_investigador" id="{{\Illuminate\Support\Facades\Crypt::encrypt($inv->id)}}">Enviar</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="center">No existen más investigadores a los cuales enviar la solicitud.</p>
            @endif
        </div>

        <div class="col s12" style="margin-top: 25px;">
            <p class="tituloMediano">Crear investigador</p>
            <div class="col s12 divider teal lighten-2" style="margin-top: -15px;margin-bottom: 25px;"></div>

            <p class="texto-informacion-medium"><strong>Nota: </strong> antes de registrar la información de un nuevo investigador, asegurese de que el correo es correcto, este paso no tiene vuelta atras y la persona con el correo registrado quedará directamente vinculada a su proyecto.</p>
            <form id="form_investigador">
                <div class="input-field col s12 m6">
                    <label class="active" for="nombres">Nombres</label>
                    <input type="text" id="nombres" name="nombres" value=" ">
                </div>

                <div class="input-field col s12 m6">
                    <label class="active" for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" value=" ">
                </div>

                <div class="input-field col s12 m6">
                    <label class="active" for="correo">Correo</label>
                    <input type="text" id="correo" name="correo" value=" ">
                </div>

                <div class="input-field col s12 m6">
                    <label class="active" for="cargo">Cargo</label>
                    <input type="text" id="cargo" name="cargo" value=" ">
                </div>

                <input type="hidden" id="proyecto" name="proyecto" value="{{\Illuminate\Support\Facades\Crypt::encrypt($proyecto->id)}}">

                <div class="col s12 contenedor-botones-investigador" style="margin-top: 15px; margin-bottom: 30px;">
                    <a class="col s12 btn teal darken-1 white-text waves-effect waves-light" id="btnGuardarNuevoInvestigador">Guardar</a>
                </div>

                <div class="progress progress-investigador invisible">
                    <div class="indeterminate"></div>
                </div>
            </form>
        </div>
    @endif
 </div>
 <!-- Modal Structure -->
   <div id="modal_relacion_investigador" class="modal modal-fixed-footer" style="margin-top: 100px;height: 45% !important;">
     <div class="modal-content">
       <p class="titulo teal-text">¿Esta seguro de enviar la solicitud al investigador?</p>
       <p>Para enviar la solicitud es necesario ingresar a continuación el rol o cargo que desea que desempeñe el investigador en el desarrollo del proyecto.</p>

        <form id="form_solicitud_investigador">
            <div class="input-field">
                <label class="active">Cargo</label>
                <input type="text" name="cargo_investigador" id="cargo_investigador" value=" ">
            </div>

            <input type="hidden" name="proyecto" id="proyecto" value="{{\Illuminate\Support\Facades\Crypt::encrypt($proyecto->id)}}">
            <input type="hidden" name="investigador" id="investigador" value="">
        </form>

     </div>
     <div class="modal-footer">
        <div class="progress invisible progress-relacion"><div class="indeterminate"></div></div>
        <div class="contenedor-botones-relacion">
            <a href="#!" class="modal-action waves-effect waves-orange btn-flat" onclick="enviarSolicitud()">ok</a>
            <a href="#!" class="modal-action modal-close waves-effect waves-orange btn-flat ">cancelar</a>
        </div>
     </div>
   </div>
@stop

@section('js')
@parent
    <script src="{{asset('Js/inv/proyecto/proyectoInvestigadores.js')}}"></script>
@stop