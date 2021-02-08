<table class="highlight responsive-table centered table_items_rubros">
    <thead>
      <tr>
          <th>Nombre</th>
          <th>Cantidad</th>
          <th>Valor Unitario</th>
          <th>Eliminar</th>
      </tr>
    </thead>

    <tbody>
          @if(count($rubro->componentesRubro))
          <input type="hidden" class="count_rubro" name="count_rubro_{{$numero_rubro}}" value="{{count($rubro->componentesRubro)}}">
          <?php $i = 0; ?>
          @foreach($rubro->componentesRubro as $componenteRubro)
              <?php $i++; ?>
              <tr class="row_item_componente">
                    <td><input type="text" name="nombre_item_{{$numero_rubro}}_{{$i}}" class="center" value="{{$componenteRubro->com_rub_nombre}}"></td>
                    <td><input type="number" name="cantidad_item_{{$numero_rubro}}_{{$i}}" class="center" value="{{$componenteRubro->com_rub_cantidad}}"></td>
                    <td><input type="number" name="valor_unitario_item_{{$numero_rubro}}_{{$i}}" class="center" value="{{$componenteRubro->com_rub_valor_unitario}}"></td>
                    <td><i id="btnEliminarItem_{{$numero_rubro}}_{{$i}}" class="mdi-content-remove-circle-outline red-text text-darken-2" style="cursor: pointer; font-weight: bold;" title="Elminar" onclick="eliminarItemRubro(this.id)"></i></td>
              </tr>
          @endforeach
          @else
             <input type="hidden" class="count_rubro" name="count_rubro_{{$numero_rubro}}" value="1">
             <tr class="row_item_componente">
                   <td><input type="text" name="nombre_item_{{$numero_rubro}}_1" class="center"></td>
                   <td><input type="number" name="cantidad_item_{{$numero_rubro}}_1" class="center"></td>
                   <td><input type="number" name="valor_unitario_item_{{$numero_rubro}}_1" class="center"></td>
                   <td><i id="btnEliminarItem_{{$numero_rubro}}_1" class="mdi-content-remove-circle-outline red-text text-darken-2" style="cursor: pointer; font-weight: bold;" title="Elminar" onclick="eliminarItemRubro(this.id)"></i></td>
             </tr>
          @endif
    </tbody>
</table>
<div class="right-align contenedor-btn-agregar-item">
  <a id="btn_agregar_item_{{$numero_rubro}}" class="btn btn-flat teal-text text-darken-1 waves-effect" style="width: auto !important;" onclick="agregarItemRubro(this.id)">Agregar Item</a>
</div>