<?php
$proponente = $perfil->proyectoInvestigativo->investigadorLider->persona;
?>
<p class="tituloPrincipalPag tituloMediano">Sugerencias a un perfil<i class="mdi-content-drafts"></i></p>

<div class="col s12 m3" style="text-align: justify;">
    <p class="texto-informacion-medium">Sus sugerencias serán enviadas al investigador por medio del sistema <strong>SINERGIA</strong> y/o vía correo electrónico, esto depende del rol que tenga el investigador en el sistema.</p>
</div>
<div class="col s12 m9" style="background-color: rgba(255,255,255,.9)">
    <div class="col s12">
        <p class="titulo s12 col m5 l4 offset-l1">Titulo: </p>
        <p class="col s12 m7 l6" >{{ $perfil->pro_titulo }}</p>
        <div class="col s12 m10 offset-m1 divider teal" style="margin-bottom: 20px;"></div>
    </div>

    <div class="col s12">
        <p class="titulo s12 col m5 l4 offset-l1">Objetivo general</p>
        <p class="col s12 m7 l6" >{{$perfil->pro_objetivo_general}}</p>
        <div class="col s12 m10 offset-m1 divider teal" style="margin-bottom: 20px;"></div>
    </div>

    <div class="col s12">
        <p class="titulo s12 col m5 l4 offset-l1">Proponente</p>
        <p class="col s12 m7 l6" >{{$proponente->per_nombres . ' ' . $proponente->per_apellidos}}</p>
        <div class="col s12 m10 offset-m1 divider teal" style="margin-bottom: 40px;"></div>
    </div>


    <form id="formSugerencia" method="post">
        <div class="col s12 m10 offset-m1">
            @if(count($perfil->proyectoInvestigativo->componentes) && ($perfil->pro_estado != "proyecto aprobado"))
                <p class="texto-informacion-medium" style="margin-bottom: 50px;"><strong>Nota:</strong> seleccione la información que considere necesaria.</p>
                <div class="input-field">
                    <label for="componente" class="active">Componente</label>
                    <select name="componente" id="componente">
                        <option value="">Seleccione</option>
                        @foreach($perfil->proyectoInvestigativo->componentes as $componente)
                            <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($componente->id)}}">{{$componente->com_nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div id="cont_select_actividades" class="input-field"></div>
                <div id="cont_select_opc_actividad" class="input-field"></div>
                <div id="cont_select_rubros" class="input-field"></div>
                <div id="cont_select_productos" class="input-field"></div>

            @endif

            <div id="" class="input-field">
                <label for="importancia" class="active">Importancia</label>
                <select name="importancia" id="importancia">
                    <option value="">Seleccione</option>
                    <option value="1">Baja</option>
                    <option value="2">Media</option>
                    <option value="3">Alta</option>
                </select>
            </div>

            <div class="input-field" style="margin-top: 50px;">
                <i class="mdi-action-info prefix"></i>
                <textarea class="materialize-textarea" id="sugerencia" name="sugerencia" required></textarea>
                <label for="sugerencia">Sugerencia</label>
            </div>
            <input type="hidden" id="idPerfil" name="idPerfil" value="{{\Illuminate\Support\Facades\Crypt::encrypt($perfil->id)}}"/>

            <p>
                <input type="checkbox" name="enviarCorreo" id="enviarCorreo">
                <label for="enviarCorreo">Informar vía correo electronico</label>
            </p>
            <br>
            <div class="contenedor-botones">
                <input type="submit" class="btn" value="enviar">
            </div>

            <div class="progress invisible">
                <div class="indeterminate"></div>
            </div>
            <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
        </div>
    </form>
</div>


@section('js')
@parent
<script type="text/javascript" src="{{asset('Js/adminv/perfil/sugerir.js')}}"></script>
@stop