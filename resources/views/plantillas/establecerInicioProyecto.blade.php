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

<?php
    $fecha = date('Y-m-d');
    if($proyecto->pro_fecha_inicio){
        $fecha = date('Y-m-d',strtotime($proyecto->pro_fecha_inicio));
    }
?>
@section('contenidoPagina')
    <p class="tituloPrincipalPag tituloGrande">Fecha inicio proyecto</p>

    <div class="col s12 white">
        <p class="texto-informacion-medium">A continuación podrá establecer la fecha en la cual iniciará el desarrollo del proyecto,
        esta fecha podrá ser reestablecida siempre y cuando el proyecto no halla iniciado el desarrollo. El sistema cambiará automaticamente el
        estado del proyecto una vez llegue la fecha de inicio establecida.</p>

        <form id="form-fecha-proyecto">
            <div class="input-field col s12 m8 l9">
                <label for="fecha_inicio">Fecha de inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="datepicker" value="{{$fecha}}">
            </div>

            <input type="hidden" name="proyecto" id="proyecto" value="{{\Illuminate\Support\Facades\Crypt::encrypt($proyecto->id)}}">

            <div class="contenedor-botones col s12 m4 l3">
                <a class="btn teal white-text col s12 waves-effect waves-light" onclick="fechaInicioProyecto()" style="margin-top: 20px;">Guardar</a>
            </div>

            <div class="progress invisible">
                <div class="indeterminate"></div>
            </div>
        </form>
    </div>
@stop

@section('js')
@parent
<script>
    $(function(){
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 2 // Creates a dropdown of 15 years to control year
          });
    })
</script>
    <script src="{{asset('Js/inv/proyecto/proyectoInvestigadores.js')}}"></script>
@stop