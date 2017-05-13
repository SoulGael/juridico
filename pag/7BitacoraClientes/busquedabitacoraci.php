<?php  
include '../conexion.php';
conectarse();
$q=$_POST['a'];
$consulta="select i.ruc, i.razon_social, i.direccion, 
age(date 'now()',date(g.gestion_juridica)),g.gestion_juridica,
i.telefono, i.movil_claro, i.movil_movistar,
g.fecha_periodo, p.total,
i.plan, g.gestion2, g.gestion_final, 
g.id_gestion
from tbl_prefactura p, vta_instalacion i, tbl_gestion_cobranzas g
where p.id_instalacion=i.id_instalacion
and p.id_prefactura=g.id_gestion
and g.reg_notif_ges3 in ('Notificacion entregada')
and i.ruc LIKE (UPPER('%".$q."%')) limit 15 offset 0;";
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
          <th>Fecha de Ingreso</th>
          <th>Telefonos</th>
          <th>Mes Adeudado</th>                  
          <th>V. Deuda</th>
          <th>Plan</th>
          <th>C. Gestión</th>
          <th>C. Gestión Juridica</th>
          </tr>
        </thead>';

  while($fila=pg_fetch_array($resultado)){
    echo '<tbody>';
    echo '<tr onclick=lamuestra(this)>';
    echo '<td>';
    echo $fila[13];
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
    echo '<td align=center>';
    echo $fila[3];
    echo '<br>';
    echo $fila[4];
    echo '</td>';
    echo '<td align=center>';
    echo $fila[5],' ',$fila[6],' ',$fila[7];
    echo '</td>';
    echo '<td>';
    echo $fila[8];
    echo '</td>';
    echo '<td>';
    echo $fila[9];
    echo '</td>';
    echo '<td>';
    echo $fila[10];
    echo '</td>';
    echo '<td>';
    echo $fila[11];
    echo '</td>';
    echo '<td>';
    echo $fila[12];
    echo '</td>';
    echo '</tr>';
    echo '</tbody>'; 
  }
  echo '</table>';
}

$consulta="select i.ruc, i.razon_social, i.direccion, 
age(date 'now()',date(g.gestion_juridica)),g.gestion_juridica,
i.telefono, i.movil_claro, i.movil_movistar,
g.fecha_periodo, p.total,
i.plan, g.gestion2, g.gestion_final, 
g.id_gestion
from tbl_factura_venta p, vta_instalacion i, tbl_gestion_cobranzas_cobros g
where p.id_instalacion=i.id_instalacion
and p.id_factura_venta=g.id_gestion
and g.reg_notif_ges3 in ('Notificacion entregada')
and i.ruc LIKE (UPPER('%".$q."%')) limit 15 offset 0;";
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
          <th>Fecha de Ingreso</th>
          <th>Telefonos</th>
          <th>Mes Adeudado</th>                  
          <th>V. Deuda</th>
          <th>Plan</th>
          <th>C. Gestión</th>
          <th>C. Gestión Juridica</th>
          </tr>
        </thead>';

  while($fila=pg_fetch_array($resultado)){
    echo '<tbody>';
    echo '<tr onclick=lamuestracobro(this)>';
    echo '<td>';
    echo $fila[13];
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
    echo '<td align=center>';
    echo $fila[3];
    echo '<br>';
    echo $fila[4];
    echo '</td>';
    echo '<td align=center>';
    echo $fila[5],' ',$fila[6],' ',$fila[7];
    echo '</td>';
    echo '<td>';
    echo $fila[8];
    echo '</td>';
    echo '<td>';
    echo $fila[9];
    echo '</td>';
    echo '<td>';
    echo $fila[10];
    echo '</td>';
    echo '<td>';
    echo $fila[11];
    echo '</td>';
    echo '<td>';
    echo $fila[12];
    echo '</td>';
    echo '</tr>';
    echo '</tbody>'; 
  }
  echo '</table>';
}
pg_close();
 ?>