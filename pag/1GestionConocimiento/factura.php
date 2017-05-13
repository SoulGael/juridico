 <?php  
 include '../conexion.php';
 conectarse();
 $q=$_POST['q'];
 $consulta="select tbl_factura_venta.autorizacion, tbl_cliente.ruc,tbl_factura_venta.fecha_emision, tbl_cliente.razon_social, 
 tbl_cliente.telefono, tbl_cliente.direccion, tbl_factura_venta.forma_pago, vta_factura_venta_detalle.codigo, 
 vta_factura_venta_detalle.descripcion_mas, vta_factura_venta_detalle.cantidad, vta_factura_venta_detalle.p_u, 
 vta_factura_venta_detalle.p_st, vta_factura_venta_detalle.descuento, vta_factura_venta_detalle.iva, vta_factura_venta_detalle.total, 
 tbl_factura_venta.observacion, tbl_factura_venta.subtotal, tbl_factura_venta.subtotal_2, tbl_factura_venta.subtotal_0, 
 tbl_factura_venta.descuento, tbl_factura_venta.iva_2, tbl_factura_venta.total  
 from vta_factura_venta_detalle, tbl_cliente, tbl_factura_venta 
 where tbl_cliente.id_cliente=tbl_factura_venta.id_cliente 
 and '".$q."'=concat(tbl_factura_venta.serie_factura,'-',
    tbl_factura_venta.num_factura) 
 and vta_factura_venta_detalle.id_factura_venta=tbl_factura_venta.id_factura_venta limit 1 offset 0";
 $resultado=pg_query($consulta) or die (pg_last_error());

 if(pg_num_rows($resultado)==0){
    echo '<b>No hay sugerencias</b>';
}
else
{
    while($tabla=pg_fetch_array($resultado))
    {
        $salida="";
        if(!strcmp($tabla[6], "e"))
        {
            $salida="Efectivo";
        }   
        if(!strcmp($tabla[6], "c"))
        {
            $salida="Cheque";
        }
        if(!strcmp($tabla[6], "p"))
        {
            $salida="Deposito Bancario";
        }
        if(!strcmp($tabla[6], "t"))
        {
            $salida="Transferencia Bancaria";
        }
        if(!strcmp($tabla[6], "j"))
        {
            $salida="Tarjeta de Credito";
        }
        if(!strcmp($tabla[6], "d"))
        {
            $salida="Credito";
        }
        echo "<FONT SIZE=3px><p align=right style='margin:0px'> Nro. <input value='$q' size='16' disabled/><br>";
        echo "Autorizacion. <input size='16' value='$tabla[0]' disabled></p></font>";
        echo "<pre style='margin:0px'>";
        echo "<FONT SIZE=3px> CI/RUC.    <input value='$tabla[1]' size='10' disabled>"; echo "                          Fecha.             <input value='$tabla[2]' size='14' disabled><br>";
        echo "Señor(es)     <input value='$tabla[3]' size='64' disabled>"; echo "    Telefono.           <input value='$tabla[4]' size='14' disabled><br>";
        echo "Direccion.    <input value='$tabla[5]' size='64' disabled>"; echo "     Forma de Pago.      <input value='$salida' size='14' disabled><br></font>";
        echo "</pre>";
        echo '<table id="selectable"  class="table table-hover">';
        echo '<thead bgcolor="#FF4900">
        <tr>
        <th width="17%">Codigo</th>  
        <th width="36%">Descripcion</th>  
        <th width="10%">Cantidad</th> 
        <th width="7%">P,/U</th>
        <th width="7%">Subtototal</th> 
        <th width="8%">Desc</th> 
        <th width="8%">Iva</th>
        <th width="8%">Total</th> 
        </tr>
        </thead>';
        echo '<tr>';
        echo '<td>';
        echo $tabla[7];
        echo '</td>';
        echo '<td>';
        echo $tabla[8];
        echo '</td>';
        echo '<td>';
        echo $tabla[9];
        echo '</td>';
        echo '<td>';
        echo $tabla[10];
        echo '</td>';
        echo '<td>';
        echo $tabla[11];
        echo '</td>';
        echo '<td>';
        echo $tabla[12];
        echo '</td>';
        echo '<td>';
        echo $tabla[13];
        echo '</td>';
        echo '<td>';
        echo $tabla[14];
        echo '</td>';
        echo '</tr>';
        echo '</table>';
        echo "<pre style='margin:0px'>";
        echo "<FONT SIZE=2px> Concepto<br><textarea rows='4' cols='50' readonly='readonly' maxlength='50'> $tabla[15]</textarea></font>";              
        echo "<FONT SIZE=3px style='float:right;'>Subtotal     <input  value='$tabla[16]' size='14' disabled><br>";
        echo "Subtotal 12% <input value='$tabla[17]' size='14' disabled><br>";
        echo "Subtotal 0%  <input value='$tabla[18]' size='14' disabled><br>";
        echo "Descuento    <input value='$tabla[19]' size='14' disabled><br>";
        echo "12% iva     <input value='$tabla[20]' size='14' disabled><br>";
        echo "total       <input value='$tabla[21]' size='14' disabled><br>";
        echo "</font></pre>";
    }
}  
pg_close();
?>                