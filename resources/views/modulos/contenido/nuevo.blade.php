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

<p class="titulo tituloPrincipalPag tituloMediano">Nuevo Contenido</p>

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

    <div id="datos-elementos" class="invisible">
        <input type="hidden" name="cant-contenedores" id="cant-contenedores" value="1">
        <input type="hidden" name="cant-titulos" id="cant-titulos" value="0">
        <input type="hidden" name="cant-parrafos" id="cant-parrafos" value="0">
        <input type="hidden" name="cant-links" id="cant-links" value="0">
        <input type="hidden" name="cant-imagenes" id="cant-imagenes" value="0">
        <input type="hidden" name="cant-contenido-externo" id="cant-contenido-externo" value="0">
    </div>

    <!--<iframe class="col s12 m6 l12 iframe-video" src="https://www.youtube.com/embed/EqhnhA1vgMU" frameborder="0" allowfullscreen></iframe>-->

    <div class="col s9 m11 l10 white z-depth-1" id="contenido">
        <div class="col s12 m12 l12 contenido-contenedor" id="contenedor-1" style="background-color: #FFFFFF; padding:0px !important;">
            <a href="#modal-propiedades" onclick="establecerFormActual('propiedades-contenedor-',1,'contenedor')" class="modal-trigger contenido-btn-propiedades contenedor-btn-elemento" id="btn-propiedades-contenedor-1"><i class="fa fa-cog right tooltipped" data-position="bottom" data-delay="50" data-tooltip="Propiedades Contenedor 1"></i></a>
        </div>
    </div>

    <a class="btn teal waves-effect waves-light white-text right modal-trigger" style="margin-top: 20px;" href="#modal-save">Guardar</a>
</div>

<div id="contenedor-modals">
    <form id="propiedades-contenedor-1">
        <p class="tituloPrincipalPag titulo">Propiedades del contenedor</p>
        <p class="texto-informacion-medium">Seleccione las medidas del contenedor principal en los diferentes tipos de pantalla. El ancho
        total de todas las pantallas es de 12 columnas, las cuales se dividen proporcionalmente de acuerdo al ancho en pixeles de la pantalla, de la misma manera trabaja cada contenedor incluido en su interfaz.</p>
        <div class="col s12 m4">
        <label>Pantalla pequeña</label>
        <input id="clase-ancho-s" type="number" value="12" class="validate" min="1" max="12">
        </div>

        <div class="col s12 m4">
        <label>Pantalla mediana</label>
        <input id="clase-ancho-m" type="number" value="12" class="validate" min="1" max="12">
        </div>

        <div class="col s12 m4">
        <label>Pantalla grande</label>
        <input id="clase-ancho-l" type="number" value="12" class="validate" min="1" max="12">
        </div>

        <p class="texto-informacion-medium">Establezca el tamaño del relleno (en pixeles) de cada uno de los lados del contenedor.</p>

        <div class="input-field col s6 m3">
        <i class="prefix fa fa-hand-o-left texto-informacion-medium"></i>
        <input id="input-padding-left" type="number" value="0" class="validate" min="0">
        </div>

        <div class="input-field col s6 m3">
        <i class="prefix fa fa-hand-o-down texto-informacion-medium"></i>
        <input id="input-padding-down" type="number" value="0" class="validate" min="0">
        </div>

        <div class="input-field col s6 m3">
        <i class="prefix fa fa-hand-o-right texto-informacion-medium"></i>
        <input id="input-padding-right" type="number" value="0" class="validate" min="0">
        </div>

        <div class="input-field col s6 m3">
        <i class="prefix fa fa-hand-o-up texto-informacion-medium"></i>
        <input id="input-padding-up" type="number" value="0" class="validate" min="0">
        </div>

        <div class="input-field col s12">
            <input type="text" value="" readonly="readonly" class="kolorPicker col s2 m1">
            <input type="hidden" value="#FFFFFF" id="background-color">
            <div class="view-color-background col s10 m11">.</div>
        </div>
        <!--<input type="text" value="#FFFFFF" class="kolorPicker">-->
</form>
<div id="contenido-footer-prop-contenedor-1"><a href="#!" class="modal-action waves-effect waves-teal btn-flat " onclick="establecerPropiedadesContenedor('contenedor-1','propiedades-contenedor-1');">Guardar</a></div>
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
                <input type="text" name="nombre" id="nombre" value="Nuevo contenido">
            </div>

            <p>Seleccione los roles en los cuales será visible el contenido a crear.</p>
            <p>
              <input type="checkbox" id="administrador" name="administrador" />
              <label for="administrador">Administrador</label>
            </p>
            <p>
              <input type="checkbox" id="evaluador" name="evaluador"/>
              <label for="evaluador">Evaluador</label>
            </p>
            <p>
              <input type="checkbox" id="investigador" name="investigador"/>
              <label for="investigador">Investigador</label>
            </p>
            <p>
              <input type="checkbox" id="sin_sesion" name="sin_sesion"/>
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