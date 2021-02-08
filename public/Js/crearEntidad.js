var relacionDelete = "";
$(function(){

})

function crearEntidad(){
    var params = $("#form_entidad").serialize()+"&_token="+$("#_token").val();
    $(".contenedor_botones").addClass("invisible");
    $("#progress_botones").removeClass("invisible");
    $.post($("#base_url").val()+"/entidad/store",params,function(data){
        if(data == 1 || data == "1"){
            window.location.reload();
        }else if(data == -1 || data == "-1"){
            lanzarMensaje("Error","Ha ocurrido un error con la información enviada, por favor recargue la página e intente nuevamente.",7000,2);
        }
        $(".contenedor_botones").removeClass("invisible");
        $("#progress_botones").addClass("invisible");
    }).error(function(jqHXR,esttado,error){
        mensajeValidationFalse(jqHXR);
        $(".contenedor_botones").removeClass("invisible");
        $("#progress_botones").addClass("invisible");
    });
}

function relacionEntidad(){
    var params = $("#form_relacion_entidad").serialize()+"&_token="+$("#_token").val();
    $(".contenedor-botones-relacion").addClass("invisible");
    $("#progress-relacion").removeClass("invisible");
    $.post($("#base_url").val()+"/proyecto/relacion-entidad",params,function(data){
        if(data == 1 || data == "1"){
            window.location.reload();
        }else if(data == -1 || data == "-1"){
            lanzarMensaje("Error","Ha ocurrido un error con la información enviada, por favor recargue la página e intente nuevamente.",7000,2);
        }
        $(".contenedor-botones-relacion").removeClass("invisible");
        $("#progress-relacion").addClass("invisible");
        ocultarModal();
    }).error(function(jqHXR,esttado,error){
        mensajeValidationFalse(jqHXR);
        $(".contenedor-botones-relacion").removeClass("invisible");
        $("#progress-relacion").addClass("invisible");
        ocultarModal();
    });
}

function deleteRelacion(){
    var params = "entidad="+relacionDelete+"&proyecto="+$("#proyecto").val()+"&_token="+$("#_token").val();
    $(".contenedor-botones-relacion-delete").addClass("invisible");
    $("#progress-relacion-delete").removeClass("invisible");
    $.post($("#base_url").val()+"/proyecto/delete-relacion-entidad",params,function(data){
        if(data == 1 || data == "1"){
            window.location.reload();
        }else if(data == -1 || data == "-1"){
            lanzarMensaje("Error","Ha ocurrido un error con la información enviada, por favor recargue la página e intente nuevamente.",7000,2);
        }
        $(".contenedor-botones-relacion-delete").removeClass("invisible");
        $("#progress-relacion-delete").addClass("invisible");
        ocultarModal();
    }).error(function(jqHXR,esttado,error){
        mensajeValidationFalse(jqHXR);
        $(".contenedor-botones-relacion-delete").removeClass("invisible");
        $("#progress-relacion-delete").addClass("invisible");
        ocultarModal();
    });
}

