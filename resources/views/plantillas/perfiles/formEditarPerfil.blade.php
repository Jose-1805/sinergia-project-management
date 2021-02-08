<p class="tituloPrincipalPag tituloMediano">{{$perfil->pro_titulo}}</p>

<form method="post" id="formEditarPerfil" class="col s12 m8 offset-m2" style="background-color: #FFF; padding: 20px 30px;" onsubmit="editarPerfil(event)">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <input type="hidden" name="id" id="id" value="{{md5($perfil->id)}}">
    <p style="margin-bottom: 30px;border-bottom: 1px solid #000;">
        Los campos con (<i class="material-icons texto-rojo">star_rate</i>) son obligatorios.
    </p>


    <div class="col s12">
        <div class="input-field">
            <textarea class="materialize-textarea" id="objetivoGeneral" name="objetivoGeneral" maxlength="5000" length="5000" required>{{$perfil->pro_objetivo_general}}</textarea>
            <label for="objetivoGeneral" class="active">Objetivo general<i class="material-icons texto-rojo">star_rate</i></label>
        </div>

        <div class="input-field">
            <textarea class="materialize-textarea" id="problema" name="problema" maxlength="5000" length="5000" required>{{$perfil->proyectoInvestigativo->pro_inv_problema}}</textarea>
            <label for="problema" class="active">Problema<i class="material-icons texto-rojo">star_rate</i></label>
        </div>

        <div class="input-field">
            <textarea class="materialize-textarea" id="justificacion" name="justificacion" maxlength="5000" length="5000" required>{{$perfil->pro_justificacion}}</textarea>
            <label for="justificacion" class="active">Justificación<i class="material-icons texto-rojo">star_rate</i></label>
        </div>

        <div class="input-field">
            <input type="text" id="presupuesto" name="presupuesto" required value="{{$perfil->pro_presupuesto_estimado}}"/>
            <label for="presupuesto" class="active">Presupuesto<i class="material-icons texto-rojo">star_rate</i></label>
        </div>

        <div class="input-field">
            <input type="text" id="sector" name="sector" maxlength="45" length="45" required value="{{$perfil->proyectoInvestigativo->pro_inv_sector}}"/>
            <label for="sector" class="active">Sector<i class="material-icons texto-rojo">star_rate</i></label>
        </div>
        <div class="progress invisible">
            <div class="indeterminate"></div>
        </div>
        <input type="submit" class="btn col s12 teal darken-1 texto-blanco" style="margin-top: 20px;" value="enviar" />
    </div>
</form>

<script>
    function editarPerfil(event){
        event.preventDefault();
        $(".progress").removeClass("invisible");
        $("input[type=submit]").fadeOut(300);
        $.post("/proyecto/editar-perfil",$("#formEditarPerfil").serialize(),function(data){
            if(data == 1){
                lanzarMensaje("Completo","La información del perfil ha sido actualizada",4000,1);
            }else if(data == 2) {
                lanzarMensaje("Error","La información del perfil no pudo ser actualizada",4000,2);
            }
            $(".progress").addClass("invisible");
            $("input[type=submit]").fadeIn(300);
        })
    }
</script>