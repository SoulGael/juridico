<?php 
session_start(); 
require_once("../dompdf/dompdf_config.inc.php");
include '../conexion.php';
conectarse();
$fe=$_GET['fec'];
$desde=$_GET['des'];
$hasta=$_GET['has'];
error_reporting(0);

$codigo='<html>
  <head>

    <title>Saitel - Sistema Juridico</title>

    <link href="../../css/ayudas.css" rel="stylesheet">
    <link href="../dashboard.css" rel="stylesheet">

  </head>

  <body>';

  $codigo.='
  <DIV STYLE="position:absolute; top:0px; left:50px; width:50; height:70; visibility:visible z-index:1"> 
      <IMG SRC="../../img/logosfondo.png" border=0  width=200; height=50;> 
      </DIV> 
      <h3 align=right>'.$fe.'</h3>
      <br><br>
      Dr.';

//---------Nombre del Abogado-----------------
$consulta="select (select nombre || ' ' || apellido as abogado from tbl_empleado where id_rol=8 and estado=true order by id_empleado desc limit 1),
get_mes(gc.fecha_periodo),
date_part('year',gc.fecha_periodo)
from tbl_gestion_cobranzas gc
where gc.fecha_periodo between '".$desde."' and '".$hasta."' limit 1";
 $resultado=pg_query($consulta) or die (pg_last_error());

 if(pg_num_rows($resultado)==0){}

 else{
  while($fila=pg_fetch_array($resultado)){
  $codigo.='<br>
      '.$fila[0].'<br>
      JEFE DEL DEPARTAMENTO JURÍDICO DE SAITEL.<br>
      Presente.-<br><br><br>
      Saludos Cordiales:<br>
      El presente tiene como finalidad informarle sobre lo relacionado con las Notificaciones realizadas del mes de '.$fila[1].' del año '.$fila[2].'.<br><br>
      De '.$fila[3].' clientes que estan Adeudando el mes antes mencionado, mi persona entrego las notificaciones a:<br>
      En la Notificacion 1:<br>';   
    }
  }


//---------Gestion uno-----------------
$consultag1="select count(reg_notif_ges1),c.notificacion_conclu 
from tbl_conclusiones_notif c, tbl_gestion_cobranzas gc 
where gc.reg_notif_ges1=c.notificacion_conclu 
and gc.fecha_periodo between '".$desde."' and '".$hasta."'
and gc.reg_notif_usu1='jvasquez'
group by notificacion_conclu;";
 $resultadog1=pg_query($consultag1) or die (pg_last_error());

 if(pg_num_rows($resultadog1)==0){}

 else{
  while($filag1=pg_fetch_array($resultadog1)){
  $codigo.='*'.$filag1[0].': '.$filag1[1].'<br>';   
    }
  }


//---------Gestion dos-----------------
$codigo.='<br>En la Notificacion 2:<br>';

$consultag2="select count(reg_notif_ges2),c.notificacion_conclu 
from tbl_conclusiones_notif c, tbl_gestion_cobranzas gc 
where gc.reg_notif_ges2=c.notificacion_conclu 
and gc.fecha_periodo between '".$desde."' and '".$hasta."'
and gc.reg_notif_usu2='jvasquez'
group by notificacion_conclu;";
 $resultadog2=pg_query($consultag2) or die (pg_last_error());

 if(pg_num_rows($resultadog2)==0){}

 else{
  while($filag2=pg_fetch_array($resultadog2)){
  $codigo.='*'.$filag2[0].': '.$filag2[1].'<br>';   
    }
  }

//---------Gestion tres-----------------
$codigo.='<br>En la Notificacion 3:<br>';

$consultag3="select count(reg_notif_ges3),c.notificacion_conclu 
from tbl_conclusiones_notif c, tbl_gestion_cobranzas gc 
where gc.reg_notif_ges3=c.notificacion_conclu 
and gc.fecha_periodo between '".$desde."' and '".$hasta."'
and gc.reg_notif_usu3='jvasquez'
group by notificacion_conclu;";
 $resultadog3=pg_query($consultag3) or die (pg_last_error());

 if(pg_num_rows($resultadog3)==0){}

 else{
  while($filag3=pg_fetch_array($resultadog3)){
  $codigo.='*'.$filag3[0].': '.$filag3[1].'<br>';   
    }
  }


$codigo.='<br>De los cuales:<br>';

$consultag4="select count(*),'PAGAN Y CONTINUAN' 
from tbl_gestion_cobranzas gc
where gc.fecha_periodo between '".$desde."' and '".$hasta."'
and gc.reg_notif_usu1='jvasquez'
and gestion_final='PAGAN Y CONTINUAN'
union
select count(*),'PAGAN Y SE RETIRAN' 
from tbl_gestion_cobranzas gc
where gc.fecha_periodo between '".$desde."' and '".$hasta."'
and gc.reg_notif_usu1='jvasquez'
and gestion_final='PAGAN Y SE RETIRAN';";
 $resultadog4=pg_query($consultag4) or die (pg_last_error());

 if(pg_num_rows($resultadog4)==0){}

 else{
  while($filag4=pg_fetch_array($resultadog4)){
  $codigo.='*'.$filag4[0].': '.$filag4[1].'<br>';   
    }
  }

//---------Final del Documento-----------------
$codigo.='<br>Es cuanto puedo comunicar.<br><br>';
$codigo.='Atentamente.<br><br><br><br><br><br>';

$consultaf="select nombre||' '||apellido as usuario, rol
 from vta_empleado
 where alias='".$_SESSION['usu']."'";
 $resultadof=pg_query($consultaf) or die (pg_last_error());

 if(pg_num_rows($resultadof)==0){}

 else{
  while($filaf=pg_fetch_array($resultadof)){
  $codigo.=''.$filaf[0].'<br>
  '.$filaf[1].'';   
    }
  }

    $codigo=utf8_decode($codigo);
    $dompdf= new DOMPDF();
    ini_set("memory_limit","1000M");
    ini_set("max_execution_time","1000");
    $dompdf->load_html($codigo);
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("Suspencion.pdf");
    $dompdf->stream('ReporteCobranzas.pdf',array('Attachment'=>0));
pg_close();
 ?>
