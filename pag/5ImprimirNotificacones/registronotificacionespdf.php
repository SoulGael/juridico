<?php 
# Cargamos la librería dompdf.
require_once("../dompdf/dompdf_config.inc.php");
include '../conexion.php';
conectarse();
$id=$_GET['id'];
$fe=$_GET['fecha'];
$ids = explode(",", $id);
$longitud=count($ids);

$codigo='<html >
  <head>

    <title>Saitel - Sistema Juridico</title>

    <link href="../../css/ayudas.css" rel="stylesheet">
    <link href="../dashboard.css" rel="stylesheet">

  </head>

  <body>';
for($n=0;$n<$longitud;$n++)
  {
    $consulta="select ubicacion,
    (select ubicacion from tbl_ubicacion where tbl_instalacion.id_ciudad=tbl_ubicacion.id_ubicacion)
    as ciudad,

    (select ubicacion from tbl_ubicacion where tbl_instalacion.id_parroquia=tbl_ubicacion.id_ubicacion)
    as parroquia,

    substring(tbl_instalacion.direccion_instalacion from 1 for 120), tbl_cliente.razon_social, tbl_cliente.telefono, 
    tbl_cliente.movil_claro, tbl_cliente.movil_movistar, tbl_prefactura.total ,
    tbl_plan_isp.plan, get_mes(tbl_gestion_cobranzas.fecha_periodo),extract(YEAR from tbl_gestion_cobranzas.fecha_periodo),
    (select nombre || ' ' || apellido from tbl_empleado where id_rol=8 and estado=true order by id_empleado desc limit 1) as abogado,
    (select to_char(tbl_gestion_cobranzas.num_notif,'000000')) as notificacion, tbl_instalacion.id_instalacion, tbl_instalacion.nombre_img
    from tbl_ubicacion, tbl_prefactura, tbl_cliente, tbl_instalacion, tbl_plan_isp, tbl_plan_servicio, tbl_gestion_cobranzas
    where tbl_cliente.id_cliente=tbl_instalacion.id_cliente 
    and tbl_instalacion.id_provincia=tbl_ubicacion.id_ubicacion
    and tbl_gestion_cobranzas.id_gestion=tbl_prefactura.id_prefactura
    and tbl_instalacion.id_plan_actual=tbl_plan_servicio.id_plan_servicio 
    and tbl_plan_isp.id_plan_isp=tbl_plan_servicio.id_plan_isp 
    and tbl_instalacion.id_instalacion=tbl_prefactura.id_instalacion    
    and id_gestion=".$ids[$n]."";
    $resultado=pg_query($consulta) or die (pg_last_error());

    while($fila=pg_fetch_array($resultado)){
      
      $nombre_fichero = '../anexos/'.$fila[15].'.JPG';
      if (file_exists($nombre_fichero)) {
      } else {
        $res = pg_query("select encode(croquis, 'base64') AS data FROM tbl_instalacion where id_instalacion=".$fila[14]."");  
        $raw = pg_fetch_result($res, 'data');
    
        // Convert to binary and send to the browser
        //header('Content-type: image/jpeg');
        //echo base64_decode($raw);

        $fp = fopen("../anexos/".$fila[15].".JPG", "x+");
        fputs($fp, base64_decode($raw));
        fclose($fp);
        //echo base64_decode($raw);        
      }

      //echo "<a href='reg.php?idfoto=".$fila[14]."></a>";
      $codigo.='<h5>Notificacion N.- '.$fila[13].'-DAJ-GC</h3>
      <DIV STYLE="position:absolute; top:0px; left:450px; width:50; height:70; visibility:visible; z-index:4"> 
      <IMG SRC="../../img/logosfondo.png" border=0  width=200; height=50;> 
      </DIV> 

      <h3 align=center>DEPARTAMENTO DE ASESORÍA JURÍDICA Y GESTION DE COBRANZAS</h3>
      <h2 align=center>NOTIFICACION Y REQUERIMIENTO DE PAGO INMEDIATO</h2>
      <h3 align=right>'.$fe.'</h3>
      Señor/a <br>
      '.$fila[4].'
      <p>Presente.-<br>
      Estimado Cliente:</p>
      <p align=justify>El Departamento de Asesoría Jurídica, ha iniciado el Proceso 
      Administrativo N°'.$fila[13].'-DAJ-GC por Gestión de cobranzas de cartera vencida 
      debido a los servicios recibidos en fechas anteriores, y que hasta el 
      momento se encuentran impago, en tal virtud, una vez agotada la gestión 
      telefónica, se procede, mediante la presente notificación escrita, a 
      extender el siguiente <b>REQUERIMIENTO DE PAGO INMEDIATO</h5></b>.
      <br>

      Por el valor de <b>'.$fila[8].'</b>. DOLARES AMERICANOS, correspondiente al
      periodo de facturación <b>'.$fila[10].'</b> del <b>'.$fila[11].'</b>.
      <br><br>

      Concediéndose un plazo perentorio final de 24 horas, afín de que el
      cliente, pueda saldar la deuda generada y extinguir sus obligaciones 
      financieras contractuales
      <br><br>

      Por otra parte debe recordarse al cliente que permanece vigente la
      cláusula contractual de GARANTÍA, como custodio de los equipos
      instalados, misma que pueda liberarse con la entrega física de los mismos 
      en las dependencias de la empresa, o por su ejecución.

      <br><br>
      En caso de negativa, se procederá a declarar al cliente como "deudor de mala fe",
      y remitir, dicha calificación a la Central de Riesgo Crediticio
      y Financiero, dentro del Sistema informático de Datos y Registros Comerciales, 
      registrándose al cliente moroso dentro del Buró de crédito 
      mencionado hasta el fiel cumplimiento de sus obligaciones, tiempo en el
      cual se generarán los intereses y costas procesales respectivas. Sin
      perjuicio de aquello, la empresa se reserva el derecho de continuar la
      gestión de cartera vencida por vía judicial. 
      <br><br>

      Particular que se notifica para los fines legales pertinentes.
      <br>

      <p align=center style="z-index:4">Atentamente</p><br>
      <img src="../../img/firma.png" style="position: absolute; top:720px; left:220px; width:170; height:85; z-index:3" />
      <p align=center  style="z-index:4">Abg. '.$fila[12].'</p>

      <p align=center><b>JEFE DE DEPARTAMENTO DE ASESORÍA JURÍDICA</b></p>

      <p align=center><b>Saitel Internet Wireless para el Ecuador Telf. 062610330</b></p>';

      $codigo.=' <h3 align=center>HOJA DE RUTA</h3>';

      $codigo.='
      <p><b>Ubicacion:</b> '.$fila[0].', '.$fila[1].', '.$fila[2].'</p>

      <p><b>Nombres:</b> '.$fila[4].'</p>

      <p><b>Dirección:</b> '.$fila[3].'></p>

      <p><b>Telefonos:</b> '.$fila[5].', '.$fila[6].', '.$fila[7].'</p>
      <p><h5>Notificacion N.- '.$fila[13].'-DAJ-GC</h3> Recibido:__________________ CI:__________________</p>
      <br><br>';
      
      $peso_archivo = filesize('../anexos/'.$fila[15].'.JPG');
      if ($peso_archivo>0) {
        $codigo.='<img src="../anexos/'.$fila[15].'.JPG" width="600" height="600">';
      } else {
        $codigo.='<img src="../anexos/404.jpg" width="600" height="600">';      
      }      

      $codigo.='<p align=center>*---------------------------------------------------------------------------------------------------------------*</p>';
      //imagedestroy($im);
    }
  }


  $codigo.='</body>
  </html>';

    $codigo=utf8_decode($codigo);
    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","1000M");
    ini_set("max_execution_time","1000");
    //$dompdf->set_paper("A4","portrait");
    @$dompdf->render();
    $dompdf->stream("Notificaciones.pdf");
    //$dompdf->stream('Notificaciones.pdf',array('Attachment'=>0));
pg_close();
?>
