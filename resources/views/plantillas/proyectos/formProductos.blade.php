<p class="tituloGrande tituloPrincipalPag" style="margin-bottom: 0px;">Gestión de productos</p>
@if($actividad->act_estado != "delete" && $componente->com_estado != "delete")
<form id="form-productos" class="col s12" style="padding-top: 50px;">
<strong>Descripción de la actividad</strong>
<p class="texto-informacion-medium" style="margin-bottom: 50px;">{{$actividad->act_descripcion}}</p>
    <div class="col s12 m6 white" style="padding: 20px 40px;">
        <div class="col s12">
            <input type="hidden" value="{{\Illuminate\Support\Facades\Crypt::encrypt($componente->id)}}" id="id-componente" name="id-componente">
            <input type="hidden" value="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}" id="id-actividad" name="id-actividad">
            <div id="contenedor-productos">
                @if(count($actividad->productos))
                    <?php $i = 0; ?>
                    @foreach($actividad->productos as $producto)
                        @if($producto->pro_estado != "delete")
                            <?php $i++; ?>
                            <div class="input-field contenedor-producto">
                                <i id="btnEliminar{{$i}}" class="mdi-content-remove-circle-outline right red-text text-darken-2" style="cursor: pointer; font-weight: bold;" title="Elminar" onclick="eliminarProducto(this.id)"></i>
                                <label for="descripcion{{$i}}" class="active">Producto {{$i}}</label>
                                <textarea id="descripcion{{$i}}" name="descripcion{{$i}}" maxlength="200" class="materialize-textarea" >{{$producto->pro_descripcion}}</textarea>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="input-field contenedor-producto">
                        <i id="btnEliminar1" class="mdi-content-remove-circle-outline right red-text text-darken-2" style="cursor: pointer; font-weight: bold;" title="Elminar" onclick="eliminarProducto(this.id)"></i>
                        <label for="descripcion1" class="active">Producto 1</label>
                        <textarea id="descripcion1" name="descripcion1" maxlength="200" class="materialize-textarea" placeholder="Descripción del producto"></textarea>
                    </div>
                @endif
            </div>
        </div>
    </div>
</form>
@endif