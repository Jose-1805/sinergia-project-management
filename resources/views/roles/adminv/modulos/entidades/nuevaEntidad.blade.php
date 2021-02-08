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
    .dropdown-content{
        overflow: auto;
    }
    .dropdown-content li {
        min-height: 10px;
    }
    .dropdown-content li span{
        padding: 5px !important;
        font-size: small;
    }
</style>

{{--Formulario para ingresar los datos de la nueva Entidad--}}
<form id="formNuevaEntidad" class="col s12 m10"
      style="">

    <h4 colspan="3" class="tituloPrincipalPag tituloGrande" xmlns="http://www.w3.org/1999/html">AQUI VAN LOS DATOS DE LA
        ENTIDAD</h4>
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <style>
            div.bien, div.mal{display: inline-block; color: #fff; margin: 5px; padding: 2px; }
            .bien{ background: green; }
            .mal{ background: red;}
        </style>

        {{--Mustra una ayuda para identificar cuando todo va bien o mal--}}
        <div class="bien">BIEN</div>
        <div class="mal">MAL</div>
    <div id="contenedorDerecho" class="col s12 m12 l12">
        <ul class="collapsible" data-collapsible="accordion">
            <li class="active">
                <div class="collapsible-header tituloPrincipalPag active"><i class="material-icons">info</i>
                    <h5>Datos básicos de la Entidad </h5>
                </div>
                <div class="collapsible-body" style="display: block;">
                    <fieldset>
                        <div class="contenidoDiv">
                            <div class="input-field">
                                <label for="Nombre">Nombre de la Entidad<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="text" id="Nombre" name="Nombre" maxlength="45" length="45"/>

                                <p class="texto-error invisible" id="nombreEntError">Este nombre ya esta registrado!</p>
                            </div>

                            <div class="input-field">
                                <label for="Telefono">Telefono<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="number" id="Telefono" name="Telefono" maxlength="45" length="45"/>
                            </div>

                            <div class="input-field">
                                <label for="Identidficacion">Tipo de identificación<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="text" id="Identidficacion" name="Identidficacion" maxlength="45"
                                       length="45"
                                        />
                            </div>

                            <div class="input-field">
                                <label for="CamaraComercio">Matricula Cámara y Comercio<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="text" id="CamaraComercio" name="CamaraComercio" maxlength="45" length="45"/>
                                <p class="texto-error invisible" id="CamaraComercioError">Este código ya ha sido registrado!</p>
                            </div>

                            <div class="input-field">
                                <label for="SectorEconomico">Sector<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="text" id="SectorEconomico" name="SectorEconomico" maxlength="45" length="45"/>
                            </div>

                            <div class="input-field">
                                <label for="NumeroDeEmpleados">Cantidad de empleados<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="number" id="NumeroDeEmpleados" name="NumeroDeEmpleados" maxlength="45"
                                       length="45"
                                        />
                            </div>

                            <div class="date-field">
                                <label for="FechaDeConstitucion">Fecha de constitución<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="date" class="datepicker" id="FechaDeConstitucion"
                                       name="FechaDeConstitucion"
                                       maxlength="45" length="45"/>
                            </div>
                            {{--<div class="input-field">--}}
                                {{--<label for="Estado">Estado<i--}}
                                            {{--class="material-icons texto-rojo">star_rate</i></label>--}}
                                {{--<input type="text" id="Estado" name="Estado" maxlength="45" length="45"/>--}}
                            {{--</div>--}}
                            <div class="selectize-dropdown">
                                <label>Estado<i class="material-icons texto-rojo">star_rate</i></label>
                                <br>
                                <select id="Estado" name="Estado">
                                    <option value="ejecutora">Ejecutora</option>
                                    <option value="propuesta">Propuesta</option>

                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </li>
            <li>
                <div class="collapsible-header tituloPrincipalPag"><i class="material-icons">info</i><h5>Actividad
                        Económica</h5></div>
                <div class="collapsible-body">
                    <fieldset>
                        <div class="contenidoDiv">
                            <div class="selectize-dropdown">
                                <label>Session Actividad Económica
                                    <i class="material-icons texto-rojo">star_rate</i></label>
                                <br>
                                <select id="seccActEco">
                                    <option value="0">Seleccione</option>
                                    {{--Lista las secciones de actividades económicas--}}
                                    @foreach($listSeccActEcos as $seccActEcos)
                                        <option value="{{$seccActEcos->id}}">{{$seccActEcos->sec_act_descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="selectize-dropdown">
                                <label>División Actividad Económica<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <br>
                                <select id="divacteco">
                                    <option value="0">Seleccione</option>
                                </select>
                            </div>

                            <div class="selectize-dropdown">
                                <label>Actividad Económica<i class="material-icons texto-rojo">star_rate</i></label>
                                <br>
                                <select id="entActividadEco" name="entActividadEco">
                                    <option value="0">Seleccione</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </li>
            <li>
                <div class="collapsible-header tituloPrincipalPag active"><i class="material-icons">info</i><h5>
                        Localización de la Entidad </h5></div>
                <div class="collapsible-body">
                    <fieldset id="localizacion">
                        <div class="contenidoDiv">
                            <fieldset>
                                <div class="selectize-dropdown" style="width: 45%; display: inline-block">
                                    <label>Departamento<i class="material-icons texto-rojo">star_rate</i></label>
                                    <br>
                                    <select id="DepartamentoDeLocalizacion" name="DepartamentoDeLocalizacion">
                                        <option value="0">Seleccione</option>
                                        @foreach($listaDep as $dep)
                                            <option value="{{$dep->id}}">{{$dep->dep_nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="selectize-dropdown" style="width: 45%; display: inline-block">
                                    <label>Municipio<i class="material-icons texto-rojo">star_rate</i></label>
                                    <br>
                                    <select id="CiudadDeLocalizacion" name="CiudadDeLocalizacion">
                                        <option value="0">Seleccione</option>
                                    </select>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend><b class="tituloPrincipalPag">Dirección</b></legend>
                                </br>
                                <div class="input-field" style="margin:auto; width: 30%; display: inline-block;">

                                    <label for="NumeroDeLaCalle">Calle<i
                                                class="material-icons texto-rojo">star_rate</i></label>
                                    <input type="number" id="NumeroDeLaCalle" name="NumeroDeLaCalle" AUTOCOMPLETE="ON" maxlength="5"
                                           length="5"
                                            />

                                    <p class="texto-error invisible" id="calleError">Ingrese un número para la
                                        calle!</p>
                                </div>

                                <div class="input-field" style="margin:auto; width: 30%; display: inline-block;">
                                    <label for="NumeroDeLaCarrera">Carrera<i
                                                class="material-icons texto-rojo">star_rate</i></label>
                                    <input type="number" id="NumeroDeLaCarrera" name="NumeroDeLaCarrera" AUTOCOMPLETE="ON"
                                           maxlength="5"
                                           length="5"
                                            />
                                    <i class="fa fa-pulse" style="float: right; margin-top: -10px;" id="correoLoad"></i>

                                    <p class="texto-error invisible" id="carreraError">Ingrese un número para la
                                        carrera!</p>
                                </div>
                                <div class="input-field" style="margin:auto; width: 30%; display: inline-block;">
                                    <label for="NumeroDeEdificacion">Número<i
                                                class="material-icons texto-rojo">star_rate</i></label>
                                    <input type="number" id="NumeroDeEdificacion" name="NumeroDeEdificacion" AUTOCOMPLETE="ON" maxlength="5"
                                           length="5"
                                            />
                                    <i class="fa fa-pulse" style="float: right; margin-top: -10px;" id="correoLoad"></i>

                                    <p class="texto-error invisible" id="numeroError">Ingrese un número de la
                                        edificación!</p>

                                </div>
                            </fieldset>

                            <div id="divCorreo" class="input-field">
                                <label for="CorreoDeLocalizacion">Correo<i class="material-icons texto-rojo">star_rate</i></label>
                                <input type="email" id="CorreoDeLocalizacion" name="CorreoDeLocalizacion" AUTOCOMPLETE="ON" maxlength="50"
                                       length="50"
                                        />
                                <i class="fa fa-pulse" style="float: right; margin-top: -10px;" id="correoLoad"></i>

                                <b>
                                    <p class="texto-error invisible" id="correoError">
                                        Este correo ya esta registrado, ingresa uno nuevo!
                                    </p>
                                </b>
                            </div>

                            <div class="input-field">
                                <label for="FaxDeLocalizacion">Fax<i class="material-icons texto-rojo">star_rate</i></label>
                                <input type="text" id="FaxDeLocalizacion" name="FaxDeLocalizacion" AUTOCOMPLETE="ON" maxlength="50"
                                       length="50"
                                        />
                                <i class="fa fa-pulse" style="float: right; margin-top: -10px;" id="correoLoad"></i>

                                <p class="texto-error invisible" id="faxError">Ingrese un fax valido!</p>
                            </div>
                            <div class="input-field">
                                <label for="SitioWebDeLocalizacion">Sitio web<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="text" id="SitioWebDeLocalizacion" name="SitioWebDeLocalizacion" AUTOCOMPLETE="ON" maxlength="50"
                                       length="50"
                                        />
                                <i class="fa fa-pulse" style="float: right; margin-top: -10px;" id="correoLoad"></i>

                                <p class="texto-error invisible" id="sitioError">Ingrese la dirección del sitio web!</p>
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
        <input type="submit" id="submit" class="btn" value="Registrar"/>
    </center>
    <br/>

    <script>
        $(document).ready(function () {

        });
    </script>

</form>
@section('js')
    @parent
    <script src="{{asset('./Js/adminv/entidad/entidades.js')}}"></script>
@stop