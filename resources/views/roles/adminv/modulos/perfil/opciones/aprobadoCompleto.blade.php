<div class="col s12 contenedor_botones">
    <div class="col s12 m6">
        <a class="btn teal darken-1 texto-blanco col s12 waves-effect modal-trigger" href="#enviarAConvocatoria" id="btnEnviarAConvocatoria">enviar a convocatoria</a>
    </div>

    <div class="col s12 m6">
        <a class="btn teal darken-1 texto-blanco col s12 waves-effect modal-trigger" href="#marcarAprobado" id="btnMarcarAprobado">Marcar como aprobado</a>
    </div>
</div>



<div id="enviarAConvocatoria" class="modal" style="margin-top: 100px;">
    <div class="modal-content">
        <h5 class="link-verde">Seleccione una convocatoria</h5>

        @if(isset($convocatorias) && (count($convocatorias)>0))
            <select id="convocatoria">
                @foreach($convocatorias as $convocatoria)
                    <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($convocatoria->id)}}">{{$convocatoria->con_compania .' ('.$convocatoria->con_numero.') - '.$convocatoria->con_fecha_cierre}}</option>
                @endforeach
            </select>
            <a href="/adminv/convocatoria-registrar" target="_blank">Registrar convocatoria</a>
        @else
            <p>No existen convocatorias abiertas en el sistema.</p>
        @endif

    </div>
    <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
        <div class="">
            @if(isset($convocatorias) && (count($convocatorias)>0))
                <a class="waves-effect waves-orange btn-flat" id="enviarAConvocatoriaOk">ok</a>
            @endif
            <a class="waves-effect waves-orange btn-flat modal-close">cancelar</a>
        </div>
    </div>
</div>

<div id="marcarAprobado" class="modal" style="margin-top: 100px;">
    <div class="modal-content">
        <h5 class="link-verde">¿Esta seguro de marcar este proyecto como aprobado?</h5>
        <p>El proyecto ya no podrá ser enviado a ninguna convocatoria y estará disponible para iniciar su proceso de pre-desarrollo.</p>
    </div>
    <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
        <div class="">
            <a class="waves-effect waves-orange btn-flat" id="marcarAprobadoOk">ok</a>
            <a class="waves-effect waves-orange btn-flat modal-close">cancelar</a>
        </div>
    </div>
</div>

@section('js')
@parent
<script src="{{asset('Js/adminv/perfil/aprobadoCompleto.js')}}"></script>
@stop