$(function(){
    $('#filtroPerfiles').change(function(){
        switch ($(this).val()){
            case '1':window.location = '/adminv/perfiles';
                break;
            case '2':recargarContenido('/adminv/perfiles-recibidos','contenedorPerfiles');
                break;
            case '3':recargarContenido('/adminv/perfiles-completos','contenedorPerfiles');
                break;
            case '4':recargarContenido('/adminv/perfiles-aprobados','contenedorPerfiles');
                break;
            case '5':recargarContenido('/adminv/perfiles-descartados','contenedorPerfiles');
                break;
        }
        
    })
})