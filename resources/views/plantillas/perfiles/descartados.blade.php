<div class="col s12 contPerfiles" id="contPerfilesDescartados" style="margin-bottom: 50px;">

@if (count($perfilesDescartados) > 0)
    <?php
            $contProyectos = 0;
            $class = "visible";
            $idModal="opcionesPerfilDescartado";
            $perfiles = $perfilesDescartados;
    ?>
    <p style="font-size: small;text-align: left; padding-left: 10px;">Perfiles descartados: {{count($perfilesDescartados)}}</p>
    @include('plantillas/listaPerfiles')
@else
    <p class="center-align white btnDataProyecto" style="padding: 15px;">No existen perfiles descartados</p>
@endif
</div>