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
    </style>
@stop

@section('menus')
    @if(isset($rol))
        @include ('roles/'.$rol.'/secciones/menu')
    @else

    @endif
@stop

@section('contenidoPagina')
<p class="tituloPrincipalPag tituloGrande">Perfil SINERGIA</p>
@if($persona)
    <?php
        $perfil = $persona->perfil;
        $lineas = null;
        if($perfil)
        $lineas = $perfil->lineasInvestigacion;
    ?>

    <div class="col s12 m3">
        <div id="" style="background-image: url(<?php
                $archivo = "imagenes/perfil/" . $persona->id;

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
    </div>

    <div class="col s12 m9 white">
        <p class="tituloPrincipalPag tituloMediano">Información personal</p>

        <div class="col s12">
            <p class="titulo col s12 m4 l3">Identificación: </p>
            <p class="col s12 m8 l9 trucate">
                @if($persona->per_identificacion != '')
                    {{$persona->per_identificacion}}
                @else
                    No establecido.
                @endif
            </p>
        </div>

        <div class="col s12">
            <p class="titulo col s12 m4 l3">Nombre: </p>
            <p class="col s12 m8 l9 trucate">
                    @if($persona->per_nombres.' '.$persona->per_apellidos != '')
                        {{$persona->per_nombres.' '.$persona->per_apellidos}}
                    @else
                        No establecido.
                    @endif
            </p>
        </div>

        <div class="col s12">
            <p class="titulo col s12 m4 l3">Correo: </p>
            <p class="col s12 m8 l9 trucate">
                @if($persona->per_correo != '')
                    {{$persona->per_correo}}
                @else
                    No establecido.
                @endif
            </p>
        </div>

        <div class="col s12">
            <p class="titulo col s12 m4 l3">Celular: </p>
            <p class="col s12 m8 l9 trucate">
                @if($persona->per_celular != '')
                    {{$persona->per_celular}}
                @else
                    No establecido.
                @endif
            </p>
        </div>

        <div class="col s12">
            <p class="titulo col s12 m4 l3">Telefono: </p>
            <p class="col s12 m8 l9 trucate">
                @if($persona->per_telefono != '')
                    {{$persona->per_telefono}}
                @else
                    No establecido.
                @endif
            </p>
        </div>

        <div class="col s12">
            <p class="titulo col s12 m4 l3">Fecha nacimiento: </p>
            <p class="col s12 m8 l9 trucate">
                @if($persona->per_fecha_nacimiento != '')
                    {{$persona->per_fecha_nacimiento}}
                @else
                    No establecido.
                @endif
            </p>
        </div>

        <div class="col s12">
            <p class="titulo col s12 m4 l3">Genero: </p>
            <p class="col s12 m8 l9 trucate">
                @if($persona->per_genero != '')
                    @if($persona->per_genero == '1')
                        Masculino
                    @elseif($persona->per_genero == '2')
                        Femenino
                    @endif
                @else
                    No establecido.
                @endif
            </p>
        </div>
    </div>


    @if($perfil)
        <div class="col s12 white" style="margin-top: 30px;">
            <p class="tituloPrincipalPag tituloMediano">Habilidades</p>

            <div class=" col s12">
                <p class="titulo">Cargo(s) que puedo desempeñar</p>
                @if($perfil->per_cargo != '')
                    <p class="comprimible">{{$perfil->per_cargo}}</p>
                @else
                    <p>No establecido.</p>
                @endif
            </div>

            <div class=" col s12">
                <p class="titulo">Perfil laboral</p>
                @if($perfil->per_perfil != '')
                    <p class="comprimible">{{$perfil->per_perfil}}</p>
                @else
                    <p>No establecido.</p>
                @endif
            </div>

            <div class=" col s12">
                <p class="titulo">Habilidades</p>
                @if($perfil->per_habilidades != '')
                    <p class="comprimible">{{$perfil->per_habilidades}}</p>
                @else
                    <p>No establecido.</p>
                @endif
            </div>

            <div class="col s12">
                <p class="titulo">Lineas de investigación</p>

                @if(count($perfil->lineasInvestigacion))
                    <ul class="collection">
                        @foreach($perfil->lineasInvestigacion as $linea)
                            <li class="collection-item">{{$linea->lin_inv_nombre}}</li>
                        @endforeach
                    </ul
                @else
                    <p class="center">No se han establecido lineas de investigación de enfoque.</p>
                @endif
            </div>
        </div>
    @endif

    @if(\Illuminate\Support\Facades\Session::get('idPersona') == $persona->id)
        <a class="btn teal darken-1 texto-blanco right waves waves-effect" style="margin-bottom: 15px; margin-top: 15px;" href="{{url('/')}}/perfil/edit/{{\Illuminate\Support\Facades\Crypt::encrypt(\Illuminate\Support\Facades\Session::get('idPersona'))}}">Editar</a>
    @endif
@else
<p style="margin-bottom: 200px;">La información recibida es incorrecta..</p>
@endif
@stop