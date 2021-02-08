<?php
 $aux = 0;
?>
<p class="tituloPrincipalPag tituloGrande">Sugerencias registradas</p>
<div class="col s12 white">
    @if(count($sugerencias))
        <ul class="collection">
            @foreach($sugerencias as $sugerencia)
                <?php
                    switch($sugerencia->sug_importancia){
                        case '1': $classImportancia = "yellow";
                            break;
                        case '2': $classImportancia = "orange";
                            break;
                        case '3': $classImportancia = "red";
                            break;
                        default: $classImportancia = "blue";
                            break;
                    }
                    $proyecto = \App\Models\Proyecto::find($sugerencia->proyecto_id);
                ?>
                @if($proyecto->pro_estado == $sugerencia->proyecto_estado)
                    <?php
                        $continuar = false;
                        switch($sugerencia->sug_elemento_nombre){
                            case "componente":
                                $c = \App\Models\Componente::find($sugerencia->sug_elemento_id);
                                if($c && $c->com_estado != "delete")
                                    $continuar = true;
                                break;
                            case "actividad":
                                        $a = \App\Models\Actividad::find($sugerencia->sug_elemento_id);
                                        if($a && $a->act_estado != "delete")
                                            $continuar = true;
                                break;
                            case "producto":
                                        $p = \App\Models\Producto::find($sugerencia->sug_elemento_id);
                                        if($p && $p->pro_estado != "delete")
                                            $continuar = true;
                                break;
                            case "rubro":
                                        $r = \App\Models\Rubro::find($sugerencia->sug_elemento_id);
                                        if($r && $r->rub_estado != "delete")
                                            $continuar = true;
                                break;
                            case "general":
                                $continuar = true;
                                break;
                        }
                    ?>
                    @if($continuar)
                    <?php $aux++; ?>
                        <li class="collection-item avatar">
                            <a href="/eval/sugerencia/{{\Illuminate\Support\Facades\Crypt::encrypt($sugerencia->id)}}">
                                  <p class="title teal-text"><strong>Proyecto: </strong>{{$sugerencia->proyecto->pro_titulo.' - '.$sugerencia->proyecto->pro_estado}}</p>
                                  <p class="texto-informacion-medium black-text"><strong>Tipo Sugerencia: </strong>{{$sugerencia->sug_elemento_nombre}}</p>
                                  <p class="texto-informacion-medium black-text"><strong>Fecha: </strong>{{date('Y-m-d',strtotime($sugerencia->created_at))." - resp.(".count($sugerencia->respuestas).")"}}</p>
                                  <i class="material-icons secondary-content right-align {{$classImportancia.'-text'}}">grade</i>
                            </a>
                        </li>
                    @endif
                @endif
            @endforeach
            @if($aux == 0)
                <p class="center">No existen sugerencias por revisar</p>
            @endif
        </ul>
    @else
        <p class="center">No existen sugerencias por revisar</p>
    @endif
</div>