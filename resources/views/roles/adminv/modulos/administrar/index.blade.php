@section('css')
@parent
    <link rel="stylesheet" href="{{asset('Css/administrar.css')}}">
@stop

<p class="tituloMediano tituloPrincipalPag" style="margin-bottom: 40px;">Administración del sistema</p>

<div class="contenedor-opciones">
    <div class="contenedor-opcion waves-effect waves-light dropdown-button" data-activates='dropdowncontenido'>
            <i class="material-icons">subject</i>
            <h3>Contenido</h3>
            <p>
            Seleccione esta opción para administrar la información que se muestra en pantalla a los usuarios.
            </p>
   </div>

   <ul id='dropdowncontenido' class='dropdown-content'>
               <li><a href="{{url('/contenido/establecer')}}">Establecer</a></li>
               <li><a href="{{url('/contenido/administrar')}}">Administrar</a></li>
             </ul>

    <div class="contenedor-opcion waves-effect waves-light dropdown-button" data-activates='dropdowneventos'>
        <i class="material-icons">today</i>
        <h3>Eventos</h3>
        <p>
        Seleccione esta opción para establecer y administrar los eventos que se deben ver en la pantalla de iniico del sistema.
        </p>
    </div>

    <ul id='dropdowneventos' class='dropdown-content'>
            <li><a href="{{url('/eventos/establecer')}}">Establecer</a></li>
            <li><a href="{{url('/eventos/administrar')}}">Administrar</a></li>
          </ul>

    <div class="contenedor-opcion waves-effect waves-light dropdown-button" data-activates='dropdownusuarios'>
            <i class="material-icons">supervisor_account</i>
            <h3>Usuarios</h3>
            <p>
            Seleccione esta opción para administrar la información de los usuarios del sistema según su rol.
            </p>
    </div>

    <ul id='dropdownusuarios' class='dropdown-content'>
        <li><a href="{{url('/adminv/investigadores')}}">Investigadores</a></li>
        <li><a href="{{url('/adminv/evaluadores')}}">Evaluadores</a></li>
    </ul>


    <div class="contenedor-opcion waves-effect waves-light">
        <a class="" href="{{url('/adminv/entidades')}}">
            <i class="material-icons">business</i>
            <h3 class="negro">Entidades</h3>
            <p>
            Seleccione esta opción para administrar las entidades registradas o a registrar en el sistema.
            </p>
        </a>
    </div>

    <div class="contenedor-opcion waves-effect waves-light">
        <a class="" href="#">
            <i class="material-icons">volume_mute</i>
            <h3 class="negro">Convocatorias</h3>
            <p>
            Seleccione esta opción para administrar las convocatorias registradas o a registrar en el sistema.
            </p>
        </a>
    </div>
</div>