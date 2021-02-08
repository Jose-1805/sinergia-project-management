$(function(){
    $(".show-actividad").click(function(){
        var id = $(this).data("act");
        $.post("/proyecto/data-actividad",{"idActividad":id,"_token":$("#_token").val()},function(data){
            $("#modal-actividad").html(data);
        })
    })
})


function addSugerenciaProducto(index){
    var sugerencia = $("#sugerencia_"+index).val();
    var importancia = $("#importancia_"+index).val();
    var idProducto= $("#pr_"+index).val();
    var idSeguimiento = $("#id_seguimiento").val();
    var params = {};

    if(validarCampoRequired(sugerencia) && validarCampoRequired(importancia)){

        if(validarCampoRequired(idProducto)){
            params = {
                "id_producto":idProducto,
                "sugerencia":sugerencia,
                "importancia":importancia,
                "_token":$("#_token").val()
            }
            if(validarCampoRequired(idSeguimiento)){
                params.id_seguimiento = idSeguimiento;
            }
            ocultarBotones();
            $(".progress").removeClass("invisible");
            $.post("/actividad/add-sugerencia-producto",params,function(data){
                $(".progress").addClass("invisible");
                mostrarBotones();
                if(data == "-1"){
                    lanzarMensaje("Error","La información enviada es incorrecta.",3000,2);
                }else{
                    lanzarMensaje("Completo",data.response,3000,1);
                    $("#sugerencia_"+index).val("");
                    $("#id_seguimiento").val(data.idSeguimiento);
                }
            })
        }else{
            lanzarMensaje("Error","La información enviada es incorrecta.",3000,2);
        }
    }else{
        lanzarMensaje("Error","Los campos de sugerencia e importancia son obligatorios",3000,2);
    }
}

function guardarCambiosProductos(){

    var params = $("#formProductos").serialize();

    ocultarBotones();
    $(".progress").removeClass("invisible");

    $.post($("#base_url").val()+"/actividad/guardar-cambios-productos",params,function(data){
        if(data == -1){
            lanzarMensaje("Error","La información enviada es incorrecta.",3000,2);
        }else{
            if(typeof(data.idSeguimiento) != "undefined"){
                $("#id_seguimiento").val(data.idSeguimiento);
            }

            if(typeof(data.actividadFinalizada) != "undefined"){
                if(data.actividadFinalizada == "si"){
                    alert("La actividad evaluada ha sido finalizada.");
                    window.location.reload();
                }else{
                    lanzarMensaje("Completo",data.response,3000,1);
                }
            }else{
                lanzarMensaje("Completo",data.response,3000,1);
            }


        }

        mostrarBotones();
        $(".progress").addClass("invisible");
    })
}

function finalizarActividad(){
    var idActividad = $("#g_id_actividad").val();
    var idSeguimiento = $("#id_seguimiento").val();
    var params = {};

        if(validarCampoRequired(idActividad)){
            params = {
                "id_actividad":idActividad,
                "_token":$("#_token").val()
            }
            if(validarCampoRequired(idSeguimiento)){
                params.id_seguimiento = idSeguimiento;
            }
            ocultarBotones();
            $(".progress").removeClass("invisible");
            $.post("/actividad/finalizar-actividad",params,function(data){
                $(".progress").addClass("invisible");
                mostrarBotones();
                if(data == "-1"){
                    lanzarMensaje("Error","La información enviada es incorrecta.",3000,2);
                }else{
                    window.location.reload();
                }
            })
        }else {
            lanzarMensaje("Error", "La información enviada es incorrecta.", 3000, 2);
        }
}

function ocultarBotones(){
    $(".contenedor-botones").fadeOut(300);
}

function mostrarBotones(){
    $(".contenedor-botones").fadeIn(300);
}