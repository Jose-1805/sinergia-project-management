<p class="tituloPrincipalPag tituloGrande">Sugerencia - {{$sugerencia->sug_elemento_nombre}}</p>
<div class="col s12 white" style="padding: 30px 10px;">
    <h5>Sugerencia</h5>
    <p style="margin-bottom: 70px;" class="comprimible">{{$sugerencia->sug_descripcion}}</p>

    @if($sugerencia->proyecto_estado == $sugerencia->proyecto->pro_estado)
        @if($sugerencia->sug_elemento_nombre == 'producto')
            @include('roles.inv.modulos.sugerenciaProducto',array("disabled"=>"disabled"))
        @elseif($sugerencia->sug_elemento_nombre == 'rubro')
            @include('roles.inv.modulos.sugerenciaRubro',array("disabled"=>"disabled"))
        @elseif($sugerencia->sug_elemento_nombre == 'actividad')
            @include('roles.inv.modulos.sugerenciaActividad',array("disabled"=>"disabled"))
        @elseif($sugerencia->sug_elemento_nombre == 'componente')
            @include('roles.inv.modulos.sugerenciaComponente',array("disabled"=>"disabled"))
        @else
            @include('roles.inv.modulos.sugerenciaGeneral',array("disabled"=>"disabled"))
        @endif
    @else
        <p>El estado actual de este perfil o proyecto no permite el desarrollo de esta sugerencia.</p>
    @endif
</div>

@section('js')
@parent
     <script src="{{asset('Js/inv/perfil/sugerencia.js')}}"></script>
@stop
