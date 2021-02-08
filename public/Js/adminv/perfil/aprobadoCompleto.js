$(function () {
    $("#enviarAConvocatoriaOk").click(function(){
        ocultarModal();
        $(".contenedor_botones").addClass("invisible");
        $(".progress").removeClass("invisible");
        var params = {"_token":$("#_token").val(),"convocatoria":$("#convocatoria").val(),"perfil":$("#idPerfil").val()};
        $.post("/proyecto/enviar-a-convocatoria",params,function(data){
            if(data == 1){
                recargarContenido('/adminv/perfiles',null);
                lanzarMensaje('Completo','El perfil a sido enviado con exito a la convocatoria',5000,1);
            }else{
                lanzarMensaje('Error','Ocurrio un problema al cambiar el estado del perfil, intentelo más tarde.',5000,2);
            }
        })
    })

    $("#marcarAprobadoOk").click(function(){
        ocultarModal();

        $(".contenedor_botones").addClass("invisible");
        $(".progress").removeClass("invisible");

        var params = {"_token":$("#_token").val(),"perfil":$("#idPerfil").val(),"correo":"2"};
        $.post("/proyecto/aprobar-proyecto",params,function(data){
            if(data == 1){
                recargarContenido('/adminv/perfiles',null);
                lanzarMensaje('Completo','El proyecto a sido marcado como aprobado.',5000,1);
            }else{
                lanzarMensaje('Error','Ocurrio un problema al cambiar el estado del perfil, intentelo más tarde.',5000,2);
            }
        })
    })
})
