<a class="btn teal darken-1 texto-blanco col s12 waves-effect modal-trigger" href="#enviarAConvocatoria" id="btnEnviarAConvocatoria">enviar a convocatoria</a>

<div id="enviarAConvocatoria" class="modal" style="margin-top: 100px;">
    <div class="modal-content">
        <h5 class="link-verde">Seleccione una convocatoria</h5>

        @if(isset($convocatorias) && (count($convocatorias)>0))
            <select id="convocatoria">
                @foreach($convocatorias as $convocatoria)
                    <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($convocatoria->id)}}">{{$convocatoria->con_compania .' ('.$convocatoria->con_numero.') - '.$convocatoria->con_fecha_cierre}}</option>
                @endforeach
            </select>
        @else
            <p>No existen convocatorias abiertas en el sistema</p>
        @endif
        <a href="/adminv/convocatoria-registrar" target="_blank">Registrar convocatoria</a>
    </div>
    <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
        <div class="">
            <a class="waves-effect waves-orange btn-flat" id="enviarAConvocatoriaOk">ok</a>
            <a class="waves-effect waves-orange btn-flat modal-close">cancelar</a>
        </div>
    </div>
</div>

@section('js')
@parent
<script src="{{asset('Js/adminv/perfil/aprobadoCompleto.js')}}"></script>
@stop