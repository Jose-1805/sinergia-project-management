<p class="tituloPrincipalPag tituloMediano">Mis tareas</p>
<div class="col s12 white">
    @if(count($productos))
        <p class="texto-informacion-medium">A continuación se listan cada unos de los productos o tareas que han sido asignados a usted, su objetivo en esta vista es
        subir la información de desarrollo de cada producto, si su rol en el proyecto es el de lider, se listarán todos los productos o tareas
        y podrá realizar cambios en cualesquiera de ellos, los cambios a un producto unicamente se pueden realizar mientras que el producto se
        encuentre es estado de revisión.</p>
        <?php $i = 0;?>
        <p class="tituloPrincipalPag">Lista de  productos</p>
        <ul class="collapsible popout" data-collapsible="accordion">
            @foreach($productos as $producto)
                <?php
                    $actividad = $producto->actividad;
                    $componente = $actividad->componente;
                ?>
                <li>
                    <div class="collapsible-header truncate texto-informacion-medium">{{$producto->pro_descripcion}}</div>
                    <div class="collapsible-body row">

                            <table class="texto-informacion-small bordered highlight">
                                <thead>
                                    <th class="center">Componente</th>
                                    <th class="center">Actividad</th>
                                    <th class="center">Producto</th>
                                </thead>

                                <tbody>
                                        <tr>
                                            <td>{{$producto->actividad->componente->com_nombre}}</td>
                                            <td>{{$producto->actividad->act_descripcion}}</td>
                                            <td>{{$producto->pro_descripcion}}</td>
                                        </tr>
                                </tbody>
                            </table>

                            <div class="divider col s12 grey lighten-3" style="margin-bottom: 20px;"></div>
                            <p class="col s12 m6 l3 texto-informacion-small"><strong>Estado componente: </strong><spam class="{{str_replace(' ','_',$componente->com_estado)}}">{{$componente->com_estado}}</spam></p>
                            <p class="col s12 m6 l3 texto-informacion-small"><strong>Estado actividad: </strong><spam class="{{str_replace(' ','_',$actividad->act_estado)}}">{{$actividad->act_estado}}</spam></p>
                            <p class="col s12 m6 l3 texto-informacion-small"><strong>Fecha inicio actividad: </strong><spam>{{$actividad->act_fecha_inicio}}</spam></p>
                            <p class="col s12 m6 l3 texto-informacion-small"><strong>Fecha fin actividad: </strong><spam>{{$actividad->act_fecha_fin}}</spam></p>
                            <p class="col s12 m6 l3 texto-informacion-small"><strong>Estado producto: </strong><spam class="{{str_replace(' ','_',$producto->pro_estado)}}">{{$producto->pro_estado}}</spam></p>
                            @if($producto->investigador)
                            <?php
                                $r = $producto->investigador->persona;
                                $nombre = $r->per_nombres." ".$r->per_apellidos;
                                $url = asset("/perfil/view/".\Illuminate\Support\Facades\Crypt::encrypt($r->id));
                            ?>
                            <a class="col s12 m6 l9 texto-informacion-small" style="margin-left: -11px;" target="_blank" href="{{$url}}"><p class="teal-text"><strong class="black-text">Responsable: </strong></strong>{{$nombre}}</p></a>
                            @else
                                <a class="col s12 m6 l9 texto-informacion-small" style="margin-left: 0px;" href="#"><p class="teal-text"><strong class="black-text">Responsable: </strong></strong>No establecido</p></a>
                            @endif

                            @if($producto->pro_ubicacion)
                                <a class="col s12 m6 l3 texto-informacion-small" href="{{url('/proyecto/download-file-producto/'.\Illuminate\Support\Facades\Crypt::encrypt($producto->id))}}"><p class="teal-text"><strong class="black-text">Archivo: </strong></strong>{{$producto->pro_ubicacion}}</p></a>
                            @endif

                            @if($producto->pro_nota)
                                <p class="texto-informacion-small col s12" style="margin-top: 20px;"><strong>Nota del producto: </strong>{{$producto->pro_nota}}</p>
                            @endif

                            <div class="col s12 divider grey lighten-3" style="margin-bottom: 20px;margin-top: 20px;"></div>
                            @if($componente->com_estado == "iniciado" && $actividad->act_estado == "iniciado" && $producto->pro_estado == "por revisar")
                                <?php $i++; ?>
                                <div class="col s12">
                                    <form id="{{'form-tarea-'.$i}}" enctype="multipart/form-data">
                                        <input type="hidden" name="producto" value="{{\Illuminate\Support\Facades\Crypt::encrypt($producto->id)}}">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <div class="input-field">
                                            <label class="active" for="nota">Nota de producto</label>
                                            <textarea id="nota" name="nota" class="materialize-textarea" maxlength="1000" length="1000"> {{$producto->pro_nota}}</textarea>
                                        </div>
                                        <div class="file-field input-field col s12" style="margin-top: -10px;">
                                            <input class="file-path validate col s12" type="text" style="" />
                                            <div class="btn col s12 btn-verde">
                                                <span class="hide-on-small-only">Seleccionar archivo</span>
                                                <span class="hide-on-med-and-up">Archivo</span>
                                                <input type="file" name="archivo" id="archivo" style=""/>
                                            </div>
                                        </div>

                                        <div class="col s12" style="margin-top: 5px;" id="contenedor-botones-{{'form-tarea-'.$i}}">
                                            <a class="btn teal white-text waves-effect waves-light" onclick="desarrollarTarea('{{"form-tarea-".$i}}')">Guardar</a>
                                        </div>

                                        <div class="progress invisible" id="contenedor-progress-{{'form-tarea-'.$i}}">
                                            <div class="indeterminate"></div>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <p class="texto-informacion-small col s12"><strong>Nota: </strong>No es posible realizar esta tarea, para desarrollar una tarea tanto su componente como su actividad deben estar
                                en estado <spam class="iniciado">iniciado</spam>, así mismo el producto debe estar en estado <spam class="por_revisar">por revisar.</spam></p>
                            @endif

                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="center texto-informacion-medium">No existen tareas asignadas a usted en este momento.</p>
    @endif
</div>
@section('js')
@parent
    <script src="{{asset('Js/inv/proyecto/misTareas.js')}}"></script>
@stop
