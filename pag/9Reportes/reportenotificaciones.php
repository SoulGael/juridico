	<?php
	include '../conexion.php';
	conectarse();
	session_start();
	$desde=$_POST['de'];
	$hasta=$_POST['ha'];
 /*
     Example10 : A 3D exploded pie graph
 */

 // Standard inclusions   
 include("../../grafica/pChart/pData.class");
 include("../../grafica/pChart/pChart.class");

 $DataSet = new pData;
 $consulta="select count(reg_notif_ges1),c.notificacion_conclu 
from tbl_conclusiones_notif c, tbl_gestion_cobranzas gc 
where gc.reg_notif_ges1=c.notificacion_conclu 
and gc.fecha_periodo between '".$desde."' and '".$hasta."'
and gc.reg_notif_usu1='jvasquez'
group by notificacion_conclu;";
 $resultado=pg_query($consulta) or die (pg_last_error());

 if(pg_num_rows($resultado)==0){
 	echo "<h2>Su usuario no ha realizado las Gestiones de Notificaciones<h2>";
 }

 else{
 	while($fila=pg_fetch_array($resultado)){ 		
 		$DataSet->AddPoint(array($fila[0]),"Serie1");
 		//$DataSet->AddPoint(array($fila[1]),"Serie2");
 		$DataSet->AddPoint(array($fila[1]." (".$fila[0].")"),"Serie2");
 	}

 	// Dataset definition 
 $DataSet->AddAllSeries();
 $DataSet->SetAbsciseLabelSerie("Serie2");

 // Initialise the graph
 $Test = new pChart(620,415);
 $Test->drawFilledRoundedRectangle(7,7,613,403,15,240,240,240);
 $Test->drawRoundedRectangle(5,5,615,405,5,230,230,130);
 $Test->createColorGradientPalette(15,42,140,227,89,55,1);

 // Draw the pie chart
 $Test->setFontProperties("../../grafica/Fonts/tahoma.ttf",8);
 $Test->AntialiasQuality = 0;
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),280,180,110,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
 $Test->drawPieLegend(330,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

 // Write the title
 $Test->setFontProperties("../../grafica/Fonts/MankSans.ttf",10);
 $Test->drawTitle(10,20,"Reporte de la Gestion de Notificaciones 1 \n Usuario: '".$_SESSION['usu']."'",100,100,100);

 $Test->Render("../anexos/reportenotificacion1.png");

 echo "<img class='img-rounded' alt='".$_SESSION['usu']."'  src='../anexos/reportenotificacion1.png' style='width: 513px; height: 403px;'>";

 //.....Notificacion 2...............................................................................

 $DataSet = new pData;
 $consulta="select count(reg_notif_ges2),c.notificacion_conclu 
from tbl_conclusiones_notif c, tbl_gestion_cobranzas gc 
where gc.reg_notif_ges2=c.notificacion_conclu 
and gc.fecha_periodo between '".$desde."' and '".$hasta."'
and gc.reg_notif_usu2='jvasquez'
group by notificacion_conclu;";
 $resultado=pg_query($consulta) or die (pg_last_error());

 if(pg_num_rows($resultado)==0){}

 else{
 	while($fila=pg_fetch_array($resultado)){ 		
 		$DataSet->AddPoint(array($fila[0]),"Serie1");
 		//$DataSet->AddPoint(array($fila[1]),"Serie2");
 		$DataSet->AddPoint(array($fila[1]." (".$fila[0].")"),"Serie2");
 	}
 }
 // Dataset definition 
 $DataSet->AddAllSeries();
 $DataSet->SetAbsciseLabelSerie("Serie2");

 // Initialise the graph
 $Test = new pChart(620,415);
 $Test->drawFilledRoundedRectangle(7,7,613,403,15,240,240,240);
 $Test->drawRoundedRectangle(5,5,615,405,5,230,230,130);
 $Test->createColorGradientPalette(15,42,140,227,89,55,1);

 // Draw the pie chart
 $Test->setFontProperties("../../grafica/Fonts/tahoma.ttf",8);
 $Test->AntialiasQuality = 0;
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),280,180,110,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
 $Test->drawPieLegend(330,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

 // Write the title
 $Test->setFontProperties("../../grafica/Fonts/MankSans.ttf",10);
 $Test->drawTitle(10,20,"Reporte de la Gestion de Notificaciones 2\n Usuario: '".$_SESSION['usu']."'",100,100,100);

 $Test->Render("../anexos/reportenotificacion2.png");

 echo "<img class='img-rounded' alt='".$_SESSION['usu']."'  src='../anexos/reportenotificacion2.png' style='width: 513px; height: 403px;'>";

 //.....Notificacion 3...............................................................................

 $DataSet = new pData;
 $consulta="select count(reg_notif_ges3),c.notificacion_conclu 
from tbl_conclusiones_notif c, tbl_gestion_cobranzas gc 
where gc.reg_notif_ges3=c.notificacion_conclu 
and gc.fecha_periodo between '".$desde."' and '".$hasta."'
and gc.reg_notif_usu3='jvasquez'
group by notificacion_conclu;";
 $resultado=pg_query($consulta) or die (pg_last_error());

 if(pg_num_rows($resultado)==0){}

 else{
 	while($fila=pg_fetch_array($resultado)){ 		
 		$DataSet->AddPoint(array($fila[0]),"Serie1");
 		//$DataSet->AddPoint(array($fila[1]),"Serie2");
 		$DataSet->AddPoint(array($fila[1]." (".$fila[0].")"),"Serie2");
 	}
 }
 // Dataset definition 
 $DataSet->AddAllSeries();
 $DataSet->SetAbsciseLabelSerie("Serie2");

 // Initialise the graph
 $Test = new pChart(620,415);
 $Test->drawFilledRoundedRectangle(7,7,613,403,15,240,240,240);
 $Test->drawRoundedRectangle(5,5,615,405,5,230,230,130);
 $Test->createColorGradientPalette(15,42,140,227,89,55,1);

 // Draw the pie chart
 $Test->setFontProperties("../../grafica/Fonts/tahoma.ttf",8);
 $Test->AntialiasQuality = 0;
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),280,180,110,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
 $Test->drawPieLegend(330,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

 // Write the title
 $Test->setFontProperties("../../grafica/Fonts/MankSans.ttf",10);
 $Test->drawTitle(10,20,"Reporte de la Gestion de Notificaciones 3 \n Usuario: '".$_SESSION['usu']."'",100,100,100);

 $Test->Render("../anexos/reportenotificacion3.png");

 echo "<img class='img-rounded' alt='".$_SESSION['usu']."'  src='../anexos/reportenotificacion3.png' style='width: 513px; height: 403px;'>";
 ini_set("memory_limit","1000M");
  ini_set("max_execution_time","1000");
 }

  //.....PAGADOS...............................................................................

 $DataSet = new pData;
 $consulta="select count(*),'PAGAN Y CONTINUAN' 
from tbl_gestion_cobranzas gc
where gc.fecha_periodo between '".$desde."' and '".$hasta."'
and gc.reg_notif_usu1='jvasquez'
and gestion_final='PAGAN Y CONTINUAN'
union
select count(*),'PAGAN Y SE RETIRAN' 
from tbl_gestion_cobranzas gc
where gc.fecha_periodo between '".$desde."' and '".$hasta."'
and gc.reg_notif_usu1='jvasquez'
and gestion_final='PAGAN Y SE RETIRAN'";
 $resultado=pg_query($consulta) or die (pg_last_error());

 if(pg_num_rows($resultado)==0){}

 else{
 	while($fila=pg_fetch_array($resultado)){ 		
 		$DataSet->AddPoint(array($fila[0]),"Serie1");
 		//$DataSet->AddPoint(array($fila[1]),"Serie2");
 		$DataSet->AddPoint(array($fila[1]." (".$fila[0].")"),"Serie2");
 	}
 }
 // Dataset definition 
 $DataSet->AddAllSeries();
 $DataSet->SetAbsciseLabelSerie("Serie2");

 // Initialise the graph
 $Test = new pChart(620,415);
 $Test->drawFilledRoundedRectangle(7,7,613,403,15,240,240,240);
 $Test->drawRoundedRectangle(5,5,615,405,5,230,230,130);
 $Test->createColorGradientPalette(15,42,140,227,89,55,1);

 // Draw the pie chart
 $Test->setFontProperties("../../grafica/Fonts/tahoma.ttf",8);
 $Test->AntialiasQuality = 0;
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),280,180,110,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
 $Test->drawPieLegend(330,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

 // Write the title
 $Test->setFontProperties("../../grafica/Fonts/MankSans.ttf",10);
 $Test->drawTitle(10,20,"Reporte de la Gestion de Notificaciones 3 \n Usuario: '".$_SESSION['usu']."'",100,100,100);

 $Test->Render("../anexos/reportenotificacion4.png");

 echo "<img class='img-rounded' alt='".$_SESSION['usu']."'  src='../anexos/reportenotificacion4.png' style='width: 513px; height: 403px;'>";
 ini_set("memory_limit","1000M");
  ini_set("max_execution_time","1000");
 pg_close();
 
?>