
@if($rol == "inv")
<?php $nombreRecibidos = "Enviados" ?>
@else
<?php $nombreRecibidos = "Recibidos" ?>
@endif
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3"><a href="#recibidos" class="truncate">{{$nombreRecibidos}}</a></li>
                <li class="tab col s3"><a href="#formulacion" class="truncate">En formulación</a></li>
                <li class="tab col s3"><a href="#completos" class="truncate">Completos</a></li>
                <li class="tab col s3"><a href="#descartados" class="truncate">Descartados</a></li>
            </ul>
        </div>

        <div class="col s12" id="recibidos">
            @include ('roles.adminv.modulos.perfil.recibidos')
        </div>
        <div class="col s12" id="formulacion">
            @include ('roles.adminv.modulos.perfil.aprobados')
        </div>
        <div class="col s12" id="completos">
            @include ('roles.adminv.modulos.perfil.aprobadoCompleto')
        </div>
        <div class="col s12" id="descartados">
            @include ('roles.adminv.modulos.perfil.descartados')
        </div>
    </div>