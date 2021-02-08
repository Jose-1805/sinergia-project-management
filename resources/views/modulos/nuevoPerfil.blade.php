<!-- DIV QUE CONTIENE LO QUE MUESTRA EL TITULO DEL MODULO -->
<p class="tituloMediano tituloPrincipalPag">Registre su perfil  <img src="imagenes/ideaNueva.png"/></p>


<div class="col s12 m4">
<p >Para registrar un nuevo perfil ingrese toda la información que se solicita a continuación.
    Si tiene alguna duda, descargue la<a href="#"> guia para realizar este paso.</a></p>
<p>Los campos con (<i class="material-icons texto-rojo">star_rate</i>) son obligatorios.</p>
</div>

<form method="post" id="formNuevoPerfil" class="col s12 m8" style="background-color: #FFF;">	
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <div id="contenedorDerecho" class="col s12 m10 offset-m1">
        <div class="input-field">
            <label for="nombres">Nombres (Proponente lider)<i class="material-icons texto-rojo">star_rate</i></label>
            <input type="text"  id="nombres" name="nombres" maxlength="45" length="45" required/>
        </div>

        <div class="input-field">
            <label for="apellidos">Apellidos<i class="material-icons texto-rojo">star_rate</i></label>
            <input type="text" id="apellidos" name="apellidos" maxlength="45" length="45" required/>
        </div>

        <div id="divCorreo" class="input-field">
            <label for="correo">Correo<i class="material-icons texto-rojo">star_rate</i></label>
            <input type="email" id="correo" name="correo" maxlength="50" length="50" required/>
            <i class="fa fa-pulse" style="float: right; margin-top: -10px;" id="correoLoad"></i>
            <p class="texto-error invisible" id="correoError">Correo con cuenta de investtigador inactiva</p>
        </div>
        <br>
        <br>
        <p class="center-align" >
            Todos los perfiles que recibimos son análisados por el lider
            y/o por los evaluadores del grupo de investigación <strong>SINERGIA</strong>
            para una posterior aprobación o descarte de los mismos. Cualquier aprendiz <strong>SENA</strong> puede hacer parte del
            grupo de investigación, en caso de no serlo, una ves registrado y aprobado un perfil la persona formará parte de nuestro grupo.
        </p>

        <hr style="color: red;background-color: #fc7323; height: 1px; margin: 30px 0px;" class="hide-on-med-and-up">
    </div>


    <div id="contenedorIzquierdo" class="col s12 m10 offset-m1">

        <div class="input-field">
            <label for="titulo">Título<i class="material-icons texto-rojo">star_rate</i></label>
            <input type="text" id="titulo" name="titulo" maxlength="250" length="250" required/>
            <i class="fa fa-pulse" id="tituloLoad" style="float: right; margin-top: -10px;"></i>
            <p class="texto-error invisible" id="tituloError">Este titulo ya existe<p>
        </div>

        <div class="input-field">
            <textarea class="materialize-textarea" id="objetivoGeneral" name="objetivoGeneral" maxlength="5000" length="5000" required></textarea>
            <label for="objetivoGeneral">Objetivo general<i class="material-icons texto-rojo">star_rate</i></label>
        </div>

        <div class="input-field">
            <textarea class="materialize-textarea" id="problema" name="problema" maxlength="5000" length="5000" required></textarea>
            <label for="problema">Problema<i class="material-icons texto-rojo">star_rate</i></label>
        </div>

        <div class="input-field">
            <textarea class="materialize-textarea" id="justificacion" name="justificacion" maxlength="5000" length="5000" required></textarea>
            <label for="justificacion">Justificación<i class="material-icons texto-rojo">star_rate</i></label>
        </div>

        <div class="input-field">
            <input type="text" id="presupuesto" name="presupuesto" required/>
            <label for="presupuesto">Presupuesto<i class="material-icons texto-rojo">star_rate</i></label>
        </div>

        <div class="input-field">
            <input type="text" id="sector" name="sector" maxlength="45" length="45" required/>
            <label for="sector">Sector<i class="material-icons texto-rojo">star_rate</i></label>
        </div>
        <div class="contenedor-botones">
            <input type="submit" class="btn col s12 teal lighten-1 texto-blanco" style="margin-top: 20px;" value="enviar" />
        </div>
    </div>

    
    <div class="progress invisible" id="formNuevoPerfilLoad" style="height: 3px;" >
        <div class="indeterminate"></div>
    </div>

</form>
</div>

@section('js')
@parent
    <script src="{{asset('Js/nuevoPerfil.js')}}"></script>
@stop