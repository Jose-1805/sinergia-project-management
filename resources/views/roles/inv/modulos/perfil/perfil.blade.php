<p class="tituloPrincipalPag tituloGrande"><?php echo $perfil->pro_titulo ?></p>
<input type="hidden" name="idPerfil" id="idPerfil" value="<?php echo md5($perfil->proyecto_id); ?>"/>
<div class="col s12 m7">
    <?php
    if ($perfil->pro_estado == 'propuesta' && $perfil->persona_id == session('idPersona'))
    {
        include '../resources/views/roles/inv/modulos/perfil/subModulos/datosPerfilEditable.blade.php';
    }
    else
    {
        include '../resources/views/roles/inv/modulos/perfil/subModulos/datosPerfilNoEditable.blade.php';
    }
    ?>
</div>

<div class="col s12 m5 z-depth-1 datosProponente" style="background-color: rgba(255,255,255,.9);">
    <p class="col s12 tituloMediano" >Datos del proponente</p>
    <?php
    if ($perfil->persona_id == session('idPersona'))
    {
        ?>
        <p>Usted es el proponente líder de este perfil, esto significa que la mayoria de acciones importantes que se apliquen a este perfil serán realizadas por usted.</p>
        <?php
        if ($perfil->pro_estado == 'propuesta')
        {
            ?>
            <p>El estado de este perfil es <strong>PROPUESTA</strong>, así que usted podra realizar cambios al mismo dando un click sobre la información que desee cambiar, finalmente presione el botón guardar cambios</p>
        <?php
    }
}
else
{
    ?>
        <div class="col s12">
            <p class="titulo s12 col l4">Nombre</p>
            <p class="col s12 l8" ><?php echo $perfil->per_nombres . ' ' . $perfil->per_apellidos; ?></p>
            <div class="col s12 divider teal" style="margin-bottom: 15px;"></div>
        </div>

        <div class="col s12">
            <p class="titulo s12 col l4">Correo</p>
            <p class="col s12 l8" ><?php echo $perfil->per_correo; ?></p>
            <div class="col s12 divider teal" style="margin-bottom: 15px;"></div>
        </div>

        <div class="col s12">
            <p class="titulo s12 col l4">Tipo</p>
            <p class="col s12 l8" ><?php echo $perfil->inv_tipo; ?></p>
            <div class="col s12 divider teal" style="margin-bottom: 15px;"></div>
        </div>
    <?php
}
?>
</div>

    <?php
    if ($perfil->pro_estado == 'propuesta aprobada' && $perfil->persona_id == session('idPersona'))
    {
        ?>
        <div class="col s12 center-align" style="margin-top: 20px;">
            <a id="btnFormular" class="btn waves-effect waves-grey">Formular<i class="mdi-hardware-keyboard Right"></i></a>
        </div>
    <?php } ?>

@section('js')
@parent
<script src="/Js/inv/perfil/perfil.js"></script>
@stop