        <div class="col s12 center">
                <div class="col s12 m4"><a class="col s12 waves-effect waves-light btn teal white-text modal-trigger" href="#descartar">descartar</a></div>
                <div class="col s12 m4"><a class="col s12 waves-effect waves-light btn teal white-text modal-trigger" href="#aprobar">aprobar</a></div>
                <div class="col s12 m4"><a class="col s12 waves-effect waves-light btn teal white-text" href="{{asset('/eval/perfil-sugerir/'.\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}">sugerir</a></div>
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
                <a id="btnDescartarNoView" class="waves-effect waves-grey btn-flat teal-text">no</a>
                <a id="btnDescartarOkView" class="waves-effect waves-grey btn-flat teal-text">si</a>
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
                <a id="btnAprobarNoView" class="waves-effect waves-grey btn-flat teal-text">no</a>
                <a id="btnAprobarOkView" class="waves-effect waves-grey btn-flat teal-text">si</a>
            </div>
        </div>

        @section('js')
        @parent
             <script src="{{asset('Js/eval/perfil/recibidos.js')}}"></script>
        @stop