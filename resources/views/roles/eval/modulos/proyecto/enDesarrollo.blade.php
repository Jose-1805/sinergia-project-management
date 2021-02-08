<?php
     $classBtnPerfil = "modal-trigger";
?>
@include('plantillas/proyectos/enDesarrollo')
<div id="opcionesProyectoEnDesarrollo" class="modal" style="margin-top: 100px;">
    <div class="modal-content">
        <h5 class="tituloPerfilSeleccionado link-verde">Titulo del perfil</h5>
        <input type="hidden" id="idPerfilSeleccionado">
    </div>
    <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
        <div class="hide-on-med-and-down">
            <a class="waves-effect waves-orange btn-flat btnVerMas">ver más<i class="mdi-action-visibility"></i></a>
            <a id="btnDecartar" class="waves-effect waves-orange btn-flat modal-trigger" href="#descartar">descartar<i class="mdi-content-clear"></i></a>
            <a class="waves-effect waves-orange btn-flat btnEvaluar">evaluar<i class="mdi-action-settings-ethernet"></i></a>
            <a class="waves-effect waves-orange btn-flat btnSugerir">sugerir<i class="mdi-content-drafts"></i></a>
        </div>

        <div class="hide-on-large-only collection">
            <a class="waves-effect waves-orange collection-item btnVerMas">ver más<i class="mdi-action-visibility"></i></a>
            <a id="btnDecartar" class="waves-effect waves-orange modal-trigger collection-item" href="#descartar">descartar<i class="mdi-content-clear"></i></a>
            <a class="waves-effect waves-orange btn-flat collection-item btnEvaluar">evaluar<i class="mdi-action-settings-ethernet"></i></a>
            <a class="waves-effect waves-orange collection-item btnSugerir">sugerir<i class="mdi-content-drafts"></i></a>
        </div>
    </div>
</div>

<div id="descartar" class="modal" style="margin-top: 100px;">
    <div class="modal-content">
        <h5>¿Esta seguro de descartar este proyecto?</h5>
        <p>
        <input type="checkbox" id="enviarCorreoDescartarProyecto">
        <label for="enviarCorreoDescartarProyecto">Informar vía correo electronico</label>
        </p>
        <div class="progress invisible" style="top: 30px;">
            <div class="indeterminate"></div>
        </div>
    </div>
    <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
        <a id="btnDescartarProyectoNo" class="waves-effect waves-grey btn-flat teal-text modal-close">no</a>
        <a id="btnDescartarProyectoOk" class="waves-effect waves-grey btn-flat teal-text">si</a>
    </div>
</div>
@section('js')
@parent
    <script src="{{asset('Js/eval/proyecto/enDesarrollo.js')}}"></script>
@stop