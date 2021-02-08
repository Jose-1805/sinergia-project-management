<?php
//$proponente = $perfil->proyectoInvestigativo->investigadorLider->persona;
?>
@if(Session::get("msjComponente"))
    <script>
        $(function(){
            var mensaje = "{{Session::get('msjComponente')}}";
            lanzarMensaje("Mensaje",mensaje,4000,4);
        })
    </script>
@endif
<p class="tituloPrincipalPag tituloMediano">Seguimiento a proyecto<i class="mdi-content-drafts"></i></p>
<input type="hidden" name="id_seguimiento" id="id_seguimiento">
<div class="col s12 white">
    <div class="col s12">

            <p class="texto-informacion-medium">Una vez cambie realize uncambio sobre un producto de una actividad se almacenarán sus daros y los del seguimiento. Cuando todos el desarrollo de todos los productos, actividades y componenres del proyecto esten completos, el sistema cambiará el estado
            de este proyecto a finalizado, estando el proyecro en dicho estado no se prodrán realizar cambios.</p>

    @include('plantillas.proyectos.seguimiento.datosGenerales')
    </div>

    <div class="col s12">
        @if($proyecto->proyectoInvestigativo->componentes)<div class="col s12 center teal-text text-darken-1 tituloMediano"><p>Componentes</p></div>
            <div class="col s12">
                <ul class="collapsible popout" data-collapsible="accordion">
                    @foreach($proyecto->proyectoInvestigativo->componentes as $componente)
                            @include('plantillas.proyectos.seguimiento.datosComponente')
                    @endforeach
                </ul>
            </div>
            <div id="modal-actividad" class="modal full-modal modal-up">
            </div>
        @else
            <p class="col s12 center texto-rojo">No es posible evaluar el proyecto, no existen componentes para visualizar.</p>
            <div class="center">
                <a class="btn waves-effect waves-light teal darken-1 texto-blanco" onclick="window.history.back()">regresar</a>
            </div>
        @endif
    </div>
</div>

@section('js')
@parent
<script src="{{asset('Js/proyecto/seguimiento.js')}}"></script>
@stop