$(function () {

    $("#btn-buscar-perfil").click(function(){
        var codigo = $("#codigo-perfil").val().trim();
        var token = $("#_token").val();
        var params = {"codigo":codigo,"_token":token};
        $(".progress").removeClass("invisible");
        var btn = $(this);
        btn.fadeOut(300);
        $.post("/proyecto/buscar-perfil-codigo",params,function(data){
            $(".progress").addClass("invisible");
            if(data == -1){
                btn.fadeIn(300);
                lanzarMensaje("Error","El código ingresado no pertenece a ningún perfil.",4000,1);
            }else{
                $("#contenedor-perfil-editar").html(data);
            }
        });
    })
})