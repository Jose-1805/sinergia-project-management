<form id="formEditarPerfil">
<div class="col s12">
    <p class="titulo col s12 l4 ">Objetivo general</p>
    <div class="form-control col s12 l8">
        <textarea class="materialize-textarea" id="objetivoGeneral" name="objetivoGeneral" style="border: none;"><?php echo $perfil->pro_objetivo_general; ?></textarea>
    </div>
    <div class="col s12 divider teal" style="margin-bottom: 20px;"></div>
</div>

<div class="col s12">
    <p class="titulo s12 col l4">Problema</p>
    <div class="form-control col s12 l8">
        <textarea class="materialize-textarea" id="problema" name="problema" style="border: none;"><?php echo $perfil->pro_inv_problema; ?></textarea>
    </div>
    <div class="col s12 divider teal" style="margin-bottom: 20px;"></div>
</div>


<div class="col s12">
    <p class="titulo s12 col l4">Justificación</p>
    <div class="form-control col s12 l8">
        <textarea class="materialize-textarea" id="justificacion" name="justificacion" style="border: none;"><?php echo $perfil->pro_justificacion; ?></textarea>
    </div>
    <div class="col s12 divider teal" style="margin-bottom: 20px;"></div>
</div>


<div class="col s12">
    <p class="titulo s12 col l4">Presupuesto</p>
    <div class="form-control col s12 l8">
        <input type="text" id="presupuesto" name="presupuesto" value="<?php echo $perfil->pro_presupuesto_estimado ?>" style="border: none;">
    </div>
    <div class="col s12 divider teal" style="margin-bottom: 20px;"></div>
</div>


<div class="col s12">
    <p class="titulo s12 col l4">Sector</p>
    <input type="text" class="col s12 l8" id="sector" name="sector" value="<?php echo $perfil->pro_inv_sector ?>" style="border: none;">
    <input type="hidden"  id="id" name="id" value="<?php echo md5($perfil->proyecto_id) ?>" >
    <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token() ?>">
</div>

<div class="col s12 left-align" style="margin-top: 30px;">
    <input type="submit" id="btnGuardarCambios" value="guardar cambios" class="btn"/>
</div>
</form>
