$(document).ready(function () {

	/*
	* Evento que se ejecuta a la hora de guardar o actualizar informacion de alguna de las categorias
	* EJ: Manuales, Instructivos etc
	*/	
	$("#btn-category").on("click", function(){

		var desc_img = document.getElementById('desc-img').value;
		var texto = document.getElementById('cont-category').value;
		var action = document.getElementById('type-action').value;
		var cat = document.getElementById("type-category").value;
		var img = document.getElementById('image').files[0];
		var formdata = new FormData();

		if (action == 'update') {
			img = actualizarCategoria(img);
		}
		
		formdata.append("archivo", img);
		formdata.append("texto", texto);
		formdata.append("categoria", cat);
		formdata.append("desc_img", desc_img);

		$.ajax({
			url: "../../contenido/category/" + action,
			type: "post",
			data: formdata,
			contentType: false,
			processData: false,
			success: function(res) {
				console.log(res);
				var response = JSON.parse(res);
				if (response.ok) {
					$.jGrowl("Se ha registrado la información", {
						position: "bottom-right",
						header: "Registro de Exitoso",
						theme: "bg-green",
						life: 5000
					});
				}
				else {
					console.log("No se ha subido la imagen: "+response.error);
					$.jGrowl(response.error, {
						position: "bottom-right",
						header: "Fallo del Registro",
						theme: "bg-red",
						life: 5000
					});
				}
			}
		});
		
	});

	function actualizarCategoria(img) {
		if (img != undefined) {
			return img;
		}
		return document.getElementById("img_principal").src.split("/").pop();
	}

	/*
	*  Evento sobre el formulario de cargar documentos que envia la informacion al servidor
	*/
	$("#btn-load-doc").on("click", function() {
		var form = document.getElementById("form-load-doc");
		var formdata = new FormData(form);

		$.ajax({
			url: "../../contenido/documento/cargarDocumento",
			type: "post",
			data: formdata,
			processData: false,
			contentType: false,
			success: function(response) {
				console.log(response);
				var res = JSON.parse(response);
				if (res.ok) {
					location.reload(true);
				}
				else {
					$.jGrowl(res.error, {
						position: "bottom-right",
						header: "Registro de documentos",
						theme: "bg-red",
						life: 5000
					});
				}
			}
		});
	});

	/*
	* Evento que borra un documento de la DB y del servidor
	*/
	$("body").on('click', '.btn-delete-doc', function(){
		var btn = $(this);
		var id = btn.data('id');
		var doc = btn.data('name');
		$.ajax({
			url: '../../documentos/delete',
			type: 'post',
			data: {
				id: id,
				doc: doc
			},
			success: function(response) {
				console.log(response);
				var res = JSON.parse(response);
				if (res.ok) {
					location.reload(true);
				}
				else {
					$.jGrowl("No se ha podido eliminar el documento", {
						position: "bottom-right",
						header: "Registro de documentos",
						theme: "bg-red",
						life: 5000
					});
				}
			}
		});
	});

	/*
	* Evento que carga en un array los estudios realizados por el docente
	*/
	var formations = new Array();
	$("#btn-load-formation").on("click", function(){
		var inputs = $("#inputs-doc").find('input');		 
		var obj = new Object();
		var ok = true;
		inputs.each(function(index){
			var val = $(this);
			if (val.val() != "") {				
				var name = val.attr('name');
				obj[name] = val.val();
			}
			else {
				$.jGrowl("Faltan datos en la formacion academica", {
					position: "bottom-right",
					header: "Registro de documentos",
					theme: "bg-red",
					life: 3000
				});
				ok = false;
				return false;
			}
		});
		if (ok) {
			formations.push(obj);
			document.getElementById('form-formation-per').reset();
			//console.log(array);		
		}
	});

	/*
	* Evento que guarda la informacion del personal en la DB
	*/
	$("#btn-save-person").on("click", function(){
		var form = document.getElementById("form-person");
		var formdata = new FormData(form)
		formdata.append('formation', JSON.stringify(formations));
		$.ajax({
			url: "../../actores/save",
			type: "post",
			data: formdata,
			processData: false,
			contentType: false,
			success: function(response) {
				console.log(response);
				var res = JSON.parse(response);
				if (res.ok) {
					$.jGrowl("La información se ha registrado exitosamente", {
						position: "bottom-right",
						header: "Registro exitoso",
						theme: "bg-green",
						life: 5000
					});

					form.reset();
					location.href = "../../actores/equipo_de_trabajo/";
				}
				else {
					$.jGrowl(res.error, {
						position: "bottom-right",
						header: "Registro fallido",
						theme: "bg-red",
						life: 5000
					});
				}
			}
		});
	});

	/*
	* Evento que elimina un integrante del personal
	*/
	$("body").on("click", ".btn-delete-person", function(e){
		e.preventDefault();
		var id = $(this).data('id');
		$.get("../../personal/delete/"+id, function(response){
			console.log(response);
			var res = JSON.parse(response);
			if (res.ok) {
				document.getElementById("person-"+id).remove();
				$.jGrowl("El recurso se ha eliminado", {
					position: "bottom-right",
					header: "Eliminación exitosa",
					theme: "bg-green",
					life: 5000
				});
			}
			else {
				$.jGrowl("No se puedo eliminar el recurso", {
					position: "bottom-right",
					header: "Eliminación fallida",
					theme: "bg-red",
					life: 5000
				});
			}
		});
		
	});

	/*
	* Evento que actualiza la informacion del personal
	*/
	$("#btn-update-per").on("click", function(){
		var form = document.getElementById("form-update-per");
		var formdata = new FormData(form);
		$.ajax({
			url: "../../actores/update",
			type: "post",
			data: formdata,
			processData: false,
			contentType: false,
			success: function(response) {
				console.log(response);
				var res = JSON.parse(response);
				if (res.ok) {
					location.reload(true);
				}
				else {
					$.jGrowl(res.error, {
						position: "bottom-right",
						header: "Ocurrio un problema",
						theme: "bg-red",
						life: 5000
					});
				}
			}
		});
	});

	/*
	* Evento que se dispara a la hora de actualizar la formacion de un docente
	*/
	$("#btn-update-estudy").on("click", function(e) {
		var form = document.getElementById("form-update-est");
		var formdata = new FormData(form);
		var action = document.getElementById("action").value == "register"? "register" : "update";	
		console.log(action);	
		$.ajax({
			url: "../../estudios/"+action,
			type: "post",
			data: formdata,
			contentType: false,
			processData: false,
			success: function( response ) {
				console.log(response);
				var res = JSON.parse(response);
				if (res.ok) {
					location.reload(true);
				}
				else {
					$.jGrowl(res.error, {
						position: "bottom-right",
						header: "Ocurrio un problema",
						theme: "bg-red",
						life: 5000
					});
				}
			}
		});
	});

	/*
	* Evento que se dispara a la hora de borrar algun tipo de formacion del docente
	*/
	$(".btn-delete-est").on("click", function(){
		var id = $(this).data('id');
		$.post('../../estudios/delete/', {id: id}, function(response) {
			var res = JSON.parse(response);
			if (res.ok) {
				location.reload(true);
			}
			else {
				$.jGrowl(res.error, {
					position: "bottom-right",
					header: "Ocurrio un problema",
					theme: "bg-red",
					life: 5000
				});  
			}
		});
	});

	/*
	* Evento que se dispara cuando se quiere guardar una subcategoria
	*/
	$("#btn-subcategoria-save").on("click", function(){
		var form = document.getElementById("form-save-subcat");
		var formdata =new FormData(form);

		$.ajax({
			url: "../../categorias/insert/",
			type: "post",
			data: formdata,
			contentType: false,
			processData: false,
			success: function(response) {
				var res = JSON.parse(response);
				if (res.ok) {
					location.reload(true);
				}
				else {
					$.jGrowl(res.error, {
						position: "bottom-right",
						header: "Ocurrio un problema",
						theme: "bg-red",
						life: 5000
					});
				}
			}
		});
	});

	/*
	* Evento que se dispara cuando se desea eliminar una subcategoria
	*/
	$("#btn-delete-categorias").on("click", function(){
		var id = $(this).data("id");

		$.post('../../categorias/delete/', {id:id}, function(response){
			var res = JSON.parse(response);
				if (res.ok) {
					location.reload(true);
				}
				else {
					$.jGrowl(res.error, {
						position: "bottom-right",
						header: "Ocurrio un problema",
						theme: "bg-red",
						life: 5000
					});
				}
		});
	});
});