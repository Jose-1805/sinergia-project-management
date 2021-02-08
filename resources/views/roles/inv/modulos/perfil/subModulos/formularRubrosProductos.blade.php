<div class='col s12' id='componentes' style='margin-bottom: 20px;'>
    <p class='col s12 tituloMediano tituloPrincipalPag'>Rubros y productos</p>
    <ul id='comp'>
        <li style='opacity:1;'>
            <div class='col s12 m4' style='text-align: justify;'>
                <p class="texto-informacion-medium">Registre los rubros y productos relacionados con cada una de las actividades registradas en el paso anterior.</p>
                <p class="texto-informacion-medium">Cada actividad debe tener mínimo un producto y puede no tener ningún rubro.</p>

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
                    if($componente->com_estado != 'delete'){
                    $aux++;
                    ?>
                    <li class='liComponente' id='{{"liComponente".$aux}}'>
                        <div class='collapsible-header'>
                            <p>{{"Componente ".$aux }}</p>
                        </div>
                        <div class='collapsible-body componente' id="{{'componente'.$aux}}">
                            <input type="hidden" value="{{\Illuminate\Support\Facades\Crypt::encrypt($componente->id)}}" name="id_componente" id="id_componente">

                            @if(count($componente->actividades))
                            <?php $cont = 0; ?>
                                 <ul class='collapsible popout' data-collapsible='accordion'>
                                    @foreach($componente->actividades as $actividad)
                                        @if($actividad->act_estado != "delete")
                                        <?php $cont++; ?>
                                            <li>
                                                <div class='collapsible-header'>
                                                    <p>Actividad {{$cont}}</p>
                                                </div>
                                                <div class='collapsible-body collection'>
                                                        <a href="#modalRubros" class="modal-trigger show-rubros collection-item" data-actividad="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}" style="padding: 20px 50px;">Rubros</a>
                                                        <a href="#modalProductos" class="modal-trigger show-productos collection-item" data-actividad="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}" style="padding: 20px 50px;">Productos</a>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                 </ul>
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
            <a class='btn waves-effect waves-light' id="btnRubrosProductosCompletos">Completo</a>
        </div>
    </div>
</div>

<div id="modalRubros" class="modal full-modal modal-up">
    <div class="modal-content col s12">
    </div>
    <div class="progress invisible" style="position: fixed; bottom: 30px;">
          <div class="indeterminate"></div>
    </div>
    <div class="modal-footer contenedor-botones">
        <a href="#!" class=" modal-action waves-effect waves-light btn-flat texto-blanco" onclick="actionsRubros()">Guardar</a>
        <a href="#!" class=" modal-action waves-effect waves-light btn-flat texto-blanco" onclick="agregarRubro()">Nuevo Rubro</a>
        <a href="#!" class=" modal-action modal-close waves-effect waves-light btn-flat texto-blanco">Cancelar</a>
    </div>
</div>

<div id="modalProductos" class="modal full-modal modal-up">
    <div class="modal-content col s12">
    </div>
    <div class="progress invisible" style="position: fixed; bottom: 30px;">
          <div class="indeterminate"></div>
    </div>

    <div class="modal-footer contenedor-botones">
        <a href="#!" class=" modal-action waves-effect waves-light btn-flat texto-blanco" onclick="actionsProductos()">Guardar</a>
        <a href="#!" class=" modal-action waves-effect waves-light btn-flat texto-blanco" onclick="agregarProducto()">Nuevo Producto</a>
        <a href="#!" class=" modal-action modal-close waves-effect waves-light btn-flat texto-blanco">Cancelar</a>
    </div>

</div>