<p class="tituloPrincipalPag tituloGrande">Solicitud</p>
<?php
    $proyecto = $solicitud->proyectoInvestigativo->proyecto;
?>
<div class="col s12 white" style="padding: 30px 10px;">
    <p>Esta solicitud a sido enviada a usted con el fin de requerir su apoyo y colaboración en el desarrollo del proyecto
    <strong>{{$proyecto->pro_titulo}}</strong>, al aprobar esta solicitud pertenecerá al grupo de investigadores de dicho proyecto
    desempeñando el rol de {{$solicitud->pro_inv_rol}}.</p>

    <p class="texto-informacion-medium"><strong>Estado de solicitud: </strong>{{$solicitud->pro_inv_estado_solicitud}}</p>
    <p class="texto-informacion-medium"><strong>Fecha de solicitud: </strong>{{date("Y-m-d", strtotime($solicitud->created_at))}}</p>
    <p class="texto-informacion-medium"><strong>Estado del proyecto: </strong>{{$proyecto->pro_estado}}</p>

    <p class="texto-informacion-medium"><strong>Nota: </strong>Las solicitudes recibidas solo podrán ser aprobadas o rechazadas por usted siempre
    y cuando el estado del proyecto sea 'proyecto aprobado'. Una vez usted apruebe o rechace la solicitud, no podrá cambiar el estado cambiado.</p>

    @if($proyecto->pro_estado == 'proyecto aprobado')
        <p class="texto-informacion-medium">Si su desición es rechazar la solicitud, podrá ingresar la razón por la cual rechaza la solicitud a continuación.</p>

        <form id="form-solicitud-revision">
            <div class="input-field col s12" style="margin-top: 20px;">
                <textarea id="razon_rechazo" name="razon_rechazo" class="materialize-textarea"></textarea>
                <label for="razon_rechazo">Razón de rechazo</label>
            </div>
            <input type="hidden" name="solicitud" value="{{\Illuminate\Support\Facades\Crypt::encrypt($solicitud->id)}}">
        </form>

        <div class="hide-on-small-only">
            <a class="btn teal white-text waves-effect waves-light right modal-trigger" href="#aprobarSolicitud">Aprobar</a>
            <a class="btn teal white-text waves-effect waves-light right modal-trigger" href="#rechazarSolicitud" style="margin-right: 10px;">Rechazar</a>
        </div>

        <div class="hide-on-med-and-up">
            <a class="btn teal white-text waves-effect waves-light col s12 modal-trigger" href="#rechazarSolicitud">Rechazar</a>
            <a class="btn teal white-text waves-effect waves-light col s12 modal-trigger" href="#aprobarSolicitud" style="margin-top: 5px;">Aprobar</a>
        </div>

    @endif
</div>

<div id="aprobarSolicitud" class="modal" style="margin-top: 100px;">
    <div class="modal-content">
        <h5 class="tituloPerfilSeleccionado link-verde">¿Esta seguro de aprobar esta la solicitud?</h5>
    </div>
    <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
        <div class="contenedor-botones-opcion">
            <div class="hide-on-med-and-down">
                <a class="waves-effect waves-orange btn-flat" id="btnAprobarSolicitud">Aceptar</a>
                <a class="waves-effect waves-orange btn-flat modal-close">Cancelar</a>
            </div>
        </div>

        <div class="progress progress-opcion invisible">
            <div class="indeterminate"></div>
        </div>
    </div>
</div>

<div id="rechazarSolicitud" class="modal" style="margin-top: 100px;">
    <div class="modal-content">
        <h5 class="tituloPerfilSeleccionado link-verde">¿Esta seguro de rechazar esta la solicitud?</h5>
    </div>
    <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
        <div class="contenedor-botones-opcion">
            <div class="hide-on-med-and-down">
                <a class="waves-effect waves-orange btn-flat" id="btnRechazarSolicitud">Aceptar</a>
                <a class="waves-effect waves-orange btn-flat modal-close">Cancelar</a>
            </div>
        </div>
        <div class="progress progress-opcion invisible">
            <div class="indeterminate"></div>
        </div>
    </div>
</div>

@section('js')
@parent
     <script src="{{asset('Js/inv/proyecto/solicitud.js')}}"></script>
@stop
