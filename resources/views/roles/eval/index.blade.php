<?php
Session::put('rol actual','evaluador');
?>
@extends('../../plantillas.master')

@section('css')
@parent

@stop

@section('js')
@parent
<script src="../Js/slider.js"></script>
@stop

@section('encabezado')
 @include('roles/secciones/encabezado')
@stop


@section('menus')
 @include ('roles/eval/secciones/menu')
@stop


@section('contenidoPagina')

    @if(isset($mod))
        @include('roles/eval/modulos/'.$mod)
    @else
        @if(isset($temp))
            @include('plantillas/'.$temp)
        @endif
    @endif
@stop

