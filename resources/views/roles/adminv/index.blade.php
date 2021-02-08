<?php
    Session::put('rol actual','administrador investigativo');
?>
@extends('plantillas.master')

@section('encabezado')
 @include('roles/secciones/encabezado')
@stop

@section('menus')
 @include ('roles/adminv/secciones/menu')
@stop


@section('contenidoPagina')
    @if(isset($mod))
      @include('roles/adminv/modulos/'.$mod)
    @else
        @if(isset($temp))
          @include('plantillas/'.$temp)
         @else
            @if(isset($per))
                @include('investigadores'.$per)
            @endif
            @if(isset($ent))
                @include('roles/adminv/modulos/entidades/'.$ent)
            @endif
            @if(isset($eva))
                @include('roles/adminv/modulos/evaluadores/'.$eva)
            @endif
            @if(isset($inv))
                @include('roles/adminv/modulos/investigadores/'.$inv)
            @endif
        @endif
    @endif
@stop

