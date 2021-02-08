$(function(){
    $('#filtroPerfiles').change(function(){
        switch ($(this).val()){
            case '1':window.location = '/inv/perfiles';
                break;
            case '2':recargarContenido('/inv/perfiles-enviados','contenedorPerfiles');
                break;
            case '3':recargarContenido('/inv/perfiles-completos','contenedorPerfiles');
                break;
            case '4':recargarContenido('/inv/perfiles-aprobados','contenedorPerfiles');
                break;
            case '5':recargarContenido('/inv/perfiles-descartados','contenedorPerfiles');
                break;
        }
        
    })
})