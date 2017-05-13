<?php   
 /* CAT:Pie charts */

  include '../conexion.php';
  conectarse();
  session_start();
  $desde=$_GET['desde'];
  $hasta=$_GET['hasta'];

  $contus=0;
  $i=0;
  
  $lista_usuario = array();
  $lista_requerimiento = array();

  $consultaj="select distinct usuario as us 
  from tbl_gestion_cobranzas gc where (gc.fecha_periodo between '".$desde."' and '".$hasta."')  and gestion_final not in ('') and usuario not in('') order by us desc";

  $resultadoj=pg_query($consultaj) or die (pg_last_error());

  if(pg_num_rows($resultadoj)!=0){

    
    while($filaj=pg_fetch_array($resultadoj)){ 

      $consulta="select count(gc.gestion1) ,c.requerimiento, (CASE WHEN usuario='' THEN 'cliente' ELSE COALESCE(usuario,'cliente') END)||' (GESTION 1)' as usuario 
      from tbl_conclusiones c, tbl_gestion_cobranzas gc 
      where (gc.fecha_periodo between '".$desde."' and '".$hasta."') 
      and gc.gestion1=c.requerimiento 
      and gc.usuario='".$filaj[0]."'
      group by c.requerimiento, usuario
      order by usuario desc";

      $lista_usuario[$contus]=$filaj[0]." (GESTION 1)";

      $resultado=pg_query($consulta) or die (pg_last_error());
      if(pg_num_rows($resultado)!=0){
        while($fila=pg_fetch_array($resultado)){  
          if($fila[0]> 0 && strcmp($fila[1], "")){
            $lista_requerimiento[0][$i]=$fila[2];
            $lista_requerimiento[1][$i]=$fila[1];
            $lista_requerimiento[2][$i]=$fila[0];
            $i++;
          }
        }
      }
      $contus++;
    }
 }

 $consultaj2="select distinct usuario2 as us 
 from tbl_gestion_cobranzas gc where (gc.fecha_periodo between '".$desde."' and '".$hasta."')  and gestion_final not in ('') and usuario2 not in('') order by us desc";
 
 $resultadoj2=pg_query($consultaj2) or die (pg_last_error());

if(pg_num_rows($resultadoj2)!=0){

  while($filaj2=pg_fetch_array($resultadoj2)){ 

    $consulta2="select count(gc.gestion2) ,c.requerimiento, (CASE WHEN usuario2='' THEN 'cliente' ELSE COALESCE(usuario2,'cliente') END)||' (GESTION 2)' as usuario 
      from tbl_conclusiones c, tbl_gestion_cobranzas gc 
      where (gc.fecha_periodo between '".$desde."' and '".$hasta."') 
      and gc.gestion2=c.requerimiento 
      and gc.usuario2='".$filaj2[0]."'
      group by c.requerimiento, usuario2
      order by usuario2 desc";

    $lista_usuario[$contus]=$filaj2[0]." (GESTION 2)";

    $resultado2=pg_query($consulta2) or die (pg_last_error());
    if(pg_num_rows($resultado2)!=0){
      while($fila2=pg_fetch_array($resultado2)){  
        if($fila2[0]> 0 && strcmp($fila2[1], "")){
          $lista_requerimiento[0][$i]=$fila2[2];
          $lista_requerimiento[1][$i]=$fila2[1];
          $lista_requerimiento[2][$i]=$fila2[0];
          $i++;
        }   
      }
    }
    $contus++;
  }
}

$lista_1[] = array('usuario' => $lista_usuario, 'requerimiento' => $lista_requerimiento);
 echo $_GET['callback']."(".json_encode($lista_1).");";

//Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
//header('Content-type: application/json; charset=utf-8');
 
//echo json_encode($jsondata);

pg_close();

?>