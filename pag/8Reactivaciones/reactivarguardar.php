<?php  
session_start();
include '../conexion.php';
conectarse();
//$q=($_GET['geu']);
$idd=$_POST['id'];
error_reporting(0);
pg_query("update tbl_instalacion set estado_servicio='a' 
	where id_instalacion=(select max(id_instalacion) 
		from tbl_instalacion 
		where id_cliente=(select id_cliente 
			from tbl_gestion_cobranzas 
			where id_gestion='".$idd."'))") or die("Error de conexion. ". pg_last_error());

pg_query("update tbl_orden_trabajo set estado='9', 
	recomendacion='EL CLIENTE SOLICITO REACTIVACION', 
	fecha_solucion=(date 'now()'), 
	solucionado=true, 
	hora_solucion=time 'now()', 
	usuario_solucion='".$_SESSION['usu']."'
	where id_instalacion=(select max(id_instalacion) 
		from tbl_instalacion 
		where id_cliente=(select id_cliente 
			from tbl_gestion_cobranzas 
			where id_gestion='".$idd."'))") or die("Error de conexion. ". pg_last_error());

pg_query("update tbl_instalacion_suspension set eliminado='true' where tipo='d' and id_instalacion=(select max(id_instalacion) from tbl_instalacion where id_cliente=(select id_cliente from tbl_gestion_cobranzas where id_gestion='".$idd."'))") or die("Error de conexion. ". pg_last_error());
pg_close();
?>