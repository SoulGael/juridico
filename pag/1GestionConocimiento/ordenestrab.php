<?php  
include '../conexion.php';
conectarse();
$q=$_POST['q'];
$consulta="select tbl_orden_trabajo.usuario_reporte, tbl_orden_trabajo.fecha_reporte, tbl_orden_trabajo.usuario_realizacion, 
tbl_orden_trabajo.fecha_realizacion, tbl_orden_trabajo.recomendacion 
from tbl_orden_trabajo, tbl_instalacion 
where tbl_instalacion.id_instalacion=tbl_orden_trabajo.id_instalacion 
and tbl_instalacion.id_cliente='".$q."' order by tbl_orden_trabajo.id_orden_trabajo desc";
$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){

echo '<b>No hay sugerencias</b>';

}else{

echo '<table id="selectable" class="table table-hover">';
echo '<thead bgcolor="#FF4900">
                <tr>
                  <th>Usuario del Reporte</th>  
				  <th>Fecha del Reporte</th>  
				  <th>usuario de la realizacion</th>  
				  <th>Fecha de la realizacion</th>  
				  <th>Observación</th>  
                </tr>
              </thead>';
while($fila=pg_fetch_array($resultado)){	
echo '<tr>';
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
echo '</tr>';
}
echo '</table>';
}
pg_close();
 ?>