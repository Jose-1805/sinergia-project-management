<?php

use Illuminate\Support\Facades\Session;
?>
<!DOCTYPE html>
<html lang="es">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        @section('titulo')
        <title>Gestión proyectos SINERGIA</title>
        @show

        @section('descripcion')
        <meta name="description" content="Sistema gestor de proyectos que nacen en el 
              grupo de investigación  del SENA, SINERGIA." />
        @show

        @section('palabrasclave')
        <meta name="keywords" content="gestion proyectos, sinergia, gestion proyectos sinergia, sena, gestion proyectos sena, investigación, grupo de investigación,comercio y servicios, centro de comercio y servicios" />
        @show

        <meta name="author" content="Jose Luis Capote Mosquera" />
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="shortcut icon" href="../favicon.ico"/> 

        <!-- jQuery -->
        <script src="{{asset('Js/jquery-1.11.2.min.js')}}"></script>

        <script type="text/javascript" src="{{asset('Js/funciones.js')}}"></script>
        <script type="text/javascript" src="{{asset('Js/funcionesProyectos.js')}}"></script>
        <script type="text/javascript" src="{{asset('Js/mensajes.js')}}"></script>
        <script type="text/javascript" src="{{asset('Js/sliderInfo.js')}}"></script>

        <link rel="stylesheet" href="{{asset('font-awesome-4.5.0/css/font-awesome.min.css')}}">
        <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->


        <!-- Materialize css -->
        <link rel="stylesheet" href="{{asset('materialize/css/materialize.min.css')}}"/>
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">-->
        <script type="text/javascript" src="{{asset('materialize/js/materialize.min.js')}}"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>-->
        <script src="{{asset('Js/jquery.kolorpicker.js')}}" type="text/javascript"></script>


        <link href="{{asset('Css/menus.css')}}" rel="stylesheet"/>
        <link href="{{asset('Css/redisenio.css')}}" rel="stylesheet"/>
        <link href="{{asset('Css/global.css')}}" rel="stylesheet"/>
        <link href="{{asset('Css/slideInfo.css')}}" rel="stylesheet"/>
        <link href="{{asset('Css/font.css')}}" rel="stylesheet"/>
        <link href="{{asset('/Css/slider.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('Css/kolorpicker.css')}}" type="text/css" media="screen, tv, projection, print" />

        @section('css')
        @show

        <script src="{{asset('Js/materializeActivaciones.js')}}"></script>
        <script src="{{asset('Js/cargas.js')}}"></script>
        @if (Session::has('idPersona'))
            <script src="{{asset('Js/notificaciones.js')}}"></script>
        @endif


        @section('js')

        @show
        <script>
$(function () {
    $('.logo').click(function () {

        @if (Session::has('idPersona'))
            @if ((Session::has('administrador investigativo')) && (Session::get('rol actual') == 'administrador investigativo') && (Session::get('administrador investigativo') == 'activo'))
                window.location.href = "{{asset('/adminv')}}";
            @endif
            @if ((Session::has('investigador')) && (Session::get('rol actual') == 'investigador') && (Session::get('investigador') == 'activo'))
                window.location.href = "{{asset('/inv')}}";
            @endif
            @if ((Session::has('evaluador')) && (Session::get('rol actual') == 'evaluador') && (Session::get('evaluador') == 'activo'))
                window.location.href = "{{asset('/eval')}}";
            @endif
        @else
            window.location.href = "{{asset('inicio')}}";
        @endif
    })
})
        </script>
    </head>

    <body>

    @if(Session::get("mensaje"))
        <script>
            $(function(){
                var mensaje = "{{Session::get('mensaje')}}";
                lanzarMensaje("Mensaje",mensaje,6000,4);
            })
        </script>
    @endif

        <div class="logoSena"></div>
        <div id="mensaje" class="z-depth-3">
            <div id="encabezadoMensaje">
                <p id="tituloMensaje"></p>       
                <i class="fa fa-close" id="btnOcultarMensaje"></i>
            </div>

            <div id="cuerpoMensaje">
                <p id="contenidoMensaje"></p>
            </div>

            <i class="fa fa-info" id="iconoMensaje"></i>         
        </div>
        <div class="divBody">
            <div class="contenedorPrincipal" id="contenedorPrincipal">


                <!-- DIV QUE CONTIENE TODA LA PARTE SUPERIOR DE LA PAGINA  -->
                <div id="parteSuperior" class="parteSuperior row">

                    @section('encabezado')
                        @if (Session::has('idPersona'))
                            @include('roles/secciones/encabezado')
                        @else
                            @include('/secciones/encabezado')
                        @endif
                    @show

                    @if(\Illuminate\Support\Facades\Session::has("idPersona"))
                        <div class="contenedor-notificaciones z-depth-3">
                            <div class="contenedor-notificaciones-body">
                                <div class="notificaciones-primario"></div>
                                <div class="notificaciones-secundario">
                                </div>
                                <p style='font-size: x-small; text-align: center;' class="invisible" id="no-notificaciones">No existen más notificaciones.</p>
                            </div>
                            <a class="btn teal white-text waves-effect waves-light" id="masNotificaciones" style="color: #FFF !important;">Ver más</a>
                        </div>
                        <div class="btn-notificaciones teal waves-effect waves-light tooltipped" data-position="left" data-delay="50" data-tooltip="Notificaciones"><strong class="white-text texto-informacion-medium" id="contador-notificaciones">0</strong></div>

                        <div class="contenedor-mas-opciones z-depth-3">
                            <div class="contenedor-mas-opciones-body collection">
                                <a href="{{url('/grupo-investigacion')}}" class="collection-item">Grupo de investigación</a>
                                <a href="{{url('/semillero')}}" class="collection-item">Semillero</a>
                                <a href="{{url('/eventos')}}" class="collection-item">Eventos</a>
                                <a href="{{url('/convocatoria')}}" class="collection-item">Convocatorias</a>
                            </div>
                        </div>
                        <div class="btn-mas-opciones teal waves-effect waves-light tooltipped" data-position="left" data-delay="50" data-tooltip="Más opciones"><strong class="white-text texto-informacion-medium" id="contador-notificaciones">+</strong></div>
                    @endif

                    <div  id="contenedorMenusNavegacion">
                        <div class="row">
                            @section('menus')

                                @if (Session::has('idPersona'))
                                    @if ((Session::has('administrador investigativo')) && (Session::get('rol actual') == 'administrador investigativo') && (Session::get('administrador investigativo') == 'activo'))
                                         @include ('roles/adminv/secciones/menu')
                                    @endif
                                    @if ((Session::has('investigador')) && (Session::get('rol actual') == 'investigador') && (Session::get('investigador') == 'activo'))
                                         @include ('roles/inv/secciones/menu')
                                    @endif
                                    @if ((Session::has('evaluador')) && (Session::get('rol actual') == 'evaluador') && (Session::get('evaluador') == 'activo'))
                                         @include ('roles/eval/secciones/menu')
                                    @endif
                                @else
                                     @include ('/secciones/menu')
                                @endif
                            @show
                        </div>
                    </div>
                    <!-- FIN DE LA PARTE SUPERIOR DE LA PAGINA -->
                </div>  

                <div class="col s12 height-encabezado" style=""></div>
                <div class="row contenedor-slider" style="width: 100%;">
                    @yield('slider')
                </div>
                <div class="row" >
                <input type="hidden" id="_token" class="_token" value="{{csrf_token()}}">
                    <div class="pagina col " style="width: 95% !important; margin-left: 2.5%;" >
                        @yield('contenidoPagina')
                    </div>
                </div>
            </div>


            <footer class="page-footer piePagina" style="background-color: #FFF;">
                <div class="container">
                    <div class="row">
                        <div class="col l6 s12">
                            <h5 class="link-verde">Grupo de Investigación SINERGIA</h5>
                            <p class="link-verde"><i class="mdi-communication-location-on left"></i>Popayán - Cauca - Colombia / Calle 4 # 2-82</p>
                            <p class="link-verde"><i class="mdi-communication-phone left"></i>Teléfono  +57 (2) 8220122 – 8243752 – 8243933 – Ext 22153</p>
                            <p class="link-verde"><i class="mdi-communication-email left"></i>sennova.comercio@sena.edu.co</p>
                            
                        </div>
                        <div class="col l4 offset-l2 s12">
                            <h5 class="link-verde">Links</h5>
                            <a class="link-verde" target="_blank" href="http://www.sena.edu.co">SENA</a><br>
                            <a class="link-verde" target="_blank" href="centrodecomercioyservicioscauca.blogspot.com.co">CENTRO DE COMERCIO Y SERVICIOS</a><br>
                            <a class="link-verde" target="_blank" href="http://www.colciencias.gov.co/">COLCIENCIAS</a><br>
                            <a class="link-verde" target="_blank" href="http://sennovasvc.cloudapp.net/">SENNOVA</a><br>
                        </div>
                    </div>
                </div>
                <div class="footer-copyright" style="background-color: #238276">
                    <div class="container white-text">
                        Todos los derechos reservados Grupo de Investigación SINERGIA
                        <a class="right white-text" href="#!">More Links</a>
                    </div>
                </div>
                <input type="hidden" value="{{url('/')}}" name="base_url" id="base_url">
            </footer>
        </div><!--FIN DIVBODY-->
    </body>
</html>