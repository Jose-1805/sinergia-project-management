<!-- PAGINA INICIAL DEL SISTEMA -->



<!-- CONTENEDOR DEL SECTION QUE MUESTRA EL SLIDER -->
<?php
if (count($eventos) > 0) {
    ?>
@section('slider')
    <div class="contenedorSlider row">

        <div style="height: 100%;">
            <div id="btnSliderIzquierdo" class="btnSlider"></div>

            <div class="elementoSlider col s12">
                <?php
                $aux = 0;
                foreach ($eventos as $evento) {
                    $aux++;
                    ?>
                    <!-- CONTENIDO -->
                    <div class="imagenSlider col s7 <?php
                    if ($aux == 1) {
                        echo 'activo';
                    } else {
                        echo 'inactivo';
                    }
                    ?>" style="background-image: url(<?php
                         if (file_exists('imagenes/eventos/' . $evento->id . '/principal.jpg')) {
                             echo 'imagenes/eventos/' . $evento->id . '/principal.jpg';
                         } else {
                             echo 'imagenes/eventos/default.jpg';
                         }
                         ?>);"></div>

                    <div class="infoSlider col s5 <?php
                    if ($aux == 1) {
                        echo 'activo';
                    } else {
                        echo 'inactivo';
                    }
                    ?>">
                        <div class="contInfoElementoSlider col s12">
                            <h2 class="truncate"><?php echo $evento->eve_titulo; ?></h2>
                            <small class="hidden-xs"><?php echo $evento->eve_descripcion_corta; ?></small>
                        </div>
                        <div class="contBtnVerMas col s12">

                            <a class="btn waves-effect waves-light" onclick="window.location.replace('{{url('/eventos/evento/'.$evento->id)}}')" ><p>ver mas</p></a>
                        </div>
                    </div>
                    <!-- FIN CONTENIDO -->


                    <?php
                }
                ?>
            </div>
            <div id="btnSliderDerecho" class="btnSlider"></div>
        </div>
    </div>
    <div  class="col s12" style="height:4px;background-color:#fc7323;margin:0px;padding:0px;margin-bottom:40px; margin-top: -20px;"></div>
@stop
    <?php
}
?>


<div class="row">
    <div class="contenidoPanel1 col s12 m8 l9">
        @if(count($contenidos))
            @foreach($contenidos as $contenido)
            <?php
                if(is_file(public_path('contenidos/'.$contenido->con_archivo))){
                    $archivo = fopen(public_path('contenidos/'.$contenido->con_archivo),'r');

                    while(!feof($archivo)) {
                        $linea = fgets($archivo);
                        echo $linea;
                    }
                    fclose($archivo);
                }
            ?>
            @endforeach
        @else
            <h3 class="col s12" style="color: #238276;">Bienvenido a SINERGIA</h3>
            <img src="{{url('imagenes/sinergia_ave.png')}}" style="margin: 0 auto; margin-top: 30px;margin-bottom: 30px;" width="300" class="materialboxed"/>
            <div class="col s12">
                <h6  style="color: #238276;font-size: large;">Son espacios de aprendizaje para formación e Investigación, Desarrollo Tecnológico e Innovación, donde el aprendiz o egresado aprende y desarrolla habilidades para la resolución de problemas que afectan al sector productivo o grupos poblacionales Caucanos, aplicando las competencias adquiridas en el programa de formación técnico o tecnológico. Los aprendices se hacen participes de los proyectos de investigación y son orientados por sus instructores. Se difunden los productos generados de las investigaciones, en eventos locales, regionales y nacionales o mediante publicaciones.</h6>
            </div>
        @endif
    </div>

    <div class="contenidoPanel2 col s12 m4 l3">

        <div class="seccion col-xs-12" id="nuevaIdea" >
            <div class="col-xs-12" style="padding: 0px;">
                <p class="center-align titulo">¿Tiene una buena idea?</p>
                <div class="center-align">
                <img src="imagenes/ideaCirculo.png" height="100"/>
                </div>
                <p class="center-align">Si tiene una idea de proyecto y quiere desarrollarla con nosotros, entonces envíenos sus datos
                    y su idea presionando el botón que aparece a continuación.</p>
            </div>
            <div class="center-align">
            <a class="btn waves-effect waves-light" id="btnNuevaIdea" name="btnNuevaIdea" onclick="window.location.replace('/nuevoPerfil')">Registrar idea</a>
            </div>
        </div>

        <div class="seccion col-xs-12" id="nuevaIdea">
            <div class="col-xs-12" style="padding: 0px;">
                <p class="center-align titulo">Mejorar su idea<p>
                <div class="center-align">
                    <img class="imgCircular" src="imagenes/ideaEditarCirculo.png" height="100" style=""/>
                </div>
                <p class="center-align">Si ya tiene registrada una idea de proyecto y desea modificar su información, lo podrá hacer desde aqui ingresando el codigo asignado a su idea</p>
            </div>
            <div class="center-align">
            <a class="btn waves-effect waves-light" id="btnEditarIdea" name="btnNuevaIdea"  onclick="window.location.replace('/editPerfil')">Editar perfil</a>
            </div>
        </div>

    </div>

</div>