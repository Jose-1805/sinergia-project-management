<?php
    $rubro = \App\Models\Rubro::find($sugerencia->sug_elemento_id);
    $idRubro = \Illuminate\Support\Facades\Crypt::encrypt($rubro->id);
?>
@if($rubro)
    @if($rubro->rub_estado == 'delete')
            <p>Este rubro ha sido eliminado del proyecto.</p>
    @else
        <form id="form_rubro">
        <div>
            <input type="hidden" name="id_rubro" id="id_rubro" value="{{$idRubro}}">

            <div class="input-field">
                <label for="nombre" class="active">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{$rubro->rub_nombre}}">
                <input type="hidden" name="cantidadComponentes" id="cantidadComponentes" value="{{count($rubro->componentesRubro)}}" {{$disabled}}>
            </div>

            <div>
                <table>
                <thead>
                    <th class="center">Nombre</th>
                    <th class="center">Cantidad</th>
                    <th class="center">Valor unitario</th>
                    @if($disabled != "disabled")
                        <th class="center">Eliminar</th>
                    @endif
                </thead>
                <tbody id="tbodyComponentes">
                    <?php $i = 0; ?>
                    @foreach($rubro->componentesRubro as $componente)
                        <?php $i++; ?>
                        <tr class="contenedorComponente">
                            <td>
                                <input {{$disabled}} type="text" name="nombre{{$i}}" id="nombre{{$i}}" value="{{$componente->com_rub_nombre}}">
                            </td>

                            <td>
                                <input {{$disabled}} type="number" name="cantidad{{$i}}" id="cantidad{{$i}}" value="{{$componente->com_rub_cantidad}}" class="center">
                            </td>

                            <td>
                                <input {{$disabled}} type="number" name="valorUnitario{{$i}}" id="valorUnitario{{$i}}" value="{{$componente->com_rub_valor_unitario}}" class="center">
                            </td>

                            @if($disabled != "disabled")
                                <td class="center">
                                    <a class="btn red darken-1 texto-blanco eliminar-componente-rubro">-</a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
        </form>
        @if($disabled != "disabled")
            <div class="contenedor-botones">
                <a class="btn teal darken-1 white-text right" id="btn_guardar_rubro">Guardar</a>
                <a class="btn teal darken-1 white-text right" id="btn_agregar_componente">Agregar componente</a>
            </div>
            <div class="progress invisible">
                <div class="indeterminate"></div>
            </div>
        @endif
    @endif
@else
    <p class="center">Ha ocurrido un problema con la información recibida, por favor regrese a la página principal e intente nuevamente</p>
@endif