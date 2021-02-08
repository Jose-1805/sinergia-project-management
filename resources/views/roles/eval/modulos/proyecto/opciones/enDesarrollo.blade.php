<div class="col s12">
    <div class="col s12 m4">
        <a class="col s12 teal white-text btn waves-effect waves-light" href="{{asset("/eval/perfil-sugerir/".\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}">sugerir</a>
    </div>

    <div class="col s12 m4">
        <a class="col s12 teal white-text btn waves-effect waves-light" href="{{asset("/proyecto/evaluar/".\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}">evaluar</a>
    </div>

    <div class="col s12 m4">
        <a class="col s12 teal white-text btn waves-effect waves-light modal-trigger" href="#descartar">descartar</a>
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
        <a id="btnDescartarProyectoNoView" class="waves-effect waves-grey btn-flat teal-text modal-close">no</a>
        <a id="btnDescartarProyectoOkView" class="waves-effect waves-grey btn-flat teal-text">si</a>
    </div>
</div>
@section('js')
@parent
    <script src="{{asset('Js/eval/proyecto/enDesarrollo.js')}}"></script>
@stop