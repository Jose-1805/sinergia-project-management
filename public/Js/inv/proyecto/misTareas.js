/**
 * Created by Jose Luis on 09/02/2016.
 */

function desarrollarTarea(id){
    $('#contenedor-progress-'+id).removeClass('invisible');
    $('#contenedor-botones-'+id).addClass('invisible');

    formData = new FormData(document.getElementById(id));

    $.ajax({
        url: $('#base_url').val()+'/inv/desarrollo-tarea',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            if(data == "1" || data == 1){
                window.location.reload();
            }else if(data == "-1" || data == -1){
                lanzarMensaje("Error","Debe enviar como mínimo un dato (nota o archivo).",7000,2);
                $('#contenedor-botones-'+id).removeClass('invisible');
                $('#contenedor-progress-'+id).addClass('invisible');
            }else if(data == "-2" || data == -2){
                lanzarMensaje("Error","Ocurrio un error con la informacion enviada.",5000,2);
                $('#contenedor-botones-'+id).removeClass('invisible');
                $('#contenedor-progress-'+id).addClass('invisible');
            }else{
                lanzarMensaje("Error",data,5000,2);
                $('#contenedor-botones-'+id).removeClass('invisible');
                $('#contenedor-progress-'+id).addClass('invisible');
            }
        }
    });

    /*$.post($('#base_url').val()+'/inv/desarrollo-tarea',formData,function(data){

        if(data == "1" || data == 1){
            window.location.reload();
        }else if(data == "-1" || data == -1){
            lanzarMensaje("Error","Debe enviar como mínimo un dato (nota o archivo).",7000,2);
        }else if(data == "-2" || data == -2){
            lanzarMensaje("Error","Ocurrio un error con la informacion enviada.",5000,2);
            $('#contenedor-botones-'+id).removeClass('invisible');
            $('#contenedor-progress-'+id).addClass('invisible');
        }else{
            lanzarMensaje("Error",data,5000,2);
            $('#contenedor-botones-'+id).removeClass('invisible');
            $('#contenedor-progress-'+id).addClass('invisible');
        }
    });*/
}
