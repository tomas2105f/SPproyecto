<?php 
include'../conexion/conexion.php';
include'../sesiones/verificar_sesion.php';

$pNombre = $_POST["nombre"];
$pPaterno = $_POST["paterno"];
$pMaterno = $_POST["materno"];
$pCorreo = $_POST["correo"];
$pfechaNac = $_POST["fecha_nac"];
$pSexo = $_POST["genero"];
$pCurp = $_POST["curp"];
$pRfc = $_POST["rfc"];
$pLocalidad = $_POST["localidad"];
$pCalle = $_POST["calle"];
$pNumero = $_POST["numero"];
$pEstado = $_POST["estado"];
$pMunicipio = $_POST["municipio"];

$fecha = date("Y-m-d");
$hora = date("H:i:s");

$activo = 1;
$usuario = $_SESSION["idUser"];

mysql_query("SET NAMES utf8");

$sql = mysql_query("SELECT id_persona FROM personas WHERE correo = '$pCorreo'", $conexion) or die("0.1");

if (mysql_num_rows($sql) > 0) {
	?>
	<script lenguage = "javascript">
		window.location="nuevo.php?error=Este correo ya está en uso";
	</script>
	<?php
}else if (mysql_num_rows($sql) == 0) {
	$sql = mysql_query("SELECT id_persona FROM personas WHERE curp = '$pCurp'", $conexion) or die("0.2");

	if (mysql_num_rows($sql) > 0) {
		?>
		<script lenguage = "javascript">
			window.location="nuevo.php?error=Este CURP ya está en uso";
		</script>
	<?php
	}else if (mysql_num_rows($sql) == 0) {
		$sql = mysql_query("SELECT id_persona FROM personas WHERE rfc = '$pRfc'", $conexion) or die("0.2");

		if (mysql_num_rows($sql) > 0) {
			?>
			<script lenguage = "javascript">
				window.location="nuevo.php?error=Este RFC ya está en uso";
			</script>
		<?php
		}else if (mysql_num_rows($sql) == 0) {
			$insertar = mysql_query("INSERT INTO personas (
										nombre,
										ap_paterno,
										ap_materno,
										correo,
										fecha_nac,
										curp,
										rfc,
										sexo,
										localidad,
										calle,
										numero,
										estado,
										municipio,
										activo,
										fecha_registro,
										hora_registro,
										id_usuario
									)
									VALUES
										(
										'$pNombre',
										'$pPaterno',
										'$pMaterno',
										'$pCorreo',
										'$pfechaNac',
										'$pCurp',
										'$pRfc',
										'$pSexo',
										'$pLocalidad',
										'$pCalle',
										'$pNumero',
										'$pEstado',
										'$pMunicipio',
										$activo,
										'$fecha',
										'$hora',
										$usuario
										)",$conexion)or die(mysql_error());
		}
	}
}
 ?>

<script lenguage = "javascript">
	window.location="nuevo.php?correcto=Persona registrada";
</script>
