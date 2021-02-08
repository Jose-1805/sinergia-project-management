@extends("plantillas/master")
@section('encabezado')
    @if(isset($rol))
    @include('roles/secciones/encabezado')
    @else
    @include('secciones/encabezado')
    @endif
@stop

@if(isset($rol))
    @section('menus')
            @include ('roles/'.$rol.'/secciones/menu')
    @stop
@endif

@section('contenidoPagina')
<p class="tituloPrincipalPag tituloGrande">Convocatorias</p>
@if(count($convocatorias)>0)
    <div class="collection">
    @foreach($convocatorias as $convocatoria)
        <a href="#!" class="collection-item">
        <div>
            <p>{{$convocatoria->con_compania.' ('.$convocatoria->con_numero.')'}}</p>
            <i class="texto-informacion-small">{{$convocatoria->con_fecha_apertura.' - '.$convocatoria->con_fecha_cierre}}</i>
            <p class="texto-informacion-small"><strong>Estado: </strong>{{$convocatoria->con_estado}}</p>
        </div>
        </a>
    @endforeach
    </div>
    <?php
     echo $convocatorias->render();
    ?>
    @if(isset($rol))
        @if($rol == "adminv")
            <a class="btn teal darken-1 texto-blanco right" href="/adminv/convocatoria-registrar">registrar</a>
        @endif
    @endif
@else
<p style="margin-bottom: 200px;">En este momento no existen convocatorias para mostrar.</p>
@endif
@stop