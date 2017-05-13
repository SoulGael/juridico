<?php
function autenticar() {
	if (!$_SESSION){
		//echo $_SESSION['usu'];
		echo '<script language = javascript>
		alert("usuario no autenticado ")
		self.location = "../../index.php"
		</script>';
	}

	$consulta="SELECT * FROM tbl_usuario WHERE alias='". $_SESSION['usu']."'"; 
	$resultado=pg_query($consulta) or die (pg_last_error());
	$fila=pg_fetch_array($resultado);

	if($fila['sesion']!=session_id())
	{
	    session_destroy();
	    echo '<script language = javascript>
		alert("usuario no autenticado 2")
		self.location = "../../index.php"
		</script>';
	}
}
?>