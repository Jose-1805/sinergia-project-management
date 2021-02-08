<form name="form_rubro_{{$numero_rubro}}" id="form_rubro_{{$numero_rubro}}" class="formulario_rubro">
    <div class="input-field">
        <label for="nombre_rubro_{{$numero_rubro}}" class="active">Nombre Rubro {{$numero_rubro}}</label>
        <input type="text" id="nombre_rubro_{{$numero_rubro}}" name="nombre_rubro_{{$numero_rubro}}" maxlength="45" class="" placeholder="Nombre del rubro" value="{{$rubro->rub_nombre}}">
    </div>

    @include('plantillas.proyectos.table_items_rubro')
</form>
