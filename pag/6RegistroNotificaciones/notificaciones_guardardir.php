<?php  
session_start(); 
include '../conexion.php';
conectarse();
$idd=$_POST['id'];
$dire=$_POST['dir'];

error_reporting(0);
pg_query("update tbl_instalacion set direccion_instalacion='".$dire."' 
	where id_instalacion=(select id_instalacion from tbl_prefactura where id_prefactura='".$idd."')") 
	or die("Error de conexion. ". pg_last_error());
echo "<div class='alert alert-success'>Direccion Nueva Guardada Exitosamente</div>";
pg_close();
?>