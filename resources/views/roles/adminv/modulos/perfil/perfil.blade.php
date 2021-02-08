@include('plantillas/perfiles/informacion')

@if($perfil->pro_estado == 'propuesta')
<div class="col s12 center-align" style="margin-top: 20px;">
    <a id="btnSugerir" class="btn waves-effect waves-grey" href="/adminv/perfil-sugerir/{{\Illuminate\Support\Facades\Crypt::encrypt($perfil->id)}}">sugerir<i class="mdi-content-drafts"></i></a>
    <a id="btnAsignar" class="btn waves-effect waves-grey" href="/adminv/perfil-asignar/{{\Illuminate\Support\Facades\Crypt::encrypt($perfil->id)}}">asignar<i class="mdi-action-assignment-ind"></i></a>
    <a id="btnAprobar" class="btn waves-effect waves-grey modal-trigger" href="#aprobar">aprobar<i class="mdi-action-done"></i></a>
    <a id="btnDecartar" class="btn waves-effect waves-grey modal-trigger" href="#descartar">descartar<i class="mdi-content-clear"></i></a>
</div>

<div id="descartar" class="modal" style="margin-top: 100px;">
        <div class="modal-content">
            <h5 id="tituloPerfilSeleccionado">¿Esta seguro de descartar este perfil?</h5>
            <p>
                <input type="checkbox" id="enviarCorreoDescartar">
                <label for="enviarCorreoDescartar">Informar vía correo electronico</label>
            </p>
            <div class="progress invisible" style="top: 30px;">
                <div class="indeterminate"></div>
            </div>
        </div>
        <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
            <a id="btnDescartarNo" class="waves-effect waves-grey btn-flat teal-text modal-close">no</a>
            <a id="btnDescartarOk" class="waves-effect waves-grey btn-flat teal-text">si</a>
        </div>
    </div>

    <div id="aprobar" class="modal" style="margin-top: 100px;">
        <div class="modal-content">
            <h5 id="tituloPerfilSeleccionado">¿Esta seguro de aprobar este perfil?</h5>
            <p>
                <input type="checkbox" id="enviarCorreoAprobar">
                <label for="enviarCorreoAprobar">Informar vía correo electronico</label>
            </p>
            <div class="progress invisible" style="top: 30px;">
                <div class="indeterminate"></div>
            </div>
        </div>
        <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
            <a id="btnAprobarNo" class="waves-effect waves-grey btn-flat teal-text modal-close">no</a>
            <a id="btnAprobarOk" class="waves-effect waves-grey btn-flat teal-text">si</a>
        </div>
    </div>
@endif
