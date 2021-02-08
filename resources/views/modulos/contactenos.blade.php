{{--<img src="../imagenes/trabajando.png" width="100" class="col s8 offset-s2 m3 offset-m1"/>--}}
{{--<h3 class="col s8 offset-s2 m7" style="color: #238276;">Lo sentimos,</h3>--}}
{{--<h5 class="col s8 offset-s2 m7" style="color: #238276;">El contenido de esta pagina aún no esta disponible.<br>Estamos trabajando en esto.</h5>--}}


<div class="col s12">
    <ul class="tabs">
        <li class="tab col s3"><a href="#test1">CONTACTO</a></li>
        <li class="tab col s3"><a href="#test2">GOOGLE MAPS</a></li>
    </ul>
</div>
<div id="test1" class="col s12">
    <div id="contenidoPagina" class="contenidoPagina">
        <div style="width: 100%; height: 350px; text-align: center; float: left;">
            <div class="contacto" style="width: 40%; float: left;">
                <img src="../imagenes/logoSennova.png"
                     style="width: 100%; height: 100%; min-height: 40px; min-width: 60px; max-height: 100%;max-width: 100%;">
            </div>
            <div  style="border-left: 5px solid #690; text-align: left; float: left; width: 50%; margin: auto; height: 90%; padding-top: 60px; padding-left: 30px;">
                <p><b><h4>Sistema de Investigación, Desarrollo Tecnológico e Innovación</h4></b></p>
                <p><b>Centro de Comercio y Servicios, Regional Cauca</b></p>

                <p><b>Calle 4 No 2-80, Popayán, Colombia</b></p>

                <p><b>Teléfono +57 (2) 8220122 – 8243752 – 8243933 – Ext 22153</b></p>

                <p><b>Correo: <a href="mailto:sennova.comercio@sena.edu.co ">sennova.comercio@sena.edu.co</a></b></p>
            </div>
        </div>


        <style>
            .min {
                width: 430px;
                height: 300px;
                margin: auto;
                float: left;
            }

            .max {
                /*position: fixed;*/
                top: 120px;
                margin: auto;
                width: 800px;
                height: 500px;
            }
        </style>
        <script>
            $(function () {
                $("#mas").click(
                        function () {
                            $("#mapa").addClass("max");
                            $("#mapa").removeClass("min");
                            $(this).css("display", "none");
                            $("#menos").css("display", "inline-block");
                        }
                );
                $("#menos").click(
                        function () {
                            $("#mapa").removeClass("max");
                            $("#mapa").addClass("min");
                            $(this).css("display", "none");
                            $("#mas").css("display", "inline-block");
                        }
                );
            });
        </script>
    </div>
</div>
<div id="test2" class="col s12">
    <div id="mapa" class="min" style="float: left;">
        <a title="Aumentar"
           style="background-color: #c3c3c3; position: relative; left: -24px; top: 24px;z-index: 10000; color: #0000AA; display: inline-block;"
           id="mas" href="#">
            <div style="border: 2px solid #FFFFFF; opacity: 0.8; height: 24px;width: 24px; background: url('../imagenes/aumentar.png') no-repeat;">
            </div>
        </a>

        <a title="Disminuir"
           style="background-color: #c3c3c3; position: relative; left: -24px; top: 24px; z-index: 10000; color: #0000AA; display: none;"
           id="menos"
           href="#">
            <div style="border: 2px solid #FFFFFF; opacity: 0.8; height: 24px;width: 24px;  background: url('../imagenes/disminuir.png') no-repeat;">
            </div>
        </a>


        <div
                style="width: 99%; height: 99%; margin: auto; border-left: 5px solid #690; float: left; box-shadow: 10px 10px 5px -3px rgba(0, 0, 0, 0.57);">
            <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d498.27469745346826!2d-76.6028156969189!3d2.441139689613668!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xae8e5fe34707d109!2sSena+Servicio+Nacional+De+Aprendizaje!5e0!3m2!1ses!2sco!4v1440600951709"
                    width="100%" height="100%" frameborder="0"
                    style="border:0; box-shadow:10px 10px 5px -3px rgba(0, 0, 0, 0.57);" allowfullscreen>

            </iframe>

        </div>


    </div>
</div>


<div style="width: 100%;height: 500px; float: left;"></div>