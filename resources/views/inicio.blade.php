@extends('plantillas.master')
@section('css')
@parent

<link href="{{asset('/Css/principal.css')}}" rel="stylesheet">
<link href="{{asset('/Css/eventos.css')}}" rel="stylesheet">
<style>
    .lean-overlay{
        z-index: 1 !important;
    }
</style>
@stop

@section('js')
@parent

<script src="{{asset('/Js/slider.js')}}"></script>
<script src="{{asset('/Js/inicio.js')}}"></script>

<script>
    @if(! \Illuminate\Support\Facades\Session::has('idPersona'))
    if (localStorage.reload == "0") {
         localStorage.reload = "1";
         location.reload();
     } else {
         localStorage.reload = "0";
     }
     @endif
</script>
@stop

@section('contenidoPagina')
@if (!isset($mod))
    @include('modulos/principal')
@else
    @include('modulos/'.$mod)
@endif


@stop