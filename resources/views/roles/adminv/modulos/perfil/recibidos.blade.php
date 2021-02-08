<?php
     $classBtnPerfil = "modal-trigger";
?>
@include('plantillas/perfiles/recibidos')

        <div id="opcionesPerfilRecibido" class="modal" style="margin-top: 100px;">
            <div class="modal-content">
                <h5 class="tituloPerfilSeleccionado link-verde">Titulo del perfil</h5>
                <input type="hidden" id="idPerfilSeleccionado">
            </div>
            <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
            <div class="hide-on-med-and-down">
                <a class="waves-effect waves-orange btn-flat btnVerMas">ver más<i class="mdi-action-visibility"></i></a>
                <a class="waves-effect waves-orange btn-flat btnAsignar">asignar<i class="mdi-action-assignment-ind"></i></a>
                <a id="btnDecartar" class="waves-effect waves-orange btn-flat modal-trigger" href="#descartar">descartar<i class="mdi-content-clear"></i></a>
                <a id="btnAprobar" class="waves-effect waves-orange btn-flat modal-trigger" href="#aprobar">aprobar<i class="mdi-action-done"></i></a>
                <a class="waves-effect waves-orange btn-flat btnSugerir">sugerir<i class="mdi-content-drafts"></i></a>
            </div>

            <div class="hide-on-large-only collection">
                <a class="waves-effect waves-orange collection-item btnVerMas">ver más<i class="mdi-action-visibility"></i></a>
                <a class="waves-effect waves-orange collection-item btnAsignar">asignar<i class="mdi-action-assignment-ind"></i></a>
                <a id="btnDecartar" class="waves-effect waves-orange modal-trigger collection-item" href="#descartar">descartar<i class="mdi-content-clear"></i></a>
                <a id="btnAprobar" class="waves-effect waves-orange modal-trigger collection-item" href="#aprobar">aprobar<i class="mdi-action-done"></i></a>
                <a class="waves-effect waves-orange collection-item btnSugerir">sugerir<i class="mdi-content-drafts"></i></a>
            </div>
            </div>
        </div>

        <!-- Modal Structure -->
        <div id="descartar" class="modal" style="margin-top: 100px;">
            <div class="modal-content">
                <h5>¿Esta seguro de descartar este perfil?</h5>
                <p>
                    <input type="checkbox" id="enviarCorreoDescartar">
                    <label for="enviarCorreoDescartar">Informar vía correo electronico</label>
                </p>
                <div class="progress invisible" style="top: 30px;">
                    <div class="indeterminate"></div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
                <a id="btnDescartarNo" class="waves-effect waves-grey btn-flat teal-text">no</a>
                <a id="btnDescartarOk" class="waves-effect waves-grey btn-flat teal-text">si</a>
            </div>
        </div>

        <div id="aprobar" class="modal" style="margin-top: 100px;">
            <div class="modal-content">
                <h5>¿Esta seguro de aprobar este perfil?</h5>
                <p>
                    <input type="checkbox" id="enviarCorreoAprobar">
                    <label for="enviarCorreoAprobar">Informar vía correo electronico</label>
                </p>
                <div class="progress invisible" style="top: 30px;">
                    <div class="indeterminate"></div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
                <a id="btnAprobarNo" class="waves-effect waves-grey btn-flat teal-text">no</a>
                <a id="btnAprobarOk" class="waves-effect waves-grey btn-flat teal-text">si</a>
            </div>
        </div>
        @section('js')
        @parent
             <script src="{{asset('Js/adminv/perfil/recibidos.js')}}"></script>
        @stop