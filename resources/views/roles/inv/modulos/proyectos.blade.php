
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s13"><a href="#enConvocatoria" class="truncate">Convocatoria</a></li>
                <li class="tab col s13"><a href="#aprobados" class="truncate">Aprobados</a></li>
                <li class="tab col s13"><a href="#enDesarrollo" class="truncate">En desarrollo</a></li>
                <li class="tab col s13"><a href="#descartados" class="truncate">Descartados</a></li>
                <li class="tab col s13"><a href="#cancelados" class="truncate">Cancelados</a></li>
                <li class="tab col s13"><a href="#terminados" class="truncate">Terminados</a></li>
            </ul>
        </div>

        <div class="col s12" id="aprobados">
            @include ('roles.inv.modulos.proyecto.aprobados')
        </div>
        <div class="col s12" id="enDesarrollo">
            @include ('roles.inv.modulos.proyecto.enDesarrollo')
        </div>
        <div class="col s12" id="enConvocatoria">
            @include ('roles.inv.modulos.proyecto.enConvocatoria')
        </div>
        <div class="col s12" id="descartados">
            @include ('roles.inv.modulos.proyecto.descartados')
        </div>
        <div class="col s12" id="terminados">
            @include ('roles.inv.modulos.proyecto.terminados')
        </div>
        <div class="col s12" id="cancelados">
            @include ('roles.inv.modulos.proyecto.cancelados')
        </div>
    </div>