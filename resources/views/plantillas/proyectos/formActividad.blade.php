<p class="tituloGrande tituloPrincipalPag" style="margin-bottom: 0px;">{{$action}} actividad</p>
@if($componente->com_estado == 'delete')
    <p>El componente al cual está asignado esta actividad ha sido eliminado.</p>
@else
    <form id="form-actividad" class="col s12">
    <p class="tituloMediano">{{$componente->com_nombre}}</p>
    <p class="texto-informacion-medium" style="margin-bottom: 50px;">{{$componente->com_objetivo}}</p>
        @if($actividad->act_estado == 'delete')
            <p>La actividad que desea editar ha sido eliminada.</p>
        @else
            <div class="col s12 m6">
                <input type="hidden" value="{{\Illuminate\Support\Facades\Crypt::encrypt($componente->id)}}" id="id-componente" name="id-componente">
                <input type="hidden" value="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}" id="id-actividad" name="id-actividad">
                <input type="hidden" value="{{$action}}" id="action" name="action">
                <div class="input-field">
                    <label for="descripcion" class="active">Descripción</label>
                    <textarea id="descripcion" name="descripcion" maxlength="200" class="materialize-textarea" >{{$actividad->act_descripcion}}</textarea>
                </div>

                <div class="input-field">
                    <label for="resultado" class="active">Resultado</label>
                    <textarea id="resultado" name="resultado" maxlength="150" class="materialize-textarea" >{{$actividad->act_resultado}}</textarea>
                </div>
            </div>

            <div class="col s12 m6">
                    <div class="input-field">
                        <label for="indicador" class="active">Indicador</label>
                        <textarea id="indicador" name="indicador" maxlength="150" class="materialize-textarea" >{{$actividad->act_indicador}}</textarea>
                    </div>
                    <p class="texto-informacion-medium">La duración de la actividad mas el número del mes de inicio de la misma no debe ser mayor de {{($componente->proyectoInvestigativo->proyecto->pro_duracion +1)}}, la duración de la actividad puede ser un número decimal.</p>
                    <div class="input-field">
                        <input type="number" name="mes-inicio" id="mes-inicio" max="{{$componente->proyectoInvestigativo->proyecto->pro_duracion}}" placeholder="Ingrese el número del mes en e que se debe iniciar la actividad" value="{{$actividad->act_numero_mes_inicio}}">
                        <label class="active" for="mes-inicio">Número mes inicio</label>
                    </div>

                    <div class="input-field">
                        <input type="number" name="duracion" id="duracion" max="{{$componente->proyectoInvestigativo->proyecto->pro_duracion}}" placeholder="Ingrese la duración de la actividad" value="{{$actividad->act_duracion}}">
                        <label class="active" for="duracion">Duración (1 = 1 mes)</label>
                    </div>
            </div>
        @endif
    </form>
@endif