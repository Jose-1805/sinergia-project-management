<div class="col s12 center-align contPerfiles" id="contPerfilesCompletos" style="margin-bottom: 50px;">

    @if (count($perfilesCompletos) > 0)
        <?php
                $contProyectos = 0;
                $class = "visible";
                $idModal="opcionesPerfilCompleto";
                $perfiles = $perfilesCompletos;
        ?>
        <p style="font-size: small;text-align: left; padding-left: 10px;">Perfiles completos: {{count($perfilesCompletos)}}</p>
        @include('plantillas/listaPerfiles')
    @else
    <p class="center-align white btnDataProyecto" style="padding: 15px;">No existen perfiles completos</p>
    @endif
</div>