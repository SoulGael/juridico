<?php  
include '../conexion.php';
conectarse();
$a=$_POST['a'];
$consulta="select id_cliente, ruc, razon_social, telefono, direccion from tbl_cliente where ruc LIKE '%".$a."%' order by razon_social limit 20 offset 0";
$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){

echo '<b>No hay sugerencias</b>';

}

else{
echo '<table id="selectable" class="table table-hover">';
echo '<thead bgcolor="#FF4900">
                <tr>
                  <th width=7%>ID Cliente</th>
                  <th>Nombres</th>
                  <th width=15%>CI/RUC</th>
                  <th>Dirección</th>
                  <th width=15%>Telefono</th>
                </tr>
              </thead>';
while($fila=pg_fetch_array($resultado)){
echo '<tbody>';
echo '<tr onclick=muestra(this)>';
echo '<td>';
echo $fila[0];
echo '</td>';
echo '<td>';
echo $fila[2];
echo '</td>';
echo '<td>';
echo $fila[1];
echo '</td>';
echo '<td>';
echo $fila[4];
echo '</td>';
echo '<td>';
echo $fila[3];
echo '</td>';
echo '</tr>';
echo '</tbody>';
}
echo '</table>';
}
pg_close();
 ?>