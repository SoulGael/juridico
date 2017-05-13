<?php  
include '../conexion.php';
conectarse();
$q=$_POST['q'];
$consulta="select g.id_gestion, c.ruc, c.razon_social, i.direccion_instalacion, 
g.gestion_final,
c.telefono, c.movil_claro, c.movil_movistar,
g.fecha_periodo, p.total,
l.plan
from tbl_ubicacion u, tbl_prefactura p, tbl_cliente c, tbl_instalacion i, tbl_plan_isp l, tbl_plan_servicio s, tbl_gestion_cobranzas g
where c.id_cliente=i.id_cliente 
and i.estado_servicio in ('d','r')
and c.id_provincia=u.id_ubicacion
and g.id_gestion=p.id_prefactura
and i.id_plan_actual=s.id_plan_servicio 
and l.id_plan_isp=s.id_plan_isp 
and i.id_instalacion=p.id_instalacion 
and c.razon_social LIKE (UPPER('%".$q."%'))
limit 15 offset 0;";
$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){
  echo '<b>No hay sugerencias</b>';
}else{
  echo '<table id="selectable" class="table table-hover">';
  echo '<thead bgcolor="#FF4900">
          <tr>
          <th>Id Cliente</th>
          <th>CI/RUC</th>
          <th>Nombres</th>
          <th>Dirección</th>
          <th>Gestion</th>
          <th>Telefonos</th>
          <th>V. Servicio</th>
          <th>Plan</th>
          </tr>
        </thead>';

    while($fila=pg_fetch_array($resultado)){
      echo '<tbody>';
      echo '<tr onclick=lamuestra(this)>';
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
      echo '<td align=center>';
      echo $fila[5],' ',$fila[6],' ',$fila[7];
      echo '</td>';
      echo '<td>';
      echo $fila[8];
      echo '</td>';
      echo '<td>';
      echo $fila[9];
      echo '</td>';
      echo '</tr>';
      echo '</tbody>'; 
    }
    echo '</table>';
}


echo '<h1>COBROS</h1>';
$consulta="select g.id_gestion, c.ruc, c.razon_social, i.direccion_instalacion, 
g.gestion_final,
c.telefono, c.movil_claro, c.movil_movistar,
g.fecha_periodo, p.total,
l.plan
from tbl_ubicacion u, tbl_factura_venta p, tbl_cliente c, tbl_instalacion i, tbl_plan_isp l, tbl_plan_servicio s, tbl_gestion_cobranzas_cobros g
where c.id_cliente=i.id_cliente 
and i.estado_servicio in ('d','r')
and c.id_provincia=u.id_ubicacion
and g.id_gestion=p.id_factura_venta
and i.id_plan_actual=s.id_plan_servicio 
and l.id_plan_isp=s.id_plan_isp 
and i.id_instalacion=p.id_instalacion 
and c.razon_social LIKE (UPPER('%".$q."%'))
limit 15 offset 0;";
$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){
  echo '<b>No hay sugerencias</b>';
}else{
  echo '<table id="selectablecobros" class="table table-hover">';
  echo '<thead bgcolor="#FF4900">
          <tr>
          <th>Id Cliente</th>
          <th>CI/RUC</th>
          <th>Nombres</th>
          <th>Dirección</th>
          <th>Gestion</th>
          <th>Telefonos</th>
          <th>V. Servicio</th>
          <th>Plan</th>
          </tr>
        </thead>';

    while($fila=pg_fetch_array($resultado)){
      echo '<tbody>';
      echo '<tr onclick=lamuestracobros(this)>';
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
      echo '<td align=center>';
      echo $fila[5],' ',$fila[6],' ',$fila[7];
      echo '</td>';
      echo '<td>';
      echo $fila[8];
      echo '</td>';
      echo '<td>';
      echo $fila[9];
      echo '</td>';
      echo '</tr>';
      echo '</tbody>'; 
    }
    echo '</table>';
}
pg_close();
//and tbl_prefactura.fecha_emision is null 
 ?>