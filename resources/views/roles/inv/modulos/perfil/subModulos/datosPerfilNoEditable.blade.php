<div class="col s12">
    <p class="titulo col s12 l4 ">Objetivo general</p>
    <p class="col s12 l8" ><?php echo $perfil->pro_objetivo_general; ?></p>
    <div class="col s12 divider teal" style="margin-bottom: 20px;"></div>
</div>

<div class="col s12">
    <p class="titulo s12 col l4">Problema</p>
    <p class="col s12 l8" ><?php echo $perfil->pro_inv_problema; ?></p>
    <div class="col s12 divider teal" style="margin-bottom: 20px;"></div>
</div>


<div class="col s12">
    <p class="titulo s12 col l4">Justificación</p>
    <p class="col s12 l8" ><?php echo $perfil->pro_justificacion; ?></p>
    <div class="col s12 divider teal" style="margin-bottom: 20px;"></div>
</div>


<div class="col s12">
    <p class="titulo s12 col l4">Presupuesto</p>
    <p class="col s12 l8" ><?php echo '$ ' . number_format(doubleval($perfil->pro_presupuesto_estimado), 0, ',', '.'); ?></p>
    <div class="col s12 divider teal" style="margin-bottom: 20px;"></div>
</div>


<div class="col s12">
    <p class="titulo s12 col l4">Sector</p>
    <p class="col s12 l8" style="margin-bottom: 50px;"><?php echo $perfil->pro_inv_sector; ?></p>
</div>