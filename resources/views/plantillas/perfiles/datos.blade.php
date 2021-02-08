<?php
    $proponente = $perfil->proyectoInvestigativo->investigadorLider->persona;
?>
<p class="tituloPrincipalPag tituloGrande">{{$perfil->pro_titulo}}</p>

<input type="hidden" name="idPerfil" id="idPerfil" value="{{\Illuminate\Support\Facades\Crypt::encrypt($perfil->id)}}"/>
@if($perfil->pro_estado == "proyecto en desarrollo" || $perfil->pro_estado == "proyecto aprobado")
<div class="hide-on-small-only contenedor-opciones-titulo col s12" style="margin-top: -75px;">
    @if($perfil->pro_estado == "proyecto en desarrollo")
        <div class="right" style="display: inline-block; cursor:pointer;margin: 0px 5px;">
            <a target="_blank" href="{{url('/proyecto/reporte-grafico/'.\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}"><i class="mdi-action-assessment small orange-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Reporte gráfico"></i></a>
        </div>
    @endif

    <div class="right" style="display: inline-block; cursor:pointer;margin: 0px 5px;">
        <a target="_blank" href="{{url('/proyecto/reporte-informacion/'.\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}"><i class="mdi-action-description small orange-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Reporte de información"></i></a>
    </div>

    <div class="right" style="display: inline-block; cursor:pointer;margin: 0px 5px;">
        <a target="_blank" href="{{url('/proyecto/grupo/'.\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}"><i class="mdi-social-people small orange-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Grupo"></i></a>
    </div>

    <div class="right" style="display: inline-block; cursor:pointer;margin: 0px 5px;">
        <a target="_blank" href="{{url('/proyecto/entidades/'.\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}"><i class="mdi-social-domain small orange-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Entidades"></i></a>
    </div>
</div>


<div class="col s12 hide-on-med-and-up">
    @if($perfil->pro_estado == "proyecto en desarrollo")
        <div class="right" style="display: inline-block; cursor:pointer;margin: 0px 5px;">
            <a target="_blank" href="{{url('/proyecto/reporte-grafico/'.\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}"><i class="mdi-action-assessment small orange-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Reporte gráfico"></i></a>
        </div>
    @endif

    <div class="right" style="display: inline-block; cursor:pointer;margin: 0px 5px;">
        <a target="_blank" href="{{url('/proyecto/reporte-informacion/'.\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}"><i class="mdi-action-description small orange-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Reporte de información"></i></a>
    </div>

    <div class="right" style="display: inline-block; cursor:pointer;margin: 0px 5px;">
        <a target="_blank" href="{{url('/proyecto/grupo/'.\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}"><i class="mdi-social-people small orange-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Grupo"></i></a>
    </div>

    <div class="right" style="display: inline-block; cursor:pointer;margin: 0px 5px;">
        <a target="_blank" href="{{url('/proyecto/entidades/'.\Illuminate\Support\Facades\Crypt::encrypt($perfil->id))}}"><i class="mdi-social-domain small orange-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Entidades"></i></a>
    </div>
</div>
@endif

<div class="col s12 m7">
    <div class="col s12">
        <p class="titulo col s12 l4 ">Objetivo general</p>
        <p class="col s12 l8 comprimible">{{$perfil->pro_objetivo_general}}</p>
        <div class="col s12 divider teal" style="margin-bottom: 20px;"></div>
    </div>

    <div class="col s12">
        <p class="titulo s12 col l4">Problema</p>
        <p class="col s12 l8 comprimible">{{$perfil->proyectoInvestigativo->pro_inv_problema}}</p>
        <div class="col s12 divider teal" style="margin-bottom: 20px;"></div>
    </div>


    <div class="col s12">
        <p class="titulo s12 col l4">Justificación</p>
        <p class="col s12 l8 comprimible">{{$perfil->pro_justificacion}}</p>
        <div class="col s12 divider teal" style="margin-bottom: 20px;"></div>
    </div>


    <div class="col s12">
        <p class="titulo s12 col l4">Presupuesto</p>
        <p class="col s12 l8">$ {{number_format(doubleval($perfil->pro_presupuesto_estimado), 0, ',', '.')}}</p>
        <div class="col s12 divider teal" style="margin-bottom: 20px;"></div>
    </div>


    <div class="col s12">
        <p class="titulo s12 col l4">Sector</p>
        <p class="col s12 l8" style="margin-bottom: 50px;">{{$perfil->proyectoInvestigativo->pro_inv_sector}}</p>
        <div class="col s12 divider teal" style="margin-bottom: 20px;"></div>
    </div>

    @if($perfil->pro_fecha_inicio)
        <div class="col s12">
            <p class="titulo s12 col l4">Fecha de inicio</p>
            <p class="col s12 l8" style="margin-bottom: 50px;">{{date("Y-m-d",strtotime($perfil->pro_fecha_inicio))}}</p>
        </div>
    @endif
</div>

<div class="col s12 m5">
    <div class="col s12 z-depth-1 autoFixed" style="background-color: rgba(255,255,255,.9);">
        <p class="col s12 tituloMediano" >Datos del proponente</p>

        <div class="col s12">
            <p class="titulo s12 col l4">Nombre</p>
            <p class="col s12 l8" >{{$proponente->per_nombres . ' ' . $proponente->per_apellidos}}</p>
            <div class="col s12 divider teal" style="margin-bottom: 15px;"></div>
        </div>

        <div class="col s12">
            <p class="titulo s12 col l4">Correo</p>
            <p class="col s12 l8" >{{$proponente->per_correo}}</p>
            <div class="col s12 divider teal" style="margin-bottom: 15px;"></div>
        </div>

        <div class="col s12">
            <p class="titulo s12 col l4">Tipo</p>
            <p class="col s12 l8" >{{$proponente->investigador->inv_tipo}}</p>
            <div class="col s12 divider teal" style="margin-bottom: 15px;"></div>
        </div>
    </div>
</div>



@if(count($perfil->proyectoInvestigativo->lineasInvestigacion))
    <div class="col s12">
        <p class="titulo">Lineas de investigación</p>
        <ul class="collection">
            @foreach($perfil->proyectoInvestigativo->lineasInvestigacion as $linea)
                <li class="collection-item">{{$linea->lin_inv_nombre}}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(count($perfil->proyectoInvestigativo->componentes))
<p class="titulo tituloPrincipalPag col s12">Componentes</p>
<div class="col s12">
    <ul class="collapsible popout" data-collapsible="accordion" style="background-color: transparent;">
        @foreach($perfil->proyectoInvestigativo->componentes as $componente)
        @if($componente->com_estado != "delete")
        <li>
          <div class="collapsible-header">{{$componente->com_nombre.' - '.$componente->com_estado}}</div>
          <div class="collapsible-body">
            <p class="titulo">Objetivo</p>
            <p>{{$componente->com_objetivo}}</p>

            <p class="col s12 titulo" style="margin-top: 30px;">Equivalente</p>
            <p>{{$componente->com_equivalente." %"}}</p>
            @if(count($componente->actividades))
                <div class="collection" style="margin-top: 50px;">
                    <?php $cont = 1; ?>
                    @foreach($componente->actividades as $actividad)
                        @if($actividad->act_estado != "delete")
                         <a href="{{url('/').'/actividad/view/'.\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}" class="collection-item" style="padding: 20px 10px;" target="_blank">Actividad {{$cont}}</a>
                         <?php $cont++; ?>
                        @endif
                    @endforeach
                </div>
            @endif
          </div>
        </li>
        @endif
        @endforeach
      </ul>
</div>
@endif