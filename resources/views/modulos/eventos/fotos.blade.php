<div class="col s12">
                <?php
                $principal = false;
                $name = "principal.";
                $archivo = '../public/imagenes/eventos/' . $evento->id . '/principal.jpg';
                $archivo2 = '../../imagenes/eventos/' . $evento->id . '/principal.jpg';
                if (file_exists($archivo)) {
                    $principal = true;
                    $name .= "jpg";
                    ?>
                    <img class="foto materialboxed col s12"  src="<?php echo $archivo2; ?>">
                    <?php
                }

                $archivo = '../public/imagenes/eventos/' . $evento->id . '/principal.png';
                        $archivo2 = '../../imagenes/eventos/' . $evento->id . '/principal.png';
                        if (file_exists($archivo)) {
                            $principal = true;
                            $name .= "png";
                            ?>
                            <img class="foto materialboxed col s12"  src="<?php echo $archivo2; ?>">
                            <?php
                        }

                $archivo = '../public/imagenes/eventos/' . $evento->id . '/principal.jpeg';
                        $archivo2 = '../../imagenes/eventos/' . $evento->id . '/principal.jpeg';
                        if (file_exists($archivo)) {
                            $principal = true;
                            $name .= "jpeg";
                            ?>
                            <img class="foto materialboxed col s12"  src="<?php echo $archivo2; ?>">
                            <?php
                        }

                 $archivo = '../public/imagenes/eventos/' . $evento->id . '/principal.svg';
                         $archivo2 = '../../imagenes/eventos/' . $evento->id . '/principal.svg';
                         if (file_exists($archivo)) {
                            $principal = true;
                            $name .= "svg";
                             ?>
                             <img class="foto materialboxed col s12"  src="<?php echo $archivo2; ?>">
                             <?php
                         }
                ?>
                    @if($principal && !isset($no_borrar))
                        <a class="btn-floating btn-sm waves-effect waves-light red darken-2 btn-eliminar-imagen tooltipped" data-position="bottom" data-delay="50" data-tooltip="Eliminar imagen" data-name="{{$name}}" data-evento="{{$evento->id}}"><i class="fa fa-trash"></i></a>
                    @endif
                   </div>
                <?php
                $i = 0;
                $stop = false;
                while (!$stop) {
                ?>
                    <div class="col s12 m6 l4" style="text-align: right;">
                <?php
                    $i++;
                    $archivo = '../public/imagenes/eventos/' . $evento->id . '/' . $i . '.jpg';
                    $archivo2 = '../../imagenes/eventos/' . $evento->id. '/' . $i . '.jpg';
                    $name = $i.".";
                    if (file_exists($archivo)) {
                        $name .= "jpg";
                        ?>
                    <img class="foto materialboxed col s12"  src="<?php echo $archivo2; ?>" >
                        <?php
                    }else{
                        $archivo = '../public/imagenes/eventos/' . $evento->id . '/' . $i . '.jpeg';
                        $archivo2 = '../../imagenes/eventos/' . $evento->id. '/' . $i . '.jpeg';
                        if (file_exists($archivo)) {
                            $name .= "jpeg";
                            ?>
                        <img class="foto materialboxed col s12"  src="<?php echo $archivo2; ?>" >
                            <?php
                        }else{
                            $archivo = '../public/imagenes/eventos/' . $evento->id . '/' . $i . '.png';
                            $archivo2 = '../../imagenes/eventos/' . $evento->id. '/' . $i . '.png';
                            if (file_exists($archivo)) {
                                $name .= "png";
                                ?>
                            <img class="foto materialboxed col s12"  src="<?php echo $archivo2; ?>" >
                                <?php
                            }else{
                                $archivo = '../public/imagenes/eventos/' . $evento->id . '/' . $i . '.svg';
                                $archivo2 = '../../imagenes/eventos/' . $evento->id. '/' . $i . '.svg';
                                if (file_exists($archivo)) {
                                    $name .= "svg";
                                    ?>
                                <img class="foto materialboxed col s12"  src="<?php echo $archivo2; ?>" >
                                    <?php
                                }else{
                                    $stop = true;
                                }
                            }
                        }
                    }
                    ?>

                    @if(!$stop && !isset($no_borrar))
                         <a class="btn-floating btn-sm waves-effect waves-light red darken-2 btn-eliminar-imagen tooltipped" data-position="bottom" data-delay="50" data-tooltip="Eliminar imagen" data-name="{{$name}}" data-evento="{{$evento->id}}"><i class="fa fa-trash"></i></a>
                    @endif
                    </div>
                    <?php
                }
                ?>