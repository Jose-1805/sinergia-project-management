/**
 * Created by Jose Luis on 21/01/2016.
 */
var save = "";
$(function(){
    $("#btnGuardarInformacionGeneral").click(function(){
        save = "general";
    });

    $("#btnGuardarHabilidades").click(function(){
        save = "habilidades";
    });

    $("#btnGuardarConfiguracionPerfil").click(function(){
        var  pass = $("#contrasenaActual");
        if(pass.val().length < 1){
            lanzarMensaje('Error','Ingrese su contraseña actual para condinuar con la edición de la información.',5000,2);
        }else{
            $(".contenedor-botones").addClass('invisible');
            $(".progress").removeClass('invisible');

            $.get($("#base_url").val()+'/validarPassword/' + pass.val()+ '/' + $("#email").val(),function (resp) {
                    if (resp == "1") {
                        pass.val('');
                        if(save == "general") {
                            actionsGeneral();
                        }else if(save == "habilidades"){
                            actionsHabilidades();
                        }

                    } else {
                        lanzarMensaje('Error','La contraseña ingresada es incorrecta.',5000,2);
                        $(".contenedor-botones").removeClass('invisible');
                        $(".progress").addClass('invisible');
                    }
                });
        }
    })
})

function actionsGeneral(){
    var img = 0;
    if($("#imagenDefecto").prop('checked')){
        img = 1;
    }

    if($("#archivo").val() && img == 0){
        var formData = new FormData(document.getElementById('form_informacion_personal'));
        //formData.append("imagen",document.getElementById("foto"));
        formData.append("_token",$("#_token").val());
        formData.append("id",$("#idPersona").val());

        $.ajax({
            url: $("#base_url").val()+"/perfil/upload-imagen",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(data){
            if(data == "1"){
                updateDatosGeneral();
            }else if(data == "-2"){
                lanzarMensaje("Error","Seleccione archivos con un tamaño inferior a 4 Mb.",10000,2);
                $(".contenedor-botones").removeClass('invisible');
                $(".progress").addClass('invisible');
            }else if(data == "-1"){
                lanzarMensaje("Error","Seleccione unicamente archivos con extensión 'jpg.' o 'png'.",10000,2);
                $(".contenedor-botones").removeClass('invisible');
                $(".progress").addClass('invisible');
            }
        });
    }else{
        updateDatosGeneral();
    }
}

function actionsHabilidades(){
    $.post($("#base_url").val()+"/perfil/actions-habilidades",$("#form_habilidades").serialize()+"&_token="+$("#_token").val()+"&id="+$("#idPersona").val(),function(data){
        if(data == 1){
            window.location.reload();
        }else{
            lanzarMensaje('Error','Ocurrio un error al aditar la información, por favor intente mas tarde.',5000,2);
            $(".contenedor-botones").removeClass('invisible');
            $(".progress").addClass('invisible');
        }
    }).error(function(jqHXR,estado,error){
        mensajeValidationFalse(jqHXR);
        $(".contenedor-botones").removeClass('invisible');
        $(".progress").addClass('invisible');
    });


}

function updateDatosGeneral(){
    var formDataInfo = $("#form_informacion_personal").serialize();
    var img = 0;
    if($("#imagenDefecto").prop('checked')){
        img = 1;
    }

    $.post($("#base_url").val() + "/perfil/actions-general", formDataInfo + "&_token=" + $("#_token").val() + "&id=" + $("#idPersona").val() + "&img=" + img, function (data) {
        if (data == '1') {
            window.location.reload();
        } else if (data == '-2') {
            lanzarMensaje('Error', 'La verificación de la contraseña es incorrecta.', 5000, 2);
        } else {
            lanzarMensaje('Error', 'Ocurrio un error al aditar la información, por favor intente mas tarde.', 5000, 2);
        }
    }).error(function (jqHXR, estado, error) {
        mensajeValidationFalse(jqHXR);
    }).complete(function () {
        $(".contenedor-botones").removeClass('invisible');
        $(".progress").addClass('invisible');
    });
}