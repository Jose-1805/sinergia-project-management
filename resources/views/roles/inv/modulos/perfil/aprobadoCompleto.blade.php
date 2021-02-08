<?php
$classBtnPerfil = "modal-trigger";
?>
@include('plantillas/perfiles/aprobadoCompleto')
<div id="opcionesPerfilCompleto" class="modal" style="margin-top: 100px;">
    <div class="modal-content">
        <h5 id="tituloPerfilSeleccionado" class="link-verde tituloPerfilSeleccionado">Titulo del perfil</h5>
        <input type="hidden" id="idPerfilSeleccionado">
        <p>Este perfil a terminado y aprobado su proceso de formulación, actualmente estamos a la espera de la primer
        convocatoria a la cual pueda ser enviado o a la decisión de marcarlo como aprobado para planear el los parametros de inicio del proyecto, una vez se realice uno de estos dos procesos se le informará el estado actual de su
        proyecto y los pasos a seguir.</p>
    </div>
    <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
        <a id="btnEditar" class="waves-effect waves-orange btn-flat modal-close">Cerrar <i class="mdi-content-clear"></i></a>
    </div>
</div>