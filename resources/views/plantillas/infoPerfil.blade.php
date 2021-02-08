<?php
    $proponente  = $perfil->proyectoInvestigativo->investigadorLider->persona;
?>
<div class="col s12 m4 l4">
                    <div class="col s12 waves-effect waves-darken btnPerfil {{$classBtnPerfil}} btnDataProyecto" href="#{{$idModal}}">
                        <h5 class="truncate">{{$perfil->pro_titulo}}</h5>
                        <p>{{$perfil->pro_objetivo_general}}</p>
                        <input type="hidden" class="idPerfil" value="{{\Illuminate\Support\Facades\Crypt::encrypt($perfil->id)}}"/>
                    </div>

                    <div class="col s12 left-align" style="background-color: rgba(255,255,255,.5); color: #238276; margin-bottom: 20px; padding: 5px 15px;">
                        <small><strong>Por:</strong> {{ $proponente->per_nombres." ".$proponente->per_apellidos }}</small><br>
                        <small><strong>Fecha:</strong> {{ date('Y-m-d', strtotime($perfil->created_at)) }}</small>
                    </div>
                </div>