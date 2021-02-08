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
    <img src="{{url('imagenes/sinergia_ave.png')}}" width="100" class="col s8 offset-s2 m3 materialboxed"/>
    <div class="col s12 m9">
    <h3  style="color: #238276;">Bienvenido a SINERGIA,</h3>
    <h6  style="color: #238276;font-size: large;">Son espacios de aprendizaje para formación e Investigación, Desarrollo Tecnológico e Innovación, donde el aprendiz o egresado aprende y desarrolla habilidades para la resolución de problemas que afectan al sector productivo o grupos poblacionales Caucanos, aplicando las competencias adquiridas en el programa de formación técnico o tecnológico. Los aprendices se hacen participes de los proyectos de investigación y son orientados por sus instructores. Se difunden los productos generados de las investigaciones, en eventos locales, regionales y nacionales o mediante publicaciones.</h6>
    </div>
@endif


<!--<img src="../imagenes/trabajando.png" width="100" class="col s8 offset-s2 m3 offset-m1"/>
<h3 class="col s8 offset-s2 m7" style="color: #238276;">Lo sentimos,</h3>
<h5 class="col s8 offset-s2 m7" style="color: #238276;">El contenido de esta pagina aún no esta disponible.<br>Estamos trabajando en esto.</h5>-->
