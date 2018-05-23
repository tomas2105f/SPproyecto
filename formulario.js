$("#iniciar").on('click', function(e){

	var user = $("#user").val();
	var pass = $("#pass").val();

	//alert(user);
	$.ajax({
		url:"../login/verificar_login.php",
		type:"POST",
		dateType:"html",
		data:{'user':user, 'pass':pass},
		success:function(respuesta){
			// alertify.success('Bienvenido',3);
			//alert(respuesta);
			//console.log(data);
			// $('#correcto').show();
			if(respuesta[0]==1)
				{
					window.location='../inicio/index.php';
					// sesionid=respuesta[1];
				}
		},
		error:function(xhr,status){
			alertify.error('Error en el metodo AJAX',3);
			//console.log(data);
		},
	});
	e.preventDefault();
	return false;
});
