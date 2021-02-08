@if($proponente->id == Session::get('idPersona'))
@if($perfil->pro_estado == "propuesta aprobada" && $perfil->pro_estado_formulacion != "4")
    <a class="btn teal darken-1 texto-blanco col s12 waves-effect" href="/inv/perfil-formular/{{\Illuminate\Support\Facades\Crypt::encrypt($perfil->id)}}" id="btnEnviarAConvocatoria">formular</a>
@elseif($perfil->pro_estado == "propuesta aprobada" && $perfil->pro_estado_formulacion == "4")
    <p class="texto-informacion-medium">Su perfil se encuentra en proceso de analisis por el evaluador asignado, pueden ser asignadas a usted tareas para mejorar la formulación
             o puede suceder que su perfil sea marcado como completo y permanezca a la espera de una convocatoria.</p>
@endif
@endif
@section('js')
@parent
<script src="{{asset('Js/adminv/perfil/aprobadoCompleto.js')}}"></script>
@stop