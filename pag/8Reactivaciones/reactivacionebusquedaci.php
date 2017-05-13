<?php  
include '../conexion.php';
conectarse();
$q=$_POST['a'];
$consulta="select tbl_gestion_cobranzas.id_gestion, tbl_cliente.ruc, tbl_cliente.razon_social, tbl_instalacion.direccion_instalacion, tbl_gestion_cobranzas.gestion_final,
tbl_cliente.telefono, tbl_cliente.movil_claro, tbl_cliente.movil_movistar,
tbl_gestion_cobranzas.fecha_periodo, tbl_prefactura.total,
tbl_plan_isp.plan
from tbl_ubicacion, tbl_prefactura, tbl_cliente, tbl_instalacion, tbl_plan_isp, tbl_plan_servicio, tbl_gestion_cobranzas
where tbl_cliente.id_cliente=tbl_instalacion.id_cliente 
and tbl_instalacion.estado_servicio in ('d','r')
and tbl_cliente.id_provincia=tbl_ubicacion.id_ubicacion
and tbl_gestion_cobranzas.id_gestion=tbl_prefactura.id_prefactura
and tbl_instalacion.id_plan_actual=tbl_plan_servicio.id_plan_servicio 
and tbl_plan_isp.id_plan_isp=tbl_plan_servicio.id_plan_isp 
and tbl_instalacion.id_instalacion=tbl_prefactura.id_instalacion 
and tbl_cliente.ruc LIKE (UPPER('%".$q."%'))
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
pg_close();
//and tbl_prefactura.fecha_emision is null 
 ?>