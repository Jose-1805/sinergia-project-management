<form id="formActualizarEntidad" class="col s12 m10"
      style="background-color: #FFF; box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.69);">

    <h4 colspan="3" class="tituloPrincipalPag tituloGrande" xmlns="http://www.w3.org/1999/html">ACTUALIZACION</h4>

    <P style="color: rgba(13, 13, 13, 0.45);">Realice los cambios que considere necesarios!</P>
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <input type="hidden" value="{{$datos->entidad->id}}" name="entidad_id"/>

    <style>
        div.bien, div.mal {
            display: inline-block;
            color: #fff;
            margin: 5px;
            padding: 2px;
        }

        .bien {
            background: green;
        }

        .mal {
            background: red;
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
                                <input type="text" id="Nombre" name="Nombre" maxlength="45" length="45"
                                       value="{{ $datos->entidad->ent_nombre}}"/>

                                <p class="texto-error invisible" id="nombreEntError">Este nombre ya esta registrado!</p>
                            </div>

                            <div class="input-field">
                                <label for="Telefono">Telefono<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="number" id="Telefono" name="Telefono" maxlength="45" length="45"
                                       value="{{$datos->entidad->ent_telefono}}"/>
                            </div>

                            <div class="input-field">
                                <label for="Identidficacion">Tipo de identificación<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="text" id="Identidficacion" name="Identidficacion" maxlength="45"
                                       length="45" value="{{$datos->entidad->ent_tipo_identificacion}}"/>
                            </div>

                            <div class="input-field">
                                <label for="CamaraComercio">Matricula Cámara y Comercio<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="text" id="CamaraComercio" name="CamaraComercio" maxlength="45" length="45"
                                       value="{{$datos->entidad->ent_matricula_c_comercio}}"/>

                                <p class="texto-error invisible" id="CamaraComercioError">Este código ya ha sido
                                    registrado!</p>
                            </div>

                            <div class="input-field">
                                <label for="SectorEconomico">Sector<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="text" id="SectorEconomico" name="SectorEconomico" maxlength="45"
                                       length="45" value="{{$datos->entidad->ent_sector}}"/>
                            </div>

                            <div class="input-field">
                                <label for="NumeroDeEmpleados">Cantidad de empleados<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="number" id="NumeroDeEmpleados" name="NumeroDeEmpleados" maxlength="45"
                                       length="45" value="{{$datos->entidad->ent_numero_empleados}}"/>
                            </div>

                            <div class="date-field">
                                <label for="FechaDeConstitucion">Fecha de constitución<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="date" class="datepicker" id="FechaDeConstitucion"
                                       name="FechaDeConstitucion" value="{{$datos->entidad->ent_fecha_constitucion}}"
                                       maxlength="45" length="45"/>
                            </div>

                            <div class="selectize-dropdown">
                                <input type="hidden" id="Est" value="{{$datos->entidad->ent_estado}}">
                                <label>Estado<i class="material-icons texto-rojo">star_rate</i></label>
                                <br>
                                <select id="Estado" name="Estado">
                                    <option value="ejecutora">Ejecutora</option>
                                    <option value="propuesta">Propuesta</option>
                                </select>
                                <script>
                                    $("#Estado").each(function () {
                                        if ($(this).attr('value') == $("#Est").val) {
                                            $(this).selected();
                                        }
                                    });
                                </script>
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
                        <div class="input-field">
                            <label for="ActividadEco">Anterio actividad ecónomica</label>
                            <input type="text" name="ActividadEco" id="ActividadEco"
                                   value="{{$datos->actividad->act_eco_descripcion}}"/>
                        </div>
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

                            {{--<P><B>Anterior Actividad económica: </B> {{$datos->actividad->act_eco_descripcion}}</P>--}}
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
                <input type="hidden" name="localizacion_id" value="{{$datos->localizacion->id}}"/>
                <div class="collapsible-body">
                    <fieldset id="localizacion">
                        <div class="contenidoDiv">
                            <fieldset>
                                <P><B>Anterior depertamento: </B> {{$datos->departamento->dep_nombre}}</P>
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

                                <P><B>Anterior ciudad: </B> {{$datos->ciudad->ciu_nombre}}</P>
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
                                <input type="hidden" name="direccion_id" value="{{$datos->direccion->id}}"/>
                                </br>
                                <div class="input-field" style="margin:auto; width: 30%; display: inline-block;">

                                    <label for="NumeroDeLaCalle">Calle<i
                                                class="material-icons texto-rojo">star_rate</i></label>
                                    <input type="number" id="NumeroDeLaCalle" name="NumeroDeLaCalle" AUTOCOMPLETE="ON"
                                           maxlength="5"
                                           length="5" value="{{$datos->direccion->dir_calle}}"/>

                                    <p class="texto-error invisible" id="calleError">Ingrese un número para la
                                        calle!</p>
                                </div>

                                <div class="input-field" style="margin:auto; width: 30%; display: inline-block;">
                                    <label for="NumeroDeLaCarrera">Carrera<i
                                                class="material-icons texto-rojo">star_rate</i></label>
                                    <input type="number" id="NumeroDeLaCarrera" name="NumeroDeLaCarrera"
                                           AUTOCOMPLETE="ON"
                                           maxlength="5" length="5" value="{{$datos->direccion->dir_carrera}}"/>
                                    <i class="fa fa-pulse" style="float: right; margin-top: -10px;" id="correoLoad"></i>

                                    <p class="texto-error invisible" id="carreraError">Ingrese un número para la
                                        carrera!</p>
                                </div>
                                <div class="input-field" style="margin:auto; width: 30%; display: inline-block;">
                                    <label for="NumeroDeEdificacion">Número<i
                                                class="material-icons texto-rojo">star_rate</i></label>
                                    <input type="number" id="NumeroDeEdificacion" name="NumeroDeEdificacion"
                                           AUTOCOMPLETE="ON" maxlength="5"
                                           length="5" value="{{$datos->direccion->dir_numero}}"/>
                                    <i class="fa fa-pulse" style="float: right; margin-top: -10px;" id="correoLoad"></i>

                                    <p class="texto-error invisible" id="numeroError">Ingrese un número de la
                                        edificación!</p>

                                </div>
                            </fieldset>

                            <div id="divCorreo" class="input-field">
                                <label for="CorreoDeLocalizacion">Correo<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="email" id="CorreoDeLocalizacion" name="CorreoDeLocalizacion"
                                       AUTOCOMPLETE="ON" maxlength="50"
                                       length="50" value="{{$datos->localizacion->loc_correo}}"/>
                                <i class="fa fa-pulse" style="float: right; margin-top: -10px;" id="correoLoad"></i>

                                <b>
                                    <p class="texto-error invisible" id="correoError">
                                        Este correo ya esta registrado, ingresa uno nuevo!
                                    </p>
                                </b>
                            </div>

                            <div class="input-field">
                                <label for="FaxDeLocalizacion">Fax<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="text" id="FaxDeLocalizacion" name="FaxDeLocalizacion" AUTOCOMPLETE="ON"
                                       maxlength="50"
                                       length="50" value="{{$datos->localizacion->loc_fax}}"/>
                                <i class="fa fa-pulse" style="float: right; margin-top: -10px;" id="correoLoad"></i>

                                <p class="texto-error invisible" id="faxError">Ingrese un fax valido!</p>
                            </div>
                            <div class="input-field">
                                <label for="SitioWebDeLocalizacion">Sitio web<i
                                            class="material-icons texto-rojo">star_rate</i></label>
                                <input type="text" id="SitioWebDeLocalizacion" name="SitioWebDeLocalizacion"
                                       AUTOCOMPLETE="ON" maxlength="50"
                                       length="50" value="{{$datos->localizacion->loc_sitio_web}}"/>
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
        <input type="submit" id="submit" class="btn" value="Guardar cambios"/>
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