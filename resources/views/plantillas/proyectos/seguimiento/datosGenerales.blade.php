<div class="col s12">
    <p class="tituloMediano">{{$proyecto->pro_titulo}}</p>
    <div class="divider grey col s12"></div>
    <div>
        <p class="col s12 m3 l2"><strong>Objetivo general</strong></p>
        <p class="col s12 m9 l10 comprimible truncate">{{$proyecto->pro_objetivo_general}}</p>
    </div>

    <div>
        <p class="col s12 m3 l2"><strong>Problema</strong></p>
        <p class="col s12 m9 l10 comprimible truncate">{{$proyecto->proyectoInvestigativo->pro_inv_problema}}</p>
    </div>

    <div>
        <p class="col s12 m3 l2"><strong>Justificación</strong></p>
        <p class="col s12 m9 l10 comprimible truncate">{{$proyecto->pro_justificacion}}</p>
    </div>

    <div>
        <p class="col s12 m3 l2"><strong>Sector</strong></p>
        <p class="col s12 m9 l10">{{$proyecto->proyectoInvestigativo->pro_inv_sector}}</p>
    </div>

    <div>
        <p class="col s12 m3 l2"><strong>Tipo financiación</strong></p>
        <p class="col s12 m9 l10">{{$proyecto->proyectoInvestigativo->pro_inv_tipo_financiacion}}</p>
    </div>

    <div>
        <p class="col s12 m3 l2"><strong>Fecha inicio</strong></p>
        <p class="col s12 m9 l10">{{$proyecto->pro_fecha_inicio}}</p>
    </div>

    <div>
        <p class="col s12 m3 l2"><strong>Duración</strong></p>
        <p class="col s12 m9 l10">{{$proyecto->pro_duracion." meses"}}</p>
    </div>
</div>