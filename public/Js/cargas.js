function cargarActividades(id){
    cargarSelect(id,'progress_select_actividades','contenedor_select_actividades','actividades',false);
}

function cargarActividadesProductos(id){
    cargarSelect(id,'progress_select_actividades','contenedor_select_actividades','actividades_productos',true);
}

function cargarProductos(id){
    cargarSelect(id, 'progress_select_productos', 'contenedor_select_productos', 'selectProductos', false);
    $("#"+id).prop("disabled","disabled");
}

function cargarActividadesRelacion(id){
    cargarSelect(id,'progress_select_actividades_relacion','contenedor_select_actividades_relacion','actividades_relacion',false);
}

function cargarDepartamentos(id){
    cargarSelect(id,'progress_select_departamentos','contenedor_select_departamentos','departamentos',true);
}

function cargarCiudades(id){
    cargarSelect(id,'progress_select_ciudades','contenedor_select_ciudades','ciudades',false);
}

function cargarDivisionesActEco(id){
    cargarSelect(id,'progress_select_divisiones_act_eco','contenedor_select_divisiones_act_eco','divisionActividadEconomica',true);
}

function cargarActividadesEconomicas(id){
    cargarSelect(id,'progress_select_actividad_economica','contenedor_select_actividad_economica','actividadesEconomicas',false);
}

function cargarSelect(id,progress,contenedor,select,change){
    $('#'+progress).removeClass('invisible');
    $('#'+contenedor).html('');

    var params = {'select':select,'id':$('#'+id).val(),'_token':$('#_token').val()};
    $.post($('#base_url').val()+'/proyecto/select',params,function(data){
        $('#'+contenedor).html(data);
        $('#'+progress).addClass('invisible');
        if(!change){
            $('#actividad').prop('onchange','');
        }
        inicializarMaterializacss();
    });
}