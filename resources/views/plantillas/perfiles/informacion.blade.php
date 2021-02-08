<?php
    $proponente = $perfil->proyectoInvestigativo->investigadorLider->persona;
?>
@extends("plantillas/master")
@section('encabezado')
    @include('roles/secciones/encabezado')
@stop

@section('menus')
 @include ('roles/'.$rol.'/secciones/menu')
@stop
@section('contenidoPagina')
@include('plantillas/perfiles/datos')
<div class="col s12">
    @if($perfil->pro_estado == "propuesta")
        @include("roles/".$rol."/modulos/perfil/opciones/propuesta")
    @elseif($perfil->pro_estado == "propuesta descartada")
        @include("roles/".$rol."/modulos/perfil/opciones/descartado")
    @elseif($perfil->pro_estado == "propuesta aprobada")
        @include("roles/".$rol."/modulos/perfil/opciones/aprobado")
    @elseif($perfil->pro_estado == "propuesta aprobada completa")
        @include("roles/".$rol."/modulos/perfil/opciones/aprobadoCompleto")

    @elseif($perfil->pro_estado == "proyecto en convocatoria")
        @include("roles/".$rol."/modulos/proyecto/opciones/enConvocatoria")
    @elseif($perfil->pro_estado == "proyecto aprobado")
        @include("roles/".$rol."/modulos/proyecto/opciones/proyectoAprobado")
    @elseif($perfil->pro_estado == "proyecto descartado")
        @include("roles/".$rol."/modulos/proyecto/opciones/proyectoDescartado")
    @elseif($perfil->pro_estado == "proyecto en desarrollo")
        @include("roles/".$rol."/modulos/proyecto/opciones/enDesarrollo")
    @elseif($perfil->pro_estado == "cancelado")
        @include("roles/".$rol."/modulos/proyecto/opciones/proyectoCancelado")
    @elseif($perfil->pro_estado == "terminado")
        @include("roles/".$rol."/modulos/proyecto/opciones/terminado")
    @endif
</div>
<div class="progress invisible">
<div class="indeterminate"></div>
</div>
@stop