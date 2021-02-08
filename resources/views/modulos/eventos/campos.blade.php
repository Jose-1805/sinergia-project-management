
<div class="input-field">
    <label for="titulo" class="active">Titulo</label>
    <input type="text" name="titulo" id="titulo" value="{{$evento->eve_titulo}}" max="30">
</div>

<div class="input-field">
    <label for="descripcion_corta" class="active">Descripción corta</label>
    <textarea name="descripcion_corta" id="descripcion_corta" class="materialize-textarea" maxlength="100">{{$evento->eve_descripcion_corta}}</textarea>
</div>

<div class="input-field">
    <label for="descripcion_detallada" class="active">Descripción detallada</label>
    <textarea name="descripcion_detallada" id="descripcion_detallada" class="materialize-textarea" maxlength="3000">{{$evento->eve_descripcion_detallada}}</textarea>
</div>

<div class="input-field">
    <label for="estado" class="active">Estado</label>
    <select id="estado" name="estado">
        <option value="habilitado" @if($evento->eve_estado == "habilitado")  {{"selected"}} @endif>Habilitado</option>
        <option value="inhabilitado" @if($evento->eve_estado == "inhabilitado")  {{"selected"}} @endif>Inhabilitado</option>
    </select>
</div>
<input type="hidden" name="evento" value="{{$evento->id}}">
<input type="hidden" name="_token" value="{{csrf_token()}}">