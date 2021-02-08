<script>
    $(function () {
        $('#contVista').fadeOut(0);
        $('#btnCerrar').fadeOut(0);
        $('.foto').on('mouseenter', function () {
            var id = $(this).attr('id');
            $('#' + id + ' .capaFoto').fadeOut(800);
        });

        $('.foto').on('mouseleave', function () {
            var id = $(this).attr('id');
            $('#' + id + ' .capaFoto').fadeIn(800);
        });


        /*$('.foto').on('click', function () {
            $('#contVista').fadeIn(500);
            nombre = $(this).attr('id');
            carpeta = $('#vista').attr('meta-evento');
            base = {{url('/')}};
            $('#vista').css({
                'background-image': 'url('+base+'/imagenes/eventos/' + carpeta + '/' + nombre + '.jpg)'
            });

            $('#vista').slideUp(200).slideDown(800);
            $('#btnCerrar').fadeIn('500');
        });*/

        $('#btnCerrar').on('click', function () {
            $('#contVista').fadeOut(800);
            $(this).fadeOut(800);
        });
    });
</script>

<div id="contenido row">
    <p id="tituloEvento"  class="tituloPrincipalPag tituloMediano col s12"><?php echo $evento->eve_titulo ?></p>
    <div id="contenedorDescripcion" class="col s12" >
        <p>
            <?php
            echo $evento->eve_descripcion_detallada;
            ?>
        </p>
    </div>

    <div id="fotos" class="col s12 m10 offset-m1">
        @include('modulos.eventos.fotos',['no_borrar'=>true])
    </div>
    

</div>
