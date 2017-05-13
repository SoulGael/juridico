<?php 
session_start(); 
require_once("../dompdf/dompdf_config.inc.php");
include '../conexion.php';
conectarse();
$nombre=$_GET['nomb'];
$cedula=$_GET['cedu'];
$plan=$_GET['pla'];
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

  Sr. Ing.<br>
  Freddy Rosero<br>
  GERENTE GENERAL<br><br>
  
  Presente<br>
  De mi consideración:<br>
  
  <p align=justify>Yo, '.$nombre.' con número de identificación '.$cedula.' solicito autorice a quien corresponda la 
  CANCELACION DEFINITIVA del plan contratado '.$plan.', por así convenir a mis intereses personales. 
  Se aclara que el consumo del presente mes y año lo cancelaré en estricto apego al contrato que suscribí 
  con la Empresa; a fin de que acto seguido se proceda con la desinstalación de los equipos de propiedad exclusiva de SAITEL.
  <br><br>
  Seguro(a) que éste pedido tendrá respuesta favorable agradezco la atención prestada.</p>
  <br><br>
  <p align=center><b>Atentamente</b><br><br><br><br><br><br>
  '.$nombre.'<br>
  CI: '.$cedula.'</p>';

$codigo.='</body>
  </html>';

    $codigo=utf8_decode($codigo);
    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    //$dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("Suspencion.pdf");
    $dompdf->stream('Notificaciones.pdf',array('Attachment'=>0));
pg_close();
 ?>