<editor-fold desc="Vista desktop">

    <div class="hide-on-small-only">
        <div class="btn-left-desktop btn-slide-info"><i class="mdi-av-skip-previous"></i></div>
        <div class="col s12">
        @foreach ($perfiles as $perfil)
            @if($contProyectos % 3 == 0)
            <div class="col s12 {{$class}}">
                @if($class == "visible")
                    <?php $class = "invisible"; ?>
                @endif
            @endif
            <?php $contProyectos++; ?>
            @include('plantillas/infoPerfil')
            @if($contProyectos % 3 == 0)
            </div>
            @endif

            @endforeach

            @if($contProyectos % 3 != 0)
                </div>
            @endif
        </div>
        <div class="btn-right-desktop btn-slide-info"><i class="mdi-av-skip-next"></i></div>
        <?php $class = "visible"; ?>
        </div>

</editor-fold>


<editor-fold desc="Vista movil">

    <div class="hide-on-med-and-up col s12">
    <div class="btn-left-movil btn-slide-info"><i class="mdi-av-skip-previous"></i></div>
    @foreach ($perfiles as $perfil)
            <div class="col s12 {{$class}}" style="padding: 0px !important;">
                @if($class == "visible")
                    <?php $class = "invisible"; ?>
                @endif
                @include('plantillas/infoPerfil')
        </div>

    @endforeach
    <div class="btn-right-movil btn-slide-info"><i class="mdi-av-skip-next"></i></div>
    </div>

</editor-fold>