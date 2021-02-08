<p class="tituloPrincipalPag tituloMediano">Nuevo perfil</p>
<div class="col s12 m4">

    <p class="texto-informacion-medium" >
        Todos los perfiles que recibimos son análisados por el lider
        y/o por los evaluadores del grupo de investigación <strong>SINERGIA</strong>
        para una posterior aprobación o descarte de los mismos. Cualquier aprendiz <strong>SENA</strong> puede hacer parte del
        grupo de investigación, en caso de no serlo, una ves registrado y aprobado un perfil la persona formará parte de nuestro grupo.
    </p>
</div>
<div class="col s12 m8 white" style="padding-bottom: 20px;">

    <p class="texto-informacion-medium" >Para registrar un nuevo perfil ingrese toda la información que se solicita a continuación.
        Si tiene alguna duda, descargue la<a href="#"> guia para realizar este paso.</a></p>
    <p class="texto-informacion-medium">Los campos con (<i class="material-icons texto-rojo">star_rate</i>) son obligatorios.</p>

    <form id="form-nuevo-perfil">
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
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

        <div class="progress invisible" style="height: 3px;" >
            <div class="indeterminate"></div>
        </div>
    </form>
</div>


@section('js')
@parent
    <script src="{{asset('Js/inv/perfil/nuevoPerfil.js')}}"></script>
@stop