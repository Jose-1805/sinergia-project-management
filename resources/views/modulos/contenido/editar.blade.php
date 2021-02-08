<?php
    $checkSinSesion = "";
    $checkAdministrador = "";
    $checkEvaluador = "";
    $checkInvestigador = "";

    foreach($contenido->arrayNameRoles() as $name){
        switch($name){
            case 'administrador investigativo': $checkAdministrador = "checked";
            break;
            case 'evaluador': $checkEvaluador = "checked";
            break;
            case 'investigador': $checkInvestigador = "checked";
            break;
        }
    }

    if($contenido->con_sin_sesion == "si")
        $checkSinSesion = "checked";
?>
@section('css')
@parent
    <link href="{{asset('Css/gestionContenido.css')}}" rel="stylesheet">
@stop

@section('js')
@parent
    <script src="{{asset('Js/contenido.js')}}"></script>
    <script src="{{asset('Js/contenidoContenedor.js')}}"></script>
    <script src="{{asset('Js/contenidoTexto.js')}}"></script>
    <script src="{{asset('Js/contenidoMedia.js')}}"></script>
    <script src="{{asset('Js/contenidoExtra.js')}}"></script>
@stop

<p class="titulo tituloPrincipalPag tituloMediano">Editar Contenido</p>

<div class="col s12 white" style="padding: 10px;">
    <div class="opciones-contenido-web col s3 m1 l2 hide-on-med-and-down">
        <div class="col s12 contenedor-opcion"><a class="col s12 btn white orange-text texto-informacion-small waves-effect waves-dark" onclick="nuevoContenedor();">Contenedor</a></div>
        <div class="col s12 contenedor-opcion"><a class="col s12 btn white orange-text texto-informacion-small waves-effect waves-dark" onclick="nuevoTitulo();">Título</a></div>
        <div class="col s12 contenedor-opcion"><a class="col s12 btn white orange-text texto-informacion-small waves-effect waves-dark" onclick="nuevoParrafo()">Párrafo</a></div>
        <div class="col s12 contenedor-opcion"><a class="col s12 btn white orange-text texto-informacion-small waves-effect waves-dark" onclick="nuevoLink();">Link</a></div>
        <div class="col s12 contenedor-opcion"><a class="col s12 btn white orange-text texto-informacion-small waves-effect waves-dark" onclick="nuevaImagen();">Imagen</a></div>
        <div class="col s12 contenedor-opcion"><a class="col s12 btn white orange-text texto-informacion-small waves-effect waves-dark" onclick="nuevoIFrame();">Externo</a></div>
    </div>

    <div class="opciones-contenido-web col s3 m1 l2 hide-on-large-only">
        <div class="col s12 contenedor-opcion"><a class="btn-floating white orange-text waves-effect waves-dark tooltipped" data-position="right" data-delay="50" data-tooltip="Contenedor" onclick="nuevoContenedor();"><i class="fa fa-square-o orange-text texto-informacion-medium"></i></a></div>
        <div class="col s12 contenedor-opcion"><a class="btn-floating white orange-text waves-effect waves-dark tooltipped" data-position="right" data-delay="50" data-tooltip="Título" onclick="nuevoTitulo();"><i class="orange-text texto-informacion-medium">T</i></a></div>
        <div class="col s12 contenedor-opcion"><a class="btn-floating white orange-text waves-effect waves-dark tooltipped" data-position="right" data-delay="50" data-tooltip="Párrafo" onclick="nuevoParrafo();"><i class="fa fa-paragraph orange-text texto-informacion-medium"></i></a></div>
        <div class="col s12 contenedor-opcion"><a class="btn-floating white orange-text waves-effect waves-dark tooltipped" data-position="right" data-delay="50" data-tooltip="Link" onclick="nuevoLink();"><i class="fa fa-link orange-text texto-informacion-medium"></i></a></div>
        <div class="col s12 contenedor-opcion"><a class="btn-floating white orange-text waves-effect waves-dark tooltipped" data-position="right" data-delay="50" data-tooltip="Imagen" onclick="nuevaImagen();"><i class="fa fa-picture-o orange-text texto-informacion-medium"></i></a></div>
        <div class="col s12 contenedor-opcion"><a class="btn-floating white orange-text waves-effect waves-dark tooltipped" data-position="right" data-delay="50" data-tooltip="Contenido externo" onclick="nuevoIFrame();"><i class="fa fa-external-link orange-text texto-informacion-medium"></i></a></div>
    </div>

    <?php
        $archivo = fopen(asset('contenidos/edit_'.$contenido->con_archivo),'r');

        while(!feof($archivo)) {
            $linea = fgets($archivo);
            echo $linea;
        }
        fclose($archivo);
    ?>

    <a class="btn teal waves-effect waves-light white-text right modal-trigger" style="margin-top: 20px;" href="#modal-save">Guardar</a>
</div>



<div id="modal-propiedades" class="modal modal-fixed-footer">
    <div class="modal-content">
    </div>
    <div class="modal-footer">

    </div>
</div>

<div id="modal-save" class="modal modal-fixed-footer">
    <div class="modal-content">
        <form id="form-guardar-contenido">
            <div class="input-field">
                <label for="nombre active">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{$contenido->con_nombre}}">
            </div>

            <p>Seleccione los roles en los cuales será visible el contenido a crear.</p>
            <p>
              <input type="checkbox" id="administrador" name="administrador" {{$checkAdministrador}}/>
              <label for="administrador">Administrador</label>
            </p>
            <p>
              <input type="checkbox" id="evaluador" name="evaluador" {{$checkEvaluador}}/>
              <label for="evaluador">Evaluador</label>
            </p>
            <p>
              <input type="checkbox" id="investigador" name="investigador" {{$checkInvestigador}}/>
              <label for="investigador">Investigador</label>
            </p>
            <p>
              <input type="checkbox" id="sin_sesion" name="sin_sesion" {{$checkSinSesion}}/>
              <label for="sin_sesion">Usuarios sin iniciar sesión</label>
            </p>
        </form>
    </div>
    <div class="modal-footer">
        <div class="progress invisible" id="progress-guardar-contenido">
            <div class="indeterminate"></div>
        </div>

        <a class="modal-action waves-effect waves-teal btn-flat " id="btn-guardar-contenido">Continuar</a>
        <a class="modal-action waves-effect waves-teal btn-flat modal-close" id="">Cancelar</a>
    </div>
</div>

<div id="contenido-guardar" class="invisible"></div>
<input type="hidden" name="contenido_id" id="contenido_id" value="{{$contenido->id}}">