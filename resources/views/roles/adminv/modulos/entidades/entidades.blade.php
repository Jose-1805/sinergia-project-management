<form>
    <a class="btn nuevo" href="nuevaentidad">NUEVA ENTIDAD</a>
    <BR>
    <BR>
    @if(!empty($entidades))
        <table>
            <caption class="tituloPrincipalPag tituloGrande">ENTIDADES REGISTRADAS EN EL SISTEMA</caption>
            <thead>
            <tr>
                <th>Tipo de identificación</th>
                <th>Nombre</th>
                <th>Sector</th>
                <th>Estado</th>
                <th>Editar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($entidades as $ent)
                <tr>
                    <td>
                        {{$ent->ent_tipo_identificacion}}
                    </td>
                    <td>
                        {{$ent->ent_nombre}}
                    </td>
                    <td>
                        {{$ent->ent_sector}}
                    </td>
                    <td>
                        {{$ent->ent_estado}}
                    </td>
                    <td>
                        <a class="btn" href="ver-entidad/{{$ent->id}}" id="{{$ent->id}}">Ver Mas</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</form>
