<?php
 $aux = 0;
?>
<p class="tituloPrincipalPag tituloGrande">Solicitudes</p>
<div class="col s12 white">
    @if(count($solicitudes))
        <ul class="collection">
            @foreach($solicitudes as $solicitud)
                <?php
                    $proyecto = $solicitud->proyectoInvestigativo->proyecto;
                ?>
                    <?php $aux++; ?>
                    <li class="collection-item avatar">
                        <a href="/inv/solicitud/{{\Illuminate\Support\Facades\Crypt::encrypt($solicitud->id)}}">
                              <p class="title teal-text"><strong>Proyecto: </strong>{{$proyecto->pro_titulo}}</p>
                              <p class="texto-informacion-medium black-text"><strong>Fecha de envio: </strong>{{date("Y-m-d",strtotime($solicitud->created_at))}}</p>
                              <i class="material-icons secondary-content right-align {{'red-text'}}">grade</i>
                        </a>
                    </li>
            @endforeach
            @if($aux == 0)
                <p class="center">No existen solicitudes por revisar</p>
            @endif
        </ul>
    @else
        <p class="center">No existen solicitudes por revisar</p>
    @endif
</div>