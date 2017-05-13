<?php 
session_start(); 
include '../conexion.php';
conectarse();
$tipo=$_POST['q'];
$desde=$_POST['r'];
$hasta=$_POST['s'];
$sucu=$_POST['suc'];
$cont=1;
error_reporting(0);
$consultausu="select tbl_pagina.pagina from tbl_pagina, tbl_privilegio where tbl_privilegio.id_pagina=tbl_pagina.id_pagina and tbl_privilegio.id_rol='".$_SESSION['idrol']."' and pagina='gestionfinal' and tbl_pagina.modulo='10' order by tbl_pagina.id_pagina"; 
$resultadousu=pg_query($consultausu) or die (pg_last_error());
$filausu=pg_fetch_array($resultadousu);


//PARA GESTION DE COBRANZAS EN PREFACTURAS
$consulta="select p.id_prefactura, i.id_cliente, p.periodo  
    from tbl_prefactura p, vta_instalacion i
    where p.id_instalacion=i.id_instalacion
    and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucu."')
    and p.fecha_emision is null and (p.periodo between '".$desde."' and '".$hasta."')";
$resultado=pg_query($consulta); 

if(pg_num_rows($resultado)!=0){
  while($fila=pg_fetch_array($resultado)){
    pg_query("insert into tbl_gestion_cobranzas (id_gestion,id_cliente,fecha_periodo,gestion1,gestion2,ob_ges1,ob_ges2,gestion_final) values ('".$fila[0]."', '".$fila[1]."', '".$fila[2]."','','','','','')");   
  }
}

$con="select p.id_prefactura, g.id_gestion, g.gestion1, g.gestion2, g.gestion_juridica, g.gestion_final,
g.fecha_periodo, i.razon_social, g.usuario, g.usuario2
from tbl_prefactura p, vta_instalacion i, tbl_gestion_cobranzas g
where i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucu."')
and p.id_instalacion=i.id_instalacion
and p.id_prefactura=g.id_gestion
and i.estado_servicio in ('a','s','c')
and p.fecha_emision is not null 
and (p.periodo between '".$desde."' and '".$hasta."')";
$res=pg_query($con) or die (pg_last_error());

if(pg_num_rows($res)!=0){
  $fin='PAGAN Y CONTINUAN';
  $sal=0;
  while($fila=pg_fetch_array($res)){
    if(strcmp ($fila[2],"")== 0){
        pg_query("update tbl_gestion_cobranzas set gestion1='".$fin."', gestion2='".$fin."', gestion_juridica=date 'now()', gestion_final='".$fin."', usuario='cliente', usuario2='cliente' where id_gestion='".$fila[1]."'") or die("Error de conexion. ". pg_last_error());
        echo "<div class='alert alert-success'><strong>".$fila[7]." </strong> Ya cancelo el valor de su factura</div>";
        $sal=1;
      }
     if(strcmp ($fila[3],'')== 0&& strcmp ($sal,0)== 0){
        pg_query("update tbl_gestion_cobranzas set gestion2='".$fin."', gestion_juridica=date 'now()', gestion_final='".$fin."', usuario2='".$fila[9]."' where id_gestion='".$fila[1]."'") or die("Error de conexion. ". pg_last_error());
        echo "<div class='alert alert-success'><strong>".$fila[7]." </strong> Ya cancelo el valor de su factura despues de la primera llamada de <strong>".$fila [8]."</strong></div>";
        $sal=1;
      }
    if(strcmp ($fila[5],'')== 0&& strcmp ($sal,0)== 0){
        pg_query("update tbl_gestion_cobranzas set gestion_final='".$fin."', usuario_juridico='".$fila[9]."' where id_gestion='".$fila[1]."'") or die("Error de conexion. ". pg_last_error());
        echo "<div class='alert alert-success'><strong>".$fila[7]." </strong> Ya cancelo el valor de su factura despues de la segunda llamada de <strong>".$fila [8]." y ".$fila [9]."</strong></div>";
      }
    //pg_query("update tbl_gestion_cobranzas set gestion1='".$ges1."', gestion2='".$ges2."', ob_ges1='".$are1."', ob_ges2='".$are2."', gestion_final='".$gesf."' where id_gestion='".$id."'") or die("Error de conexion. ". pg_last_error());
  }
}

$con="select p.id_prefactura, g.id_gestion, g.gestion1, g.gestion2, g.gestion_juridica, g.gestion_final,
g.fecha_periodo, i.razon_social, g.usuario, g.usuario2
from tbl_prefactura p, vta_instalacion i, tbl_gestion_cobranzas g
where i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucu."')
and p.id_instalacion=i.id_instalacion
and p.id_prefactura=g.id_gestion
and i.estado_servicio in('t','r','d','e')
and p.fecha_emision is not null 
and (p.periodo between '".$desde."' and '".$hasta."')";
$res=pg_query($con) or die (pg_last_error());

if(pg_num_rows($res)!=0){
  $fin='PAGAN Y SE RETIRAN';
  $sal=0;
  while($fila=pg_fetch_array($res)){
    $sal=0;
    if(strcmp ($fila[2],'')== 0){
        pg_query("update tbl_gestion_cobranzas set gestion1='".$fin."', gestion2='".$fin."', gestion_juridica=date 'now()', gestion_final='".$fin."', usuario='cliente', usuario2='cliente' where id_gestion='".$fila[1]."'") or die("Error de conexion. ". pg_last_error());
        echo "<div class='alert alert-success'><strong>".$fila[7]." </strong> Ya cancelo el valor de su factura <strong>SE RETIRO</strong></div>";
        $sal=1;
      }
    if(strcmp ($fila[3],'')== 0&& strcmp ($sal,0)== 0){
        pg_query("update tbl_gestion_cobranzas set gestion2='".$fin."', gestion_juridica=date 'now()', gestion_final='".$fin."', usuario2='".$fila[9]."' where id_gestion='".$fila[1]."'") or die("Error de conexion. ". pg_last_error());
        echo "<div class='alert alert-success'><strong>".$fila[7]." </strong> Ya cancelo el valor de su factura despues de la primera llamada de <strong>".$fila [8]." SE RETIRO</strong></div>";
        $sal=1;
      }
    if(strcmp ($fila[5],'')== 0&& strcmp ($sal,0)== 0){
        pg_query("update tbl_gestion_cobranzas set gestion_final='".$fin."' where id_gestion='".$fila[1]."'") or die("Error de conexion. ". pg_last_error());
        echo "<div class='alert alert-success'><strong>".$fila[7]." </strong> Ya cancelo el valor de su factura despues de la segunda llamada de <strong>".$fila [8]." y ".$fila [9]." SE RETIRO</strong></div>";
      }
    //pg_query("update tbl_gestion_cobranzas set gestion1='".$ges1."', gestion2='".$ges2."', ob_ges1='".$are1."', ob_ges2='".$are2."', gestion_final='".$gesf."' where id_gestion='".$id."'") or die("Error de conexion. ". pg_last_error());
  }
}


if(strcmp($tipo, "TODOS")== 0){
    $consulta="select  i.razon_social, i.telefono, i.movil_claro, i.movil_movistar, 
    i.plan, p.total, g.gestion1, g.gestion2, g.gestion_juridica, g.id_gestion, 
    g.ob_ges1, g.ob_ges2, g.ob_gesj, g.gestion_final, 
    g.usuario, g.usuario2, i.txt_estado_servicio, g.ob_gestion_juridica, g.usuario_juridico,
    i.email
    from vta_instalacion i, tbl_prefactura p, tbl_gestion_cobranzas g
    where p.id_instalacion=i.id_instalacion
    and p.id_prefactura=g.id_gestion
    and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucu."')
    and p.fecha_emision is null and (p.periodo between '".$desde."' and '".$hasta."')
    order by i.plan='CORPORATIVO' desc, i.plan='CORPORATIVO' desc, i.plan='SMALL' desc, 
    i.plan='SMALL ESPECIAL' desc, i.plan='RESIDENCIAL' desc, i.plan='RESIDENCIAL ESPECIAL' desc, 
    i.plan='NOCTURNO' desc, i.plan='NOCTURNO ESPECIAL' desc, 
    p.total desc, i.razon_social asc";
    $resultado=pg_query($consulta) or die (pg_last_error());
  }
else{
  $consulta="select  i.razon_social, i.telefono, i.movil_claro, i.movil_movistar, 
  i.plan, p.total, g.gestion1, g.gestion2, g.gestion_juridica, g.id_gestion, 
  g.ob_ges1, g.ob_ges2, g.ob_gesj, g.gestion_final, 
  g.usuario, g.usuario2, i.txt_estado_servicio, g.ob_gestion_juridica, g.usuario_juridico,
  i.email
  from vta_instalacion i, tbl_prefactura p, tbl_gestion_cobranzas g
  where p.id_instalacion=i.id_instalacion
  and p.id_prefactura=g.id_gestion
  and g.gestion_final in ('')
  and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucu."')
  and p.fecha_emision is null and (p.periodo between '".$desde."' and '".$hasta."')
  and i.plan='".$tipo."' 
  order by i.plan='CORPORATIVO' desc, i.plan='CORPORATIVO' desc, i.plan='SMALL' desc, 
  i.plan='SMALL ESPECIAL' desc, i.plan='RESIDENCIAL' desc, i.plan='RESIDENCIAL ESPECIAL' desc, 
  i.plan='NOCTURNO' desc, i.plan='NOCTURNO ESPECIAL' desc, 
  p.total desc, i.razon_social asc";
  $resultado=pg_query($consulta) or die (pg_last_error());
}

if(pg_num_rows($resultado)==0){
  echo '<b>No hay sugerencias</b>';
}
else{
  $consultatot="select count(*), 
    (select count(*) from tbl_gestion_cobranzas where usuario='". $_SESSION['usu']."' and fecha_periodo between '".$desde."' and '".$hasta."') usuario1,
    (select count(*) from tbl_gestion_cobranzas where usuario2='". $_SESSION['usu']."' and fecha_periodo between '".$desde."' and '".$hasta."')
    from tbl_prefactura p, vta_instalacion i
    where p.id_instalacion=i.id_instalacion
    and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucu."')
    and p.fecha_emision is null and (p.periodo between '".$desde."' and '".$hasta."')";
  $resultadotot=pg_query($consultatot) or die (pg_last_error());

  while($filatot=pg_fetch_array($resultadotot)){
    echo "Has llamado: <strong>(".$filatot[1].") de la Gestion uno</strong>, y <strong>(".$filatot[2].") de la Gestion dos</strong>, de: ".$filatot[0];
  }
  $bloq=0;
  echo '<table id="selectable" class="table table-hover">';
  echo '<thead bgcolor="#FF4900">
                <tr>
                  <th>N°</th>  
                  <th>Nombre</th>  
                  <th>Telefono</th> 
                  <th>Claro</th> 
                  <th>Movi</th> 
                  <th>Plan Actual</th> 
                  <th>Deuda</th> 
                  <th>Gestion 1</th>
                  <th>Gestion 2</th>
                  <th>G. Juridica</th>
                  <th>Guardar</th>
                </tr>
              </thead>';
    while($fila=pg_fetch_array($resultado)){
        //echo '<tr onclick=salida(this)>';
      echo '<tr id="'.$fila[9].'">';
        echo '<td>';
        echo $cont;
        echo '</td>';
        echo '<td>';
          echo  '<input class="form-control" type="hidden" id="nombre_'.$fila[9].'" value="'.$fila[0].'"></input>';
            echo $fila[0].' <b>'.$fila['email'].'</b> ('.$fila['txt_estado_servicio'].')';
          echo "</div>";
        echo '</td>';
        echo '<td>';
        echo $fila[1];
        echo '</td>';
        echo '<td>';
        echo $fila[2];
        echo '</td>';
        echo '<td>';
        echo $fila[3];
        echo '</td>';
        echo '<td>';
        echo $fila[4];
        echo '</td>';
        echo '<td>';
        echo $fila[5];
        echo '</td>';        
        echo '<td>';
        echo '<select  id="guno_'.$fila[9].'" style="width:97%">';
        if(strcmp ($fila[6],null)== 0)
        {
          $consultaop="select * from tbl_conclusiones order by requerimiento asc";
          $resultadoop=pg_query($consultaop) or die (pg_last_error());
          echo '<option width="98%"> </option>';
          while($tablaop=pg_fetch_array($resultadoop))
          {
            echo '<option>'.$tablaop[0].'</option>';
          }  
        }
        else{
          echo '<option>'.$fila[6].'</option>';
        }
        echo '</select>';
        echo '<textarea rows="2" cols="15" id="areag1_'.$fila[9].'" style="width:97%" placeholder="Observacion?">'.$fila[10].'</textarea>';
        echo '<p align=center>';
        echo '<input class="form-control" type="text" disabled id="usu_'.$fila[9].'" value='.$fila[14].'></input>';
        echo '</p>';
        echo '</td>';

        //Gestion 2
        echo '<td>';
        echo '<select id="gdos_'.$fila[9].'" style="width:97%">';
        if(strcmp ($fila[7],null)== 0)
        {
          $consultaop="select * from tbl_conclusiones order by requerimiento asc";
          $resultadoop=pg_query($consultaop) or die (pg_last_error());
          echo '<option> </option>';
          while($tablaop=pg_fetch_array($resultadoop))
          {
            echo '<option>'.$tablaop[0].'</option>';
          }   
        }
        else{
          echo '<option>'.$fila[7].'</option>';
        }
        echo '</select>';
        echo '<textarea rows="2" cols="15" id="areag2_'.$fila[9].'" style="width:97%" placeholder="Observacion?">'.$fila[11].'</textarea>';
        echo '<p align=center>';
        echo '<input class="form-control" type="text" disabled id="usu2_'.$fila[9].'" value='.$fila[15].'></input>';
        echo '</p>';
        echo '</td>';

        //Gestion Juridica
         echo '<td>';
        echo '<select id="gjur_'.$fila[9].'" style="width:97%">';
        if(strcmp ($fila['gestion_final'],null)== 0)
        {
          $consultaop="select * from tbl_conclusiones order by requerimiento asc";
          $resultadoop=pg_query($consultaop) or die (pg_last_error());
          echo '<option> </option>';
          while($tablaop=pg_fetch_array($resultadoop))
          {
            echo '<option>'.$tablaop[0].'</option>';
          }   
        }
        else{
          echo '<option>'.$fila['gestion_final'].'</option>';
        }
        echo '</select>';
        echo '<textarea rows="2" cols="15" id="areagj_'.$fila[9].'" style="width:97%" placeholder="Observacion?">'.$fila['ob_gestion_juridica'].'</textarea>';
        echo '<p align=center>';
        echo '<input class="form-control" type="text" disabled id="usugj_'.$fila[9].'" value='.$fila['usuario_juridico'].'></input>';
        echo '</p>';
        echo '</td>';

        //Opciones del Boton Guardar
        echo "<td>";
        if(strcmp ($fila[6],null)== 0){
          echo '<input  class="btn btn-success" name="btn_guardar" type=submit value="Guardar G1" onClick="guardar('.$fila[9].');">';
          $bloq=1;
        }
        if(strcmp ($fila[7],null)== 0&&strcmp ($bloq,0)== 0){
          echo '<input  class="btn btn-success" name="btn_guardar" type="submit" value="Guardar G2" onClick="guardar2('.$fila[9].');">';
          $bloq=1;
        }
        if(strcmp ($fila['gestion_final'],null)== 0&&strcmp ($bloq,0)== 0){
          echo '<input  class="btn btn-success" name="btn_guardar" type="submit" value="G. Juridico" onClick="guardar3('.$fila[9].');">';
        }
        echo "</td>";
        echo '</tr>';
        $bloq=0;
        $cont++;
      }
      echo '</table>';    
    }

echo "<br><br>";



//PARA LA GESTION DE COBRANZAS EN COBROS
$consulta="select id_factura_venta, id_cliente, fecha_emision 
          from tbl_factura_venta 
          where deuda>0 and fecha_emision between '".$desde."' and '".$hasta."' and 
          id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucu."')";
$resultado=pg_query($consulta); 

if(pg_num_rows($resultado)!=0){
  while($fila=pg_fetch_array($resultado)){
    pg_query("insert into tbl_gestion_cobranzas_cobros (id_gestion,id_cliente,fecha_periodo) values ('".$fila[0]."', '".$fila[1]."', '".$fila[2]."')");   
  }
}

$con="select p.id_factura_venta, g.id_gestion, g.gestion1, g.gestion2, g.gestion_juridica, g.gestion_final,
g.fecha_periodo, i.razon_social, g.usuario, g.usuario2
from tbl_factura_venta p, vta_instalacion i, tbl_gestion_cobranzas_cobros g
where i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucu."')
and p.id_instalacion=i.id_instalacion
and p.id_factura_venta=g.id_gestion
and i.estado_servicio in ('a','s','c')
and p.deuda=0 
and p.fecha_emision between '".$desde."' and '".$hasta."'";
$res=pg_query($con) or die (pg_last_error());

if(pg_num_rows($res)!=0){
  $fin='PAGAN Y CONTINUAN';
  $sal=0;
  while($fila=pg_fetch_array($res)){
    if(strcmp ($fila[2],"")== 0){
        pg_query("update tbl_gestion_cobranzas_cobros set gestion1='".$fin."', gestion2='".$fin."', gestion_juridica=date 'now()', gestion_final='".$fin."', usuario='cliente', usuario2='cliente' where id_gestion='".$fila[1]."'") or die("Error de conexion. ". pg_last_error());
        echo "<div class='alert alert-success'><strong>".$fila[7]." </strong> Ya cancelo el valor de su factura en cobros</div>";
        $sal=1;
      }
     if(strcmp ($fila[3],'')== 0&& strcmp ($sal,0)== 0){
        pg_query("update tbl_gestion_cobranzas_cobros set gestion2='".$fin."', gestion_juridica=date 'now()', gestion_final='".$fin."', usuario2='".$fila[9]."' where id_gestion='".$fila[1]."'") or die("Error de conexion. ". pg_last_error());
        echo "<div class='alert alert-success'><strong>".$fila[7]." </strong> Ya cancelo el valor de su factura despues de la primera llamada de <strong>".$fila [8]."</strong></div>";
        $sal=1;
      }
    if(strcmp ($fila[5],'')== 0&& strcmp ($sal,0)== 0){
        pg_query("update tbl_gestion_cobranzas_cobros set gestion_final='".$fin."', usuario_juridico='".$fila[9]."' where id_gestion='".$fila[1]."'") or die("Error de conexion. ". pg_last_error());
        echo "<div class='alert alert-success'><strong>".$fila[7]." </strong> Ya cancelo el valor de su factura despues de la segunda llamada de <strong>".$fila [8]." y ".$fila [9]."</strong></div>";
      }
    //pg_query("update tbl_gestion_cobranzas set gestion1='".$ges1."', gestion2='".$ges2."', ob_ges1='".$are1."', ob_ges2='".$are2."', gestion_final='".$gesf."' where id_gestion='".$id."'") or die("Error de conexion. ". pg_last_error());
  }
}

$con="select p.id_factura_venta, g.id_gestion, g.gestion1, g.gestion2, g.gestion_juridica, g.gestion_final,
g.fecha_periodo, i.razon_social, g.usuario, g.usuario2
from tbl_factura_venta p, vta_instalacion i, tbl_gestion_cobranzas_cobros g
where i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucu."')
and p.id_instalacion=i.id_instalacion
and p.id_factura_venta=g.id_gestion
and i.estado_servicio in('t','r','d','e')
and p.deuda=0 
and p.fecha_emision between '".$desde."' and '".$hasta."'";
$res=pg_query($con) or die (pg_last_error());

if(pg_num_rows($res)!=0){
  $fin='PAGAN Y SE RETIRAN';
  $sal=0;
  while($fila=pg_fetch_array($res)){
    $sal=0;
    if(strcmp ($fila[2],'')== 0){
        pg_query("update tbl_gestion_cobranzas_cobros set gestion1='".$fin."', gestion2='".$fin."', gestion_juridica=date 'now()', gestion_final='".$fin."', usuario='cliente', usuario2='cliente' where id_gestion='".$fila[1]."'") or die("Error de conexion. ". pg_last_error());
        echo "<div class='alert alert-success'><strong>".$fila[7]." </strong> Ya cancelo el valor de su factura de cobros <strong>SE RETIRO</strong></div>";
        $sal=1;
      }
    if(strcmp ($fila[3],'')== 0&& strcmp ($sal,0)== 0){
        pg_query("update tbl_gestion_cobranzas_cobros set gestion2='".$fin."', gestion_juridica=date 'now()', gestion_final='".$fin."', usuario2='".$fila[9]."' where id_gestion='".$fila[1]."'") or die("Error de conexion. ". pg_last_error());
        echo "<div class='alert alert-success'><strong>".$fila[7]." </strong> Ya cancelo el valor de su factura despues de la primera llamada de <strong>".$fila [8]." SE RETIRO</strong></div>";
        $sal=1;
      }
    if(strcmp ($fila[5],'')== 0&& strcmp ($sal,0)== 0){
        pg_query("update tbl_gestion_cobranzas_cobros set gestion_final='".$fin."' where id_gestion='".$fila[1]."'") or die("Error de conexion. ". pg_last_error());
        echo "<div class='alert alert-success'><strong>".$fila[7]." </strong> Ya cancelo el valor de su factura despues de la segunda llamada de <strong>".$fila [8]." y ".$fila [9]." SE RETIRO</strong></div>";
      }
    //pg_query("update tbl_gestion_cobranzas set gestion1='".$ges1."', gestion2='".$ges2."', ob_ges1='".$are1."', ob_ges2='".$are2."', gestion_final='".$gesf."' where id_gestion='".$id."'") or die("Error de conexion. ". pg_last_error());
  }
}


if(strcmp($tipo, "TODOS")== 0){
    $consulta="select  i.razon_social, i.telefono, i.movil_claro, i.movil_movistar, 
    i.plan, p.total, g.gestion1, g.gestion2, g.gestion_juridica, g.id_gestion, 
    g.ob_ges1, g.ob_ges2, g.ob_gesj, g.gestion_final, 
    g.usuario, g.usuario2, i.txt_estado_servicio, g.ob_gestion_juridica, g.usuario_juridico,
    i.email
    from vta_instalacion i, tbl_factura_venta p, tbl_gestion_cobranzas_cobros g
    where p.id_instalacion=i.id_instalacion
    and p.id_factura_venta=g.id_gestion
    and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucu."')
    and p.deuda>0 and p.fecha_emision between '".$desde."' and '".$hasta."'
    order by i.plan='CORPORATIVO' desc, i.plan='SMALL' desc, 
    i.plan='SMALL ESPECIAL' desc, i.plan='RESIDENCIAL' desc, i.plan='RESIDENCIAL ESPECIAL' desc, 
    i.plan='NOCTURNO' desc, i.plan='NOCTURNO ESPECIAL' desc, 
    p.total desc, i.razon_social asc";
    $resultado=pg_query($consulta) or die (pg_last_error());
  }
else{
  $consulta="
  select  i.razon_social, i.telefono, i.movil_claro, i.movil_movistar, 
  i.plan, p.total, g.gestion1, g.gestion2, g.gestion_juridica, g.id_gestion, 
  g.ob_ges1, g.ob_ges2, g.ob_gesj, g.gestion_final, 
  g.usuario, g.usuario2, i.txt_estado_servicio, g.ob_gestion_juridica, g.usuario_juridico,
  i.email
  from vta_instalacion i, tbl_factura_venta p, tbl_gestion_cobranzas_cobros g
  where p.id_instalacion=i.id_instalacion
  and p.id_factura_venta=g.id_gestion
  and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucu."')
  and p.deuda>0 and p.fecha_emision between '".$desde."' and '".$hasta."'
  and i.plan='".$tipo."'
  order by i.plan='CORPORATIVO' desc, i.plan='CORPORATIVO' desc, i.plan='SMALL' desc, 
  i.plan='SMALL ESPECIAL' desc, i.plan='RESIDENCIAL' desc, i.plan='RESIDENCIAL ESPECIAL' desc, 
  i.plan='NOCTURNO' desc, i.plan='NOCTURNO ESPECIAL' desc, 
  p.total desc, i.razon_social asc";
  $resultado=pg_query($consulta) or die (pg_last_error());
}

if(pg_num_rows($resultado)==0){
  echo '<b>No hay sugerencias</b>';
}
else{
  $consultatot="select count(*), 
    (select count(*) from tbl_gestion_cobranzas_cobros where usuario='". $_SESSION['usu']."' and fecha_periodo between '".$desde."' and '".$hasta."') usuario1,
    (select count(*) from tbl_gestion_cobranzas_cobros where usuario2='". $_SESSION['usu']."' and fecha_periodo between '".$desde."' and '".$hasta."')
    from tbl_factura_venta p, vta_instalacion i
    where p.id_instalacion=i.id_instalacion
    and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucu."') 
    and p.deuda>0 and p.fecha_emision between '".$desde."' and '".$hasta."'";
  $resultadotot=pg_query($consultatot) or die (pg_last_error());

  while($filatot=pg_fetch_array($resultadotot)){
    echo "Has llamado: <strong>(".$filatot[1].") de la Gestion uno</strong>, y <strong>(".$filatot[2].") de la Gestion dos</strong>, de: ".$filatot[0];
  }
  $bloq=0;
  $cont=1;
  echo '<table id="selectable" class="table table-hover"><h2>COBROS</h2>';
  echo '<thead bgcolor="#FF4900">
                <tr>
                  <th>N°</th>  
                  <th>Nombre</th>  
                  <th>Telefono</th> 
                  <th>Claro</th> 
                  <th>Movi</th> 
                  <th>Plan Actual</th> 
                  <th>Deuda</th> 
                  <th>Gestion 1</th>
                  <th>Gestion 2</th>
                  <th>G. Juridica</th>
                  <th>Guardar</th>
                </tr>
              </thead>';
    while($fila=pg_fetch_array($resultado)){
        //echo '<tr onclick=salida(this)>';
      echo '<tr id="'.$fila[9].'">';
        echo '<td>';
        echo $cont;
        echo '</td>';
        echo '<td>';
          echo  '<input class="form-control" type="hidden" id="nombrec_'.$fila[9].'" value="'.$fila[0].'"></input>';
            echo $fila[0].' <b>'.$fila['email'].'</b> ('.$fila['txt_estado_servicio'].')';
          echo "</div>";
        echo '</td>';
        echo '<td>';
        echo $fila[1];
        echo '</td>';
        echo '<td>';
        echo $fila[2];
        echo '</td>';
        echo '<td>';
        echo $fila[3];
        echo '</td>';
        echo '<td>';
        echo $fila[4];
        echo '</td>';
        echo '<td>';
        echo $fila[5];
        echo '</td>';        
        echo '<td>';
        echo '<select  id="gunoc_'.$fila[9].'" style="width:97%">';
        if(strcmp ($fila[6],null)== 0)
        {
          $consultaop="select * from tbl_conclusiones order by requerimiento asc";
          $resultadoop=pg_query($consultaop) or die (pg_last_error());
          echo '<option width="98%"> </option>';
          while($tablaop=pg_fetch_array($resultadoop))
          {
            echo '<option>'.$tablaop[0].'</option>';
          }  
        }
        else{
          echo '<option>'.$fila[6].'</option>';
        }
        echo '</select>';
        echo '<textarea rows="2" cols="15" id="areag1c_'.$fila[9].'" style="width:97%" placeholder="Observacion?">'.$fila[10].'</textarea>';
        echo '<p align=center>';
        echo '<input class="form-control" type="text" disabled id="usuc_'.$fila[9].'" value='.$fila[14].'></input>';
        echo '</p>';
        echo '</td>';

        //Gestion 2
        echo '<td>';
        echo '<select id="gdosc_'.$fila[9].'" style="width:97%">';
        if(strcmp ($fila[7],null)== 0)
        {
          $consultaop="select * from tbl_conclusiones order by requerimiento asc";
          $resultadoop=pg_query($consultaop) or die (pg_last_error());
          echo '<option> </option>';
          while($tablaop=pg_fetch_array($resultadoop))
          {
            echo '<option>'.$tablaop[0].'</option>';
          }   
        }
        else{
          echo '<option>'.$fila[7].'</option>';
        }
        echo '</select>';
        echo '<textarea rows="2" cols="15" id="areag2c_'.$fila[9].'" style="width:97%" placeholder="Observacion?">'.$fila[11].'</textarea>';
        echo '<p align=center>';
        echo '<input class="form-control" type="text" disabled id="usu2c_'.$fila[9].'" value='.$fila[15].'></input>';
        echo '</p>';
        echo '</td>';

        //Gestion Juridica
         echo '<td>';
        echo '<select id="gjurc_'.$fila[9].'" style="width:97%">';
        if(strcmp ($fila['gestion_final'],null)== 0)
        {
          $consultaop="select * from tbl_conclusiones order by requerimiento asc";
          $resultadoop=pg_query($consultaop) or die (pg_last_error());
          echo '<option> </option>';
          while($tablaop=pg_fetch_array($resultadoop))
          {
            echo '<option>'.$tablaop[0].'</option>';
          }   
        }
        else{
          echo '<option>'.$fila['gestion_final'].'</option>';
        }
        echo '</select>';
        echo '<textarea rows="2" cols="15" id="areagjc_'.$fila[9].'" style="width:97%" placeholder="Observacion?">'.$fila['ob_gestion_juridica'].'</textarea>';
        echo '<p align=center>';
        echo '<input class="form-control" type="text" disabled id="usugjc_'.$fila[9].'" value='.$fila['usuario_juridico'].'></input>';
        echo '</p>';
        echo '</td>';

        //Opciones del Boton Guardar
        echo "<td>";
        if(strcmp ($fila[6],null)== 0){
          echo '<input  class="btn btn-success" name="btn_guardar" type=submit value="Guardar G1" onClick="guardarc('.$fila[9].');">';
          $bloq=1;
        }
        if(strcmp ($fila[7],null)== 0&&strcmp ($bloq,0)== 0){
          echo '<input  class="btn btn-success" name="btn_guardar" type="submit" value="Guardar G2" onClick="guardarc2('.$fila[9].');">';
          $bloq=1;
        }
        if(strcmp ($fila['gestion_final'],null)== 0&&strcmp ($bloq,0)== 0){
          echo '<input  class="btn btn-success" name="btn_guardar" type="submit" value="G. Juridico" onClick="guardarc3('.$fila[9].');">';
        }
        echo "</td>";
        echo '</tr>';
        $bloq=0;
        $cont++;
      }
      echo '</table>';    
    }
pg_close();
 ?>