@if(Session::get("msjComponente"))
    <script>
        $(function(){
            var mensaje = "{{Session::get('msjComponente')}}";
            lanzarMensaje("Mensaje",mensaje,4000,4);
        })
    </script>
@endif

<div class="col s12 white">
    @include('plantillas/perfiles/datos')
</div>

<div class="col s12 white">
    <p style="text-align: justify;" class="texto-informacion-medium">Para formular su perfil debe tener clara la información de las actividades que piensa llevar a cabo para el posible desarrollo del proyecto, si no esta familiarizado con el los términos utilizados y/o la información que debe ingresar, <a>aquí</a> encuentra una guía para realizar este paso. </p>
</div>

<div class="col s12 white" id="datosPerfil">

    <?php
    switch ($perfil->pro_estado_formulacion)
    {
        case 0:
    ?>
         @include('roles/inv/modulos/perfil/subModulos/formularInformacionGeneral')
    <?php
            break;
        case 1:
     ?>
     @include('roles/inv/modulos/perfil/subModulos/formularComponentes')
     <?php
            break;
        case 2:
     ?>
     @include('roles/inv/modulos/perfil/subModulos/formularActividades')
     <?php
            break;
        case 3:
     ?>
      @include('roles/inv/modulos/perfil/subModulos/formularRubrosProductos')
      <?php
            break;
       case 4:
       ?>
         <p class="texto-informacion-medium">Su perfil se encuentra en proceso de analisis por el evaluador asignado, pueden ser asignadas a usted tareas para mejorar la formulación
         o puede suceder que su perfil sea marcado como completo y permanezca a la espera de una convocatoria.</p>
       <?php
         break;
    }
    ?>
    <div class="progress invisible">
        <div class="indeterminate"></div>
    </div>
</div>
@section('js')
@parent
    <script type="text/javascript" src="{{asset('Js/inv/perfil/perfilFormular.js')}}"></script>
@stop