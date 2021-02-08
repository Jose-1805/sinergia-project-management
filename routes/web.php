<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*//////////////////////////////////////////////////
 * INICIO CONTROLLER //////////////////////////////
 */
Route::get('/', 'InicioController@getIndex');
Route::get('inicio', 'InicioController@getIndex');
Route::get('semillero','InicioController@semillero');
Route::get('contactenos','InicioController@contactenos');
Route::get('grupo-investigacion','InicioController@grupoInvestigacion');
Route::get("nuevoPerfil","InicioController@nuevoPerfil");
Route::get("editPerfil","InicioController@editPerfil");
Route::get("restaurar-contrasena","InicioController@restaurarContrasena");

/*//////////////////////////////////////////////////
 * USUARIO CONTROLLER //////////////////////////////
 */
Route::get('validarCorreoInvestigador/{correo}','UsuarioController@validarCorreoInvestigador');
Route::get('validarPassword/{password}/{correo}','UsuarioController@validarPassword');
Route::post('login', "UsuarioController@login");
Route::post('restaurar-contrasena-send', "UsuarioController@restaurarContrasena");
Route::get('notificaciones', "UsuarioController@notificaciones");
Route::get('notificacionesNuevas', "UsuarioController@notificacionesNuevas");
Route::get('notificacionesRevisadasOk', "UsuarioController@notificacionesRevisadasOk");
Route::get('masNotificaciones/{index}', "UsuarioController@masNotificaciones");


/*///////////////////////////////////////////////////
 * PROYECTO CONTROLLER //////////////////////////////
 */
Route::post('registroPerfil','ProyectoController@registrarPerfil');
Route::get('validarTitulo/{titulo}',"ProyectoController@validarTitulo");


//RUTAS PARA EL ADMINISTRADOR INVESTIGATIVO
//AdministradorInvestigativoController
Route::group(['prefix' => 'adminv'], function () {
    Route::get('','AdministradorInvestigativoController@getIndex');
    Route::get('perfiles','AdministradorInvestigativoController@getPerfiles');
    Route::get('proyectos','AdministradorInvestigativoController@getProyectos');
    Route::get('perfil-sugerir/{id}','AdministradorInvestigativoController@getPerfilSugerir');
    Route::get('perfil-asignar/{id}','AdministradorInvestigativoController@getPerfilAsignar');
    Route::get('convocatoria-registrar','AdministradorInvestigativoController@getConvocatoriaRegistrar');
    Route::get('entidades','AdministradorInvestigativoController@getEntidades');
    Route::get('nuevaentidad','AdministradorInvestigativoController@getNuevaEntidad');
    Route::post('registrar-entidad','AdministradorInvestigativoController@postRegistrarentidad');
    Route::get('administrar','AdministradorInvestigativoController@getAdministrar');

    //CONSULTAS
    Route::get('departamentos','AdministradorInvestigativoController@getDepartamentos');
    Route::get('traerdivacteco/{id}','AdministradorInvestigativoController@getTraerdivacteco');
    Route::get('traeracteco/{id}','AdministradorInvestigativoController@getTraeracteco');
    Route::get('traermunicipios/{id}','AdministradorInvestigativoController@getTraermunicipios');

    //VALIDACIOBES
    Route::get('validarnombre/{nombre?}','AdministradorInvestigativoController@getValidarnombre');
    Route::get('validar-camara-comercio/{camara?}','AdministradorInvestigativoController@getValidarCamaraComercio');
    Route::get('validar-correo-entidad/{correo?}','AdministradorInvestigativoController@getValidarCorreoEntidad');

    //PARA ENTIDADES
    Route::get('ver-entidad/{id}','AdministradorInvestigativoController@getVerEntidad');
    Route::get('actualizar-entidad/{id}','AdministradorInvestigativoController@getActualizarEntidad');
    Route::post('actualizar-entidad','AdministradorInvestigativoController@postActualizarEntidad');

    //PARA EVALUADORES
    Route::get('evaluadores','AdministradorInvestigativoController@getEvaluadores');
    Route::get('nuevo-evaluador','AdministradorInvestigativoController@getNuevoEvaluador');
    Route::get('validar-correo-persona/{correo}','AdministradorInvestigativoController@getValidarCorreoPersona');
    Route::post('registrar-evaluador','AdministradorInvestigativoController@postRegistrarEvaluador');
    Route::get('ver-evaluador/{id}','AdministradorInvestigativoController@getVerEvaluador');
    Route::get('actualizar-evaluador/{id}','AdministradorInvestigativoController@getActualizarEvaluador');
    Route::post('actualizar-evaluador','AdministradorInvestigativoController@postActualizarEvaluador');

    //PARA INVESTIGADORES
    Route::get('investigadores','AdministradorInvestigativoController@getInvestigadores');
    Route::get('nuevo-investigador','AdministradorInvestigativoController@getNuevoInvestigador');
    Route::post('registrar-investigador','AdministradorInvestigativoController@postRegistrarInvestigador');
    Route::get('ver-investigador/{id}','AdministradorInvestigativoController@getVerInvestigador');
    Route::get('actualizar-investigador/{id}','AdministradorInvestigativoController@getActualizarInvestigador');
    Route::post('actualizar-investigador','AdministradorInvestigativoController@postActualizarInvestigador');

});

//RUTAS PARA EL ADMINISTRADOR INVESTIGATIVO
//InvestigadorController
Route::group(['prefix' => 'inv'], function () {
    Route::get('', 'InvestigadorController@getIndex');
    Route::get('nuevo-perfil','InvestigadorController@getNuevoPerfil');
    Route::post('nuevo-perfil','InvestigadorController@postNuevoPerfil');
    Route::get('perfiles','InvestigadorController@getPerfiles');
    Route::get('proyectos','InvestigadorController@getProyectos');
    Route::get('editar-perfil/{íd}','InvestigadorController@getEditarPerfil');
    Route::get('perfi/{íd}','InvestigadorController@getPerfil');
    Route::get('perfil-formular/{id}','InvestigadorController@getPerfilFormular');
    Route::get('sugerencias','InvestigadorController@getSugerencias');
    Route::get('sugerencia/{id}','InvestigadorController@getSugerencia');
    Route::get('solicitudes','InvestigadorController@getSolicitudes');
    Route::get('solicitud/{id}','InvestigadorController@getSolicitud');
    Route::post('cambiar-estado-solicitud','InvestigadorController@postCambiarEstadoSolicitud');
    Route::get('asignacion-tareas/{id}','InvestigadorController@getAsignacionTareas');
    Route::post('asignar-tarea','InvestigadorController@postAsignarTarea');
    Route::get('mis-tareas/{id}','InvestigadorController@getMisTareas');
    Route::post('desarrollo-tarea','InvestigadorController@postDesarrolloTarea');

});

//RUTAS PARA EL EVALUADOR
//EvaluadorController
Route::group(['prefix' => 'eval'], function () {
    Route::get('', 'EvaluadorController@getIndex');
    Route::get('perfiles','EvaluadorController@getPerfiles');
    Route::get('proyectos','EvaluadorController@getProyectos');
    Route::get('sugerencias','EvaluadorController@getSugerencias');
    Route::get('perfil-sugerir/{id}','EvaluadorController@getPerfilSugerir');
    Route::get('sugerencia/{id}','EvaluadorController@getSugerencia');
});

//RUTAS PARA PROYECTOS
//ProyectoController
Route::group(['prefix' => 'proyecto'], function () {
    Route::get('', 'ProyectoController@getIndex');
    Route::get('perfil/{id}','ProyectoController@getPerfil');
    Route::get('evaluar/{id}','ProyectoController@getEvaluar');
    Route::post('aprobar-perfil','ProyectoController@postAprobarPerfil');
    Route::post('perfil-completo','ProyectoController@postPerfilCompleto');
    Route::post('descartar-perfil','ProyectoController@postDescartarPerfil');
    Route::post('enviar-a-convocatoria','ProyectoController@postEnviarAConvocatoria');
    Route::post('aprobar-proyecto','ProyectoController@postAprobarProyecto');
    Route::post('asignar-perfil','ProyectoController@postAsignarPerfil');
    Route::post('buscar-perfil-codigo','ProyectoController@postBuscarPerfilCodigo');
    Route::post('editar-perfil','ProyectoController@postEditarPerfil');
    Route::post('registrar-sugerencia-perfil','ProyectoController@postRegistrarSugerenciaPerfil');
    Route::post('data-actividad','ProyectoController@postDataActividad');
    Route::post('data-actividad-edit','ProyectoController@postDataActividadEdit');
    Route::post('crear-actividad','ProyectoController@postCrearActividad');
    Route::post('editar-actividad','ProyectoController@postEditarActividad');
    Route::post('actions-actividad','ProyectoController@postActionsActividad');
    Route::post('productos-actividad','ProyectoController@postProductosActividad');
    Route::post('rubros-actividad','ProyectoController@postRubrosActividad');
    Route::get('html-nuevo-rubro/{numero_rubro}','ProyectoController@getHtmlNuevoRubro');
    Route::post('actions-rubros','ProyectoController@postActionsRubros');
    Route::post('actions-productos','ProyectoController@postActionsProductos');
    Route::post('formular-informacion-general','ProyectoController@postFormularInformacionGeneral');
    Route::post('guardar-formular-componenetes','ProyectoController@postGuardarFormularComponenetes');
    Route::post('completo-formular-componenetes','ProyectoController@postCompletoFormularComponenetes');
    Route::post('completo-formular-actividades','ProyectoController@postCompletoFormularActividades');
    Route::post('completo-formular-rubros-productos','ProyectoController@postCompletoFormularRubrosProductos');
    Route::post('select','ProyectoController@postSelect');
    Route::get('entidades/{id}','ProyectoController@getEntidades');
    Route::post('relacion-entidad','ProyectoController@postRelacionEntidad');
    Route::post('delete-relacion-entidad','ProyectoController@postDeleteRelacionEntidad');
    Route::get('grupo/{id}','ProyectoController@getGrupo');
    Route::post('agregar-investigador-relacion','ProyectoController@postAgregarInvestigadorRelacion');
    Route::post('enviar-solicitud-proyecto-investigador','ProyectoController@postEnviarSolicitudProyectoInvestigador');
    Route::get('inicio-proyecto/{id}','ProyectoController@getInicioProyecto');
    Route::post('establecer-fecha-inicio','ProyectoController@postEstablecerFechaInicio');
    Route::post('guardar-respuesta-sugerencia','ProyectoController@postGuardarRespuestaSugerencia');
    Route::post('sugerencia-revisada','ProyectoController@postSugerenciaRevisada');
    Route::get('download-file-producto/{id}','ProyectoController@getDownloadFileProducto');
    Route::get('reporte-informacion/{id}','ProyectoController@getReporteInformacion');
    Route::get('reporte-grafico/{id}','ProyectoController@getReporteGrafico');
});

//RUTAS PARA COMPONENTES
//ComponenteController
Route::group(['prefix' => 'componente'], function () {
    Route::post('update', 'ComponenteController@postUpdate');
});

//RUTAS PARA ACTIVIDADES
//ActividadController
Route::group(['prefix' => 'actividad'], function () {
    Route::get('view/{id}','ActividadController@getView');
    Route::post('update','ActividadController@postUpdate');
    Route::post('add-sugerencia','ActividadController@postAddSugerencia');
    Route::post('add-sugerencia-producto','ActividadController@postAddSugerenciaProducto');
    Route::post('guardar-cambios-productos','ActividadController@postGuardarCambiosProductos');
    Route::post('finalizar-actividad','ActividadController@postFinalizarActividad');
    Route::post('delete','ActividadController@postDelete');
});

//RUTAS PARA PRODUCTOS
//ProductoController
Route::group(['prefix' => 'producto'], function () {
    Route::post('update', 'ProductoController@postUpdate');
});

//RUTAS PARA RUBRO
//RubroController
Route::group(['prefix' => 'rubro'], function () {
    Route::post('update', 'RubroController@postUpdate');
});

//RUTAS PARA CONVOCATORIAS
//ConvocatoriaController
Route::group(['prefix' => 'convocatoria'], function () {
    Route::get('', 'ConvocatoriaController@getIndex');
});

//RUTAS PARA PERFILES
//PerfilController
Route::group(['prefix' => 'perfil'], function () {
    Route::get('view/{id}', 'PerfilController@getView');
    Route::get('edit/{id}', 'PerfilController@getEdit');
    Route::post('actions-habilidades', 'PerfilController@postActionsHabilidades');
    Route::post('actions-general', 'PerfilController@postActionsGeneral');
    Route::post('upload-imagen', 'PerfilController@postUploadImagen');
});

//RUTAS PARA ENTIDADES
//EntidadController
Route::group(['prefix' => 'entidad'], function () {
    Route::post('store', 'EntidadController@postStore');
});

//RUTAS PARA EVENTOS
//EventosController
Route::group(['prefix' => 'eventos'], function () {
    Route::get('', 'EventosController@getIndex');
    Route::get('establecer','EventosController@getEstablecer');
    Route::get('administrar','EventosController@getAdministrar');
    Route::post('list','EventosController@postList');
    Route::post('save','EventosController@postSave');
    Route::get('evento/{id}','EventosController@getEvento');
    Route::post('cambiar-estado','EventosController@postCambiarEstado');
    Route::get('editar/{id}','EventosController@getEditar');
    Route::get('crear','EventosController@getCrear');
    Route::post('guardar','EventosController@postGuardar');
    Route::post('eliminar-imagen','EventosController@postEliminarImagen');
    Route::post('editar','EventosController@postEditar');
    Route::post('view-fotos','EventosController@postViewFotos');
});

//RUTAS PARA CONTENIDOS
//ContenidoController
Route::group(['prefix' => 'contenido'], function () {
    Route::get('nuevo', 'ContenidoController@getNuevo');
    Route::post('save','ContenidoController@postSave');
    Route::get('establecer','ContenidoController@getEstablecer');
    Route::get('administrar','ContenidoController@getAdministrar');
    Route::post('list','ContenidoController@postList');
    Route::post('cambiar-estado','ContenidoController@postCambiarEstado');
    Route::post('save-conf','ContenidoController@postSaveConf');
    Route::get('editar/{id}','ContenidoController@getEditar');
});


Route::get('salir',function(){
    Session::flush();
    return redirect('/');
});