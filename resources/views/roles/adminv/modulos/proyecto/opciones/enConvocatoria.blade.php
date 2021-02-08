<a class="btn teal darken-1 texto-blanco col s12 waves-effect modal-trigger" href="#aprobarConvocatoria" id="btnAprobarEnConvocatoria">aprobado por convocatoria</a>

<div id="aprobarConvocatoria" class="modal" style="margin-top: 100px;">
    <div class="modal-content">
        <h5 class="link-verde">¿Esta seguro de aprobar este proyecto en convocatoria?</h5>
        <p>
            <input type="checkbox" id="enviarCorreoAprobarEnConvocatoria">
            <label for="enviarCorreoAprobarEnConvocatoria">Informar vía correo electronico</label>
        </p>
    </div>
    <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
        <div class="">
            <a class="waves-effect waves-orange btn-flat" id="aprobarEnConvocatoriaOk">si</a>
            <a class="waves-effect waves-orange btn-flat modal-close">no</a>
        </div>
    </div>
</div>

@section('js')
@parent
<script src="{{asset('Js/adminv/proyecto/enConvocatoria.js')}}"></script>
@stop