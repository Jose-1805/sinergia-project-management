<form>
    <a class="btn nuevo" href="nuevo-investigador">NUEVO INVESTIGADOR</a>
    <BR>
    <BR>
    @if(!empty($investigadores))
        <table>
            <caption class="tituloPrincipalPag tituloGrande">INVESTIGADORES REGISTRADOS EN EL SISTEMA</caption>
            <thead>
            <tr>
                <th>IDENTIFICACIÓN</th>
                <th>NOMBRE</th>
                <th>APELLIDOS</th>
                <th>CORREO</th>
                <th>TIPO DE INVESTIGADOR</th>
            </tr>
            </thead>
            <tbody>
            @foreach($investigadores  as $inv)
                <tr>
                    <td>
                        {{$inv->per_identificacion}}
                    </td>
                    <td>
                        {{$inv->per_nombres}}
                    </td>
                    <td>
                        {{$inv->per_apellidos}}
                    </td>
                    <td>
                        {{$inv->per_correo}}
                    </td>
                    <td>
                        {{$inv->inv_tipo}}
                    </td>

                    <td>
                        <a class="btn" href="ver-investigador/{{$inv->idInv}}" id="{{$inv->idInv}}">Ver Mas</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</form>
