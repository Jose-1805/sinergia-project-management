/**
 * Created by Jose Luis on 05/02/2016.
 */
$(function(){
    $("#btnAprobarSolicitud").click(function(){
        cambiarEstadoSolicitud("aprobado");
    })

    $("#btnRechazarSolicitud").click(function(){
        cambiarEstadoSolicitud("rechazado");
    })
})


function cambiarEstadoSolicitud(estado){
    $(".contenedor-botones-opcion").addClass("invisible");
    $(".progress-opcion").removeClass("invisible");
    var params = $("#form-solicitud-revision").serialize()+"&estado="+estado+"&_token="+$("#_token").val();
    $.post($("#base_url").val()+"/inv/cambiar-estado-solicitud",params,function(data){
        if(data == "1" || data == 1){
            window.location.href = $("#base_url").val()+"/inv/solicitudes";
        }else if(data == "-2" || data == -2){
            lanzarMensaje("Error","Ocurrio un error desconocido al intentar cambiar el estado de la solicitud.",7000,2);
        }else{
            lanzarMensaje("Error",data,7000,2);
        }
    })
}