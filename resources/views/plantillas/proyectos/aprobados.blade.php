<div class="col s12 center-align contPerfiles" id="contProyectosAprobados" style="margin-bottom: 50px;">
    @if(count($proyectosAprobados) > 0)
        <?php
                $contProyectos = 0;
                $class = "visible";
                $idModal="opcionesProyectoAprobado";
                $perfiles = $proyectosAprobados;
        ?>
        <p style="font-size: small;text-align: left; padding-left: 10px;">Proyectos aprobados: {{count($proyectosAprobados)}}</p>
        @include('plantillas/listaPerfiles')

    @else
        <p class="center-align white btnDataProyecto" style="padding: 15px;">No existen proyectos aprobados</p>
    @endif
</div>