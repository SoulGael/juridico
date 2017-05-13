<?php  
include '../conexion.php';
conectarse();
$q=$_POST['q'];
$consulta="select tbl_prefactura.periodo, tbl_prefactura.fecha_emision, tbl_instalacion.ip from tbl_instalacion, 
tbl_prefactura 
where tbl_instalacion.id_instalacion=tbl_prefactura.id_instalacion 
and tbl_instalacion.id_cliente='".$q."' and tbl_prefactura.fecha_emision is null order by id_prefactura desc";
$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){

echo '<b>No hay Registros</b>';

}else{
	echo '<table id="selectable" class="table table-hover">';
	echo '<thead bgcolor="#FF4900">
                <tr>
                  <th>Periodo</th>  
				  <th>F. Emision</th>  
				  <th>IP</th>  
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
echo '</tr>';
}
echo '</table>';
echo '</div>';
}
pg_close();
 ?>