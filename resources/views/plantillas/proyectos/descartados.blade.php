<div class="col s12 contPerfiles" id="contProyectosDescartados" style="margin-bottom: 50px;">

@if (count($proyectosDescartados) > 0)
    <?php
            $contProyectos = 0;
            $class = "visible";
            $idModal="opcionesProyectoDescartado";
            $perfiles = $proyectosDescartados;
    ?>
    <p style="font-size: small;text-align: left; padding-left: 10px;">Proyectos descartados: {{count($proyectosDescartados)}}</p>
    @include('plantillas/listaPerfiles')
@else
    <p class="center-align white btnDataProyecto" style="padding: 15px;">No existen proyectos descartados</p>
@endif
</div>