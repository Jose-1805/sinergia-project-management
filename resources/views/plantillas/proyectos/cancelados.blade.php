<div class="col s12 center-align contPerfiles" id="contProyectosCancelados" style="margin-bottom: 50px;">
    @if (count($proyectosCancelados) > 0)
        <?php
            $contProyectos = 0;
            $class = "visible";
            $idModal="opcionesProyectoCancelado";
            $perfiles = $proyectosCancelados;
        ?>
        <p style="font-size: small;text-align: left; padding-left: 10px;">Proyectos cancelados: {{count($proyectosCancelados)}}</p>
        @include('plantillas/listaPerfiles')
    @else
        <p class="center-align white btnDataProyecto" style="padding: 15px;">No existen proyectos cancelados</p>
    @endif
</div>