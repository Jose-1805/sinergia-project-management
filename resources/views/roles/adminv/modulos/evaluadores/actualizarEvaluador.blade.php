<style xmlns="http://www.w3.org/1999/html">
    fieldset > ul {
        margin: 5px;
        border: 1px solid #ff9f49;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.69);
    }

    h5 span {
        float: right;
    }

    .msj-error {
        display: block;
        background: rgba(255, 0, 0, 0.48);
        border: 1px solid rgba(255, 0, 0, 0.48);
        border-radius: 5px;
        margin: 20px;
        padding: 30px;
        font-size: 10px;
    }

    .msj-error li {
        list-style: circle;
    }

    .collapsible-body p {
        margin: 0px;
        padding: 0px;
    }
</style>

{{--Formulario para ingresar los datos de la nueva Entidad--}}
<form id="formActualizarEvaluador" class="col s12 m10"
      style="">

    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <input type="hidden" value="{{$datos->idEva}}" name="evaluador_id"/>

    <div id="contenedorDerecho" class="col s12 m12 l12">
        <ul class="collapsible" data-collapsible="accordion">
            <li class="active">
                <div class="collapsible-header tituloPrincipalPag active"><i class="material-icons">info</i>
                    <h5>Datos del Evaluador </h5>
                </div>
                <div class="collapsible-body" style="display: block;">
                    <fieldset>
                        <div class="contenidoDiv">

                            <div class="input-field">
                                <label for="Identidficacion">Identificación<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="number" id="Identidficacion" name="Identidficacion" maxlength="45"
                                       length="45" required="required" value="{{$datos->per_identificacion}}"/>
                            </div>

                            <div class="input-field">
                                <label for="Nombres">Nombres<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="text" id="Nombres" name="Nombres" value="{{$datos->per_nombres}}"
                                       maxlength="45" length="45" required="required" />
                            </div>

                            <div class="input-field">
                                <label for="Apellidos">Apellidos<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="text" id="Apellidos" name="Apellidos" value="{{$datos->per_apellidos}}"
                                       maxlength="45" length="45" required="required" />
                            </div>

                            <div class="input-field">
                                <label for="Telefono">Telefono<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="number" id="Telefono" name="Telefono"
                                       value="{{$datos->per_numero_telefono}}" maxlength="45" length="45" />
                            </div>

                            <div class="input-field">
                                <label for="Celular">Celular<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="number" id="Celular" name="Celular" value="{{$datos->per_numero_celular}}"
                                       maxlength="45" length="45" />
                            </div>

                            <div class="date-field">
                                <label for="FechaDeNacimiento">Fecha de nacimiento<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="date" class="datepicker" id="FechaDeNacimiento"
                                       name="FechaDeNacimiento" value="{{$datos->per_fecha_nacimiento}}"
                                       maxlength="45" length="45" required="required" />
                            </div>

                            <div class="selectize-dropdown">
                                <label>Género
                                    <i class="material-icons texto-rojo">star_rate</i></label>
                                <br>
                                <select id="Genero" name="Genero" required="required">
                                    <option value="0">Femenino</option>
                                    <option value="1">Masculino</option>
                                </select>
                            </div>

                            <div id="divCorreo" class="input-field">
                                <label for="Correo">Correo<i class="material-icons texto-rojo">star_rate</i></label>
                                <input type="email" id="Correo" name="Correo" value="{{$datos->per_correo}}"
                                       AUTOCOMPLETE="ON" maxlength="50"
                                       length="50" required="required"
                                        />
                                <i class="fa fa-pulse" style="float: right; margin-top: -10px;" id="correoLoad"></i>

                                <b>
                                    <p class="texto-error invisible" id="correoError">
                                        Este correo ya esta registrado, ingresa uno nuevo!
                                    </p>
                                </b>
                            </div>

                            <div class="selectize-dropdown">
                                <label>Tipo de Evaluador<i class="material-icons texto-rojo">star_rate</i></label>
                                <br>
                                <select id="TipoDeEvaluador" name="TipoDeEvaluador" required="required">
                                    <option value="Técnico">Técnico</option>
                                    <option value="Tecnólogo">Tecnólogo</option>
                                    <option value="Profesional">Profesional</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </li>
        </ul>
    </div>

    <div class="progress invisible" id="formNuevoPerfilLoad" style="height: 3px;">
        <div class="indeterminate"></div>
    </div>

    <center>

        <input type="submit" id="submit" class="btn" value="ACTUALIZAR EVALUADOR" />
    </center>
    <br/>

    <script>
        $(document).ready(function () {

        });
    </script>

</form>
@section('js')
    @parent
    <script src="{{asset('./Js/adminv/evaluador/evaluadores.js')}}"></script>
@stop