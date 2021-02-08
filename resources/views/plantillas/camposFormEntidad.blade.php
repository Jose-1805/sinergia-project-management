<?php
    $seccionesActEco = \App\Models\SeccionActividadEconomica::orderBy('sec_act_descripcion')->get();
    $paises = \App\Models\Pais::orderBy('pai_nombre')->get();
?>
<div class="col s12">
    <div class="input-field">
        <input type="text" name="nombre_entidad" id="nombre_entidad">
        <label from="nombre_entidad">Nombre</label>
    </div>

    <div class="col s12" style="margin-bottom: 30px;">
        <label class="active">Actividad económica</label>

        <div class="col s12" style="border: 1px solid rgba(21, 21, 21, 0.43);">
            <div>
                <label from="seccionActEco">Sección</label>
                <select id="seccionActEco" onchange="cargarDivisionesActEco(this.id)">
                    <option>Seleccione</option>
                    @foreach($seccionesActEco as $seccion)
                        <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($seccion->id)}}">{{$seccion->sec_act_descripcion}}</option>
                    @endforeach
                </select>
            </div>

            <div id="contenedor_select_divisiones_act_eco">
                <label from="divisionActEco">División</label>
                <select id="divisionActEco">
                    <option>Seleccione</option>
                </select>
            </div>
            <div class="progress invisible" id="progress_select_divisiones_act_eco">
                <div class="indeterminate"></div>
            </div>

            <div id="contenedor_select_actividad_economica">
                <label from="actividad_economica">Actividad</label>
                <select id="actividad_economica">
                    <option>Seleccione</option>
                </select>
            </div>
            <div class="progress invisible" id="progress_select_actividad_economica">
                <div class="indeterminate"></div>
            </div>
        </div>
    </div>

    <div class="input-field col s12 l6">
        <input type="text" name="matricula_camara_comercio" id="matricula_camara_comercio">
        <label from="matricula_camara_comercio">Matricula de camara y comercio</label>
    </div>

    <div class="input-field col s12 l6">
        <input type="number" name="cantidad_empleados" id="cantidad_empleados">
        <label from="cantidad_empleados">Cantidad empleados</label>
    </div>

    <div class="input-field col s12 l6">
        <input type="date" name="fecha_constitucion" id="fecha_constitucion">
        <label from="fecha_constitucion">Fecha de constitución</label>
    </div>

    <div class="input-field col s12 l6">
        <input type="text" name="tipo_identificacion" id="tipo_identificacion">
        <label from="tipo_identificacion">Tipo identificacion</label>
    </div>

    <div class="input-field col s12 l6">
        <input type="text" name="telefono_entidad" id="telefono_entidad">
        <label from="telefono_entidad">Telefono</label>
    </div>

    <div class="input-field col s12 l6">
        <input type="text" name="fax" id="fax">
        <label from="fax">Fax</label>
    </div>

    <div class="input-field col s12 l6">
        <input type="text" name="sitio_web" id="sitio_web">
        <label from="sitio_web">Sitio web</label>
    </div>

    <div class="input-field col s12 l6">
        <input type="text" name="correo_entidad" id="correo_entidad">
        <label from="correo_entidad">Correo</label>
    </div>

    <div class="input-field col s12 l6">
        <label from="pais">País</label>
        <select id="pais" onchange="cargarDepartamentos(this.id)">
            <option>Seleccione</option>
            @foreach($paises as $pais)
                <option value="{{\Illuminate\Support\Facades\Crypt::encrypt($pais->id)}}">{{$pais->pai_nombre}}</option>
            @endforeach
        </select>
    </div>

    <div class="input-field col s12 l6">
        <div id="contenedor_select_departamentos">
            <label from="departamento">Departamento</label>
            <select id="departamento">
                <option>Seleccione</option>
            </select>
        </div>
        <div class="progress invisible" id="progress_select_departamentos">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div class="input-field col s12 l6">
        <div id="contenedor_select_ciudades">
            <label from="ciudad">Ciudad</label>
            <select id="ciudad">
                <option>Seleccione</option>
            </select>
        </div>
        <div class="progress invisible" id="progress_select_ciudades">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div class="input-field col s12 l6">
        <input type="text" name="calle" id="calle">
        <label from="calle">Calle</label>
    </div>

    <div class="input-field col s12 l6">
        <input type="text" name="Carrera" id="Carrera">
        <label from="Carrera">Carrera</label>
    </div>

    <div class="input-field col s12 l6">
        <input type="text" name="direccion_numero" id="direccion_numero">
        <label from="direccion_numero">Número</label>
    </div>
</div>

<div class="col s12">
    <p class="tituloMediano">Contácto</p>
    <div class="divider teal lighten-3 col s12" style="margin-bottom: 25px;"></div>

    <div class="input-field col s12 l6">
        <input type="text" name="nombre_completo_contacto" id="nombre_completo_contacto">
        <label from="nombre_completo_contacto">Nombre completo</label>
    </div>

    <div class="input-field col s12 l6">
        <input type="text" name="telefono_contacto" id="telefono_contacto">
        <label from="telefono_contacto">Telefono</label>
    </div>

    <div class="input-field col s12 l6">
        <input type="text" name="correo_contacto" id="correo_contacto">
        <label from="correo_contacto">Correo</label>
    </div>

    <div class="input-field col s12 l6">
        <input type="text" name="cargo" id="cargo">
        <label from="cargo">Cargo</label>
    </div>
</div>

<script>
    $(function(){
        $('label').addClass('active');
        $('input').prop('placeholder',' ');
    });
</script>
