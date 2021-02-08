@section('js')
    <script src="{{asset('/Js/contenido.js')}}"></script>
@stop
<?php
    $sHoy = "";$sUltimaSemana = "";$sUltimoMes = "";$sNoMostrar = "";$sTodos = "";$sNumero= "";
    $cantidad = 1;
    $classCantidad = "invisible";
    switch($configuracion->con_con_mostrar){
        case "hoy":$sHoy = "selected";
            break;
        case "ultima semana": $sUltimaSemana = "selected";
            break;
        case "ultimo mes": $sUltimoMes = "selected";
            break;
        case "todos": $sTodos = "selected";
            break;
        case "numero": $sNumero = "selected";
            $cantidad = $configuracion->con_con_numero_mostrar;
            $classCantidad = "";
            break;

    }
?>
<p class="tituloMediano tituloPrincipalPag">Establecer contenidos</p>

<div class="col s12 white" style="padding: 20px 10px;">
    <div class="col s12 m5 l4">
    <p class="texto-informacion-medium justificado">A continuación puede establecer y seleccionar los contenidos a mostrar en las paginas
    principales de los usuarios del sistema de acuerdo a la fecha de creación o la cantidad deseada.</p>
    </div>

    <div class="col s12 m7 l8">
        <div class="col s12 m8 l9">
            <label>Contenidos a mostrar</label>
            <select id="contenidos" name="contenidos">
                <option value="hoy" {{$sHoy}}>Hoy</option>
                <option value="ultima semana" {{$sUltimaSemana}}>Última semana</option>
                <option value="ultimo mes" {{$sUltimoMes}}>Último mes</option>
                <option value="todos" {{$sTodos}}>Todos</option>
                <option value="numero" {{$sNumero}}>Número</option>
            </select>
            <div class="col s12 divider white"></div>
            <div class="{{$classCantidad}} cantidad-mostrar">
                <label for="cantidad_mostrar">Cantidad a mostrar</label>
                <input type="number" id="cantidad_mostrar" name="cantidad_mostrar" value="{{$cantidad}}">
            </div>
        </div>

        <div class="col s12 m4 l3">
            <a class="col s5 m3 l4 teal texto-blanco btn-flat waves-effect waves-light tooltipped" id="btn-previsualizar-contenidos" data-position="bottom" data-delay="50" data-tooltip="Previsualizar" style="margin-top: 20px;"><i class="material-icons">visibility</i></a>
            <a class="col s7 m9 l8 teal texto-blanco btn-flat waves-effect waves-light" id="btn-guardar-conf-contenidos" style="margin-top: 20px;">Guardar</a>
        </div>
    </div>

    <div class="col s12 progress invisible" style="margin-top: 30px;">
        <div class="indeterminate"></div>
    </div>
    <div class="col s12" style="margin-top: 40px;" id="contenedor-lista">
        @include('modulos.contenido.lista')
    </div>
</div>