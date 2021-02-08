<div class="modal-content">
    <h4 class="tituloPrincipalPag">Evaluación de actividad</h4>
    @if($actividad->act_estado == "delete")
        <p>Esta actividad ha sido eliminada.</p>
    @else
        <p class="texto-informacion-small" style="margin-bottom: 50px;"><strong>Nota: </strong>Una vez la actividad sea finalizada no se podrán deshacer cambios. Una actividad es finalizada cuando todos sus productos estan en estado aprobado o cuando cuando no tiene productos y se hace click sobre el botón finalizar actividad.</p>
        <strong class="col s12 m4 l2 texto-informacion-medium">Descripción: </strong><p class="col s12 m8 l10">{{$actividad->act_descripcion}}</p>
        <strong class="col s12 m4 l2 texto-informacion-medium">Indicador: </strong><p class="col s12 m8 l10">{{$actividad->act_indicador}}</p>
        <strong class="col s12 m4 l2 texto-informacion-medium">Resultado: </strong><p class="col s12 m8 l10">{{$actividad->act_resultado}}</p>
        <strong class="col s12 m4 l2 texto-informacion-medium">Duración: </strong><p class="col s12 m8 l10">{{$actividad->act_duracion." meses"}}</p>
        <strong class="col s12 m4 l2 texto-informacion-medium">Fecha de inicio: </strong><p class="col s12 m8 l10">{{$actividad->act_fecha_inicio}}</p>
        <strong class="col s12 m4 l2 texto-informacion-medium">Fecha de finalización estimada: </strong><p class="col s12 m8 l10">{{$actividad->act_fecha_fin}}</p>
        <input type="hidden" name="g_id_actividad" id="g_id_actividad" value="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}">

        @if(count($actividad->productos))
            <?php $aux = 0; ?>
            @foreach($actividad->productos as $p)
                @if($p->pro_estado != 'delete')
                    <?php $aux++; ?>
                @endif
            @endforeach

            @if($aux > 0)
                <div class="col s12 white">
                  <ul class="tabs">
                    <?php $i = 0; ?>
                    @foreach($actividad->productos as $producto)
                        <?php $i++; ?>
                        <li class="tab"><a href="#pro_{{$producto->id}}">Producto {{$i}}</a></li>
                    @endforeach
                  </ul>
                </div>
                <form id="formProductos" name="formProductos">
                <input type="hidden" name="id_actividad" id="id_actividad" value="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}">
                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                <?php $i = 0; ?>
                @foreach($actividad->productos as $producto)
                    <?php $i++; ?>
                    <div id="pro_{{$producto->id}}" class="col s12 white" style="padding-top: 20px; padding-bottom: 20px;">
                        <div class="col s12 m8">
                            <strong class="col s12">Descripción</strong>
                            <div class="col s12 divider grey lighten-2"></div>
                            <p class="col s12 texto-informacion-medium" style="margin-top: 5px;">{{$producto->pro_descripcion}}</p>
                            @if(!empty($producto->pro_ubicacion))
                                <div class="col s12 divider white" style="margin-top: 20px;"></div>
                                <strong class="col s12">Archivo</strong>
                                <div class="col s12 divider grey lighten-2"></div>
                               <a class="col s12" style="margin-top: 5px;" href="{{url('/proyecto/download-file-producto/'.\Illuminate\Support\Facades\Crypt::encrypt($producto->id))}}"></spam>{{$producto->pro_ubicacion}} <i class="mdi-file-file-download"></i></a>
                            @endif

                            @if(!empty($producto->pro_nota))
                                <div class="col s12 divider white" style="margin-top: 20px;"></div>
                                <strong class="col s12">Nota de producto</strong>
                                <div class="col s12 divider grey lighten-2"></div>
                               <p class="col s12 texto-informacion-medium" style="margin-top: 5px;">{{$producto->pro_nota}}</p>
                            @endif
                        </div>

                        <div class="col s12 m4">
                            <input type="hidden" name="id_producto{{$i}}" id="id_producto{{$i}}" value="{{\Illuminate\Support\Facades\Crypt::encrypt($producto->id)}}">
                            <label for="estado_producto{{$i}}">Estado</label>
                            <select id="estado_producto{{$i}}" name="estado_producto{{$i}}">
                            <?php
                                $porRevisar = "";
                                $noAprobado = "";
                                $aprobado = "";
                            ?>
                                @if($producto->pro_estado == "por revisar")
                                    <?php $porRevisar = "selected" ?>
                                @endif

                                @if($producto->pro_estado == "aprobado")
                                    <?php $aprobado = "selected" ?>
                                @endif

                                @if($producto->pro_estado == "no aprobado")
                                    <?php $noAprobado = "selected" ?>
                                @endif

                                <option value="1" {{$porRevisar}}>Por revisar</option>
                                <option value="2" {{$aprobado}}>Aprobado</option>
                                <option value="3" {{$noAprobado}}>No aprobado</option>
                            </select>
                        </div>
                        <div class="divider col s12 orange" style="margin-bottom: 60px; margin-top: 20px;"></div>

                        <div class="col s12">
                            <div class="col s12 m8 l9 input-field">
                                <label for="sugerencia_{{$i}}" class="active"><strong>Sugerencia</strong></label>
                                <input type="hidden" name="pr_{{$i}}" id="pr_{{$i}}" value="{{\Illuminate\Support\Facades\Crypt::encrypt($producto->id)}}">
                                <textarea id="sugerencia_{{$i}}" class="materialize-textarea" name="sugerencia_{{$i}}" placeholder="Sugerencia del producto" rows="1"></textarea>
                            </div>
                            <div class="col s12 m4 l3">
                                <label for="importancia_{{$i}}">Importancia</label>
                                <select id="importancia_{{$i}}" name="importancia_{{$i}}">
                                    <option value="1">Baja</option>
                                    <option value="2">Media</option>
                                    <option value="3">Alta</option>
                                </select>
                            </div>
                            <div class="contenedor-botones">
                                <a class="btn teal darken-1 texto-blanco" onclick="addSugerenciaProducto('{{$i}}')">Enviar sugerencia</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                </form>
            @endif
        @endif

    @endif
</div>
<div class="modal-footer">
    <div class="progress orange lighten-4 invisible" style="margin-top: -10px;">
        <div class="indeterminate orange darken-2"></div>
    </div>
    <div class="contenedor-botones">
        @if(count($actividad->productos))
            <?php $aux = 0; ?>
            @foreach($actividad->productos as $p)
                @if($p->pro_estado != 'delete')
                    <?php $aux++; ?>
                @endif
            @endforeach

            @if($aux > 0)
                <a href="#!" class="waves-effect waves-light btn-flat texto-blanco" onclick="guardarCambiosProductos()">Guardar cambios</a>
            @endif
        @else
            @if($actividad->act_estado != "delete")
                <a href="#!" class="waves-effect waves-light btn-flat texto-blanco" onclick="finalizarActividad()">Finalizar actividad</a>
            @endif
        @endif
        <a href="#!" class="waves-effect waves-light btn-flat texto-blanco" onclick="ocultarModal()">Cancelar</a>
    </div>
</div>
<script>
inicializarMaterializacss();
</script>