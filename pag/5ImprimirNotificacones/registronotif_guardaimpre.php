<?php  
include '../conexion.php';
conectarse();
//$q=($_GET['geu']);
$idd=$_POST['id'];
error_reporting(0);

$consulta="select num_notif from tbl_gestion_cobranzas where num_notif is null and id_gestion='".$idd."'"; 
$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){
  pg_query("update tbl_gestion_cobranzas 
	SET gestion_juridica=date 'now()', 
	ob_gesj=ob_gesj+1
	where id_gestion='".$idd."'") or die("Error de conexion. ". pg_last_error());
}
else{
   pg_query("update tbl_gestion_cobranzas 
	SET gestion_juridica=date 'now()', 
	ob_gesj=ob_gesj+1, num_notif=(select max(num_notif)+1 from tbl_gestion_cobranzas)
	where id_gestion='".$idd."'") or die("Error de conexion. ". pg_last_error());
}
pg_close();
?>