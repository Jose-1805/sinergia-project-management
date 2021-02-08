$(function () {
    $("#aprobarEnConvocatoriaOk").click(function(){
        ocultarModal();
        $("#btnAprobarEnConvocatoria").css({"display":"none"})
        $(".progress").removeClass("invisible");
        var correo = 1;
        if ($('#enviarCorreoAprobarEnConvocatoria').prop('checked')) {
            correo = 2
        }

        var params = {"_token":$("#_token").val(),"perfil":$("#idPerfil").val(),"correo":correo};
        $.post("/proyecto/aprobar-proyecto",params,function(data){
            if(data == 1){
                recargarContenido('/adminv/proyectos',null);
                lanzarMensaje('Completo','El proyecto ha sido aprobado con exito en la convocatoria',4000,1);
                setTimeout(function(){
                    window.location.href = "/adminv/proyectos";
                },4000)
            }else{
                lanzarMensaje('Error','Ocurrio un problema al cambiar el estado del proyecto, intentelo más tarde.',5000,2);
            }
        })
    })
})
