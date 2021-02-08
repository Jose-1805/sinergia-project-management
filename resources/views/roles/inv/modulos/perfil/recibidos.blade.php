<?php
     $classBtnPerfil = "modal-trigger";
?>
@include('plantillas/perfiles/recibidos')
<div id="opcionesPerfilRecibido" class="modal" style="margin-top: 100px;">
    <div class="modal-content">
        <h5 id="tituloPerfilSeleccionado" class="link-verde">Titulo del perfil</h5>
        <input type="hidden" id="idPerfilSeleccionado">
    </div>
    <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
    <div class="hide-on-med-and-down">
        <a id="btnVerMas" class="waves-effect waves-orange btn-flat btnVerMas">ver más <i class="mdi-action-visibility"></i></a>
        <a id="btnEditar" class="waves-effect waves-orange btn-flat">editar <i class="mdi-image-edit"></i></a>
    </div>

    <div class="hide-on-large-only collection">
        <a id="btnVerMas" class="waves-effect waves-orange btn-flat btnVerMas">ver más <i class="mdi-action-visibility"></i></a>
        <a id="btnEditar" class="waves-effect waves-orange btn-flat">editar <i class="mdi-image-edit"></i></a>
    </div>
    </div>
</div>

@section('js')
@parent
     <script src="{{asset('Js/inv/perfil/enviados.js')}}"></script>
@stop