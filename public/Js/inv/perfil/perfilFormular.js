var id_aux = "";
$(function () {
    $('#btnInfoGeneralCompleto').click(function () {
        var num_lineas = $('#lineas_investigacion option:selected').length;
        if(num_lineas > 4 || num_lineas < 1){
            lanzarMensaje("Error","Seleccione mínimo una (1) y máximo cuetro (4) lineas de investigación.",4000,2);
        }else {
            $(".progress").removeClass('invisible');
            $(".contenedor-botones").addClass('invisible');
            var idPerfil = $("#idPerfil").val();
            var duracion = $("#duracion").val();
            var tipoFinanciacion = $("#tipoFinanciacion").val();
            var token = $("#_token").val();
            var params = {
                'id_perfil': idPerfil,
                'duracion': duracion,
                'tipo_financiacion': tipoFinanciacion,
                'lineas_investigacion': $('#lineas_investigacion').val(),
                '_token': token
            };
            $.post('/proyecto/formular-informacion-general', params, function (data) {
                if (data == 1) {
                    window.location.reload();
                } else if(data == -2){
                    lanzarMensaje("Error","Seleccione mínimo una (1) y máximo cuetro (4) lineas de investigación.",4000,2);
                } else {
                    lanzarMensaje('Error', 'Ocurrio un error al guardar la información general del perfil.', 4000, 1);
                    $(".progress").addClass('invisible');
                    $(".contenedor-botones").removeClass('invisible');
                }
            }).error(function (jqXHR) {
                $(".progress").addClass('invisible');
                $(".contenedor-botones").removeClass('invisible');
                mensajeValidationFalse(jqXHR);
            });
            //window.scroll(0, window.innerHeight * 10);
        }
    });

    $('#datosPerfil').on('click', '#componentes .col div #btnNuevoComponente', function () {
        agregarComponente();
    });


    $('#datosPerfil').on('click', '#componentes div ul li div p .btnBorrarComponente', function () {
        //if($('#componente div  .liComponente').size > 1){
        if ($('.liComponente').size() > 1) {
            $('#liComponente' + $(this).attr('id')).remove();
        } else {
            alert('Debes tener por lo menos un componente');
        }
        restaurarPropiedadesEtiquetas();
    });

    $('#btnGuardarComponentes').click(function(){
        var params = $("#form-componentes").serialize();
        var idPerfil = $("#idPerfil").val();
        var token = $("#_token").val();
        params += "&id_perfil="+idPerfil+"&_token="+token;
        $(".contenedor-botones").addClass('invisible');
        $(".progress").removeClass('invisible');

        $.post('/proyecto/guardar-formular-componenetes',params,function(data){
            if(data == '1'){
                lanzarMensaje('Completo','La información se ha almacenado con exito.',4000,1);
            }else{
                lanzarMensaje('Error','La información enviada es incorrecta, por favor recargue la pagina.',4000,2);
            }

            $(".contenedor-botones").removeClass('invisible');
            $(".progress").addClass('invisible');
        });
    });


    $('#btnComponentesCompletos').click(function(){
        var params = $("#form-componentes").serialize();
        var idPerfil = $("#idPerfil").val();
        var token = $("#_token").val();
        params += "&id_perfil="+idPerfil+"&_token="+token;
        $(".contenedor-botones").addClass('invisible');
        $(".progress").removeClass('invisible');

        $.post('/proyecto/completo-formular-componenetes',params,function(data){
            if(data == '1'){
                window.location.reload();
            }else if(data == '-1'){
                lanzarMensaje('Error','La información enviada es incorrecta, recuerde ingresar toda la información solicitada en cada componente.',4000,2);
            }else if(data == '-2'){
                lanzarMensaje('Error','La información enviada es incorrecta, por favor recargue la pagina.',4000,2);
            }else if(data == '-3'){
                lanzarMensaje('Error','La información enviada es incorrecta, recuerde que la suma de todos los equivalentes debe ser igual a 100.',4000,2);
            }

            $(".contenedor-botones").removeClass('invisible');
            $(".progress").addClass('invisible');
        });
    });

    $('#btnActividadesCompletas').click(function(){
        var idPerfil = $("#idPerfil").val();
        var token = $("#_token").val();
        params = {"id_perfil":idPerfil,"_token":token};
        $(".contenedor-botones").addClass('invisible');
        $(".progress").removeClass('invisible');

        $.post('/proyecto/completo-formular-actividades',params,function(data){
            if(data == 1){
                window.location.reload();
            }else if(data == -2){
                lanzarMensaje('Error','La información enviada es incorrecta',4000,2);
            }else if(data == -1){
                lanzarMensaje('Error','La información enviada es incorrecta, recuerde que cada componente debe tener por lo menos una actividad',7000,2);
            }

            $(".contenedor-botones").removeClass('invisible');
            $(".progress").addClass('invisible');
        });
    });

    $('#btnRubrosProductosCompletos').click(function(){
        var idPerfil = $("#idPerfil").val();
        var token = $("#_token").val();
        params = {"id_perfil":idPerfil,"_token":token};
        $(".contenedor-botones").addClass('invisible');
        $(".progress").removeClass('invisible');

        $.post('/proyecto/completo-formular-rubros-productos',params,function(data){
            if(data == 1){
                window.location.href = '/inv/perfiles';
            }else if(data == -2){
                lanzarMensaje('Error','La información enviada es incorrecta.',4000,2);
            }else if(data == -1){
                lanzarMensaje('Error','La información enviada es incorrecta, recuerde que cada actividad debe tener por lo menos un producto.',7000,2);
            }

            $(".contenedor-botones").removeClass('invisible');
            $(".progress").addClass('invisible');
        });
    })

    $(".show-nueva-actividad").click(function(){
        var id = $(this).data("componente");
        $("#modalActividad .modal-content").html("");
        $.post("/proyecto/crear-actividad",{"idComponente":id,"_token":$("#_token").val()},function(data){
            $("#deleteActividad").css("display","none");
            $("#modalActividad .modal-content").html(data);
        })
    })

    $(".show-editar-actividad").click(function(){
        var id = $(this).data("actividad");
        id_aux = id;
        $("#modalActividad .modal-content").html("");
        $.post("/proyecto/editar-actividad",{"idActividad":id,"_token":$("#_token").val()},function(data){
            $("#deleteActividad").css("display","inline-block");
            $("#modalActividad .modal-content").html(data);
        })
    })


    $(".show-rubros").click(function(){
        var id = $(this).data("actividad");
        $("#modalActividad .modal-content").html("");
        $.post($("#base_url").val()+"/proyecto/rubros-actividad",{"idActividad":id,"_token":$("#_token").val()},function(data){
            $("#modalRubros .modal-content").html(data);
            inicializar();
        })
    })

    $(".show-productos").click(function(){
        var id = $(this).data("actividad");
        $("#modalActividad .modal-content").html("");
        $.post("/proyecto/productos-actividad",{"idActividad":id,"_token":$("#_token").val()},function(data){
            $("#modalProductos .modal-content").html(data);
        })
    })
});

function actionsActividad(){
    var params = $("#form-actividad").serialize();
    var action = $("#action").val();
    var url = $("#base_url").val()+'/proyecto/actions-actividad';

    params += "&_token="+$("#_token").val();

    $('.progress').removeClass('invisible');
    $('.contenedor-botones').addClass('invisible');

    $.post(url,params,function(data){
        if(data == 1){
            window.location.reload();
        }else{
            lanzarMensaje('Error',data,8000,2);
        }
        $('.progress').addClass('invisible');
        $('.contenedor-botones').removeClass('invisible');
    }).error(function(jqXHR,estado,error){
        $('.progress').addClass('invisible');
        $('.contenedor-botones').removeClass('invisible');
        mensajeValidationFalse(jqXHR);
    })
}


function deleteActividad() {
    if(confirm("¿Esta seguro de eliminar esta actividad?")) {
        var url = $("#base_url").val() + '/actividad/delete';
        var params = {'id': id_aux, '_token': $("#_token").val()};
        $.post(url, params, function (data) {
            if (data == 1) {
                window.location.reload();
            } else if (data == -1) {
                lanzarMensaje("Error", "Ocurrio un error intentando eliminar la actividad, recargue la página e intente nuevamente.", 7000, 2);
            }
        });
    }
}


function agregarComponente() {
    var componentes = $('.liComponente');
    var cantidad = componentes.size();
    if (cantidad == 5) {
        alert('Puede dividir su proyecto unicamente en 5 componentes');
    } else {

        var ultimoLi = $('#liComponente' + cantidad);
        if (ultimoLi.length) {
            ultimoLi.after(generarHtmlNuevoComponente(cantidad + 1));
            restaurarPropiedadesEtiquetas();
            inicializar();
        } else {
            alert('Problemas al agregar un componente');
        }
    }
}

function generarHtmlNuevoComponente(id) {
    return "<li class='liComponente' id='liComponente" + id + "'>" +
    "<div class='collapsible-header'>" +
    "<p>Componente " + id + " <i class='mdi-navigation-cancel btnBorrarComponente' style='float: right; color:red;' id='" + id + "'></i></p>" +
    "</div>" +
    "<div class='collapsible-body componente' id='componente" + id + "'>" +
    "<div class='input-field'>" +
    "<input type='text' name='nombre" + id + "' id='nombre" + id + "'>" +
    "<label for='nombre" + id + "'>Nombre</label>" +
    "</div>" +
    "<div class='input-field'>" +
    "<textarea name='objetivo" + id + "' id='objetivo" + id + "' class='materialize-textarea'></textarea>" +
    "<label for='objetivo" + id + "'>Objetivo</label>" +
    "</div>" +

    "<div class='input-field'>" +
    "<label for='equivalente" + id + "'>Equivalente</label>" +
    "<input type='number' min='1' max='100' id='equivalente" + id + "' name='equivalente" + id + "' value='1'>" +
    "</div>" +
    "</div>" +
    "</li>";
}


function restaurarPropiedadesEtiquetas() {
    $('.liComponente').each(function (index) {
        var p = $(this).children('div').children('p');
        p.html("componente " + (index + 1) + "<i class='mdi-navigation-cancel btnBorrarComponente' style='float: right; color:red;' id='" + (index + 1) + "'></i>");
        $(this).attr('id', 'liComponente' + (index + 1));

    });
    $('.componente').each(function (index) {
        var input = $('.componente').eq(index).children('.input-field').children('input[type="text"]');
        input.attr('id', 'nombre' + (index + 1));
        input.attr('name', 'nombre' + (index + 1));

        var textArea = $(this).children('.input-field').children('textarea');
        textArea.attr('id', 'objetivo' + (index + 1));
        textArea.attr('name', 'objetivo' + (index + 1));

        var range = $(this).children('.input-field').children('input[type="number"]');
        range.attr('id', 'equivalente' + (index + 1));
        range.attr('name', 'equivalente' + (index + 1));

        $(this).attr('id', 'componente' + (index + 1));

        var labels = $(this).children('div').children('label');
        labels.eq(0).attr('for', 'nombre' + (index + 1));
        labels.eq(1).attr('for', 'objetivo' + (index + 1));
        labels.eq(2).attr('for', 'equivalente' + (index + 1));
    });
}

function eliminarProducto(id){
    var cantidad = $(".contenedor-producto").length;
    if(cantidad > 1) {
        $("#" + id).parent().remove();
        reestructurarEtiquetasProductos();
    }else{
        lanzarMensaje('Error','Cada actividad debe tener por lo menos un producto.',4000,2);
    }
}

function agregarProducto(){
    var obj = $('.contenedor-producto').eq(0).clone();
    $(obj).children('textarea').eq(0).val('');
    $(obj).appendTo($('#contenedor-productos'));
    reestructurarEtiquetasProductos();
}

function reestructurarEtiquetasProductos(){
    $('.contenedor-producto').each(function(indice){
        $(this).children('i').eq(0).attr('id','btnEliminar'+(indice+1));
        $(this).children('label').eq(0).attr('for','descripcion'+(indice+1));
        $(this).children('label').eq(0).text('Producto '+(indice+1));
        $(this).children('textarea').eq(0).attr('id','descripcion'+(indice+1));
        $(this).children('textarea').eq(0).attr('name','descripcion'+(indice+1));
    })
}

function actionsProductos(){
    reestructurarEtiquetasProductos();
    var cantidad = $(".contenedor-producto").length;
    if(cantidad >= 1) {
        $('.progress').removeClass('invisible');
        $('.contenedor-botones').addClass('invisible');
        $.post('/proyecto/actions-productos',$("#form-productos").serialize()+'&_token='+$("#_token").val(),function(data){
            window.location.reload();
        })
    }else{
        lanzarMensaje('Error','Cada actividad debe tener por lo menos un producto.',4000,2);
    }
}

function agregarRubro(){
    var cantidad = $('.contenedor-rubro').length + 1;
    $.get('/proyecto/html-nuevo-rubro/'+cantidad,function(data){
        var contenedor = $('.contenedor-rubro').eq(0).clone();
        $(contenedor).children('.collapsible-body').eq(0).html(data);
        contenedor.appendTo($('#contenedor-rubros'));
        inicializar();
        reestructurarEtiquetasRubros();
    });
}

function eliminarRubro(id){
        $("#" + id).parent().parent().remove();
        reestructurarEtiquetasRubros();
}


function agregarItemRubro(id){
    var formParent = $("#"+id).parent().parent();
    var tableBody = $(formParent).children('.table_items_rubros').eq(0).children('tbody').eq(0);
    var row = $(tableBody).children('.row_item_componente').eq(0).clone();

    $(row).children('td').eq(0).children('input[type="text"]').eq(0).val('');
    $(row).children('td').eq(1).children('input[type="number"]').eq(0).val(0);
    $(row).children('td').eq(2).children('input[type="number"]').eq(0).val(0);

    $(row).appendTo($(tableBody));
    reestructurarEtiquetasRubros()
}

function eliminarItemRubro(id){
    var full_parent = $("#" + id).parent().parent().parent();
    if($(full_parent).children('.row_item_componente').length > 1) {
        $("#" + id).parent().parent().remove();
        reestructurarEtiquetasRubros();
    }else{
        lanzarMensaje('Error','Cada rubro debe contener por lo menos un item.',4000,2);
    }
}

function reestructurarEtiquetasRubros(){
    $('.contenedor-rubro').each(function(indice){
        var etiquetaELiminar = $(this).children('.collapsible-header').eq(0).children('i').eq(0);
        $(etiquetaELiminar).attr('id','btnEliminarRubro_'+(indice + 1));
        $(this).children('.collapsible-header').eq(0).html('Rubro '+(indice+1));
        $(etiquetaELiminar).appendTo($(this).children('.collapsible-header').eq(0));

        var form_rubro = $(this).children('.collapsible-body').eq(0).children('.formulario_rubro').eq(0);
        $(form_rubro).attr('id','form_rubro_'+(indice + 1));
        $(form_rubro).attr('name','form_rubro_'+(indice + 1));
        $(form_rubro).children('.input-field').eq(0).children('label').eq(0).text("Nombre Rubro "+(indice + 1));
        $(form_rubro).children('.input-field').eq(0).children('label').eq(0).attr("for","nombre_rubro_"+(indice + 1));
        $(form_rubro).children('.input-field').eq(0).children('input[type="text"]').eq(0).attr("id","nombre_rubro_"+(indice + 1));
        $(form_rubro).children('.input-field').eq(0).children('input[type="text"]').eq(0).attr("name","nombre_rubro_"+(indice + 1));
        $(form_rubro).children('.contenedor-btn-agregar-item').eq(0).children('a').eq(0).attr('id','btn_agregar_item_'+(indice + 1))
        var count_items = $(form_rubro).children('.table_items_rubros').eq(0).children('tbody').eq(0).children('.count_rubro').eq(0);
        var numero = $(form_rubro).children('.table_items_rubros').eq(0).children('tbody').eq(0).children('.row_item_componente').length;
        $(count_items).val(numero);
        $(count_items).attr("name","count_rubro_"+(indice + 1));
        reestructurarEtiquetasItemsRubros();
    });
}

function reestructurarEtiquetasItemsRubros(){

    $('.table_items_rubros').each(function(indice){
        $(this).children('tbody').eq(0).children('tr').each(function(index){
            $(this).children('td').eq(0).children('input[type="text"]').eq(0).attr('name','nombre_item_'+(indice+1)+'_'+(index + 1));
            $(this).children('td').eq(1).children('input[type="number"]').eq(0).attr('name','cantidad_item_'+(indice+1)+'_'+(index + 1));
            $(this).children('td').eq(2).children('input[type="number"]').eq(0).attr('name','valor_unitario_item_'+(indice+1)+'_'+(index + 1));
            $(this).children('td').eq(3).children('i').eq(0).attr('id','btnEliminarItem_'+(indice+1)+'_'+(index + 1));
        })
    })
}

function actionsRubros(){
    reestructurarEtiquetasRubros();
    params = "id_actividad="+$('#id-actividad').val()+'&_token='+$('#_token').val()+'&cantidad_rubros='+$('.contenedor-rubro').length;
    $(".formulario_rubro").each(function(index){
        params += '&'+$(".formulario_rubro").eq(index).serialize();
    })

    $('.progress').removeClass('invisible');
    $('.contenedor-botones').addClass('invisible');
    $.post('/proyecto/actions-rubros',params,function(data){
        if(data == 1){
            window.location.reload();
        }else{
            mensaje = '<lu>';
            $.each(data, function(i, item) {
                mensaje += '<li>'+ data[i] + '</li>';
            });
            mensaje += '</ul>';
            lanzarMensaje('Error',mensaje,5000,2);
        }
        $('.progress').addClass('invisible');
        $('.contenedor-botones').removeClass('invisible');
    })
}

function inicializar() {

    $('.collapsible').collapsible({
        accordion: false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });

}