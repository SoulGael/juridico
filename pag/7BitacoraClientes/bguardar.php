<?php 
session_start(); 
include '../conexion.php';
conectarse();
$id=$_POST['id'];
$interes=$_POST['inter'];
$cobrado=$_POST['cobra'];
$deuda=$_POST['deud'];
$conclusion=$_POST['co'];
error_reporting(0);

$codigo='<html>
  <head>

    <title>Saitel - Sistema Juridico</title>

    <link href="../../css/ayudas.css" rel="stylesheet">
    <link href="../dashboard.css" rel="stylesheet">

  </head>

  <body>';

$consulta="select g.id_gestion, c.ruc, p.valor_internet
from tbl_ubicacion u, tbl_prefactura p, tbl_cliente c, tbl_instalacion i, tbl_plan_isp l, tbl_plan_servicio s, tbl_gestion_cobranzas g
where c.id_cliente=i.id_cliente 
and g.gestion2 not in('PAGAN Y SE RETIRAN','ERRORES VARIOS','PAGAN Y CONTINUAN','')
and c.id_provincia=u.id_ubicacion
and g.id_gestion=p.id_prefactura
and i.id_plan_actual=s.id_plan_servicio 
and l.id_plan_isp=s.id_plan_isp 
and i.id_instalacion=p.id_instalacion 
and p.fecha_emision is null 
and g.impresion=true 
and (age(date 'now()',date(g.gestion_juridica)))<'4 days'
and g.id_gestion='".$id."'
order by plan='CORPORATIVO' desc, 
plan='CORPORATIVO ESPECIAL' desc, plan='SMALL' desc, plan='SMALL ESPECIAL' desc, 
plan='RESIDENCIAL' desc, plan='RESIDENCIAL ESPECIAL' desc, plan='NOCTURNO' desc, 
plan='NOCTURNO ESPECIAL' desc, valor_internet desc,
ob_gesj desc;"; 
$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){
  pg_query("update tbl_gestion_cobranzas set gestion_juridica=date 'now()', gestion_final='".$conclusion."', 
    interes_generado='".$interes."', 
    cobrado='".$cobrado."', 
    valor_deuda='".$deuda."',
    orden_trabajo='TRUE'
    where id_gestion='".$id."'") or die("Error de conexion. ". pg_last_error());
}
else{
   pg_query("update tbl_gestion_cobranzas set gestion_juridica=date 'now()', gestion_final='".$conclusion."', 
    interes_generado='".$interes."', 
    cobrado='".$cobrado."', 
    valor_deuda='".$deuda."',
    orden_trabajo='TRUE'
    where id_gestion='".$id."'") or die("Error de conexion. ". pg_last_error());
}

if(!strcmp($conclusion, "PAGAN Y CONTINUAN"))
{
  pg_query("update tbl_instalacion set estado_servicio='a' where id_instalacion=(select id_instalacion from tbl_prefactura where id_prefactura='".$id."')") or die("Error de conexion. ". pg_last_error());
}
if(!strcmp($conclusion, "POR RETIRAR"))
{
  pg_query("update tbl_instalacion set estado_servicio='r' where id_instalacion=(select max(id_instalacion) from tbl_instalacion where id_cliente=(select id_cliente from tbl_gestion_cobranzas where id_gestion='".$id."'))") or die("Error de conexion. ". pg_last_error());
  pg_query("insert into tbl_orden_trabajo(id_instalacion, id_sucursal, num_orden, fecha_reporte, tipo_trabajo, diagnostico_tecnico, usuario_reporte, usuario_cliente, estado) 
values
(select id_instalacion from tbl_prefactura where id_prefactura='".$id."'),
(select id_sucursal from tbl_instalacion where id_cliente=(select id_cliente from tbl_gestion_cobranzas where id_gestion='".$id."'),
(select (max(num_orden)::int)+1 from tbl_orden_trabajo where id_sucursal=(select id_sucursal from tbl_instalacion where id_cliente=(select id_cliente from tbl_gestion_cobranzas where id_gestion='".$id."')), 
date 'now()',
'4', 
'RETIRO DE EQUIPOS POR PEDIDO DEL CLIENTE',
'".$_SESSION['usu']."', 
'', 
1)") 
    or die('<script language="javascript">
      alert("El Dato no fue ingresado");
      </script>' );
}
if(!strcmp($conclusion, "SALDADO"))
{
  pg_query("update tbl_instalacion set estado_servicio='d' where id_instalacion=(select id_instalacion from tbl_prefactura where id_prefactura='".$id."')") or die("Error de conexion. ". pg_last_error());
}
if(!strcmp($conclusion, "PAGAN Y SE RETIRAN"))
{
  pg_query("update tbl_instalacion set estado_servicio='t' where id_instalacion=(select id_instalacion from tbl_prefactura where id_prefactura='".$id."')") or die("Error de conexion. ". pg_last_error());
}
if(!strcmp($conclusion, "EQUIPOS DEVUELTOS"))
{
  pg_query("update tbl_instalacion set estado_servicio='e' where id_instalacion=(select id_instalacion from tbl_prefactura where id_prefactura='".$id."')") or die("Error de conexion. ". pg_last_error());
}
pg_close();
 ?>