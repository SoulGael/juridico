<?php 
session_start(); 
require_once("../dompdf/dompdf_config.inc.php");
include '../conexion.php';
conectarse();
$nombre=$_GET['nomb'];
$cedula=$_GET['cedu'];
$fe=$_GET['fec'];
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
      <br><br><br>
      Señor Ing.<br>
      Freddy Rosero<br>
      GERENTE GENERAL<br><br>

      Presente.-<br><br>

      <p align=justify>Yo, '.$nombre.', portador de la cédula de identidad número '.$cedula.', solicito comedidamente se sirva disponer 
      previo el trámite que corresponda, la reactivación del servicio de Internet a partir de '.$fe.', 
      por convenir a mis intereses personales. En tal virtud, autorizo se deje sin efecto la suspensión conforme lo solicitado.<br>

      Se aclara que la tarifa por consumo del mes reactivado será completa; toda vez que, he sido informado de forma 
      clara y precisa los efectos de la presente solicitud, de conformidad con lo dispuesto en el artículo 5, 
      numeral 4 de la Ley Orgánica de defensa del consumidor que tipifica: 
      "Informarse responsablemente de las condiciones de uso de los bienes y servicios a consumirse.".</p><br><br><br>
      
      <p align=center><b>Atentamente</b><br><br><br><br>
      '.$nombre.'<br>
      CI: '.$cedula.'</p>
      ';

$codigo.='</body>
  </html>';

    $codigo=utf8_decode($codigo);
    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    //$dompdf->set_paper("A4","portrait");
    $dompdf->render();
    $dompdf->stream("Suspencion.pdf");
    //$dompdf->stream('Reactivacion.pdf',array('Attachment'=>0));
pg_close();
 ?>