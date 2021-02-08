<ul class="collapsible" data-collapsible="accordion" style="padding: 10px;">
    <li>
        <div class="collapsible-header tituloPrincipalPag active"><i class="material-icons">info</i>
            <h5>Datos basicos de la Entidad </h5>
        </div>
        <div class="collapsible-body">
            <div class="input-field">
                <label for="entNombre">Nombre de la Entidad
                </label>
                <input type="text" id="entNombre" name="entNombre" value="{{ $datos->entidad->ent_nombre}}"
                       maxlength="45" length="45"/>
            </div>

            <div class="input-field">
                <label for="telefono">Telefono
                </label>
                <input type="number" id="telefono" name="telefono" value="{{$datos->entidad->ent_telefono}}"
                       maxlength="45"
                       length="45"/>
            </div>

            <div class="input-field">
                <label for="identidficacion">Tipo de identificación
                </label>
                <input type="text" id="identidficacion" name="identidficacion"
                       value="{{$datos->entidad->ent_tipo_identificacion}}" maxlength="45" length="45"/>
            </div>

            <div class="input-field">
                <label for="camara">Matricula Cámara y Comercio
                </label>
                <input type="text" id="camara" name="camara" value="{{$datos->entidad->ent_matricula_c_comercio}}"
                       maxlength="45" length="45"/>
            </div>

            <div class="input-field">
                <label for="sector">Sector
                </label>
                <input type="text" id="sector" name="sector" value="{{$datos->entidad->ent_sector}}" maxlength="45"
                       length="45"
                        />
            </div>

            <div class="input-field">
                <label for="empleados">Cantidad de empleados
                </label>
                <input type="number" id="empleados" name="empleados" value="{{$datos->entidad->ent_numero_empleados}}"
                       maxlength="45" length="45"/>
            </div>

            <div class="date-field">
                <label for="fecha">Fecha de constitución
                </label>
                <input type="date" class="datepicker" id="fecha" name="fecha"
                       value="{{$datos->entidad->ent_fecha_constitucion}}"
                       maxlength="45" length="45"/>
            </div>

            <div class="input-field">
                <label for="estado">Estado
                </label>
                <input type="text" id="estado" name="estado" value="{{$datos->entidad->ent_estado}}" maxlength="45"
                       length="45"/>
            </div>
        </div>
    </li>
    <li>
        <div class="collapsible-header tituloPrincipalPag active"><i class="material-icons">info</i>
            <h5>Datos basicos de la Entidad </h5>
        </div>
        <div class="collapsible-body">
            <div class="input-field">
                <label for="actividadEco">Actividad Económica</label>
                <input type="text" id="actividadEco" name="actividadEco"
                       value="{{$datos->actividad->act_eco_descripcion}}"/>
            </div>
        </div>
    </li>
    <li>
        <div class="collapsible-header tituloPrincipalPag active"><i class="material-icons">info</i>
            <h5>Localización de la Entidad </h5>
        </div>
        <div class="collapsible-body">
            <div class="input-field">
                <label for="actividadEco">Departamento</label>
                <input type="text" id="Departamento" name="Departamento" value="{{$datos->departamento->dep_nombre}}"/>
            </div>
            <div class="input-field">
                <label for="actividadEco">Ciudad</label>
                <input type="text" id="Ciudad" name="Ciudad" value="{{$datos->ciudad->ciu_nombre}}"/>
            </div>
            <fieldset>
                <legend>Dirección</legend>
                <div class="input-field col s4">
                    <label for="Calle">Calle</label>
                    <input type="text" id="Calle" name="Calle" value="{{$datos->direccion->dir_calle}}"/>
                </div>
                <div class="input-field col s4">
                    <label for="Carrera">Carrera</label>
                    <input type="text" id="Carrera" name="Carrera" value="{{$datos->direccion->dir_carrera}}"/>
                </div>
                <div class="input-field col s4">
                    <label for="Numero">Número</label>
                    <input type="text" id="Numero" name="Numero" value="{{$datos->direccion->dir_numero}}"/>
                </div>

            </fieldset>
            <fieldset>
                <legend>Localización</legend>
                <div class="input-field col s4">
                    <label for="Correo">Correo</label>
                    <input type="text" id="Correo" name="Correo" value="{{$datos->localizacion->loc_correo}}"/>
                </div>
                <div class="input-field col s4">
                    <label for="Fax">Fax</label>
                    <input type="text" id="Fax" name="Fax" value="{{$datos->localizacion->loc_fax}}"/>
                </div>
                <div class="input-field col s4">
                    <label for="SitioWeb">Sitio web</label>
                    <input type="text" id="SitioWeb" name="SitioWeb" value="{{$datos->localizacion->loc_sitio_web}}"/>
                </div>
            </fieldset>
        </div>
    </li>
</ul>
<br/>
<br/>
<center>
    {{--<input type="submit" value="Actualizar">--}}
    <a id="actualizar" class="btn" href="/adminv/actualizar-entidad/{{$datos->entidad->id}}">MODIFICAR ENTIDAD</a>
</center>
<script>
    $("b").css("color", "#238276");
    $("legend").css("color", "#238276");
    $("input").attr("readonly", "readonly");
    $("input").css("color", "#000");
</script>
