@section('js')
           <script src="{{asset('/Js/eventos.js')}}"></script>
       @stop
       <p class="titulo tituloPrincipalPag tituloMediano">Crear evento</p>
       <form id="form-crear-evento" enctype="multipart/form-data">
           <p class="col s12 m5 l4 texto-informacion-medium">Los eventos registrados serán vistos en la vista principal del sistema siempre y cuando
           su estado este habilitado y sus datos de creación correspondan al rango o filtro de vista establecido. Puede cargar el maximo 8 imagenes, la primera imagen que seleccione será
           la imagen principal que se mostrará en la vista principal.</p>
           <div class="col s12 m7 l8 white" style="padding: 30px 20px;">
               @include('modulos.eventos.campos')
               <div id="contenedor-imagenes" style="margin-top: 60px;" class="contenedor-imagenes col s12">
               </div>
               <div class="col s12" style="margin-top: 40px;" id="contenedor-botones-nuevo-evento">
                   <a class="btn teal white-text right" onclick="guardarEvento();">Guardar</a>
                   <a class="btn teal white-text right" onclick="agregarImagen();">Agregar imagen</a>
               </div>
               <div class="progress invisible" id="progress-nuevo-evento">
                   <div class="indeterminate"></div>
               </div>
           </div>
       </form>