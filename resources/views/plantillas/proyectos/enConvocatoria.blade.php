<div class="col s12 center-align contPerfiles" id="contProyectosEnDesarrollo" style="margin-bottom: 50px;">

    @if (count($proyectosEnConvocatoria) > 0)
        <?php
                $contProyectos = 0;
                $class = "visible";
                $idModal="opcionesProyectoEnConvocatoria";
                $perfiles = $proyectosEnConvocatoria;
        ?>
        <p style="font-size: small;text-align: left; padding-left: 10px;">Proyectos en convocatoria: {{count($proyectosEnConvocatoria)}}</p>
        @include('plantillas/listaPerfiles')
    @else
    <p class="center-align white btnDataProyecto" style="padding: 15px;">No existen proyectos en convocatoria</p>
    @endif
</div>