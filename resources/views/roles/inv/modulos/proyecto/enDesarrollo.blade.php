<?php
     $classBtnPerfil = "modal-trigger";
?>
@include('plantillas/proyectos/enDesarrollo')

<div id="opcionesProyectoEnDesarrollo" class="modal" style="margin-top: 100px;">
    <div class="modal-content">
        <h5 class="tituloPerfilSeleccionado link-verde">Titulo del perfil</h5>
        <input type="hidden" id="idPerfilSeleccionado">
    </div>
    <div class="modal-footer" style="background-color: #FFFFFF;padding: 0px;">
        <div class="hide-on-med-and-down">
            <a class="waves-effect waves-orange btn-flat btnVerMas">Ver más <i class="mdi-action-visibility"></i></a>
            <a class="waves-effect waves-orange btn-flat btnMisTareas">Mis tareas <i class="mdi-action-assignment"></i></a>
        </div>
    </div>
</div>

@section('js')
@parent
     <script>
        $(function(){
            $(".btnVerMas").click(function(){
                window.location.href = $("#base_url").val()+"/proyecto/perfil/"+perfilSeleccionado;
            })

            $(".btnMisTareas").click(function(){
                    window.location.href = $("#base_url").val()+"/inv/mis-tareas/"+perfilSeleccionado;
            })
        })
     </script>
@stop