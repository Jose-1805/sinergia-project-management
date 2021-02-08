<p class="tituloGrande tituloPrincipalPag" style="margin-bottom: 0px;">Gestión de rubros</p>
@if($actividad->act_estado != "delete" && $componente->com_estado != "delete")
<strong>Descripción de la actividad</strong>
<p class="texto-informacion-medium" style="margin-bottom: 50px;">{{$actividad->act_descripcion}}</p>
    <div class="col s12 white" style="padding: 20px 40px;">
        <div class="col s12">
            <input type="hidden" value="{{\Illuminate\Support\Facades\Crypt::encrypt($componente->id)}}" id="id-componente" name="id-componente">
            <input type="hidden" value="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}" id="id-actividad" name="id-actividad">
            <ul id="contenedor-rubros" class="collapsible popout">
                @if(count($actividad->rubros))
                    <?php $i = 0; ?>
                    @foreach($actividad->rubros as $rubro)
                        @if($rubro->rub_estado != "delete")
                            <?php $i++; ?>
                            <li class="contenedor-rubro">
                                <div class="collapsible-header">Rubro {{$i}} <i id="btnEliminarRubro_{{$i}}" class="mdi-content-remove-circle-outline red-text text-darken-2 right" style="cursor: pointer; font-weight: bold;" title="Elminar" onclick="eliminarRubro(this.id)"></i></div>
                                <div class="collapsible-body">
                                    @include('plantillas.proyectos.formulario_rubro',array('rubro'=>$rubro,'numero_rubro'=>$i))
                                </div>
                            </li>
                        @endif
                    @endforeach
                @else
                    <li class="contenedor-rubro">
                        <div class="collapsible-header">Rubro 1 <i id="btnEliminarRubro_1" class="mdi-content-remove-circle-outline red-text text-darken-2 right" style="cursor: pointer; font-weight: bold;" title="Elminar" onclick="eliminarRubro(this.id)"></i></div>
                        <div class="collapsible-body">
                            <?php $rubro = new \App\Models\Rubro();?>
                            @include('plantillas.proyectos.formulario_rubro',array('rubro'=>$rubro,'numero_rubro'=>1))
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    @endif