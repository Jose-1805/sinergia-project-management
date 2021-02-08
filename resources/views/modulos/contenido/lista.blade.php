<div class="col s12">
    @if(count($contenidos))
    <table class="bordered responsive-table highlight no-striped centered">
        <thead>
            <tr>
                <th width="15%">Nombre</th>
                <th width="50%">Usuarios</th>
                <th>Fecha de creación</th>
                <th>
                    @if($estado)
                        Cambiar estado
                    @else
                        Estado
                    @endif
                </th>
                @if($editar)
                    <th>Editar</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @foreach($contenidos as $c)
                <tr class="texto-informacion-medium" data-contenido="{{$c->id}}">
                    <td>{{$c->con_nombre}}</td>
                    <td>
                        <ul>
                            @foreach($c->arrayNameRoles() as $name)
                                <li>{{$name}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{date("Y-m-d",strtotime($c->created_at))}}</td>
                    <td>
                        @if($estado)
                            @if($c->con_estado == "habilitado")
                                <a class="btn-flat white-text red darken-2 waves-effect waves-light cambiar-estado-contenido">Inhabilitar</a>
                            @else
                                <a class="btn-flat white-text teal waves-effect waves-light cambiar-estado-contenido">Habilitar</a>
                            @endif
                        @else
                            {{$c->con_estado}}
                        @endif
                    </td>

                    @if($editar)
                        <td>
                            <a href="{{url('/contenido/editar/'.$c->id)}}"><i class="material-icons teal-text">play_arrow</i></a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p class="center texto-informacion-medium">No hay contenidos para mostrar</p>
    @endif
</div>