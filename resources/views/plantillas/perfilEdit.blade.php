@extends("plantillas/master")
@section('encabezado')
    @if(isset($rol))
    @include('roles/secciones/encabezado')
    @else
    @include('secciones/encabezado')
    @endif
@stop

@section('css')
    <style>
        .imgUserPerfil{
            width: 200px;
            height: 200px;
            background-color: white;
            margin: 0 auto;
            border-radius: 5px;
        }

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
                top: -10px !important;
                margin-left: -5px !important;
            }
    </style>
@stop

@section('menus')
    @if(isset($rol))
        @include ('roles/'.$rol.'/secciones/menu')
    @else

    @endif
@stop

@section('js')
    <script src="{{asset('Js/cuentaPerfilEditar.js')}}"></script>
@stop

@section('contenidoPagina')

@if(Session::get("msjPerfilCuenta"))
    <script>
        $(function(){
            var mensaje = "{{Session::get('msjPerfilCuenta')}}";
            lanzarMensaje("Mensaje",mensaje,4000,4);
        })
    </script>
@endif

<p class="tituloPrincipalPag tituloGrande">Editar perfil SINERGIA</p>
@if($persona)
    <?php
        $perfil = $persona->perfil;
        $lineas = null;
        if($perfil)
        $lineas = $perfil->lineasInvestigacion;

        $lineasInvestigacion = \App\Models\LineaInvestigacion::all();
    ?>



    <div class="col s12 white" style="padding-top: 30px;">

        <form id="form_informacion_personal">
            <div class="col s12 m6">
                <p style="margin-bottom: 60px;">
                    Todos los campos con (<i class="material-icons texto-rojo">star_rate</i>) son obligatorios.
                </p>
                <div id="" style="background-image: url(<?php
                        $archivo = "imagenes/perfil/" . session('idPersona');

                        if (file_exists($archivo . '.png')) {
                            $archivo .= '.png';
                            echo asset($archivo);
                        } else if (file_exists($archivo . '.jpg')) {
                            $archivo .= '.jpg';
                            echo asset($archivo);
                        } else {
                            $archivo = 'imagenes/perfil/user.png';
                            echo asset($archivo);
                        }
                        ?>); <?php
                             $datosImg = getimagesize($archivo);
                             if ($datosImg[0] > $datosImg[1]) {
                                 echo 'background-size: auto 100%;';
                             } else {
                                 echo 'background-size: 100% auto;';
                             }
                             ?>" class="imgUserPerfil"></div>

                <p class="col s12" style="margin-top: 10px;">
                    <input type="checkbox" id="imagenDefecto" />
                    <label for="imagenDefecto">Utilizar imagen por defecto</label>
                </p>


                <div class="file-field input-field col s12" style="margin-top: -10px;">
                    <input class="file-path validate col s12" type="text" style="" />
                    <div class="btn col s12 btn-verde">
                        <span>Cambiar imagen</span>
                        <input type="file" name="archivo" id="archivo" style=""/>
                    </div>
                </div>


                <div class="input-field" style="margin-top: 173px;">
                    <input type="password" id="nueva_contrasena" name="nueva_contrasena" value=""/>
                    <label for="nueva_contrasena" class="active">Nueva contraseña</label>
                </div>

                <div class="input-field" style="margin-top: 39px;">
                    <input type="password" id="nueva_contrasena_verificacion" name="nueva_contrasena_verificacion" value=""/>
                    <label for="nueva_contrasena_verificacion" class="active">Verifique nueva contraseña</label>
                </div>

            </div>

            <div class="col s12 m6">

                <div class="input-field">
                    <input type="text" id="identificacion" name="identificacion"  value="{{$persona->per_identificacion}}"/>
                    <label for="identificacion" class="active">Identificación<i class="material-icons texto-rojo">star_rate</i></label>
                </div>

                <div class="input-field">
                    <input type="text" id="nombres" name="nombres"  value="{{$persona->per_nombres}}"/>
                    <label for="nombres" class="active">Nombres<i class="material-icons texto-rojo">star_rate</i></label>
                </div>

                <div class="input-field">
                    <input type="text" id="apellidos" name="apellidos"  value="{{$persona->per_apellidos}}"/>
                    <label for="apellidos" class="active">Apellidos<i class="material-icons texto-rojo">star_rate</i></label>
                </div>

                <div class="input-field">
                    <input type="text" id="correo" name="correo"  value="{{$persona->per_correo}}"/>
                    <label for="correo" class="active">Correo<i class="material-icons texto-rojo">star_rate</i></label>
                </div>

                <div class="input-field">
                    <input type="tel" id="celular" name="celular"  value="{{$persona->per_numero_celular}}"/>
                    <label for="celular" class="active">Celular<i class="material-icons texto-rojo">star_rate</i></label>
                </div>

                <div class="input-field">
                    <input type="tel" id="telefono" name="telefono" value="{{$persona->per_numero_telefono}}"/>
                    <label for="telefono" class="active">Telefono</label>
                </div>

                <div class="input-field">
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{$persona->per_fecha_nacimiento}}"/>
                    <label for="fecha_nacimiento" class="active">Fecha de nacimiento</label>
                </div>

                <div class="input-field" style="margin-top: 40px;">
                    <select id="genero" name="genero">
                        @if($persona->per_genero == '1')
                            <option value="">Seleccione</option>
                            <option value="1" selected>Masculino</option>
                            <option value="2">Femenino</option>
                        @elseif($persona->per_genero == '2')
                            <option value="">Seleccione</option>
                            <option value="2" selected>Femenino</option>
                            <option value="1">Masculino</option>
                        @else
                            <option value="">Seleccione</option>
                            <option value="1">Masculino</option>
                            <option value="2">Femenino</option>
                        @endif
                    </select>
                    <label for="genero" class="active">Genero</label>
                </div>

             </div>

            <a class="btn teal darken-1 texto-blanco right waves waves-effect modal-trigger" href="#modalContrasena" id="btnGuardarInformacionGeneral" style="margin-bottom: 15px; margin-top: 15px;">Guardar</a>
        </form>
    </div>

    @if(\Illuminate\Support\Facades\Session::has('investigador') && \Illuminate\Support\Facades\Session::has('investigador') == "activo")
    @if(!$perfil)
        <?php $perfil = new \App\Models\Perfil();?>
    @endif
    <div class="col s12 white" style="margin-top: 30px;">
        <p class="tituloPrincipalPag tituloMediano">Habilidades</p>
        <form id="form_habilidades">
            <div class="input-field">
                <textarea class="materialize-textarea" id="cargos" name="cargos" maxlength="200" length="200">{{$perfil->per_cargo}}</textarea>
                <label for="cargos" class="active">Cargos que puede desempeñar<i class="material-icons texto-rojo">star_rate</i></label>
            </div>


            <div class="input-field">
                <textarea class="materialize-textarea" id="perfil" name="perfil" maxlength="5000" length="5000">{{$perfil->per_perfil}}</textarea>
                <label for="perfil" class="active">Perfil<i class="material-icons texto-rojo">star_rate</i></label>
            </div>

            <div class="input-field">
                <textarea class="materialize-textarea" id="habilidades" name="habilidades" maxlength="5000" length="5000">{{$perfil->per_habilidades}}</textarea>
                <label for="habilidades" class="active">Habilidades<i class="material-icons texto-rojo">star_rate</i></label>
            </div>

            <div class="input-field" style="margin-top: 40px;">
                <select name='lineas_investigacion[]' id='lineas_investigacion' multiple='multiple'>
                    <option disabled="disabled">Seleccione</option>
                    @foreach($lineasInvestigacion as $l)
                        <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($l->id)}}"
                        @if(count($lineas))
                            @foreach($lineas as $lin)
                                @if($lin->id == $l->id)
                                    selected
                                    <?php break; ?>
                                @endif
                            @endforeach
                        @endif
                        >{{$l->lin_inv_nombre}}</option>
                    @endforeach
                </select>
                <label for="cargo" class="active">Lineas de investigación</label>
            </div>
        </form>

        <a class="btn teal darken-1 texto-blanco right waves waves-effect modal-trigger" href="#modalContrasena" id="btnGuardarHabilidades" style="margin-bottom: 15px; margin-top: 15px;">Guardar</a>
    </div>
    @endif

    <div id="modalContrasena" class="modal modal-fixed-footer" style="margin-top: 100px; min-height: 330px; height: auto; overflow: hidden;">
        <div class="modal-content">
          <h4 class="tituloPrincipalPag">Contraseña</h4>
          <p class="justificado">Por la seguridad de su información personal es necesario que ingrese su contaseña actual para finalizar el proceso
          de configuración de su perfil.</p>
          <div class="input-field col s12 m10 offset-m1" style="margin-top: 50px;">
            <label for="contrasenaActual">Contraseña actual</label>
            <input type="password" id="contrasenaActual" name="contrasenaActual">
          </div>
        </div>
        <div class="modal-footer">
          <div class="col s12 contenedor-botones">
                <a href="#!" class="waves-effect btn-flat" id="btnGuardarConfiguracionPerfil">Guardar</a>
                <a href="#!" class="modal-close waves-effect btn-flat">Cancelar</a>
          </div>

          <div class="progress invisible">
              <div class="indeterminate"></div>
          </div>

        </div>


    </div>

    <input type="hidden" id="email" value="{{$persona->per_correo}}">
    <input type="hidden" id="idPersona" value="{{\Illuminate\Support\Facades\Crypt::encrypt($persona->id)}}">
@else
    <p style="margin-bottom: 200px;">La información recibida es incorrecta..</p>
@endif
@stop