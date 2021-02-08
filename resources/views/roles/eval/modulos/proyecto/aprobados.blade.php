<?php
     $classBtnPerfil = "modal-trigger";
?>
@include('plantillas/proyectos/aprobados')

<div id="opcionesProyectoAprobado" class="modal" style="margin-top: 100px;">
    <div class="modal-content">
        <h5 class="tituloPerfilSeleccionado link-verde">Titulo del perfil</h5>
        <input type="hidden" id="idPerfilSeleccionado">
    </div>
    <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
        <div class="hide-on-med-and-down">
            <a class="waves-effect waves-orange btn-flat btnVerMas">Ver más <i class="mdi-action-visibility"></i></a>
            <a class="waves-effect waves-orange btn-flat btnEstablecerInicio">Establecer inicio <i class="mdi-action-schedule"></i></a>
            <a class="waves-effect waves-orange btn-flat btnSugerirAprobadoEval">Sugerir <i class="mdi-content-drafts"></i></a>
        </div>
    </div>
</div>

@section('js')
@parent
    <script src="{{asset('Js/adminv/proyecto/aprobado.js')}}"></script>
@stop