<style>
    .card{
        min-height: 400px;
    }
</style>
<div class="row">
    @forelse($eventos as $e)
        <div class="col s12 m6 l4">
            <div class="card">
                <?php
                    $path = public_path('imagenes/eventos/'.$e->id.'/principal.jpg');
                ?>
                @if(file_exists($path))
                    <div class="card-image">
                        <img src="{!! asset('imagenes/eventos/'.$e->id.'/principal.jpg') !!}">
                    </div>
                @endif
                <div class="card-content">
                    <span class="card-title">{{$e->eve_titulo}}</span>
                    <p>{!! $e->eve_descripcion_corta !!}</p>
                </div>
                <div class="card-action">
                    <a href="{!! url('/eventos/evento/'.$e->id) !!}">Ver evento</a>
                </div>
            </div>
        </div>
    @empty
        <p class="center-align">No existen eventos para mostrar</p>
@endforelse
</div>

@section('js')
@parent
    <script src="{{}}"></script>
@stop