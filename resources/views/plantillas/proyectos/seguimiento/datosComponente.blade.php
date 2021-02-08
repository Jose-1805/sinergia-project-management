@if($componente->com_estado != "delete")
    <li>
      <div class="collapsible-header teal-text text-darken-1"><i class="mdi-action-dashboard orange-text darken-1"></i>{{$componente->com_nombre." - (".$componente->com_estado.")"}}</div>
      <div class="collapsible-body">
        <p><strong>Objetivo del componente</strong></p>
        <p class="comprimible">{{$componente->com_objetivo}}</p>

        <p><strong>Equivalente:</strong> {{$componente->com_equivalente." %"}}</p>
        <br><br>
        @if($componente->actividades)
            <?php $aux = 0; ?>
            @foreach($componente->actividades as $a)
                @if($a->act_estado != "delete")
                    <?php $aux++; ?>
                @endif
            @endforeach

            @if($aux > 0)
            <p class=""><strong>Lista de actividades iniciadas</strong></p>
                <div class="collection">
                    <?php $i = 0; ?>
                    @foreach($componente->actividades as $actividad)
                        <?php $i++; ?>
                        @if($actividad->act_estado == "iniciado")
                            <a href="#modal-actividad" id="link_actividad{{$actividad->id}}" class="collection-item modal-trigger show-actividad" data-act="{{\Illuminate\Support\Facades\Crypt::encrypt($actividad->id)}}" style="padding: 20px 10px;">Actividad {{$i}}</a>
                        @else
                           <?php $i--; ?>
                        @endif
                    @endforeach
                    @if($i == 0)
                        <p>No existen actividades iniciadas para este componente.</p>
                    @endif
                </div>
            @endif
        @else
            <p class="col s12 texto-rojo center">No es posible realizar un seguimiento a este componente, no existen actividades relacionadas.</p>
        @endif
      </div>
    </li>
@endif