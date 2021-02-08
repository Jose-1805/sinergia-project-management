@if($perfil->pro_estado == "propuesta")
<p class="tituloMediano tituloPrincipalPag">Perfil - asignar evaluador <i class="mdi-action-assignment-ind"></i></p>

<div class="col s12 m3">
    <p class="texto-informacion-small justificado">
        Un perfil en estado <strong>'PROPUESTA'</strong> solamente puede ser asignado a un evaluador, quien toma las decisiones
        sobre el perfil en caso de no hacerlo el administrador, si un perfil ya tiene asignado un evaluador
        y asigna uno nuevo, el primero ya no será el evaluador del perfil.
    </p>
</div>
@else
<p class="tituloMediano tituloPrincipalPag">Perfil - asignar evaluadores <i class="mdi-action-assignment-ind"></i></p>

<div class="col s12 m3">
    <p class="texto-informacion-small justificado">
        Un proyecto o un perfil que no se encuentre en estado <strong>'PROPUESTA'</strong>, podrá tener tantos
        evaluadores como usted considere necesario.
    </p>
</div>

@endif

<form id="formAsignarPerfil">
<div class="col s12 m9" style="background-color: rgba(255,255,255,.9)">
    <div class="col s12 m6">
        <p class="titulo truncate">Titulo</p>
        <p><a class="info-link truncate" target="_blank" href="/proyecto/perfil/{{\Illuminate\Support\Facades\Crypt::encrypt($perfil->id)}}">{{$perfil->pro_titulo}}</a></p>
        <p class="titulo">Proponente</p>
        <p><a class="info-link truncate" target="_blank" href="{{url('/')}}/perfil/view/{{\Illuminate\Support\Facades\Crypt::encrypt($proponente->id)}}">{{$proponente->per_nombres . ' ' . $proponente->per_apellidos}}</a></p>
        @if(count($asignados)>0)
            @if($perfil->pro_estado == "propuesta" || $perfil->pro_estado == "proyecto aprobado")
                <p class="titulo">Evaluador actual</p>
                <p><a class="info-link truncate" target="_blank" href="{{url('/')}}/perfil/view/{{\Illuminate\Support\Facades\Crypt::encrypt($asignados->get(0)->persona->id)}}">{{$asignados->get(0)->persona->per_nombres.' '.$asignados->get(0)->persona->per_apellidos.' ('.$asignados->get(0)->eva_tipo.')'}}</a></p>
            @else
                <p class="titulo">Evaluadores actuales</p>
                @foreach($asignados as $eval)
                    <p><a class="info-link truncate" target="_blank" href="{{url('/')}}/perfil/view/{{\Illuminate\Support\Facades\Crypt::encrypt($asignados->get(0)->persona->id)}}">{{$eval->persona->per_nombres.' '.$eval->persona->per_apellidos.' ('.$eval->eva_tipo.')'}}</a></p>
                @endforeach
            @endif

        @endif
    </div>


    <div class="col s12 m6 z-depth-1" style="background-color: rgba(255,255,255,1);padding-bottom: 15px;">
        @if($perfil->pro_estado == "propuesta" || $perfil->pro_estado == "proyecto aprobado")
            <p class="titulo">Seleccione un evaluador</p>
        @else
            <p class="titulo">Seleccione los evaluadores</p>
        @endif
        <div style="max-height: 300px; overflow-y: auto; overflow-x: hidden;">
                @if (count($evaluadores) > 0)
                    <?php $i = 0; ?>
                    @foreach ($evaluadores as $evaluador)
                        <?php $i++; ?>
                        @if($perfil->pro_estado == "propuesta" || $perfil->pro_estado == "proyecto aprobado")
                        <p>
                            <input type="radio" name="evaluadores[]" id="evaluador{{$i}}" value="{{\Illuminate\Support\Facades\Crypt::encrypt($evaluador->id)}}"/>
                            <label for="evaluador{{$i}}"><a class="info-link truncate" target="_blank" href="{{url('/')}}/perfil/view/{{\Illuminate\Support\Facades\Crypt::encrypt($evaluador->persona->id)}}">{{$evaluador->persona->per_nombres . ' ' . $evaluador->persona->per_apellidos . ' (' . $evaluador->eva_tipo . ')'}}</a></label>
                        </p>
                        @else
                        <p>
                            <input type="checkbox" name="evaluadores[]" id="evaluador{{$i}}" value="{{\Illuminate\Support\Facades\Crypt::encrypt($evaluador->id)}}"/>
                            <label for="evaluador{{$i}}"><a class="info-link truncate" target="_blank" href="{{url('/')}}/perfil/view/{{\Illuminate\Support\Facades\Crypt::encrypt($evaluador->persona->id)}}">{{$evaluador->persona->per_nombres . ' ' . $evaluador->persona->per_apellidos . ' (' . $evaluador->eva_tipo . ')'}}</a></label>
                        </p>
                        @endif
                    @endforeach
                @else
                    <p class="center-align">No existen evaluadores para seleccionar</p>
                @endif
        </div>
    </div>

    <div class="col s12" style="margin-top: 20px; margin-bottom: 10px;">
        <input type="checkbox" id="checkInformarViaCorreo" name="checkInformarViaCorreo" />
        <label for="checkInformarViaCorreo">Informar vía correo electronico</label>
    </div>
    <div class="col s12 contenedor_botones">
        <a class="btn waves-effect waves-light col s12 teal darken-1 texto-blanco" id="btnAsignar">asignar</a>
    </div>

    <div class="progress invisible">
        <div class="indeterminate"></div>
    </div>
</div>
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}" />
    <input type="hidden" id="txtIdPerfil" name="txtIdPerfil" value="{{\Illuminate\Support\Facades\Crypt::encrypt($perfil->id)}}"/>

</form>

@section('js')
@parent
<script src="{{asset('Js/adminv/perfil/asignar.js')}}"></script>
@stop