<?php  
include '../conexion.php';
conectarse();
$q=$_POST['q'];
$consulta="select tbl_instalacion_suspension.usuario_solicitud, tbl_instalacion_suspension.fecha_inicio, 
tbl_instalacion_suspension.tiempo, tbl_instalacion_suspension.fecha_termino 
from vta_instalacion, tbl_instalacion_suspension 
where vta_instalacion.id_cliente='".$q."' 
and vta_instalacion.id_instalacion=tbl_instalacion_suspension.id_instalacion 
order by tbl_instalacion_suspension.id_instalacion_suspension desc";
$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){

echo '<b>No hay Registros</b>';

}else{

echo '<table id="selectable" class="table table-hover">';
echo '<thead bgcolor="#FF4900">
                <tr>
                  <th>Fecha de Inicio</th>  
				  <th>Tiempo</th>  
				  <th>Fecha de Termino</th>  
				  <th>Usuario</th>  
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
echo '</tr>';
}
echo '</table>';
}
pg_close();
 ?>