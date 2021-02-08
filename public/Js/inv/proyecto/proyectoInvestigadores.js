$(function() {
    $("#btnGuardarNuevoInvestigador").click(function(){
        nuevoInvestigador();
    })

    $(".relacion_investigador").click(function(){
        $("#investigador").val($(this).attr('id'));
    })
})

function nuevoInvestigador(){
    var params = $("#form_investigador").serialize()+"&_token="+$("#_token").val();
    $(".contenedor-botones-investigador").addClass("invisible");
    $(".progress-investigador").removeClass("invisible");
    $.post($("#base_url").val()+"/proyecto/agregar-investigador-relacion",params,function(data){
        if(data == 1 || data == "1"){
            window.location.reload();
        }else if(data == -1 || data == "-1"){
            lanzarMensaje("Error","Ha ocurrido un error con la información enviada, por favor recargue la página e intente nuevamente.",7000,2);
        }else{
            lanzarMensaje("Error",data,7000,2);
        }
        $(".contenedor-botones-investigador").removeClass("invisible");
        $(".progress-investigador").addClass("invisible");
    }).error(function(jqHXR,esttado,error){
        mensajeValidationFalse(jqHXR);
        $(".contenedor-botones-investigador").removeClass("invisible");
        $(".progress-investigador").addClass("invisible");
    });
}

function enviarSolicitud(){
    var params = $("#form_solicitud_investigador").serialize()+"&_token="+$("#_token").val();
    $(".contenedor-botones-relacion").addClass("invisible");
    $(".progress-relacion").removeClass("invisible");
    $.post($("#base_url").val()+"/proyecto/enviar-solicitud-proyecto-investigador",params,function(data){
        if(data == 1 || data == "1"){
            window.location.reload();
        }else if(data == -1 || data == "-1"){
            lanzarMensaje("Error","Ha ocurrido un error con la información enviada, por favor recargue la página e intente nuevamente.",7000,2);
        }else{
            lanzarMensaje("Error",data,7000,2);
        }
        $(".contenedor-botones-relacion").removeClass("invisible");
        $(".progress-relacion").addClass("invisible");
    }).error(function(jqHXR,esttado,error){
        mensajeValidationFalse(jqHXR);
        $(".contenedor-botones-relacion").removeClass("invisible");
        $(".progress-relacion").addClass("invisible");
    });
}