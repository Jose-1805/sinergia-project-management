<div class="col s12 center">
    <div class="col s12 m3"><a id="btnCompleto" class="col s12 waves-effect waves-light btn teal white-text" href="{{asset('/adminv/perfil-asignar/'.\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}">Asignar</a></div>
    <div class="col s12 m3"><a class="col s12 waves-effect waves-light btn teal white-text" href="{{asset('/adminv/perfil-sugerir/'.\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}">sugerir</a></div>
    <div class="col s12 m3"><a id="btnCompleto" class="col s12 waves-effect waves-light btn teal white-text modal-trigger" href="#completo">completo</a></div>
    <div class="col s12 m3"><a id="btnDecartarEnFormulacion" class="col s12 waves-effect waves-light btn teal white-text modal-trigger" href="#descartarEnFormulacion">descartar</a></div>
</div>

<!-- Modal Structure -->
        <div id="descartarEnFormulacion" class="modal" style="margin-top: 100px;">
            <div class="modal-content">
                <h5>¿Esta seguro de descartar este perfil?</h5>
                <p>
                    <input type="checkbox" id="enviarCorreoDescartarEnFormulacion">
                    <label for="enviarCorreoDescartarEnFormulacion">Informar vía correo electronico</label>
                </p>
                <div class="progress invisible" style="top: 30px;">
                    <div class="indeterminate"></div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
                <a id="btnDescartarNoView" class="waves-effect waves-grey btn-flat teal-text">no</a>
                <a id="btnDescartarOkView" class="waves-effect waves-grey btn-flat teal-text">si</a>
            </div>
        </div>

        <div id="completo" class="modal" style="margin-top: 100px;">
            <div class="modal-content">
                <h5>¿Esta seguro de marcar este perfil en formulación como completo?</h5>
                <p>
                    <input type="checkbox" id="enviarCorreoPerfilCompleto">
                    <label for="enviarCorreoPerfilCompleto">Informar vía correo electronico</label>
                </p>
                <div class="progress invisible" style="top: 30px;">
                    <div class="indeterminate"></div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
                <a id="btnCompletoNoView" class="waves-effect waves-grey btn-flat teal-text">no</a>
                <a id="btnCompletoOkView" class="waves-effect waves-grey btn-flat teal-text">si</a>
            </div>
        </div>
        @section('js')
        @parent
             <script src="{{asset('Js/adminv/perfil/aprobados.js')}}"></script>
        @stop