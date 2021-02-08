@section("css")
    <style>
        /*.select-wrapper ul,.select-wrapper .select-dropdown,.select-wrapper .caret{
            display: none !important;
        }

        .select-wrapper select{
                display: inline-block !important;
                height: auto !important;
                min-height: 200px !important;
        }*/

        .dropdown-content{
            overflow: auto;
        }
        .dropdown-content li span{
            padding: 0px !important;
            font-size: small;
        }

        .dropdown-content li span label{
            height: 20px !important;
        }

        input[type="checkbox"]+label:before{
            top: 5px !important;
            margin-left: 5px !important;
        }
    </style>
@stop
<p class="tituloPrincipalPag tituloMediano">Asignación de tareas</p>

<div class="col s12 white">
    <p class="texto-informacion-medium"><strong>Nota: </strong>Esta vista muestra unicamente los investigadores que han aprobado la solicitud
    enviada y los investigadores creados por usted, los resultados de los productos o treas asignadas a un investigador unicamente podrán
    ser registrados en el sistema por dicho investigador o por el investigador lider del proyecto.</p>
    <ul class="collapsible popout" data-collapsible="accordion">
         @foreach($investigadores as $investigador)
            <li>
               <?php $persona =  $investigador->persona; ?>
               <div class="collapsible-header teal-text texto-informacion-medium">{{$persona->per_nombres." ".$persona->per_apellidos." __ (".$investigador->pro_inv_rol.")"}}</div>
               <div class="collapsible-body">
                    @if(count($proyecto->tareasInvestigador($investigador->id)))
                        <table class="texto-informacion-small bordered highlight">
                            <thead>
                                <th class="center">Componente</th>
                                <th class="center">Actividad</th>
                                <th class="center">Producto</th>
                            </thead>

                            <tbody>
                                @foreach($proyecto->tareasInvestigador($investigador->id) as $producto)
                                    <tr>
                                        <td>{{$producto->actividad->componente->com_nombre}}</td>
                                        <td>{{$producto->actividad->act_descripcion}}</td>
                                        <td>{{$producto->pro_descripcion}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="texto-informacion-medium center">Investigador sin tareas asignadas</p>
                    @endif
               </div>
            </li>
         @endforeach
    </ul>


    <div class="col s12" style="margin-top: 20px;">
        <div class="input-field col s12 m6">
            <label for="componentes" class="active">Componentes</label>
            <select id="componentes" onchange="cargarActividadesProductos(this.id)">
                <option value="">Seleccione</option><
                <?php $i = 0; ?>
                @foreach($proyecto->proyectoInvestigativo->componentes as $componente)
                    <?php $i++; ?>
                    <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($componente->id)}}">Componente {{$i}}</option>
                @endforeach
            </select>
        </div>

        <div class="input-field col s12 m6">
            <div id="contenedor_select_actividades">
                <label for="actividad" class="active">Actividades</label>
                <select id="actividad">
                    <option value="">Seleccione</option><
                </select>
            </div>
            <div class="progress invisible" id="progress_select_actividades">
                <div class="indeterminate"></div>
            </div>
        </div>

        <form id="form-asignar-tarea">
            <div class="input-field col s12 m6">
                <div id="contenedor_select_productos">
                    <label for="producto" class="active">Productos</label>
                    <select id="producto">
                        <option value="">Seleccione</option><
                    </select>
                </div>
                <div class="progress invisible" id="progress_select_productos">
                    <div class="indeterminate"></div>
                </div>
            </div>

            <div class="input-field col s12 m6">
                <label for="investigador" class="active">Investigador</label>
                <select id="investigador" name="investigador">
                    <option value="">Seleccione</option><
                    <?php $i = 0; ?>
                    @foreach($investigadores as $investigador)
                        <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($investigador->id)}}">{{$investigador->persona->per_nombres." ".$investigador->persona->per_apellidos}}</option>
                    @endforeach
                </select>
            </div>
        </form>


        <a class="btn teal white-text waves-effect waves-light right modal-trigger" style="margin-bottom: 20px; margin-top: 10px;" href="#modalAsignarTarea">Guardar</a>

    </div>
</div>


<!-- Modal Structure -->
<div id="modalAsignarTarea" class="modal modal-fixed-footer" style="margin-top: 8%; max-height: 300px;">
    <div class="modal-content">
        <p class="teal-text tituloMediano">¿Esta seguro de asignar la tarea a este investigador?</p>
    </div>

    <div class="modal-footer">
        <div class="contenedor-botones-tareas">
            <a href="#!" class="modal-action waves-effect waves-orange btn-flat" id="btnAsignarTareaOk">Aceptar</a>
            <a href="#!" class="modal-action modal-close waves-effect waves-orange btn-flat ">Cancelar</a>
        </div>

        <div class="progress progress-tareas invisible">
            <div class="indeterminate"></div>
        </div>
    </div>
</div>

@section('js')
@parent
    <script src="{{asset("Js/inv/proyecto/asignarTarea.js")}}"></script>
    <script>
        inicializarMaterializacss();
    </script>
@stop