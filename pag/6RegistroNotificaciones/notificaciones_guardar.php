<?php  
session_start(); 
include '../conexion.php';
conectarse();
$ges1=$_POST['g1'];
$ges2=$_POST['g2'];
$ges3=$_POST['g3'];
$gesf='';
$are1=$_POST['a1'];
$are2=$_POST['a2'];
$are3=$_POST['a3'];
$id=$_POST['id'];
$opcion=$_POST['op'];
$usuar=$_SESSION['usu'];

error_reporting(0);
if(!strcmp(strtolower($ges1), 'notificacion entregada')||!strcmp(strtolower($ges2), 'notificacion entregada')||!strcmp(strtolower($ges3), 'notificacion entregada'))
{
pg_query("update tbl_gestion_cobranzas 
	SET gestion_juridica=date 'now()', 
	impresion=true 
	where id_gestion='".$id."'") or die("Error de conexion. ". pg_last_error());
}

if(!strcmp(strtolower($ges1), 'notificacion entregada'))
{
pg_query("update tbl_instalacion 
	set estado_servicio='n' 
	where id_instalacion=(select max(id_instalacion) 
		from tbl_instalacion 
		where id_cliente=(select id_cliente from tbl_gestion_cobranzas where id_gestion='".$id."')) and estado_servicio!='a'") or die("Error de conexion. ". pg_last_error());	

pg_query("update tbl_gestion_cobranzas set 
	reg_notif_ges2='".$ges1."', reg_notif_usu2='".$usuar."', reg_notif_fecha2=date 'now()', 
	reg_notif_ges3='".$ges1."', reg_notif_usu3='".$usuar."', reg_notif_fecha3=date 'now()'
	where id_gestion='".$id."'") or die("Error de conexion. ". pg_last_error());
}

if(!strcmp(strtolower($ges2), 'notificacion entregada'))
{
pg_query("update tbl_gestion_cobranzas 
	SET gestion_juridica=date 'now()', 
	impresion=true 
	where id_gestion='".$id."'") or die("Error de conexion. ". pg_last_error());

pg_query("update tbl_instalacion 
	set estado_servicio='n' 
	where id_instalacion=(select max(id_instalacion) 
		from tbl_instalacion 
		where id_cliente=(select id_cliente from tbl_gestion_cobranzas where id_gestion='".$id."')) and estado_servicio!='a'") or die("Error de conexion. ". pg_last_error());	

pg_query("update tbl_gestion_cobranzas set  
	reg_notif_ges3='".$ges2."', reg_notif_usu3='".$usuar."', reg_notif_fecha3=date 'now()'
	where id_gestion='".$id."'") or die("Error de conexion. ". pg_last_error());
}


if (!strcmp($opcion, 'gestion1')) 
{
	pg_query("update tbl_gestion_cobranzas set reg_notif_ges1='".$ges1."', reg_notif_ob1='".$are1."', reg_notif_usu1='".$usuar."', reg_notif_fecha1=date 'now()' where id_gestion='".$id."'") or die("Error de conexion. ". pg_last_error());
	echo '<div class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Exito!</strong> Gestion 1 Guardada 
	</div>';
}

if (!strcmp($opcion, 'gestion2'))
{
	pg_query("update tbl_gestion_cobranzas set reg_notif_ges2='".$ges2."', reg_notif_ob2='".$are2."', reg_notif_usu2='".$usuar."', reg_notif_fecha2=date 'now()' where id_gestion='".$id."'") or die("Error de conexion. ". pg_last_error());
	echo '<div class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Exito!</strong> Gestion 2 Guardada 
	</div>';
}

if (!strcmp($opcion, 'gestion3'))
{
	pg_query("update tbl_gestion_cobranzas set reg_notif_ges3='".$ges3."', reg_notif_ob3='".$are3."', reg_notif_usu3='".$usuar."', reg_notif_fecha3=date 'now()' where id_gestion='".$id."'") or die("Error de conexion. ". pg_last_error());
	echo '<div class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Exito!</strong> Gestion 3 Guardada 
	</div>';

}  
pg_close();
?>