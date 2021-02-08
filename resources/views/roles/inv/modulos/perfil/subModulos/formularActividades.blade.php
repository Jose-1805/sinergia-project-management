<div class='col s12' id='componentes' style='margin-bottom: 20px;'>
    <p class='col s12 tituloMediano tituloPrincipalPag'>Actividades</p>
    <ul id='comp'>
        <li style='opacity:1;'>
            <div class='col s12 m4' style='text-align: justify;'>
                <p class="texto-informacion-medium">Registre las actividades que planea desarrollar para cumplir el objetivo de cada componente.</p>
                <p class="texto-informacion-medium">Cada componente debe tener por lo menos una actividad, una vez registre todas sus actividades presione el boton COMPLETO para pasar al siguiente paso. </p>

            </div>
        </li>
    </ul>

    <div class='col s12 m8'>

        <ul class='collapsible' data-collapsible='accordion'>
            @if (count($objPerfil->proyectoInvestigativo->componentes))
                <?php
                $aux = 0;
                foreach ($objPerfil->proyectoInvestigativo->componentes as $componente)
                {
                    if($componente->com_estado != "delete"){
                    $aux++;
                    ?>
                    <li class='liComponente' id='{{"liComponente".$aux}}'>
                        <div class='collapsible-header'>
                            <p>{{"Componente ".$aux }}</p>
                        </div>
                        <div class='collapsible-body componente' id="{{'componente'.$aux}}">
                            <input type="hidden" value="{{\Illuminate\Support\Facades\Crypt::encrypt($componente->id)}}" name="id_componente" id="id_componente">
                            <div class="right" style="margin-top: -20px;">
                                <i class="material-icons teal-text darken-1 waves-effect waves-light modal-trigger show-nueva-actividad" href="#modalActividad" data-componente="{{\Illuminate\Support\Facades\Crypt::encrypt($componente->id)}}" style="cursor: pointer;">library_add</i>
                            </div>

                            @if(count($componente->actividades))
                            <?php $cont = 0; ?>
                                 <div class="collection">
                                    @foreach($componente->actividades as $actividad)
                                        @if($actividad->act_estado != "delete")
                                            <?php $cont++; ?>
                                            <a href="#modalActividad" class="collection-item modal-trigger show-editar-actividad" data-actividad="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}" style="padding: 20px 50px;">Actividad {{$cont}}</a>
                                        @endif
                                    @endforeach
                                 </div>
                            @else
                                <p class="texto-informacion-medium center">No se han registrado actividades.</p>
                            @endif

                        </div>
                    </li>
                <?php
                    }
                }
            ?>
            @endif
        </ul>

        <div class='right-align contenedor-botones'>
            <a class='btn waves-effect waves-light' id="btnActividadesCompletas">completo</a>
        </div>
    </div>
</div>

<div id="modalActividad" class="modal full-modal modal-up">
    <div class="modal-content col s12">
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action waves-effect waves-light btn-flat texto-blanco" onclick="actionsActividad()">Guardar</a>
        <a href="#!" class=" modal-action waves-effect waves-light btn-flat texto-blanco" id="deleteActividad" onclick="deleteActividad()">Eliminar</a>
        <a href="#!" class=" modal-action modal-close waves-effect waves-light btn-flat texto-blanco">Cancelar</a>
    </div>
</div>