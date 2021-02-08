<div id="contenedor-perfil-editar">
    <!-- DIV QUE CONTIENE LO QUE MUESTRA EL TITULO DEL MODULO -->
    <div class="col s12 m8 offset-m2" style="background-color: #FFF;margin-top: 80px;">
        <p >Para actualizar la información de su perfil ingrese el código que fue asignado al mismo en
        el proceso de registro, una vez identificado el proyecto se listará la información editable de su perfil.</p>
    </div>

    <div class="col s12 m8 offset-m2" style="background-color: #FFF;margin-bottom: 100px;padding-bottom: 20px;">
        <div class="input-field">
            <label for="codigo-perfil">Código</label>
            <input type="password"  id="codigo-perfil" name="codigo-perfil" maxlength="45" required/>
        </div>
        <div class="right">
            <a class="btn teal darken-1 texto-blanco" id="btn-buscar-perfil">enviar</a>
        </div>

        <div class="progress invisible">
            <div class="indeterminate"></div>
        </div>
    </div>
</div>

@section('js')
@parent
    <script src="{{asset('Js/editarPerfil.js')}}"></script>
@stop