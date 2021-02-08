@section('js')
<script src="{{asset('/Js/contenido.js')}}"></script>
@stop

<p class="tituloMediano tituloPrincipalPag">Administración de contenido</p>
<div class="col s12 white" style="padding: 20px 10px;">
<a href="{{url("/contenido/nuevo")}}" class="tooltipped btn-floating-1 btn-floating waves-effect waves-light teal" data-position="bottom" data-delay="50" data-tooltip="Agregar contenido"><i class="material-icons">add</i></a>
@include('modulos.contenido.lista')

<?php echo $contenidos->render(); ?>
</div>