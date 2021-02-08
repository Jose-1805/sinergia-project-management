 $(function(){
 	$('#btnInfoGeneralCompleto').click(function(){ 	
		abrirAgregarComponentes();
 		inicializar();
 	});

 	$('#datosPerfil').on('click','#componentes .col div #btnNuevoComponente',function(){
 		agregarComponente(); 		
 	});

 	
 	$('#datosPerfil').on('click','#componentes div ul li div p .btnBorrarComponente',function(){
 		//if($('#componente div  .liComponente').size > 1){
 			if($('.liComponente').size()>1){
 				$('#liComponente'+$(this).attr('id')).remove();
 				restaurarPropiedadesEtiquetas();
 			}else{
 				alert('Debes tener por lo menos un componente');
 			}
 	});
  });



function abrirAgregarComponentes(){
$('#datosPerfil').html("<div class='col s12' id='componentes' style='margin-bottom: 20px;'>"+
	 				"<p class='col s12'>Componentes</p>"+
	 				"<ul id='comp'>"+
	 				"<li style='opacity:0;'>"+
					"<div class='col s12 m4' style='text-align: justify;'>"+
	 					"<p>Toda la información que se solicita es obligatoria. </p>"+
	 					"<p>Registra todos los componentes de tu perfil y ten en cuenta que la suma de todos los equivalentes debe ser 100%.</p>"+
	 					"<p>Recuerda que antes de pasar a la siguiente pestaña debes almacenar los cambios para seguir correctamente la formulación de tu perfil.</p>"+
	 				"</div>"+
	 				"</li>"+	 				
	 				"</ul>"+

	 				"<div class='col s12 m8'>"+						 	

						"<ul class='collapsible' data-collapsible='accordion'>"+
							"<li class='liComponente' id='liComponente1'>"+
								"<div class='collapsible-header'>"+
									"<p>Componente 1 <i class='mdi-navigation-cancel btnBorrarComponente' style='float: right; color:red;' id='1'></i></p>"+
								"</div>"+
								"<div class='collapsible-body'>"+
									"<div id='componente1' class='col s12 componente'>"+
						 				"<div class='input-field'>"+
						 					"<input type='text' name='txtNombreComponente1' id='txtNombreComponente1'>"+
						 					"<label for='txtNombreComponente1'>Nombre</label>"+
						 				"</div>"+
						 				"<div class='input-field'>"+
						 					"<textarea name='txtObjetivo1' id='txtObjetivo1' class='materialize-textarea'></textarea>"+
						 					"<label for='txtObjetivo1'>Objetivo</label>"+
						 				"</div>"+

						 				"<div class='range-field'>"+			 				
						 					"<label for='txtEquivalente1'>Equivalente</label>"+
						 					"<input type='range' min='1' max='100' id='txtEquivalente1' name='txtEquivalente1'>"+
						 				"</div>"+						 				
					 				"</div>"+
								"</div>"+
							"</li>"+
						"</ul>"+		

						"<div class='right-align'>"+
						 	"<a class='btn waves-effect waves-light' id='btnNuevoComponente'>nuevo</a>"+
						 	"<a class='btn waves-effect waves-light'>guardar</a>"+
						 	"<a class='btn waves-effect waves-light'>completo</a>"+
						"</div>"+							
	 				"</div>"+
	 			"</div>");

 		showStaggeredList('#comp');
}

function agregarComponente(){
	var componentes = $('.liComponente');
	var cantidad = componentes.size();
		if(cantidad == 5){
			alert('Puedes dividir tu proyecto unicamente en 5 componentes');
		}else{

		var ultimoLi = $('#liComponente'+cantidad);
		if(ultimoLi.length){
			ultimoLi.after(generarHtmlNuevoComponente(cantidad+1));
		}else{
			alert('Problemas al agregar un componente');
		}
	}
}

function generarHtmlNuevoComponente(id){
	return "<li class='liComponente' id='liComponente"+id+"'>"+
								"<div class='collapsible-header'>"+
									"<p>Componente "+id+" <i class='mdi-navigation-cancel btnBorrarComponente' style='float: right; color:red;' id='"+id+"'></i></p>"+
								"</div>"+
								"<div class='collapsible-body'>"+
									"<div id='componente"+id+"' class='col s12 componente'>"+
						 				"<div class='input-field'>"+
						 					"<input type='text' name='txtNombreComponente"+id+"' id='txtNombreComponente"+id+"'>"+
						 					"<label for='txtNombreComponente"+id+"'>Nombre</label>"+
						 				"</div>"+
						 				"<div class='input-field'>"+
						 					"<textarea name='txtObjetivo"+id+"' id='txtObjetivo"+id+"' class='materialize-textarea'></textarea>"+
						 					"<label for='txtObjetivo"+id+"'>Objetivo</label>"+
						 				"</div>"+

						 				"<div class='range-field'>"+			 				
						 					"<label for='txtEquivalente"+id+"'>Equivalente</label>"+
						 					"<input type='range' min='1' max='100' id='txtEquivalente"+id+"' name='txtEquivalente"+id+"'>"+
						 				"</div>"+						 				
					 				"</div>"+
								"</div>"+
							"</li>";
}


function restaurarPropiedadesEtiquetas(){
	$('.liComponente').each(function(index){
		var p = $(this).children('div').children('p');
		p.html("componente "+(index+1)+"<i class='mdi-navigation-cancel btnBorrarComponente' style='float: right; color:red;' id='"+(index+1)+"'></i>" );
		$(this).attr('id','liComponente'+(index+1));

	});

	$('.componente').each(function(index){
		var input = $(this).children('.input-field').children('input');
		input.attr('id','txtNombreComponente'+(index+1));
		input.attr('name','txtNombreComponente'+(index+1));

		var textArea = $(this).children('.input-field').children('textarea');
		textArea.attr('id','txtObjetivo'+(index+1));
		textArea.attr('name','txtObjetivo'+(index+1));

		var range = $(this).children('.range-field').children('input');
		range.attr('id','txtEquivalente'+(index+1));
		range.attr('name','txtEquivalente'+(index+1));

		$(this).attr('id','componente'+(index+1));

		var labels = $(this).children('div').children('label');
		labels.eq(0).attr('for','txtNombreComponente'+(index+1));
		labels.eq(1).attr('for','txtObjetivo'+(index+1));
		labels.eq(2).attr('for','txtEquivalente'+(index+1));
	});
}