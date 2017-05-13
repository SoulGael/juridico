<?php 

include 'conexion.php';
conectarse();
//Inicio de variables de sesión
session_start();
//Recibir los datos ingresados en el formulario
$usuario= $_POST['user'];
$contrasena= md5($_POST['pass']);


//Consultar si los datos son están guardados en la base de datos
$consulta="SELECT * FROM tbl_usuario WHERE alias='".$usuario."' AND clave ='".$contrasena."'"; 
$resultado=pg_query($consulta) or die (pg_last_error());
$fila=pg_fetch_array($resultado);
//echo $fila['sesion'];
//echo "<br>";
//echo session_id();

//if($fila['sesion']==session_id())
//{
//	echo "entra";
//}session_destroy();

if($fila['sesion']!=session_id())
{
	$modificar=pg_query("update tbl_usuario set sesion='".session_id()."' where alias='".$usuario."'") or die("Error de conexion. ". pg_last_error());
}

if (!$fila[0]) //opcion1: Si el usuario NO existe o los datos son INCORRRECTOS
{
	echo '<script language = javascript>
	alert("Usuario o Password errados, por favor verifique.")
	self.location = "../index.php"
	</script>';
}
//if($fila['autenticacion_ip']==session_id())
//{self.location = "../index.php"  header("Location: inicio.php");

else //opcion2: Usuario logueado correctamente
{
	//Definimos las variables de sesión y redirigimos a la página de usuario
	$_SESSION['usu'] = $fila['alias'];
	$_SESSION['idrol'] = $fila['id_rol'];
	$consulta="select sesion, autenticacion_ip from tbl_usuario,tbl_sucursal where alias='". $_SESSION['usu']."' 
	and autenticacion_ip like '%".$_SERVER['REMOTE_ADDR']."%' and ips_computador like '%".$_SERVER['REMOTE_ADDR']."%'"; 
	$resultado=pg_query($consulta) or die (pg_last_error());
	$fila=pg_fetch_array($resultado);

	if($fila['sesion']!=session_id())
	{
	    session_destroy();
	    echo '<script language = javascript>
	alert("Esta IP '.$_SERVER['REMOTE_ADDR'].' no se encuentra registrada en nuestra base de datos")
	self.location = "../../index.php"
	</script>';
	}
	header("Location: 1GestionConocimiento/index.php");
}

?>


<!--<?php
//$usuario=$_POST['user'];
//$contra=md5($_POST['pass']);
//echo $usuario;
?>
<br>

<?php
//if (($usuario=="admin") && ($contra==md5("123")))
{
  //echo ('usuario Correcto');
  //echo $usuario;
  //echo $contra;
}
//else
{
 //echo('Incorrecto');
// echo $usuario;
  //echo $contra;
}
?>-->