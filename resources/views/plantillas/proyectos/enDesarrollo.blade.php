<div class="col s12 center-align contPerfiles" id="contProyectosEnDesarrollo" style="margin-bottom: 50px;">

    @if (count($proyectosEnDesarrollo) > 0)
        <?php
                $contProyectos = 0;
                $class = "visible";
                $idModal="opcionesProyectoEnDesarrollo";
                $perfiles = $proyectosEnDesarrollo;
        ?>
        <p style="font-size: small;text-align: left; padding-left: 10px;">Proyectos en desarrollo: {{count($proyectosEnDesarrollo)}}</p>
        @include('plantillas/listaPerfiles')
    @else
    <p class="center-align white btnDataProyecto" style="padding: 15px;">No existen proyectos en desarrollo</p>
    @endif
</div>