<div class="col s12">
    @if(count($eventos))
    <table class="bordered responsive-table highlight no-striped centered">
        <thead>
            <tr>
                <th width="15%">Título</th>
                <th width="50%">Descripción corta</th>
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
            @foreach($eventos as $e)
                <tr class="texto-informacion-medium" data-evento="{{$e->id}}">
                    <td>{{$e->eve_titulo}}</td>
                    <td>{{$e->eve_descripcion_corta}}</td>
                    <td>{{date("Y-m-d",strtotime($e->eve_fecha_creacion))}}</td>
                    <td>
                        @if($estado)
                            @if($e->eve_estado == "habilitado")
                                <a class="btn-flat white-text red darken-2 waves-effect waves-light cambiar-estado-evento">Inhabilitar</a>
                            @else
                                <a class="btn-flat white-text teal waves-effect waves-light cambiar-estado-evento">Habilitar</a>
                            @endif
                        @else
                            {{$e->eve_estado}}
                        @endif
                    </td>

                    @if($editar)
                        <td>
                            <a href="{{url('/eventos/editar/'.$e->id)}}"><i class="material-icons teal-text">play_arrow</i></a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p class="center texto-informacion-medium">No hay eventos para mostrar</p>
    @endif
</div>