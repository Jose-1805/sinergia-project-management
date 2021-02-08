@if($modal == "")
    <form id="propiedades-contenedor">
        <p class="tituloPrincipalPag titulo">Propiedades del contenedor</p>
        <p class="texto-informacion-medium">Seleccione las medidas del contenedor principal en los diferentes tipos de pantalla. El ancho
        total de todas las pantallas es de 12 columnas, las cuales se dividen proporcionalmente de acuerdo al ancho en pixeles de la pantalla, de la misma manera trabaja cada contenedor incluido en su interfaz.</p>
        <div class="col s12 m4">
        <label>Pantalla pequeña</label>
        <input id="clase-ancho-s" type="number" value="12" class="validate" min="1" max="12">
        </div>

        <div class="col s12 m4">
        <label>Pantalla mediana</label>
        <input id="clase-ancho-m" type="number" value="12" class="validate" min="1" max="12">
        </div>

        <div class="col s12 m4">
        <label>Pantalla grande</label>
        <input id="clase-ancho-l" type="number" value="12" class="validate" min="1" max="12">
        </div>

        <p class="texto-informacion-medium">Establezca el tamaño del relleno (en pixeles) de cada uno de los lados del contenedor.</p>

        <div class="input-field col s6 m3">
        <i class="prefix fa fa-hand-o-left texto-informacion-medium"></i>
        <input id="clase-padding-left" type="number" value="0" class="validate" min="0">
        </div>

        <div class="input-field col s6 m3">
        <i class="prefix fa fa-hand-o-down texto-informacion-medium"></i>
        <input id="clase-padding--down" type="number" value="0" class="validate" min="0">
        </div>

        <div class="input-field col s6 m3">
        <i class="prefix fa fa-hand-o-right texto-informacion-medium"></i>
        <input id="clase-padding-right" type="number" value="0" class="validate" min="0">
        </div>

        <div class="input-field col s6 m3">
        <i class="prefix fa fa-hand-o-up texto-informacion-medium"></i>
        <input id="clase-padding--up" type="number" value="0" class="validate" min="0">
        </div>
    </form>
@elseif($modal == "")

@endif