<?php
Session::put('rol actual','investigador');
?>
@extends('plantillas.master')


@section('encabezado')
@include('roles/secciones/encabezado')
@stop

@section('menus')
    @include('roles/inv/secciones/menu')
@stop


@section('contenidoPagina')
    @if(isset($mod))
        @include('roles/inv/modulos/'.$mod)
    @else
        @if(isset($temp))
            @include('plantillas/'.$temp)
        @endif
    @endif
@stop