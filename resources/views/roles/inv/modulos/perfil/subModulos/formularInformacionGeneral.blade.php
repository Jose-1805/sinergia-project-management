<style>
    /*.select-wrapper ul,.select-wrapper .select-dropdown,.select-wrapper .caret{
        display: none !important;
    }

    .select-wrapper select{
            display: inline-block !important;
            height: auto !important;
            min-height: 200px !important;
    }*/

    .dropdown-content{
        overflow: auto;
    }
    .dropdown-content li span{
        padding: 0px !important;
        font-size: small;
    }

    .dropdown-content li span label{
        height: 20px !important;
    }

    input[type="checkbox"]+label:before{
        top: 5px !important;
        margin-left: 5px !important;
    }
</style>
<div class="col s12" id="informacionGeneral" style="margin-bottom: 20px; margin-top: 60px;">
    <p class="col s12 tituloMediano tituloPrincipalPag">Información general</p>
    <div class="col s12 m4">
        <p class="texto-informacion-medium">Toda la información solicitada es obligatoria. </p>

        <p class="texto-informacion-medium">La información que ingrese en este formulario se tendrá en cuenta en el desarrollo del siguiente paso (Formulación de componentes).</p>
    </div>
    <div class="col s12 m8">
        <div class="input-field">
            <input type="number" name="duracion" id="duracion" placeholder="Ingrese la duración en meses del proyecto">
            <label for="duracion" class="active">Duración(meses)</label>
        </div>
        <div class="input-field">
            <input type="text" name="tipoFinanciación" id="tipoFinanciacion" placeholder="Ingrese el tipo de financiación del proyecto">
            <label for="tipoFinanciacion" class="active">Tipo financiación</label>
        </div>

        @include('plantillas.selects',array("select" => "lineasInvestigacion","numero_select"=>"1"))

        <div class="right-align contenedor-botones" style="margin-top: 100px;">
            <a class="btn waves-effect waves-light" id="btnInfoGeneralCompleto">Guardar</a>
        </div>
    </div>
</div>