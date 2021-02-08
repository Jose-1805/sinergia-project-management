@section('css')
@parent
    <style>
        input[type=text]:disabled, input[type=text][readonly="readonly"], input[type=password]:disabled, input[type=password][readonly="readonly"], input[type=email]:disabled, input[type=email][readonly="readonly"], input[type=url]:disabled, input[type=url][readonly="readonly"], input[type=time]:disabled, input[type=time][readonly="readonly"], input[type=date]:disabled, input[type=date][readonly="readonly"], input[type=datetime-local]:disabled, input[type=datetime-local][readonly="readonly"], input[type=tel]:disabled, input[type=tel][readonly="readonly"], input[type=number]:disabled, input[type=number][readonly="readonly"], input[type=search]:disabled, input[type=search][readonly="readonly"], textarea.materialize-textarea:disabled, textarea.materialize-textarea[readonly="readonly"] {
            color: rgba(0,0,0,1);
            border-bottom: 1px dotted rgba(0,0,0,0);
        }

        .input-field label {
            color: rgba(0,0,0,0.6);
        }

        input[type=text]:disabled+label, input[type=text][readonly="readonly"]+label, input[type=password]:disabled+label, input[type=password][readonly="readonly"]+label, input[type=email]:disabled+label, input[type=email][readonly="readonly"]+label, input[type=url]:disabled+label, input[type=url][readonly="readonly"]+label, input[type=time]:disabled+label, input[type=time][readonly="readonly"]+label, input[type=date]:disabled+label, input[type=date][readonly="readonly"]+label, input[type=datetime-local]:disabled+label, input[type=datetime-local][readonly="readonly"]+label, input[type=tel]:disabled+label, input[type=tel][readonly="readonly"]+label, input[type=number]:disabled+label, input[type=number][readonly="readonly"]+label, input[type=search]:disabled+label, input[type=search][readonly="readonly"]+label, textarea.materialize-textarea:disabled+label, textarea.materialize-textarea[readonly="readonly"]+label {
            color: rgba(0,0,0,0.6);
        }
    </style>
@stop
<p class="tituloPrincipalPag tituloGrande">Sugerencia - {{$sugerencia->sug_elemento_nombre}}</p>
<div class="col s12 white" style="padding: 30px 10px;">
    <p class="titulo">Detalle de sugerencia</p>
    <p style="margin-bottom: 40px; margin-top: -10px;" class="comprimible">{{$sugerencia->sug_descripcion}}</p>

    @if($sugerencia->sug_estado == "revisado")
        <p class="center texto-informacion-medium">Esta sugerencia ha sido marcada como revisada.</p>
    @else
        <?php
            $personaLider = $sugerencia->proyecto->proyectoInvestigativo->investigadorLider->persona;
            $infoShow = false;
            $mostrarRespuesta = true;
        ?>
        @if(\App\Models\Sistema::getSiglaRolActual()== "inv" && $personaLider->id == \Illuminate\Support\Facades\Session::get('idPersona') )
            @if($sugerencia->proyecto_estado == $sugerencia->proyecto->pro_estado && $sugerencia->proyecto->pro_estado == "propuesta aprobada")
                @if($sugerencia->sug_elemento_nombre == 'producto')
                    <?php
                        $producto = \App\Models\Producto::find($sugerencia->sug_elemento_id);
                        if(!$producto || $producto->pro_estado == "delete"){
                            echo "<p class='center texto-informacion-medium'>El producto relacionado con esta sugerencia ha sido eliminado.</p>";
                            $mostrarRespuesta = false;
                        }else{
                            $mostrarRespuesta = true;
                            ?>@include('roles.inv.modulos.sugerenciaProducto',array("disabled"=>""))<?php
                        }
                    ?>
                @elseif($sugerencia->sug_elemento_nombre == 'rubro')
                    <?php
                        $rubro = \App\Models\Rubro::find($sugerencia->sug_elemento_id);
                        if(!$rubro || $rubro->rub_estado == "delete"){
                            echo "<p class='center texto-informacion-medium'>El rubto relacionado con esta sugerencia ha sido eliminado.</p>";
                            $mostrarRespuesta = false;
                        }else{
                            $mostrarRespuesta = true;
                            ?>@include('roles.inv.modulos.sugerenciaRubro',array("disabled"=>""))<?php
                        }
                    ?>
                @elseif($sugerencia->sug_elemento_nombre == 'actividad')
                    <?php
                        $actividad = \App\Models\Actividad::find($sugerencia->sug_elemento_id);
                        if(!$actividad || $actividad->act_estado == "delete"){
                            echo "<p class='center texto-informacion-medium'>La actividad relacionada con esta sugerencia ha sido eliminada.</p>";
                            $mostrarRespuesta = false;
                        }else{
                            $mostrarRespuesta = true;
                            ?>@include('roles.inv.modulos.sugerenciaActividad',array("disabled"=>""))<?php
                        }
                    ?>
                @elseif($sugerencia->sug_elemento_nombre == 'componente')
                    <?php
                        $componente = \App\Models\Componente::find($sugerencia->sug_elemento_id);
                        if(!$componente || $componente->com_estado == "delete"){
                            echo "<p class='center texto-informacion-medium'>El componente relacionado con esta sugerencia ha sido eliminado.</p>";
                            $mostrarRespuesta = false;
                        }else{
                            $mostrarRespuesta = true;
                            ?>@include('roles.inv.modulos.sugerenciaComponente',array("disabled"=>""))<?php
                        }
                    ?>
                @else
                    @include('roles.inv.modulos.sugerenciaGeneral',array("disabled"=>""))
                @endif
                <?php $infoShow = true; ?>
            @else
                @if($sugerencia->proyecto->pro_estado == "propuesta aprobada")
                    <p>El estado actual de este perfil o proyecto no permite el desarrollo de esta sugerencia.</p>
                @endif
            @endif
        @endif

        @if(!$infoShow)
            <div class="col s12 divider grey ligthen-3" style="margin-bottom: 20px;"></div>
            @if($sugerencia->sug_elemento_nombre == 'producto')
                @include('roles.inv.modulos.sugerenciaProducto',array("disabled"=>"disabled"))
            @elseif($sugerencia->sug_elemento_nombre == 'rubro')
                @include('roles.inv.modulos.sugerenciaRubro',array("disabled"=>"disabled"))
            @elseif($sugerencia->sug_elemento_nombre == 'actividad')
                @include('roles.inv.modulos.sugerenciaActividad',array("disabled"=>"disabled"))
            @elseif($sugerencia->sug_elemento_nombre == 'componente')
                @include('roles.inv.modulos.sugerenciaComponente',array("disabled"=>"disabled"))
            @else
                @include('roles.inv.modulos.sugerenciaGeneral',array("disabled"=>"disabled"))
            @endif
        @endif

        @if(isset($mostrarRespuesta) && $mostrarRespuesta)
        <p class="tituloPrincipalPag tituloMediano">Respuestas</p>
        <?php
            $respuestas = $sugerencia->respuestas;
        ?>
        <div class="col s12 white lighten-5" style="border: 1px solid rgba(99,99,99,0.1);">
            @if($respuestas && count($respuestas))
                    <ul class="collection" id="contenedor-respuestas" style="overflow-y: auto; min-height: 200px; max-height: 600px;">
                        @foreach($respuestas as $respuesta)
                            <li class="collection-item avatar">
                                  <img src="{{\App\Models\Sistema::getPathImgPerfil($respuesta->persona_id)}}" alt="Imagen de perfil" class="circle">
                                  <?php $per = $respuesta->persona; ?>
                                  <a class="teal-text texto-informacion-medium" target="_blank" href="{{url("/perfil/view/".\Illuminate\Support\Facades\Crypt::encrypt($per->id))}}">{{$per->per_nombres." ".$per->per_apellidos}}</a>
                                  <p class="texto-informacion-medium">{{$respuesta->res_sug_respuesta}}</p>
                                  <br>
                                  <?php $fecha = explode("-",date("r",strtotime($respuesta->created_at)))[0]; ?>
                                  <p class="right-align texto-informacion-small teal-text">{{$fecha}}</p>
                            </li>
                        @endforeach
                    </ul>
            @else
                <p class="texto-informacion-medium center">No existen respuestas en esta sugerencia.</p>
            @endif

            <div>
                <form id="form-respuesta">
                    <div class="input-field col s12" style="margin-top: 30px;">
                        <label for="respuesta" class="active">Responder</label>
                        <textarea id="respuesta" name="respuesta" class="materialize-textarea" length="2000" maxlength="2000"> </textarea>
                    </div>

                    <input type="hidden" name="sugerencia" id="sugerencia" value="{{\Illuminate\Support\Facades\Crypt::encrypt($sugerencia->id)}}" >
                </form>
                <div class="right-align col s12 contenedor-botones-respuesta" style="padding-right: 10px; padding-bottom: 10px; margin-top: 30px;">
                    @if($sugerencia->persona_id == \Illuminate\Support\Facades\Session::get("idPersona"))
                        <a class="btn teal white-text waves-effect waves-light modal-trigger" href="#modal-revisada">Sugerencia Revisada</a>
                    @endif
                    <a class="btn teal white-text waves-effect waves-light" onclick="enviarRespuestaSugerencia()">Enviar</a>
                </div>

                <div class="progress progress-respuesta invisible">
                    <div class="indeterminate"></div>
                </div>
            </div>
        </div>

        <div id="modal-revisada" class="modal modal-fixed-footer" style="max-height: 300px; height:200px; margin-top: 110px;">
            <div class="modal-content">
                <p class="teal-text tituloMediano">¿Esta seguro de marcar esta sugerencia como revisada?</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-orange btn-flat" onclick="sugerenciaRevisada()">Ok</a>
                <a href="#!" class="modal-close waves-effect waves-orange btn-flat modal-close">Cancelar</a>
            </div>
        </div>
        @endif
    @endif
</div>

@section('js')
@parent
     <script src="{{asset('Js/inv/perfil/sugerencia.js')}}"></script>
     <script>
     inicializarMaterializacss();
     $(function(){
        $("#contenedor-respuestas").animate({ scrollTop: $('#contenedor-respuestas')[0].scrollHeight}, 1000);
     })
     </script>
@stop
