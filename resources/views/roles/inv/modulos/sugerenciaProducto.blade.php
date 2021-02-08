<?php
    $producto = \App\Models\Producto::find($sugerencia->sug_elemento_id);
    $idProducto = \Illuminate\Support\Facades\Crypt::encrypt($producto->id);
?>
@if($producto)
    @if($producto->pro_estado == 'delete')
        <p>Este producto ha sido eliminado del proyecto.</p>
    @else


        @if($disabled == "disabled")
            <div class="col s12">
                <strong class="col s12">Descripción</strong>
                <div class="col s12 divider grey lighten-2"></div>
                <p class="col s12 texto-informacion-medium" style="margin-top: 5px;">{{$producto->pro_descripcion}}</p>

                @if($producto->pro_ubicacion)
                    <div class="col s12 divider white" style="margin-top: 20px;"></div>
                    <strong class="col s12">Archivo</strong>
                    <div class="col s12 divider grey lighten-2"></div>
                    <a class="col s12" style="margin-top: 5px;" href="{{url('/proyecto/download-file-producto/'.\Illuminate\Support\Facades\Crypt::encrypt($producto->id))}}"></spam>{{$producto->pro_ubicacion}} <i class="mdi-file-file-download"></i></a>
                @endif

                @if($producto->pro_nota)
                    <div class="col s12 divider white" style="margin-top: 20px;"></div>
                    <strong class="col s12">Nota de producto</strong>
                    <div class="col s12 divider grey lighten-2"></div>
                    <p class="col s12 texto-informacion-medium" style="margin-top: 5px;">{{$producto->pro_nota}}</p>
                @endif
            </div>
        @else
            <div class="input-field">
                <input type="hidden" name="id_producto" id="id_producto" value="{{$idProducto}}">
                <label for="descripcion" class="active">Descripción</label>
                <textarea class="materialize-textarea" id="descripcion" name="descripcion" {{$disabled}}>{{$producto->pro_descripcion}}</textarea>
            </div>
        @endif



        @if($disabled != "disabled")
            <div class="contenedor-botones">
                <a class="btn teal darken-1 white-text right" id="btn_guardar_producto">Guardar</a>
            </div>
            <div class="progress invisible">
                <div class="indeterminate"></div>
            </div>
        @endif
    @endif
@else
    <p class="center">Ha ocurrido un problema con la información recibida, por favor regrese a la página principal e intente nuevamente</p>
@endif