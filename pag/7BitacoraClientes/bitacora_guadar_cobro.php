<?php  
include '../conexion.php';
conectarse();
$a=$_POST['id'];
$cont=1;
$consulta="select c.ruc, c.razon_social, c.direccion, 
age(date 'now()',date(g.gestion_juridica)),g.gestion_juridica,
c.telefono, c.movil_claro, c.movil_movistar,
g.fecha_periodo, p.total,
l.plan, g.gestion2, g.gestion_final, g.id_gestion
from tbl_ubicacion u, tbl_factura_venta p, tbl_cliente c, tbl_instalacion i, tbl_plan_isp l, tbl_plan_servicio s, tbl_gestion_cobranzas_cobros g
where c.id_cliente=i.id_cliente 
and g.gestion2 not in('PAGAN Y SE RETIRAN','ERRORES VARIOS','PAGAN Y CONTINUAN','')
and c.id_provincia=u.id_ubicacion
and g.id_gestion=p.id_factura_venta
and i.id_plan_actual=s.id_plan_servicio 
and l.id_plan_isp=s.id_plan_isp 
and i.id_instalacion=p.id_instalacion 
and g.impresion=true 
and g.id_gestion='".$a."'
order by plan='CORPORATIVO' desc, 
plan='CORPORATIVO ESPECIAL' desc, plan='SMALL' desc, plan='SMALL ESPECIAL' desc, 
plan='RESIDENCIAL' desc, plan='RESIDENCIAL ESPECIAL' desc, plan='NOCTURNO' desc, 
plan='NOCTURNO ESPECIAL' desc, p.total desc,
ob_gesj desc;";
$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){

echo '<b>No hay sugerencias</b>';

}else{
echo '<table id="selectable" class="table table-hover">';
echo '<thead bgcolor="#FF4900">
                <tr>
                  <th>ID Cliente</th>
                  <th>CI/RUC</th>
                  <th>Nombres</th>
                  <th>Dirección</th>
                  <th>Fecha de Ingreso</th>
                  <th>Telefonos</th>
                  <th>Mes Adeudado</th>                  
                  <th>V. Deuda</th>
                  <th>I. por Mora</th>
                  <th>Plan</th>
                  <th>C. Bitacora</th>
                  <th>Guardar</th>
                </tr>
              </thead>';

while($fila=pg_fetch_array($resultado)){
echo '<tbody  id="casi" value='.$fila[9].'>';
echo '<tr>';
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
echo $fila[5],'<br>',$fila[6],'<br>',$fila[7];
echo '</td>';
echo '<td>';
echo $fila[8];
echo '</td>';
echo '<td>';
echo '<input class="form-control" id ="txtdeuda" type="text" readonly value="'.$fila[9].'">';
echo '</td>';

echo '<td>';
echo "<input class='form-control' id ='txtnota1' type='text' placeholder='Ingrese el valor de interes'>";
echo '</td>';

echo '<td>';
echo $fila[10];
echo '</td>';
echo '<td>';
//echo $fila[11];
echo '<select  id="conclusionges" style="width:97%">';
echo '<option>'.$fila[12].'</option>';
echo '<option>PAGAN Y CONTINUAN</option>;';
echo '<option>EQUIPOS DEVUELTOS</option>;';
echo '<option>POR RETIRAR</option>;';
echo '<option>SALDADO</option>;';
echo '<option>PAGAN Y SE RETIRAN</option>;';
echo '</select>';
echo '</td>';

echo '<td>';
echo "<button type='button' class='btn btn-primary' onclick='presionBotoncobros()'>Guardar</button>";
echo '</td>';
echo '</tr>';
echo '</tbody>'; 
}
echo '</table>';
}
pg_close();
?>