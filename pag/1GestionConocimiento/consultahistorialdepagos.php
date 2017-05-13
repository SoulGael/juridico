<?php  
include '../conexion.php';
conectarse();
$q=$_POST['q'];
$consulta="select concat(tbl_factura_venta.serie_factura,'-',tbl_factura_venta.num_factura), 
tbl_factura_venta.fecha_emision, tbl_factura_venta.vendedor, tbl_factura_venta.forma_pago, tbl_factura_venta.total, 
tbl_factura_venta.ip, tbl_factura_venta.observacion 
from tbl_cliente, tbl_factura_venta 
where tbl_factura_venta.id_cliente=tbl_cliente.id_cliente 
and tbl_factura_venta.id_cliente='".$q."' order by tbl_factura_venta.id_factura_venta desc";
$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){

echo '<b>No hay sugerencias</b>';

}else{
echo '<table id="selectable"  class="table table-hover">';
echo '<thead bgcolor="#FF4900">
<tr>
<th width="17%"># de Factura</th>  
<th width="13%">F. Emision</th>  
<th width="10%">Cajera</th>  
<th width="15%">Forma de Pago</th>
<th width="7%">Total</th> 
<th width="18%">Ip</th> 
<th width="21%">Concepto</th>
</tr>
</thead>';

while($fila=pg_fetch_array($resultado)){
	$salida="";
	if(!strcmp($fila[3], "e"))
	{
		$salida="Efectivo";
	}	
	if(!strcmp($fila[3], "c"))
	{
		$salida="Cheque";
	}
	if(!strcmp($fila[3], "p"))
	{
		$salida="Deposito Bancario";
	}
	if(!strcmp($fila[3], "t"))
	{
		$salida="Transferencia Bancaria";
	}
	if(!strcmp($fila[3], "j"))
	{
		$salida="Tarjeta de Credito";
	}
	if(!strcmp($fila[3], "d"))
	{
		$salida="Credito";
	}
echo '<tr onclick=detallefac(this) data-toggle="modal" data-target="#myModal">';
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
echo $salida;
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
echo '</tr>';
}
echo '</table>';
}
pg_close();
 ?>