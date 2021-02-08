<form>
    <a class="btn nuevo" href="nuevo-evaluador">NUEVO EVALUADOR</a>
    <BR>
    <BR>
    @if(!empty($evaluadores))
        <table>
            <caption class="tituloPrincipalPag tituloGrande">EVALUADORES REGISTRADOS EN EL SISTEMA</caption>
            <thead>
            <tr>
                <th>IDENTIFICACIÓN</th>
                <th>NOMBRE</th>
                <th>APELLIDOS</th>
                <th>CORREO</th>
                <th>TIPO DE EVALUADOR</th>
            </tr>
            </thead>
            <tbody>
            @foreach($evaluadores as $eva)
                <tr>
                    <td>
                        {{$eva->per_identificacion}}
                    </td>
                    <td>
                        {{$eva->per_nombres}}
                    </td>
                    <td>
                        {{$eva->per_apellidos}}
                    </td>
                    <td>
                        {{$eva->per_correo}}
                    </td>
                    <td>
                        {{$eva->eva_tipo}}
                    </td>

                    <td>
                        <a class="btn" href="ver-evaluador/{{$eva->idEva}}" id="{{$eva->idEva}}">Ver Mas</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</form>
