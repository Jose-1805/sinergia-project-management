@include('plantillas.camposFormEntidad')

<div class="col s12">
    <p class="tituloMediano">Aporte</p>
    <div class="col s12 divider teal lighten-2" style="margin-top: 0px;margin-bottom: 25px;"></div>


    <div class="divider col s12 transparent"></div>
    <div class="input-field col s12 l6">
        <input type="text" name="aporte" id="aporte">
        <label from="aporte">Aporte</label>
    </div>

    <input type="hidden" name="proyecto" id="proyecto" value="{{\Illuminate\Support\Facades\Crypt::encrypt($proyecto->id)}}">

    <div class="contenedor_botones col s12">
        <a class="btn col s12 teal darken-1 texto-blanco" onclick="crearEntidad()">Guardar</a>
    </div>

    <div class="progress invisible" id="progress_botones">
        <div class="indeterminate"></div>
    </div>
</div>
