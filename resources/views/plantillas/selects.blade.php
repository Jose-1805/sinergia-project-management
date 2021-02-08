@if($select == 'actividades')
    <?php
        $componente = \App\Models\Componente::find($id);
    ?>
        <label for="actividad" class="active">Actividad</label>
        <select name="actividad" id="actividad" onchange="opcionesActividad(this.id)">
            <option value="">Seleccione</option>
            @if($componente && count($componente->actividades))
                <?php $cont = 1; ?>
                @foreach($componente->actividades as $actividad)
                    @if($actividad->act_estado != "delete")
                        <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}">Actividad {{$cont}}</option>
                        <?php $cont++; ?>
                    @endif
                @endforeach
            @endif
        </select>
@elseif($select == 'actividades_productos')
    <?php
        $componente = \App\Models\Componente::find($id);
    ?>
        <label for="actividad" class="active">Actividad</label>
        <select name="actividad" id="actividad" onchange="cargarProductos(this.id)">
            <option value="">Seleccione</option>
            @if($componente && count($componente->actividades))
                <?php $cont = 1; ?>
                @foreach($componente->actividades as $actividad)
                    @if($actividad->act_estado != "delete")
                        <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}">Actividad {{$cont}}</option>
                        <?php $cont++; ?>
                    @endif
                @endforeach
            @endif
        </select>

@elseif($select == 'actividades_relacion')
         <?php
             $componente = \App\Models\Componente::find($id);
         ?>
             <label for="actividad_relacion" class="active">Actividad</label>
             <select name="actividad_relacion" id="actividad_relacion" onchange="">
                 <option value="">Seleccione</option>
                 @if($componente && count($componente->actividades))
                     <?php $cont = 1; ?>
                     @foreach($componente->actividades as $actividad)
                         @if($actividad->act_estado != "delete")
                             <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}">Actividad {{$cont}}</option>
                             <?php $cont++; ?>
                         @endif
                     @endforeach
                 @endif
             </select>
@elseif($select == 'opcionesActividades')
    <?php
        $actividad = \App\Models\Actividad::find($id);
    ?>
    @if($actividad && (count($actividad->rubros) || count($actividad->productos)))
        <input type="hidden" id="actividad" name="actividad" value="{{\Illuminate\Support\Facades\Crypt::encrypt($id)}}">
        <label for="opcion" class="active">Opción</label>
        <select name="opcion" id="opcion" onchange="seleccionOpcion(this.id)">
            <option value="">Seleccione</option>
            @if(count($actividad->rubros))
                <?php $aux = 0;?>
                @foreach($actividad->rubros as $r)
                    @if($r->rub_estado != "delete")
                        <?php $aux++;?>
                    @endif
                @endforeach

                @if($aux > 0)
                    <option value="selectRubros">Rubros</option>
                @endif
            @endif


            @if(count($actividad->productos))
                <?php $aux = 0;?>
                @foreach($actividad->productos as $p)
                    @if($p->pro_estado != "delete")
                        <?php $aux++;?>
                    @endif
                @endforeach

                @if($aux > 0)
                    <option value="selectProductos">Productos</option>
                @endif
            @endif
        </select>
    @endif
@elseif($select == 'selectRubros')
    <?php
        $actividad = \App\Models\Actividad::find($id);
    ?>
        <label for="rubro" class="active">Rubro</label>
        <select name="rubro" id="rubro">
            <option value="">Seleccione</option>
            @if($actividad && count($actividad->rubros))
                @foreach($actividad->rubros as $rubro)
                    <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($rubro->id)}}">{{$rubro->rub_nombre}}</option>
                @endforeach
            @endif
        </select>
@elseif($select == 'selectProductos')
    <?php
        $actividad = \App\Models\Actividad::find($id);
    ?>
        <label for="producto" class="active">Producto</label>
        <select name="producto" id="producto">
            <option value="">Seleccione</option>
                @if($actividad && count($actividad->productos))
                <?php $cont = 1; ?>
                @foreach($actividad->productos as $producto)
                    <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($producto->id)}}">{{$cont}}&bull; {{$producto->pro_descripcion}}</option>
                    <?php $cont++; ?>
                @endforeach
            @endif
        </select>
@elseif($select == 'lineasInvestigacion')
        <?php
            $lineas = \App\Models\LineaInvestigacion::all();
        ?>
        @if(count($lineas))
            <div class='contenedor-select-linea'>
                <label for='lineas_investigacion' class='active'>Lineas de investigación (Mantenga Ctrl y seleccione las lineas de investigación, máximo 4)</label>
                <select name='lineas_investigacion[]' id='lineas_investigacion' multiple='multiple'>
                    @foreach($lineas as $linea)
                        <option value='{{\Illuminate\Support\Facades\Crypt::encrypt($linea->id)}}'>{{$linea->lin_inv_nombre}}</option>
                    @endforeach
                </select>
            </div>
        @else
            <p>No existen lineas de investigación para seleccionar.</p>
        @endif
@elseif($select == 'departamentos')
    <?php
        $pais = \App\Models\Pais::find($id);
    ?>

    <label for="departamento" class="active">Departamentos</label>
    <select name="departamento" id="departamento" onchange="cargarCiudades(this.id)">
        <option value="">Seleccione</option>
        @if($pais && count($pais->departamentos))
            @foreach($pais->departamentos as $departamento)
                    <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($departamento->id)}}">{{$departamento->dep_nombre}}</option>
            @endforeach
        @endif
    </select>
@elseif($select == 'ciudades')
    <?php
        $departamento = \App\Models\Departamento::find($id);
    ?>

    <label for="ciudad" class="active">Ciudad</label>
    <select name="ciudad" id="ciudad" onchange="">
        <option value="">Seleccione</option>
        @if($departamento && count($departamento->ciudades))
            @foreach($departamento->ciudades as $ciudad)
                    <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($ciudad->id)}}">{{$ciudad->ciu_nombre}}</option>
            @endforeach
        @endif
    </select>
@elseif($select == 'divisionActividadEconomica')
    <?php
            $seccion = \App\Models\SeccionActividadEconomica::find($id);
        ?>

    <label for="divisionActEco" class="active">División</label>
    <select name="divisionActEco" id="divisionActEco" onchange="cargarActividadesEconomicas(this.id)">
        <option value="">Seleccione</option>
        @if($seccion && count($seccion->divisionesActividadesEconomicas))
            @foreach($seccion->divisionesActividadesEconomicas as $division)
                    <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($division->id)}}">{{$division->div_act_descripcion}}</option>
            @endforeach
        @endif
    </select>
@elseif($select == 'actividadesEconomicas')
    <?php
        $division = \App\Models\DivisionActividadEconomica::find($id);
    ?>

    <label for="actividad_economica" class="active">Actividad</label>
    <select name="actividad_economica" id="actividad_economica" onchange="">
        <option value="">Seleccione</option>
        @if($division && count($division->actividadesEconomicas))
            @foreach($division->actividadesEconomicas as $actividad)
                    <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}">{{$actividad->act_eco_descripcion}}</option>
            @endforeach
        @endif
    </select>
@endif



