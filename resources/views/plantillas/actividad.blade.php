@extends("plantillas/master")
@section('encabezado')
    @if(isset($rol))
    @include('roles/secciones/encabezado')
    @else
    @include('secciones/encabezado')
    @endif
@stop

@section('menus')
    @if(isset($rol))
        @include ('roles/'.$rol.'/secciones/menu')
    @else

    @endif

@stop

@section('contenidoPagina')
<p class="tituloPrincipalPag tituloGrande">Actividad</p>
<div class="col s12 white" style="padding: 20px 40px;">

<div class="col s12">
    <p class="titulo">Descripción</p>
    <p>{{$actividad->act_descripcion}}</p>
    <div class="col s12 divider"></div>
</div>

<div class="col s12">
    <strong class="titulo">Indicador</strong>
    <p>{{$actividad->act_indicador}}</p>
    <div class="col s12 divider"></div>
</div>

<div class="col s12">
    <strong class="titulo">Resultado</strong>
    <p>{{$actividad->act_resultado}}</p>
    <div class="col s12 divider"></div>
</div>

<div class="col s12 m6">
    <strong class="titulo">Duración</strong>
    <p>{{$actividad->act_duracion." mes(es)"}}</p>
    <div class="col s12 divider"></div>
</div>

<div class="col s12 m6">
    <strong class="titulo">Mes de inicio</strong>
    <p>{{$actividad->act_numero_mes_inicio}}</p>
    <div class="col s12 divider"></div>
</div>

<div class="col s12 m6">
    <strong class="titulo">Fecha de inicio</strong>
    @if($actividad->act_fecha_inicio == '')
        <p>Fecha no establecida</p>
    @else
        <p>{{$actividad->act_fecha_inicio}}</p>
    @endif
    <div class="col s12 divider"></div>
</div>

<div class="col s12 m6">
    <strong class="titulo">Fecha finalización</strong>
    @if($actividad->act_fecha_fin == '')
            <p>Fecha no establecida</p>
    @else
        <p>{{$actividad->act_fecha_fin}}</p>
    @endif
    <div class="col s12 divider"></div>
</div>

<p class="tituloPrincipalPag tituloMediano col s12" style="margin-top: 40px !important;">Productos</p>
<?php $aux = 0;?>
<table class="table bordered highlight">
<thead>
    <th>Descripción</th>
    <th>Estado</th>
</thead>

<tbody>
@foreach($actividad->productos as $producto)
    @if($producto->pro_estado != 'delete')
        <?php $aux++; ?>
        <tr>
            <td>{{$producto->pro_descripcion}}</td>
            <td>{{$producto->pro_estado}}</td>
        </tr>
    @endif
@endforeach
@if($aux == 0)
<tr>
    <td colspan="2">
        <p>No existen productos relacionados con esta actividad.</p>
    </td>
</tr>

@endif

</tbody>
</table>



<p class="tituloPrincipalPag tituloMediano col s12" style="margin-top: 50px !important;">Rubros</p>
<?php $aux = 0;?>
<div class="col s12">
<ul class="collapsible" data-collapsible="accordion">
@foreach($actividad->rubros as $rubro)
    @if($rubro->rub_estado != 'delete')
        <?php $aux++; ?>
            <li>
              <div class="collapsible-header">{{$rubro->rub_nombre}}</div>
              <div class="collapsible-body">
                <table class="table bordered highlight">
                    <thead>
                        <th class="center">Nombre</th>
                        <th class="center">Cantidad</th>
                        <th class="center">Valor unitario</th>
                    </thead>

                    <tbody>
                        <?php $aux = 0; ?>
                        @foreach($rubro->componentesRubro as $componente)
                            @if($componente->com_rub_estado != 'delete')
                                <?php $aux++; ?>
                                <tr>
                                    <td class="center">{{$componente->com_rub_nombre}}</td>
                                    <td class="center">{{$componente->com_rub_cantidad}}</td>
                                    <td class="center">{{'$ '.number_format($componente->com_rub_valor_unitario,2,',','.')}}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
              </div>
            </li>
    @endif
@endforeach
</ul>
@if($aux == 0)
    <p class="col s12 center">No existen rubros relacionados con esta actividad</p>
@endif
</div>


</div>
@stop