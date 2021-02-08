
@if($rol == "inv")
<?php $nombreRecibidos = "Enviados" ?>
@else
<?php $nombreRecibidos = "Recibidos" ?>
@endif
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s4"><a href="#recibidos" class="truncate">{{$nombreRecibidos}}</a></li>
                <li class="tab col s4"><a href="#formulacion" class="truncate">En formulación</a></li>
                <li class="tab col s4"><a href="#descartados" class="truncate">Descartados</a></li>
            </ul>
        </div>

        <div class="col s12" id="recibidos">
            @include ('roles.eval.modulos.perfil.recibidos')
        </div>
        <div class="col s12" id="formulacion">
            @include ('roles.eval.modulos.perfil.aprobados')
        </div>
        <div class="col s12" id="descartados">
            @include ('roles.eval.modulos.perfil.descartados')
        </div>
    </div>