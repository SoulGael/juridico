<?php 
session_start(); 
include '../conexion.php';
conectarse();
$provincia=$_POST['prov'];
$ciudad=$_POST['ciu'];
$parroquia=$_POST['par'];
$desde=$_POST['de'];
$hasta=$_POST['ha'];
$sucursal=$_POST['su'];

$cont=1;
for($i=0;;$i++){
  
  if(!strcmp($provincia, "TODAS")){

    $consulta="select gc.id_gestion,
      (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
       as Provincia,
       ubicacion,

      (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
       as parroquia,
      c.razon_social, (select to_char(num_notif,'000000')), i.direccion_instalacion, 
      gc.reg_notif_ges1, gc.reg_notif_ob1, gc.reg_notif_usu1,
      gc.reg_notif_ges2, gc.reg_notif_ob2, gc.reg_notif_usu2,
      gc.reg_notif_ges3, gc.reg_notif_ob3, gc.reg_notif_usu3
      from tbl_gestion_cobranzas gc, tbl_cliente c, tbl_instalacion i, tbl_prefactura p, tbl_ubicacion u
      where gc.id_cliente=i.id_cliente 
      and c.id_cliente=gc.id_cliente
      and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
      and gc.id_gestion=p.id_prefactura
      and p.id_instalacion=i.id_instalacion
      and gc.fecha_periodo between '".$desde."' and '".$hasta."'
      and i.id_provincia=u.id_ubicacion
      and gc.gestion_final not in ('PAGAN Y CONTINUAN', 'PAGAN Y SE RETIRAN', 'ERRORES VARIOS')
      and gc.ob_gesj>0 order by gc.id_gestion";
      break;
  }

  if(strcmp($provincia, "")&&!strcmp($ciudad, "")){
    $consulta="select gc.id_gestion,
    (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
     as Provincia,
     ubicacion,

    (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
     as parroquia,
    c.razon_social, (select to_char(num_notif,'000000')), i.direccion_instalacion, 
    gc.reg_notif_ges1, gc.reg_notif_ob1, gc.reg_notif_usu1,
    gc.reg_notif_ges2, gc.reg_notif_ob2, gc.reg_notif_usu2,
    gc.reg_notif_ges3, gc.reg_notif_ob3, gc.reg_notif_usu3
    from tbl_gestion_cobranzas gc, tbl_cliente c, tbl_instalacion i, tbl_prefactura p, tbl_ubicacion u
    where gc.id_cliente=i.id_cliente 
    and c.id_cliente=gc.id_cliente
    and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
    and gc.id_gestion=p.id_prefactura
    and p.id_instalacion=i.id_instalacion
    and gc.fecha_periodo between '".$desde."' and '".$hasta."'
    and i.id_provincia=(select id_ubicacion from tbl_ubicacion where ubicacion='".$provincia."' limit 1 offset 0)
    and i.id_provincia=u.id_ubicacion
    and gc.gestion_final not in ('PAGAN Y CONTINUAN', 'PAGAN Y SE RETIRAN', 'ERRORES VARIOS')
    and gc.ob_gesj>0 order by gc.id_gestion";
    break;
  }

  if(strcmp($ciudad, "")&&!strcmp($parroquia, "")){
    $consulta="select gc.id_gestion,
    (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
     as Provincia,
     ubicacion,

    (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
     as parroquia,
    c.razon_social, (select to_char(num_notif,'000000')), i.direccion_instalacion, 
    gc.reg_notif_ges1, gc.reg_notif_ob1, gc.reg_notif_usu1, 
    gc.reg_notif_ges2, gc.reg_notif_ob2, gc.reg_notif_usu2,
    gc.reg_notif_ges3, gc.reg_notif_ob3, gc.reg_notif_usu3
    from tbl_gestion_cobranzas gc, tbl_cliente c, tbl_instalacion i, tbl_prefactura p, tbl_ubicacion u
    where gc.id_cliente=i.id_cliente 
    and c.id_cliente=gc.id_cliente
    and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
    and gc.id_gestion=p.id_prefactura
    and p.id_instalacion=i.id_instalacion
    and gc.fecha_periodo between '".$desde."' and '".$hasta."'
    and i.id_ciudad=(select id_ubicacion from tbl_ubicacion where ubicacion='".$ciudad."' limit 1 offset 0)
    and i.id_ciudad=u.id_ubicacion
    and gc.gestion_final not in ('PAGAN Y CONTINUAN', 'PAGAN Y SE RETIRAN', 'ERRORES VARIOS')
    and gc.ob_gesj>0 order by gc.id_gestion";
    break;
  }
  if(strcmp($parroquia, "")){
    $consulta="
    select gc.id_gestion,
    (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
     as Provincia,
     ubicacion,

    (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
     as parroquia,
    c.razon_social, (select to_char(num_notif,'000000')), i.direccion_instalacion, 
    gc.reg_notif_ges1, gc.reg_notif_ob1, gc.reg_notif_usu1,
    gc.reg_notif_ges2, gc.reg_notif_ob2, gc.reg_notif_usu2,
    gc.reg_notif_ges3, gc.reg_notif_ob3, gc.reg_notif_usu3
    from tbl_gestion_cobranzas gc, tbl_cliente c, tbl_instalacion i, tbl_prefactura p, tbl_ubicacion u
    where gc.id_cliente=i.id_cliente 
    and c.id_cliente=gc.id_cliente
    and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
    and gc.id_gestion=p.id_prefactura
    and p.id_instalacion=i.id_instalacion
    and gc.fecha_periodo between '".$desde."' and '".$hasta."'
    and i.id_parroquia=(select id_ubicacion from tbl_ubicacion where ubicacion='".$parroquia."' limit 1 offset 0)
    and i.id_parroquia=u.id_ubicacion
    and gc.gestion_final not in ('PAGAN Y CONTINUAN', 'PAGAN Y SE RETIRAN', 'ERRORES VARIOS')
    and gc.ob_gesj>0 order by gc.id_gestion";
    break;
    }
}

$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){
  echo '<b>No hay sugerencias</b>';
}
else{
  echo '<table id="selectable" name="selectable" class="table table-hover">';
  echo '<thead bgcolor="#FF4900">
    <tr>
    <th></th>
    <th>N°</th>
    <th>Provincia</th>        
    <th>Ciudad</th>  
    <th>Parroquia</th> 
    <th>Razon Social</th> 
    <th>N° Notif</th> 
    <th>Direccion</th>         
    <th>1ra Notificacion</th>
    <th>2da Notificacion</th> 
    <th>3ra Notificacion</th>
    </tr>
    </thead>';
    while($fila=pg_fetch_array($resultado)){
      //echo '<tr onclick=salida(this)>';
      echo '<tr onclick=cambio_direccion(this)>';
      echo '<td>';
      echo $cont;
      echo '</td>';
      echo '<td>';
      echo $fila[0];
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
      echo '<td data-toggle="modal" data-target="#myModal">';
      echo $fila[6];
      echo '</td>';         
      echo '<td>';
      echo '<select  id="guno_'.$cont.'" style="width:97%">';
      if(!strcmp ($fila[7],null)){
        $consultaop="select * from tbl_conclusiones_notif order by notificacion_conclu asc";
        $resultadoop=pg_query($consultaop) or die (pg_last_error());
        echo '<option width="98%"> </option>;';
        
        while($tablaop=pg_fetch_array($resultadoop)){
          echo '<option>'.$tablaop[0].'</option>;';
        }                    
      }

      else{
        echo '<option>'.$fila[7].'</option>;';
      }
      echo '</select>';
      echo '<textarea rows="2" cols="15" id="areag1_'.$cont.'" style="width:97%" placeholder="Observacion?">'.$fila[8].'</textarea>';
      echo '<p align=center>';
      echo '<input class="form-control" type="text" disabled id="usu_'.$cont.'" value='.$fila[9].'></input>';
      echo '</p>';
      echo '</td>';

      echo '<td>';
      echo '<select id="gdos_'.$cont.'" style="width:97%">';
        
      if(!strcmp ($fila[10],null)){
        $consultaop="select * from tbl_conclusiones_notif order by notificacion_conclu asc";
        $resultadoop=pg_query($consultaop) or die (pg_last_error());
        echo '<option> </option>;';
        
        while($tablaop=pg_fetch_array($resultadoop)){
          echo '<option>'.$tablaop[0].'</option>;';
        }                    
      }
      else{
        echo '<option>'.$fila[10].'</option>;';
      }
      
      echo '</select>';
      echo '<textarea rows="2" cols="15" id="areag2_'.$cont.'" style="width:97%" placeholder="Observacion?">'.$fila[11].'</textarea>';
      echo '<p align=center>';
      echo '<input class="form-control" type="text" disabled id="usu2_'.$cont.'" value='.$fila[12].'></input>';
      echo '</p>';
      echo '</td>';

      echo '<td>';
      echo '<select id="gtres_'.$cont.'" style="width:97%">';
        
      if(!strcmp ($fila[13],null)){
        echo '<option></option>;';
        echo '<option>Notificacion entregada</option>;';                 
      }
      else{
        echo '<option>'.$fila[13].'</option>;';
      }
      echo '</select>';
      echo '<textarea rows="2" cols="15" id="areag3_'.$cont.'" style="width:97%" placeholder="Observacion?">'.$fila[14].'</textarea>';
      echo '<p align=center>';
      echo '<input class="form-control" type="text" disabled id="usu3_'.$cont.'" value='.$fila[15].'></input>';
      echo '</p>';
      echo '</td>';
      echo '</tr>';

      $cont++;
    }
  echo '</table>';
}


//Gestion de Cobros
echo '<h1>COBROS</h1>';
echo '<input  type="button" class="btn btn-success" name="btn_guardar_cobros" type=submit value="Guardar Notificaciónes" onclick=guardarcobros(this)>';
$cont=1;
for($i=0;;$i++){
  
  if(!strcmp($provincia, "TODAS")){

    $consulta="select gc.id_gestion,
      (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
       as Provincia,
       ubicacion,

      (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
       as parroquia,
      c.razon_social, (select to_char(num_notif,'000000')), i.direccion_instalacion, 
      gc.reg_notif_ges1, gc.reg_notif_ob1, gc.reg_notif_usu1,
      gc.reg_notif_ges2, gc.reg_notif_ob2, gc.reg_notif_usu2,
      gc.reg_notif_ges3, gc.reg_notif_ob3, gc.reg_notif_usu3
      from tbl_gestion_cobranzas_cobros gc, tbl_cliente c, tbl_instalacion i, tbl_factura_venta p, tbl_ubicacion u
      where gc.id_cliente=i.id_cliente 
      and c.id_cliente=gc.id_cliente
      and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
      and gc.id_gestion=p.id_factura_venta
      and p.id_instalacion=i.id_instalacion
      and gc.fecha_periodo between '".$desde."' and '".$hasta."'
      and i.id_provincia=u.id_ubicacion
      and gc.gestion_final not in ('PAGAN Y CONTINUAN', 'PAGAN Y SE RETIRAN', 'ERRORES VARIOS')
      and gc.ob_gesj>0 order by gc.id_gestion";
      break;
  }

  if(strcmp($provincia, "")&&!strcmp($ciudad, "")){
    $consulta="select gc.id_gestion,
    (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
     as Provincia,
     ubicacion,

    (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
     as parroquia,
    c.razon_social, (select to_char(num_notif,'000000')), i.direccion_instalacion, 
    gc.reg_notif_ges1, gc.reg_notif_ob1, gc.reg_notif_usu1,
    gc.reg_notif_ges2, gc.reg_notif_ob2, gc.reg_notif_usu2,
    gc.reg_notif_ges3, gc.reg_notif_ob3, gc.reg_notif_usu3
    from tbl_gestion_cobranzas_cobros gc, tbl_cliente c, tbl_instalacion i, tbl_factura_venta p, tbl_ubicacion u
    where gc.id_cliente=i.id_cliente 
    and c.id_cliente=gc.id_cliente
    and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
    and gc.id_gestion=p.id_factura_venta
    and p.id_instalacion=i.id_instalacion
    and gc.fecha_periodo between '".$desde."' and '".$hasta."'
    and i.id_provincia=(select id_ubicacion from tbl_ubicacion where ubicacion='".$provincia."' limit 1 offset 0)
    and i.id_provincia=u.id_ubicacion
    and gc.gestion_final not in ('PAGAN Y CONTINUAN', 'PAGAN Y SE RETIRAN', 'ERRORES VARIOS')
    and gc.ob_gesj>0 order by gc.id_gestion;";
    break;
  }

  if(strcmp($ciudad, "")&&!strcmp($parroquia, "")){
    $consulta="select gc.id_gestion,
    (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
     as Provincia,
     ubicacion,

    (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
     as parroquia,
    c.razon_social, (select to_char(num_notif,'000000')), i.direccion_instalacion, 
    gc.reg_notif_ges1, gc.reg_notif_ob1, gc.reg_notif_usu1, 
    gc.reg_notif_ges2, gc.reg_notif_ob2, gc.reg_notif_usu2,
    gc.reg_notif_ges3, gc.reg_notif_ob3, gc.reg_notif_usu3
    from tbl_gestion_cobranzas_cobros gc, tbl_cliente c, tbl_instalacion i, tbl_factura_venta p, tbl_ubicacion u
    where gc.id_cliente=i.id_cliente 
    and c.id_cliente=gc.id_cliente
    and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
    and gc.id_gestion=p.id_factura_venta
    and p.id_instalacion=i.id_instalacion
    and gc.fecha_periodo between '".$desde."' and '".$hasta."'
    and i.id_ciudad=(select id_ubicacion from tbl_ubicacion where ubicacion='".$ciudad."' limit 1 offset 0)
    and i.id_ciudad=u.id_ubicacion
    and gc.gestion_final not in ('PAGAN Y CONTINUAN', 'PAGAN Y SE RETIRAN', 'ERRORES VARIOS')
    and gc.ob_gesj>0 order by gc.id_gestion;";
    break;
  }
  if(strcmp($parroquia, "")){
    $consulta="select gc.id_gestion,
    (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
     as Provincia,
     ubicacion,

    (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
     as parroquia,
    c.razon_social, (select to_char(num_notif,'000000')), i.direccion_instalacion, 
    gc.reg_notif_ges1, gc.reg_notif_ob1, gc.reg_notif_usu1,
    gc.reg_notif_ges2, gc.reg_notif_ob2, gc.reg_notif_usu2,
    gc.reg_notif_ges3, gc.reg_notif_ob3, gc.reg_notif_usu3
    from tbl_gestion_cobranzas_cobros gc, tbl_cliente c, tbl_instalacion i, tbl_factura_venta p, tbl_ubicacion u
    where gc.id_cliente=i.id_cliente 
    and c.id_cliente=gc.id_cliente
    and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
    and gc.id_gestion=p.id_factura_venta
    and p.id_instalacion=i.id_instalacion
    and gc.fecha_periodo between '".$desde."' and '".$hasta."'
    and i.id_parroquia=(select id_ubicacion from tbl_ubicacion where ubicacion='".$parroquia."' limit 1 offset 0)
    and i.id_parroquia=u.id_ubicacion
    and gc.gestion_final not in ('PAGAN Y CONTINUAN', 'PAGAN Y SE RETIRAN', 'ERRORES VARIOS')
    and gc.ob_gesj>0 order by gc.id_gestion;";
    break;
    }
}

$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){
  echo '<b>No hay sugerencias</b>';
}
else{
  echo '<table id="selectablecobros" name="selectablecobros" class="table table-hover">';
  echo '<thead bgcolor="#FF4900">
    <tr>
    <th></th>
    <th>N°</th>
    <th>Provincia</th>        
    <th>Ciudad</th>  
    <th>Parroquia</th> 
    <th>Razon Social</th> 
    <th>N° Notif</th> 
    <th>Direccion</th>         
    <th>1ra Notificacion</th>
    <th>2da Notificacion</th> 
    <th>3ra Notificacion</th>
    </tr>
    </thead>';
    while($fila=pg_fetch_array($resultado)){
      //echo '<tr onclick=salida(this)>';
      echo '<tr>';
      echo '<td>';
      echo $cont;
      echo '</td>';
      echo '<td>';
      echo $fila[0];
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
      echo $fila[6];
      echo '</td>';         
      echo '<td>';
      echo '<select  id="gunoc_'.$cont.'" style="width:97%">';
      if(!strcmp ($fila[7],null)){
        $consultaop="select * from tbl_conclusiones_notif order by notificacion_conclu asc";
        $resultadoop=pg_query($consultaop) or die (pg_last_error());
        echo '<option width="98%"> </option>;';
        
        while($tablaop=pg_fetch_array($resultadoop)){
          echo '<option>'.$tablaop[0].'</option>;';
        }                    
      }

      else{
        echo '<option>'.$fila[7].'</option>;';
      }
      echo '</select>';
      echo '<textarea rows="2" cols="15" id="areagc1_'.$cont.'" style="width:97%" placeholder="Observacion?">'.$fila[8].'</textarea>';
      echo '<p align=center>';
      echo '<input class="form-control" type="text" disabled id="usuc_'.$cont.'" value='.$fila[9].'></input>';
      echo '</p>';
      echo '</td>';

      echo '<td>';
      echo '<select id="gdosc_'.$cont.'" style="width:97%">';
        
      if(!strcmp ($fila[10],null)){
        $consultaop="select * from tbl_conclusiones_notif order by notificacion_conclu asc";
        $resultadoop=pg_query($consultaop) or die (pg_last_error());
        echo '<option> </option>;';
        
        while($tablaop=pg_fetch_array($resultadoop)){
          echo '<option>'.$tablaop[0].'</option>;';
        }                    
      }
      else{
        echo '<option>'.$fila[10].'</option>;';
      }
      
      echo '</select>';
      echo '<textarea rows="2" cols="15" id="areagc2_'.$cont.'" style="width:97%" placeholder="Observacion?">'.$fila[11].'</textarea>';
      echo '<p align=center>';
      echo '<input class="form-control" type="text" disabled id="usuc2_'.$cont.'" value='.$fila[12].'></input>';
      echo '</p>';
      echo '</td>';

      echo '<td>';
      echo '<select id="gtresc_'.$cont.'" style="width:97%">';
        
      if(!strcmp ($fila[13],null)){
        echo '<option></option>;';
        echo '<option>Notificacion entregada</option>;';                 
      }
      else{
        echo '<option>'.$fila[13].'</option>;';
      }
      echo '</select>';
      echo '<textarea rows="2" cols="15" id="areagc3_'.$cont.'" style="width:97%" placeholder="Observacion?">'.$fila[14].'</textarea>';
      echo '<p align=center>';
      echo '<input class="form-control" type="text" disabled id="usuc3_'.$cont.'" value='.$fila[15].'></input>';
      echo '</p>';
      echo '</td>';
      echo '</tr>';

      $cont++;
    }
  echo '</table>';
}
pg_close();
?>