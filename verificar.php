<?
//se manda llamar la conexion
include'../conexion/conexion.php';

//Variables post de Login
//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*
$pass=$_POST["password"];
$user=$_POST["username"];
//Encriptacion de Contraseña
$contras=md5($pass);
//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*

mysql_query("SET NAMES utf8");
$consulta=mysql_query("SELECT
						personas.id_persona,
						personas.nombre,
						personas.ap_paterno,
						personas.ap_materno,
						personas.correo,
						usuarios.id_usuario,
						usuarios.usuario,
						usuarios.contra,
						user_config.color,
						user_config.expirar_sesion,
						user_config.tiempo_sesion
					FROM
						personas
					INNER JOIN trabajadores ON personas.id_persona = trabajadores.id_persona
					INNER JOIN usuarios ON trabajadores.id_trabajador = usuarios.id_trabajador
					INNER JOIN user_config ON usuarios.id_usuario = user_config.id_usuario
					WHERE
						usuario = '$user'
					AND contra = '$pass'
					AND personas.activo = 1
					AND usuarios.activo = 1
					AND trabajadores.activo = 1
					LIMIT 1",$conexion) or die (mysql_error());
					   
//Descargamos el arreglo que arroja la consulta
$row=mysql_fetch_row($consulta);
//Se cuenta el numero de filas
$num=mysql_num_rows($consulta);
//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*

//Verificar si es un usuario existente o no
//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*
if($num==1)
{
	/////Bloque para la session del sistema/////////////////////////////////////
	//asigno un nombre a la sesión para poder guardar diferentes datos 
    session_name("loginUsuario"); 
    // inicio la sesión 
    session_start(); 
    //defino la sesión que demuestra que el usuario está autorizado 
    $_SESSION["autentificado"]= "SI"; 
    //defino la fecha y hora de inicio de sesión en formato aaaa-mm-dd hh:mm:ss 
    $_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s"); 
	
	//Defino variables de session restantes
    //*//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*
    //$sNombreUsuario=$_SESSION["s_user"];
	$_SESSION["idPersona"]= $row[0];
	$_SESSION["nPersona"]= $row[1];
	$_SESSION["apPersona"]= $row[2].' '.$row[3];
	$_SESSION["nCorreo"]= $row[4];
	$_SESSION["idUser"]= $row[5];
	$_SESSION["nUser"]= $row[6]; //Nombre de usuario
	$_SESSION["colorTheme"]= $row[8];
	$_SESSION["expirarSesion"]= $row[9];
	$_SESSION["tiempoSesion"]= $row[10];

	header("Location: ../inicio/index.php");
}
else
{
	//Si el nombre de usuario o contraseña son erroneos
	header("Location: ../login/login.php?var=error");
}
//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*//*

mysql_close($conexion);//cierro la conexion a la bd
?>
