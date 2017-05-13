<?php
session_start();
include '../conexion.php';
conectarse();
//$q=($_GET['geu']);
$id=$_POST['id'];
$ges=$_POST['ges'];
$area=$_POST['ar'];
$nombre=$_POST['nomb'];
$opcion=$_POST['opc'];
$usuario=$_POST['usu'];

$gesf='';
error_reporting(0);

/*$ids = explode(".,", $id);
$longitud=count($ids);
$gesuno = explode(".,", $ges1);
$gesdos = explode(".,", $ges2);
$area1 = explode(".,", $are1);
$area2 = explode(".,", $are2);
$opciones = explode(".,", $opcion);
$nombres = explode(".,", $nombre);*/
if (strcmp($opcion, 'gestion1')==0) {
	if (strcmp(strtoupper($ges),'PAGAN Y CONTINUAN')== 0||strcmp(strtoupper($ges),"PAGAN Y SE RETIRAN")== 0||strcmp(strtoupper($ges),"ERRORES VARIOS")== 0)
	{
		pg_query("update tbl_gestion_cobranzas set gestion1='".$ges."', gestion2='".$ges."', ob_ges1=date 'now()'||': ".$area."', gestion_final='".$ges."', gestion_juridica=date 'now()', usuario='".$usuario."', usuario2='".$usuario."' where id_gestion=".$id."") or die("Error de conexion. ". pg_last_error());
		echo "<td colspan='11'><div class='alert alert-success'><strong>".$nombre." </strong> Gestion Guardada con: ".$ges." y '".$area."'</div></td>";
	}
	else
	{
		pg_query("update tbl_gestion_cobranzas set gestion1='".$ges."', gestion2='', ob_ges1=date 'now()'||': ".$area."', usuario='".$usuario."' where id_gestion=".$id."") or die("Error de conexion. ". pg_last_error());
		echo "<td colspan='11'><div class='alert alert-success'><strong>".$nombre." </strong> Gestion Guardada con: ".$ges." y '".$area."'</div></td>";
	}
}

if (strcmp($opcion, 'gestion2')==0) {
	if (strcmp(strtoupper($ges),'PAGAN Y CONTINUAN')== 0||strcmp(strtoupper($ges),"PAGAN Y SE RETIRAN")== 0||strcmp(strtoupper($ges),"ERRORES VARIOS")== 0)
	{
		pg_query("update tbl_gestion_cobranzas set gestion2='".$ges."', ob_ges2=date 'now()'||': ".$area."', gestion_final='".$ges."', usuario2='".$usuario."', gestion_juridica=date 'now()' where id_gestion=".$id."") or die("Error de conexion. ". pg_last_error());
		echo "<td colspan='11'><div class='alert alert-info'><strong>".$nombre." </strong> Gestion Dos Guardada con: ".$ges." y '".$area."'</div></td>";
	}
	else
	{
		pg_query("update tbl_gestion_cobranzas set gestion2='".$ges."', ob_ges2=date 'now()'||': ".$area."', usuario2='".$usuario."' where id_gestion=".$id."") or die("Error de conexion. ". pg_last_error());
		echo "<td colspan='11'><div class='alert alert-info'><strong>".$nombre." </strong> Gestion Dos Guardada con: ".$ges." y '".$area."'</div></td>";
	}
}

if (strcmp($opcion, 'gestion3')==0) {
	pg_query("update tbl_gestion_cobranzas set gestion_final='".$ges."', ob_gestion_juridica=date 'now()'||': ".$area."', usuario_juridico='".$usuario."' where id_gestion=".$id."") or die("Error de conexion. ". pg_last_error());
	echo "<td colspan='11'><div class='alert alert-info'><strong>".$nombre." </strong> Gestion Juridica Guardada con: ".$ges." y '".$area."'</div></td>";
}

//Gestion de Cobros
if (strcmp($opcion, 'gestionc1')==0) {
	if (strcmp(strtoupper($ges),'PAGAN Y CONTINUAN')== 0||strcmp(strtoupper($ges),"PAGAN Y SE RETIRAN")== 0||strcmp(strtoupper($ges),"ERRORES VARIOS")== 0)
	{
		pg_query("update tbl_gestion_cobranzas_cobros set gestion1='".$ges."', gestion2='".$ges."', ob_ges1=date 'now()'||': ".$area."', gestion_final='".$ges."', gestion_juridica=date 'now()', usuario='".$usuario."', usuario2='".$usuario."' where id_gestion=".$id."") or die("Error de conexion. ". pg_last_error());
		echo "<td colspan='11'><div class='alert alert-success'><strong>".$nombre." </strong> Gestion Guardada con: ".$ges." y '".$area."'</div></td>";
	}
	else
	{
		pg_query("update tbl_gestion_cobranzas_cobros set gestion1='".$ges."', gestion2='', ob_ges1=date 'now()'||': ".$area."', usuario='".$usuario."' where id_gestion=".$id."") or die("Error de conexion. ". pg_last_error());
		echo "<td colspan='11'><div class='alert alert-success'><strong>".$nombre." </strong> Gestion Guardada con: ".$ges." y '".$area."'</div></td>";
	}
}

if (strcmp($opcion, 'gestionc2')==0) {
	if (strcmp(strtoupper($ges),'PAGAN Y CONTINUAN')== 0||strcmp(strtoupper($ges),"PAGAN Y SE RETIRAN")== 0||strcmp(strtoupper($ges),"ERRORES VARIOS")== 0)
	{
		pg_query("update tbl_gestion_cobranzas_cobros set gestion2='".$ges."', ob_ges2=date 'now()'||': ".$area."', gestion_final='".$ges."', usuario2='".$usuario."', gestion_juridica=date 'now()' where id_gestion=".$id."") or die("Error de conexion. ". pg_last_error());
		echo "<td colspan='11'><div class='alert alert-info'><strong>".$nombre." </strong> Gestion Dos Guardada con: ".$ges." y '".$area."'</div></td>";
	}
	else
	{
		pg_query("update tbl_gestion_cobranzas_cobros set gestion2='".$ges."', ob_ges2=date 'now()'||': ".$area."', usuario2='".$usuario."' where id_gestion=".$id."") or die("Error de conexion. ". pg_last_error());
		echo "<td colspan='11'><div class='alert alert-info'><strong>".$nombre." </strong> Gestion Dos Guardada con: ".$ges." y '".$area."'</div></td>";
	}
}

if (strcmp($opcion, 'gestionc3')==0) {
	pg_query("update tbl_gestion_cobranzas_cobros set gestion_final='".$ges."', ob_gestion_juridica=date 'now()'||': ".$area."', usuario_juridico='".$usuario."' where id_gestion=".$id."") or die("Error de conexion. ". pg_last_error());
	echo "<td colspan='11'><div class='alert alert-info'><strong>".$nombre." </strong> Gestion Juridica Guardada con: ".$ges." y '".$area."'</div></td>";
}
pg_close();
?>