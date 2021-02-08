<?php
    $componente = \App\Models\Componente::find($sugerencia->sug_elemento_id);
    if(!$componente || $componente->com_estado == "delete"){
?>
        <p class="center texto-informacion-medium">El componente relacionado con esta sugerencia ha sido eliminado.</p>
<?php
        $mostrarRespuesta = false;
    }else{
        $mostrarRespuesta = true;
    $idComponente = \Illuminate\Support\Facades\Crypt::encrypt($componente->id);
?>
@if($componente)
<form id="form-componente" class="col s12">
    @if($componente->com_estado == 'delete')
            <p>Este componente ha sido eliminado del proyecto.</p>
    @else
        <input type="hidden" name="idComponente" id="idComponente" value="{{$idComponente}}">
        <div class="col s12">
            <div class='input-field'>
                <input type='text' name='nombre' id='nombre' class="active" value="{{$componente->com_nombre}}" {{$disabled}}>
                <label for='nombre'>Nombre</label>
            </div>
            <div class='input-field'>
                <textarea name='objetivo' id='objetivo' class='materialize-textarea' {{$disabled}}>{{$componente->com_objetivo}}</textarea>
                <label for='objetivo' class="active">Objetivo</label>
            </div>

            <div class='input-field'>
                <label for='equivalente' class="active">Equivalente</label>
                <input type='number' min='1' max='100' id='equivalente' name='equivalente' value="{{$componente->com_equivalente}}" {{$disabled}}>
            </div>
        </div>
        @if($disabled != "disabled")
            <div class="contenedor-botones">
                <a class="btn teal darken-1 white-text right" id="btn_guardar_componente">Guardar</a>
            </div>
            <div class="progress invisible">
                <div class="indeterminate"></div>
            </div>
        @endif
    @endif
</form>
@else
    <p class="center">Ha ocurrido un problema con la información recibida, por favor regrese a la página principal e intente nuevamente</p>
@endif