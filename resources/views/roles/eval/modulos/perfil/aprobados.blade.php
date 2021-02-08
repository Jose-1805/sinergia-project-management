<?php
     $classBtnPerfil = "modal-trigger";
?>
@include('plantillas/perfiles/aprobados')
<div id="opcionesPerfilEnFormulacion" class="modal" style="margin-top: 100px;">
            <div class="modal-content">
                <h5 class="tituloPerfilSeleccionado link-verde">Titulo del perfil</h5>
                <input type="hidden" id="idPerfilSeleccionado">
            </div>
            <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
            <div class="hide-on-med-and-down">
                <a class="waves-effect waves-orange btn-flat btnVerMas">ver más<i class="mdi-action-visibility"></i></a>
                <a id="btnDecartarEnFormulacion" class="waves-effect waves-orange btn-flat modal-trigger" href="#descartarEnFormulacion">descartar<i class="mdi-content-clear"></i></a>
                <a id="btnCompleto" class="waves-effect waves-orange btn-flat modal-trigger" href="#completo">completo<i class="mdi-action-done"></i></a>
                <a class="waves-effect waves-orange btn-flat btnSugerir">sugerir<i class="mdi-content-drafts"></i></a>
            </div>

            <div class="hide-on-large-only collection">
                <a class="waves-effect waves-orange collection-item btnVerMas">ver más<i class="mdi-action-visibility"></i></a>
                <a id="btnDecartarEnFormulacion" class="waves-effect waves-orange modal-trigger collection-item" href="#descartarEnFormulacion">descartar<i class="mdi-content-clear"></i></a>
                <a id="btnCompleto" class="waves-effect waves-orange modal-trigger collection-item" href="#completo">completo<i class="mdi-action-done"></i></a>
                <a class="waves-effect waves-orange collection-item btnSugerir">sugerir<i class="mdi-content-drafts"></i></a>
            </div>
            </div>
        </div>

        <!-- Modal Structure -->
        <div id="descartarEnFormulacion" class="modal" style="margin-top: 100px;">
            <div class="modal-content">
                <h5 id="tituloPerfilSeleccionado">¿Esta seguro de descartar este perfil?</h5>
                <p>
                    <input type="checkbox" id="enviarCorreoDescartarEnFormulacion">
                    <label for="enviarCorreoDescartarEnFormulacion">Informar vía correo electronico</label>
                </p>
                <div class="progress invisible" style="top: 30px;">
                    <div class="indeterminate"></div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
                <a id="btnDescartarEnFormulacionNo" class="waves-effect waves-grey btn-flat teal-text">no</a>
                <a id="btnDescartarEnFormulacionOk" class="waves-effect waves-grey btn-flat teal-text">si</a>
            </div>
        </div>

        <div id="completo" class="modal" style="margin-top: 100px;">
            <div class="modal-content">
                <h5 id="tituloPerfilSeleccionado">¿Esta seguro de marcar este perfil en formulación como completo?</h5>
                <p>
                    <input type="checkbox" id="enviarCorreoPerfilCompleto">
                    <label for="enviarCorreoPerfilCompleto">Informar vía correo electronico</label>
                </p>
                <div class="progress invisible" style="top: 30px;">
                    <div class="indeterminate"></div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
                <a id="btnCompletoNo" class="waves-effect waves-grey btn-flat teal-text">no</a>
                <a id="btnCompletoOk" class="waves-effect waves-grey btn-flat teal-text">si</a>
            </div>
        </div>
        @section('js')
        @parent
             <script src="{{asset('Js/eval/perfil/aprobados.js')}}"></script>
        @stop