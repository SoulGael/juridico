<?php
function eliminar() {
error_reporting(0);
$consulta="select tbl_gestion_cobranzas.id_gestion, tbl_cliente.ruc, tbl_prefactura.valor_internet
from tbl_ubicacion, tbl_prefactura, tbl_cliente, tbl_instalacion, tbl_plan_isp, tbl_plan_servicio, tbl_gestion_cobranzas
where tbl_cliente.id_cliente=tbl_instalacion.id_cliente 
and tbl_gestion_cobranzas.gestion_final not in('PAGAN Y SE RETIRAN','ERRORES VARIOS','PAGAN Y CONTINUAN','')
and tbl_cliente.id_provincia=tbl_ubicacion.id_ubicacion
and tbl_gestion_cobranzas.id_gestion=tbl_prefactura.id_prefactura
and tbl_instalacion.id_plan_actual=tbl_plan_servicio.id_plan_servicio 
and tbl_plan_isp.id_plan_isp=tbl_plan_servicio.id_plan_isp 
and tbl_instalacion.id_instalacion=tbl_prefactura.id_instalacion 
and tbl_prefactura.fecha_emision is null 
and tbl_gestion_cobranzas.impresion=true 
and (age(date 'now()',date(tbl_gestion_cobranzas.gestion_juridica)))>'1 mon'
and orden_trabajo=false
order by plan='CORPORATIVO' desc, 
plan='CORPORATIVO ESPECIAL' desc, plan='SMALL' desc, plan='SMALL ESPECIAL' desc, 
plan='RESIDENCIAL' desc, plan='RESIDENCIAL ESPECIAL' desc, plan='NOCTURNO' desc, 
plan='NOCTURNO ESPECIAL' desc, valor_internet desc,
ob_gesj desc;"; 
$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){
}
else{
	while($fila=pg_fetch_array($resultado)){
    pg_query("update tbl_gestion_cobranzas set orden_trabajo=true where id_gestion='".$fila[0]."'") or die("Error de conexion. ". pg_last_error());
    pg_query("update tbl_instalacion set estado_servicio='r' where id_instalacion=(select max(id_instalacion) from tbl_instalacion where id_cliente=(select id_cliente from tbl_gestion_cobranzas where id_gestion='".$fila[0]."'))") or die("Error de conexion. ". pg_last_error());
    pg_query("insert into tbl_orden_trabajo(id_instalacion, id_sucursal, num_orden, fecha_reporte, tipo_trabajo, diagnostico_tecnico, usuario_reporte, usuario_cliente, estado) 
        values
        ((select id_instalacion from tbl_instalacion where id_cliente=(select id_instalacion from tbl_prefactura where id_prefactura='".$fila[0]."'),
            (select id_sucursal from tbl_instalacion where id_cliente=(select id_cliente from tbl_gestion_cobranzas where id_gestion='".$fila[0]."'),
                (select (max(num_orden)::int)+1 from tbl_orden_trabajo where id_sucursal=(select id_sucursal from tbl_instalacion where id_cliente=(select id_cliente from tbl_gestion_cobranzas where id_gestion='".$fila[0]."')), 
                    date 'now()',
                    '4', 
                    'RETIRO DE EQUIPOS GENERADO POR EL SISTEMA',
                    'sistemas'") 
    or die('' );
	}    
}

}
?>