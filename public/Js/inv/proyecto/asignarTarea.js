/**
 * Created by Jose Luis on 07/02/2016.
 */
$(function(){
    $("#btnAsignarTareaOk").click(function(){
        asignarTarea("");
    })
})

function asignarTarea(confirmacion){
    $('.progress-tareas').removeClass('invisible');
    $('.contenedor-botones-tareas').addClass('invisible');

    var params = $("#form-asignar-tarea").serialize()+'&_token='+$('#_token').val()+confirmacion;
    $.post($('#base_url').val()+'/inv/asignar-tarea',params,function(data){

        if(data == "1" || data == 1){
            window.location.reload();
        }else if(data == "-1" || data == -1){
            if(confirm("Este producto o tarea ya tiene un investigador asignado. ¿Desea reemplazarlo por el seleccionado actualmente?")){
                asignarTarea("&confirmacion=1");
            }else{
                ocultarModal();
                $('.contenedor-botones-tareas').removeClass('invisible');
                $('.progress-tareas').addClass('invisible');
            }
        }else if(data == "-2" || data == -2){
            ocultarModal();
            lanzarMensaje("Error","Ocurrio un error con la informacion enviada.",5000,2);
            $('.contenedor-botones-tareas').removeClass('invisible');
            $('.progress-tareas').addClass('invisible');
        }else{
            ocultarModal();
            lanzarMensaje("Error",data,5000,2);
            $('.contenedor-botones-tareas').removeClass('invisible');
            $('.progress-tareas').addClass('invisible');
        }
    });
}
