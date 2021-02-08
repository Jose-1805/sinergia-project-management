@section('js')
<script src="{{asset('/Js/eventos.js')}}"></script>
@stop

<p class="tituloMediano tituloPrincipalPag">Administración de eventos</p>
<div class="col s12 white" style="padding: 20px 10px;">
<a href="{{url("/eventos/crear")}}" class="tooltipped btn-floating-1 btn-floating waves-effect waves-light teal" data-position="bottom" data-delay="50" data-tooltip="Agregar evento"><i class="material-icons">add</i></a>
@include('modulos.eventos.lista')

<?php echo $eventos->render(); ?>
</div>