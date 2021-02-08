@if($rol == "inv")
<?php $nombreRecibidos = "Enviados" ?>
@else
<?php $nombreRecibidos = "Recibidos" ?>
@endif
@if(Session::get("msjComponente"))
    <script>
        $(function(){
            var mensaje = "{{Session::get('msjComponente')}}";
            lanzarMensaje("Mensaje",mensaje,15000,4);
        })
    </script>
@endif
        <a href="{{url("/inv/nuevo-perfil")}}" class="tooltipped btn-floating-1 btn-floating waves-effect waves-light teal" data-position="bottom" data-delay="50" data-tooltip="Agregar perfil"><i class="material-icons">add</i></a>

    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s13"><a href="#recibidos" class="truncate">{{$nombreRecibidos}}</a></li>
                <li class="tab col s13"><a href="#formulacion" class="truncate">En formulación</a></li>
                <li class="tab col s13"><a href="#completos" class="truncate">Completos</a></li>
                <li class="tab col s13"><a href="#descartados" class="truncate">Descartados</a></li>
            </ul>
        </div>

        <div class="col s12" id="recibidos">
            @include ('roles.inv.modulos.perfil.recibidos')
        </div>
        <div class="col s12" id="formulacion">
            @include ('roles.inv.modulos.perfil.aprobados')
        </div>
        <div class="col s12" id="completos">
            @include ('roles.inv.modulos.perfil.aprobadoCompleto')
        </div>
        <div class="col s12" id="descartados">
            @include ('roles.inv.modulos.perfil.descartados')
        </div>
    </div>