<form id="form-componentes">
<div class='col s12' id='componentes' style='margin-bottom: 20px;'>
    <p class='col s12 tituloMediano tituloPrincipalPag'>Componentes</p>
    <ul id='comp'>
        <li style='opacity:1;'>
            <div class='col s12 m4' style='text-align: justify;'>
                <p class="texto-informacion-medium justificado">Registre todos los componentes de su perfil y tenga en cuenta que la suma de todos los equivalentes debe ser 100% al presionar el boton COMPLETO.</p>
                <p class="texto-informacion-medium justificado">Puede presionar el boton GUARDAR para almacenar la información y editarla posteriormente, presionando el boton COMPLETO se almacenará la información y se dará espacio al siguiente paso.</p>
                <p class="texto-informacion-medium justificado">Si recibe sugerencias a un componente, edite la informaciób del componente preferiblemente desde la vista de sugerencias, al guardar la información desde esta vista, todas las sugerencias y respuestas relacionadas con sus componentes serán eliminadas.</p>
            </div>
        </li>	 				
    </ul>

    <div class='col s12 m8'>						 	

        <ul class='collapsible' data-collapsible='accordion'>
            @if (!count($objPerfil->proyectoInvestigativo->componentes))
                <li class='liComponente' id='liComponente1'>
                    <div class='collapsible-header'>
                        <p>Componente 1 <i class='mdi-navigation-cancel btnBorrarComponente' style='float: right; color:red;' id='1'></i></p>
                    </div>
                    <div class='collapsible-body'>
                        <div id='componente1' class='col s12 componente'>
                            <div class='input-field'>
                                <input type='text' name='nombre1' id='nombre1'>
                                <label for='nombre1'>Nombre</label>
                            </div>
                            <div class='input-field'>
                                <textarea name='objetivo1' id='objetivo1' class='materialize-textarea'></textarea>
                                <label for='objetivo1'>Objetivo</label>
                            </div>

                            <div class='input-field'>
                                <label for='equivalente1'>Equivalente</label>
                                <input type='number' min='1' max='100' id='equivalente1' name='equivalente1'>
                            </div>						 				
                        </div>
                    </div>
                </li>
            @else
                <?php
                $aux = 0;
                foreach ($objPerfil->proyectoInvestigativo->componentes as $componente)
                {
                    $aux++;
                    ?>
                    <li class='liComponente' id='{{"liComponente".$aux}}'>
                        <div class='collapsible-header'>
                            <p>{{"Componente ".$aux }}<i class='mdi-navigation-cancel btnBorrarComponente' style='float: right; color:red;' id='{{$aux}}'></i></p>
                        </div>
                        <div class='collapsible-body componente' id="{{'componente'.$aux}}">
                                <div class='input-field'>
                                    <input type='text' name='{{"nombre".$aux}}' id='{{"nombre".$aux}}' value="{{$componente->com_nombre}}">
                                    <label for='{{"nombre".$aux}}'>Nombre</label>
                                </div>
                                <div class='input-field'>
                                    <textarea name='{{"objetivo".$aux}}' id='{{"objetivo".$aux}}' class='materialize-textarea'>{{$componente->com_objetivo}}</textarea>
                                    <label for='{{"objetivo".$aux}}'>Objetivo</label>
                                </div>

                                <div class='input-field'>
                                    <label for='{{"equivalente".$aux}}'>Equivalente</label>
                                    <input type='number' min='1' max='100' id='{{"equivalente".$aux}}' name='{{"equivalente".$aux}}' value="{{$componente->com_equivalente}}">
                                </div>
                        </div>
                    </li>
                <?php
                }
            ?>
            @endif
        </ul>		

        <div class='right-align contenedor-botones'>
            <a class='btn waves-effect waves-light' id='btnNuevoComponente'>nuevo</a>
            <a class='btn waves-effect waves-light' id="btnGuardarComponentes">guardar</a>
            <a class='btn waves-effect waves-light' id="btnComponentesCompletos">completo</a>
        </div>							
    </div>
</div>
</form>