<?php
    $actividad = \App\Models\Actividad::find($sugerencia->sug_elemento_id);
    $idActividad = \Illuminate\Support\Facades\Crypt::encrypt($actividad->id);
?>
@if($actividad)
    @if($actividad->act_estado == 'delete')
        <p>Esta actividad ha sido eliminada del proyecto.</p>
    @else
        <form id="form-actividad" class="col s12">
            <div class="col s12 m6">
                <input type="hidden" value="{{$idActividad}}" id="id_actividad" name="id_actividad">
                <input type="hidden" value="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->componente->id)}}" id="id-componente" name="id-componente">
                <div class="input-field">
                    <label for="descripcion" class="active">Descripción</label>
                    <textarea id="descripcion" name="descripcion" maxlength="200" class="materialize-textarea" {{$disabled}}>{{$actividad->act_descripcion}}</textarea>
                </div>

                <div class="input-field">
                    <label for="resultado" class="active">Resultado</label>
                    <textarea id="resultado" name="resultado" maxlength="150" class="materialize-textarea" {{$disabled}} >{{$actividad->act_resultado}}</textarea>
                </div>
            </div>

            <div class="col s12 m6">
                    <div class="input-field">
                        <label for="indicador" class="active">Indicador</label>
                        <textarea id="indicador" name="indicador" maxlength="150" class="materialize-textarea" {{$disabled}} >{{$actividad->act_indicador}}</textarea>
                    </div>
                    @if($disabled != "disabled")
                        <p class="texto-informacion-medium">La duración de la actividad mas el número del mes de inicio de la misma no debe ser mayor de {{($actividad->componente->proyectoInvestigativo->proyecto->pro_duracion +1)}}, la duración de la actividad puede ser un número decimal.</p>
                    @endif
                    <div class="input-field">
                        <input type="number" name="mes-inicio" id="mes-inicio" {{$disabled}} max="{{$actividad->componente->proyectoInvestigativo->proyecto->pro_duracion}}" placeholder="Ingrese el número del mes en e que se debe iniciar la actividad" value="{{$actividad->act_numero_mes_inicio}}">
                        <label class="active" for="mes-inicio">Número mes inicio</label>
                    </div>

                    <div class="input-field">
                        <input type="number" name="duracion" id="duracion" {{$disabled}} max="{{$actividad->componente->proyectoInvestigativo->proyecto->pro_duracion}}" placeholder="Ingrese la duración de la actividad" value="{{$actividad->act_duracion}}">
                        <label class="active" for="duracion">Duración (1 = 1 mes)</label>
                    </div>
            </div>

            @if($disabled != "disabled")
                <div class="contenedor-botones">
                    <a class="btn teal darken-1 white-text right" id="btn_guardar_actividad">Guardar</a>
                </div>
                <div class="progress invisible">
                    <div class="indeterminate"></div>
                </div>
            @endif
        </form>
    @endif
@else
    <p class="center">Ha ocurrido un problema con la información recibida, por favor regrese a la página principal e intente nuevamente</p>
@endif