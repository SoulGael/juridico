<?php 
session_start(); 
include '../conexion.php';
conectarse();
$provincia=$_POST['prov'];
$ciudad=$_POST['ciu'];
$parroquia=$_POST['par'];
$desde=$_POST['de'];
$hasta=$_POST['ha'];
$sucursal=$_POST['su'];
$cont=1;
for($i=0;;$i++){
    if(!strcmp($provincia, "TODAS")){
        $consulta="select ubicacion,
        (select ubicacion from tbl_ubicacion where i.id_ciudad=tbl_ubicacion.id_ubicacion)
         as ciudad,

        (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
         as parroquia,

        i.direccion_instalacion,g.gestion2, c.razon_social,p.id_prefactura, c.telefono, 
        c.movil_claro, c.movil_movistar, p.total ,
        l.plan, g.ob_gesj, age(date 'now()',date(g.gestion_juridica)),g.gestion_juridica
        from tbl_ubicacion u, tbl_prefactura p, tbl_cliente c, tbl_instalacion i, tbl_plan_isp l, tbl_plan_servicio s, tbl_gestion_cobranzas g
        where c.id_cliente=i.id_cliente 
        and g.gestion_final not in('PAGAN Y SE RETIRAN','ERRORES VARIOS','PAGAN Y CONTINUAN','')
        and i.id_provincia=u.id_ubicacion
        and g.id_gestion=p.id_prefactura
        and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
        and g.fecha_periodo between '".$desde."' and '".$hasta."'
        and i.id_plan_actual=s.id_plan_servicio 
        and l.id_plan_isp=s.id_plan_isp 
        and i.id_instalacion=p.id_instalacion 
        and g.impresion=false order by id_ubicacion, plan='CORPORATIVO' desc, 
        plan='CORPORATIVO ESPECIAL' desc, plan='SMALL' desc, plan='SMALL ESPECIAL' desc, 
        plan='RESIDENCIAL' desc, plan='RESIDENCIAL ESPECIAL' desc, plan='NOCTURNO' desc, 
        plan='NOCTURNO ESPECIAL' desc, p.total desc,
        ob_gesj desc;";
        break;
    }

    if(strcmp($provincia, "")&&!strcmp($ciudad, "")){
        $consulta="select (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
         as Provincia,
         ubicacion,

        (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
         as parroquia,
         i.direccion_instalacion, g.gestion2, c.razon_social, p.id_prefactura, c.telefono, 
        c.movil_claro, c.movil_movistar, p.total ,
        l.plan, g.ob_gesj,age(date 'now()',date(g.gestion_juridica)),g.gestion_juridica
        from tbl_ubicacion u, tbl_prefactura p, tbl_cliente c, tbl_instalacion i, tbl_plan_isp l, tbl_plan_servicio s, tbl_gestion_cobranzas g
        where c.id_cliente=i.id_cliente 
        and g.gestion_final not in('PAGAN Y SE RETIRAN','ERRORES VARIOS','PAGAN Y CONTINUAN','')
        and i.id_provincia=(select id_ubicacion from tbl_ubicacion where ubicacion='".$provincia."' limit 1 offset 0)
        and i.id_ciudad=u.id_ubicacion
        and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
        and g.fecha_periodo between '".$desde."' and '".$hasta."'
        and g.id_gestion=p.id_prefactura
        and i.id_plan_actual=s.id_plan_servicio 
        and l.id_plan_isp=s.id_plan_isp 
        and i.id_instalacion=p.id_instalacion 
        and g.impresion=false
        order by id_ubicacion, plan='CORPORATIVO' desc, 
        plan='CORPORATIVO ESPECIAL' desc, plan='SMALL' desc, plan='SMALL ESPECIAL' desc, 
        plan='RESIDENCIAL' desc, plan='RESIDENCIAL ESPECIAL' desc, plan='NOCTURNO' desc, 
        plan='NOCTURNO ESPECIAL' desc, p.total desc,
        ob_gesj desc;";
        break;
    }

    if(strcmp($ciudad, "")&&!strcmp($parroquia, "")){
        $consulta="select (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
        as parroquia,
        ubicacion,
        (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
         as parroquia,

         i.direccion_instalacion, g.gestion2, c.razon_social,p.id_prefactura, c.telefono, 
        c.movil_claro, c.movil_movistar, p.total ,
        l.plan, g.ob_gesj, age(date 'now()',date(g.gestion_juridica)),g.gestion_juridica
        from tbl_ubicacion u, tbl_prefactura p, tbl_cliente c, tbl_instalacion i, tbl_plan_isp l, tbl_plan_servicio s, tbl_gestion_cobranzas g
        where c.id_cliente=i.id_cliente 
        and g.gestion_final not in('PAGAN Y SE RETIRAN','ERRORES VARIOS','PAGAN Y CONTINUAN','')
        and i.id_ciudad=(select id_ubicacion from tbl_ubicacion where ubicacion='".$ciudad."' limit 1 offset 0)
        and i.id_ciudad=u.id_ubicacion
        and g.id_gestion=p.id_prefactura
        and i.id_plan_actual=s.id_plan_servicio 
        and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
        and g.fecha_periodo between '".$desde."' and '".$hasta."'
        and l.id_plan_isp=s.id_plan_isp 
        and i.id_instalacion=p.id_instalacion 
        and g.impresion=false
        order by id_ubicacion, plan='CORPORATIVO' desc, 
        plan='CORPORATIVO ESPECIAL' desc, plan='SMALL' desc, plan='SMALL ESPECIAL' desc, 
        plan='RESIDENCIAL' desc, plan='RESIDENCIAL ESPECIAL' desc, plan='NOCTURNO' desc, 
        plan='NOCTURNO ESPECIAL' desc, p.total desc,
        ob_gesj desc;";
        break;
    }

    if(strcmp($parroquia, "")){
        $consulta="select (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
         as Provincia,
        (select ubicacion from tbl_ubicacion where i.id_ciudad=tbl_ubicacion.id_ubicacion)
         as Ciudad,
         ubicacion,
         i.direccion_instalacion, g.gestion2, c.razon_social, p.id_prefactura, c.telefono, 
        c.movil_claro, c.movil_movistar, p.total ,
        l.plan, g.ob_gesj, age(date 'now()',date(g.gestion_juridica)),g.gestion_juridica
        from tbl_ubicacion u, tbl_prefactura p, tbl_cliente c, tbl_instalacion i, tbl_plan_isp l, tbl_plan_servicio s, tbl_gestion_cobranzas g
        where c.id_cliente=i.id_cliente 
        and g.gestion_final not in('PAGAN Y SE RETIRAN','ERRORES VARIOS','PAGAN Y CONTINUAN','')
        and i.id_parroquia=(select id_ubicacion from tbl_ubicacion where ubicacion='".$parroquia."' limit 1 offset 0)
        and i.id_parroquia=u.id_ubicacion
        and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
        and g.fecha_periodo between '".$desde."' and '".$hasta."'
        and g.id_gestion=p.id_prefactura
        and i.id_plan_actual=s.id_plan_servicio 
        and l.id_plan_isp=s.id_plan_isp 
        and i.id_instalacion=p.id_instalacion 
        and g.impresion=false
        order by id_ubicacion, plan='CORPORATIVO' desc, 
        plan='CORPORATIVO ESPECIAL' desc, plan='SMALL' desc, plan='SMALL ESPECIAL' desc, 
        plan='RESIDENCIAL' desc, plan='RESIDENCIAL ESPECIAL' desc, plan='NOCTURNO' desc, 
        plan='NOCTURNO ESPECIAL' desc, p.total desc,
        ob_gesj desc";
        break;
    }
}

$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){
    echo '<b>No hay sugerencias</b>';
}
else{
    echo '<table id="selectable" name="selectable" class="table table-hover">';
    echo '<thead bgcolor="#FF4900">
        <tr>
        <th>N°</th>
        <th>Id Cliente</th>
        <th>Provincia</th>        
        <th>Ciudad</th>  
        <th>Parroquia</th> 
        <th>Direccion</th> 
        <th>Razon Social</th> 
        <th>Telefonos</th>         
        <th>Gestion</th>
        <th>Deuda</th> 
        <th>Plan</th>
        <th colspan="2">Imprimir<input name="checktodos" type="checkbox" onchange=seleccionar(this)></th>
        <th>Fecha Impresión</th>
        </tr>
        </thead>';
    
    while($fila=pg_fetch_array($resultado)){
        //echo '<tr onclick=salida(this)>';
        echo '<tr>';
        echo '<td>';
        echo $cont;
        echo '</td>';
        echo '<td>';
        echo $fila[6];
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
        echo '<td>';
        echo $fila[3];
        echo '</td>';
        echo '<td>';
        echo $fila[5];
        echo '</td>';
        echo '<td>';
        echo $fila[7],' ',$fila[8],' ',$fila[9];
        echo '</td>';
        echo '<td>';
        echo $fila[4];
        echo '</td>';
        echo '<td>';
        echo $fila[10];
        echo '</td>';
        echo '<td>';
        echo $fila[11];
        echo '</td>';
        echo '<td>';        
        echo '<input type="checkbox" name="condi" value="'.$fila[6].'" id="condiciones'.$cont.'">';
        echo '</td>';
        echo '<td>';
        echo $fila[12];
        echo '</td>';
        echo '<td align=center>';
        echo $fila[14];
        echo '<br>';
        echo $fila[13];
        echo '</td>';           
        echo '</tr>';
        $cont++;
    }
    echo '</table>';
}


//Modulo de cobros
$cont=1;
for($i=0;;$i++){
    if(!strcmp($provincia, "TODAS")){
        $consulta="select ubicacion,
        (select ubicacion from tbl_ubicacion where i.id_ciudad=tbl_ubicacion.id_ubicacion)
         as ciudad,

        (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
         as parroquia,

        i.direccion_instalacion,g.gestion2, c.razon_social,p.id_factura_venta, c.telefono, 
        c.movil_claro, c.movil_movistar, p.total ,
        l.plan, g.ob_gesj, age(date 'now()',date(g.gestion_juridica)),g.gestion_juridica
        from tbl_ubicacion u, tbl_factura_venta p, tbl_cliente c, tbl_instalacion i, tbl_plan_isp l, tbl_plan_servicio s, tbl_gestion_cobranzas_cobros g
        where c.id_cliente=i.id_cliente 
        and g.gestion_final not in('PAGAN Y SE RETIRAN','ERRORES VARIOS','PAGAN Y CONTINUAN','')
        and i.id_provincia=u.id_ubicacion
        and g.id_gestion=p.id_factura_venta
        and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
        and g.fecha_periodo between '".$desde."' and '".$hasta."'
        and i.id_plan_actual=s.id_plan_servicio 
        and l.id_plan_isp=s.id_plan_isp 
        and i.id_instalacion=p.id_instalacion 
        and g.impresion=false order by id_ubicacion, plan='CORPORATIVO' desc, 
        plan='CORPORATIVO ESPECIAL' desc, plan='SMALL' desc, plan='SMALL ESPECIAL' desc, 
        plan='RESIDENCIAL' desc, plan='RESIDENCIAL ESPECIAL' desc, plan='NOCTURNO' desc, 
        plan='NOCTURNO ESPECIAL' desc, p.total desc,
        ob_gesj desc;";
        break;
    }

    if(strcmp($provincia, "")&&!strcmp($ciudad, "")){
        $consulta="select (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
         as Provincia,
         ubicacion,

        (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
         as parroquia,
         i.direccion_instalacion, g.gestion2, c.razon_social, p.id_factura_venta, c.telefono, 
        c.movil_claro, c.movil_movistar, p.total ,
        l.plan, g.ob_gesj,age(date 'now()',date(g.gestion_juridica)),g.gestion_juridica
        from tbl_ubicacion u, tbl_factura_venta p, tbl_cliente c, tbl_instalacion i, tbl_plan_isp l, tbl_plan_servicio s, tbl_gestion_cobranzas_cobros g
        where c.id_cliente=i.id_cliente 
        and g.gestion_final not in('PAGAN Y SE RETIRAN','ERRORES VARIOS','PAGAN Y CONTINUAN','')
        and i.id_provincia=(select id_ubicacion from tbl_ubicacion where ubicacion='".$provincia."' limit 1 offset 0)
        and i.id_ciudad=u.id_ubicacion
        and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
        and g.fecha_periodo between '".$desde."' and '".$hasta."'
        and g.id_gestion=p.id_factura_venta
        and i.id_plan_actual=s.id_plan_servicio 
        and l.id_plan_isp=s.id_plan_isp 
        and i.id_instalacion=p.id_instalacion 
        and g.impresion=false
        order by id_ubicacion, plan='CORPORATIVO' desc, 
        plan='CORPORATIVO ESPECIAL' desc, plan='SMALL' desc, plan='SMALL ESPECIAL' desc, 
        plan='RESIDENCIAL' desc, plan='RESIDENCIAL ESPECIAL' desc, plan='NOCTURNO' desc, 
        plan='NOCTURNO ESPECIAL' desc, p.total desc,
        ob_gesj desc;";
        break;
    }

    if(strcmp($ciudad, "")&&!strcmp($parroquia, "")){
        $consulta="select (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
        as parroquia,
        ubicacion,
        (select ubicacion from tbl_ubicacion where i.id_parroquia=tbl_ubicacion.id_ubicacion)
         as parroquia,

         i.direccion_instalacion, g.gestion2, c.razon_social,p.id_factura_venta, c.telefono, 
        c.movil_claro, c.movil_movistar, p.total ,
        l.plan, g.ob_gesj, age(date 'now()',date(g.gestion_juridica)),g.gestion_juridica
        from tbl_ubicacion u, tbl_factura_venta p, tbl_cliente c, tbl_instalacion i, tbl_plan_isp l, tbl_plan_servicio s, tbl_gestion_cobranzas_cobros g
        where c.id_cliente=i.id_cliente 
        and g.gestion_final not in('PAGAN Y SE RETIRAN','ERRORES VARIOS','PAGAN Y CONTINUAN','')
        and i.id_ciudad=(select id_ubicacion from tbl_ubicacion where ubicacion='".$ciudad."' limit 1 offset 0)
        and i.id_ciudad=u.id_ubicacion
        and g.id_gestion=p.id_factura_venta
        and i.id_plan_actual=s.id_plan_servicio 
        and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
        and g.fecha_periodo between '".$desde."' and '".$hasta."'
        and l.id_plan_isp=s.id_plan_isp 
        and i.id_instalacion=p.id_instalacion 
        and g.impresion=false
        order by id_ubicacion, plan='CORPORATIVO' desc, 
        plan='CORPORATIVO ESPECIAL' desc, plan='SMALL' desc, plan='SMALL ESPECIAL' desc, 
        plan='RESIDENCIAL' desc, plan='RESIDENCIAL ESPECIAL' desc, plan='NOCTURNO' desc, 
        plan='NOCTURNO ESPECIAL' desc, p.total desc,
        ob_gesj desc;";
        break;
    }

    if(strcmp($parroquia, "")){
        $consulta="select (select ubicacion from tbl_ubicacion where i.id_provincia=tbl_ubicacion.id_ubicacion)
         as Provincia,
        (select ubicacion from tbl_ubicacion where i.id_ciudad=tbl_ubicacion.id_ubicacion)
         as Ciudad,
         ubicacion,
         i.direccion_instalacion, g.gestion2, c.razon_social, p.id_factura_venta, c.telefono, 
        c.movil_claro, c.movil_movistar, p.total ,
        l.plan, g.ob_gesj, age(date 'now()',date(g.gestion_juridica)),g.gestion_juridica
        from tbl_ubicacion u, tbl_factura_venta p, tbl_cliente c, tbl_instalacion i, tbl_plan_isp l, tbl_plan_servicio s, tbl_gestion_cobranzas_cobros g
        where c.id_cliente=i.id_cliente 
        and g.gestion_final not in('PAGAN Y SE RETIRAN','ERRORES VARIOS','PAGAN Y CONTINUAN','')
        and i.id_parroquia=(select id_ubicacion from tbl_ubicacion where ubicacion='".$parroquia."' limit 1 offset 0)
        and i.id_parroquia=u.id_ubicacion
        and i.id_sucursal=(select id_sucursal from tbl_sucursal where sucursal='".$sucursal."')
        and g.fecha_periodo between '".$desde."' and '".$hasta."'
        and g.id_gestion=p.id_factura_venta
        and i.id_plan_actual=s.id_plan_servicio 
        and l.id_plan_isp=s.id_plan_isp 
        and i.id_instalacion=p.id_instalacion 
        and g.impresion=false
        order by id_ubicacion, plan='CORPORATIVO' desc, 
        plan='CORPORATIVO ESPECIAL' desc, plan='SMALL' desc, plan='SMALL ESPECIAL' desc, 
        plan='RESIDENCIAL' desc, plan='RESIDENCIAL ESPECIAL' desc, plan='NOCTURNO' desc, 
        plan='NOCTURNO ESPECIAL' desc, p.total desc,
        ob_gesj desc;";
        break;
    }
}

echo '<h2>COBROS</h2>';
echo '<input  class="btn btn-success" name="btn_imprimir_cobro" type=submit value="Imprimir" onclick=imprimoCobro(this)>';
$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){
    echo '<b>No hay sugerencias</b>';
}
else{
    echo '<table id="selectableCobro" name="selectableCobro" class="table table-hover">';
    echo '<thead bgcolor="#FF4900">
        <tr>
        <th>N°</th>
        <th>Id Cliente</th>
        <th>Provincia</th>        
        <th>Ciudad</th>  
        <th>Parroquia</th> 
        <th>Direccion</th> 
        <th>Razon Social</th> 
        <th>Telefonos</th>         
        <th>Gestion</th>
        <th>Deuda</th> 
        <th>Plan</th>
        <th colspan="2">Imprimir<input name="checktodoscobros" type="checkbox" onchange=seleccionarCobros(this)></th>
        <th>Fecha Impresión</th>
        </tr>
        </thead>';
    
    while($fila=pg_fetch_array($resultado)){
        //echo '<tr onclick=salida(this)>';
        echo '<tr>';
        echo '<td>';
        echo $cont;
        echo '</td>';
        echo '<td>';
        echo $fila[6];
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
        echo '<td>';
        echo $fila[3];
        echo '</td>';
        echo '<td>';
        echo $fila[5];
        echo '</td>';
        echo '<td>';
        echo $fila[7],' ',$fila[8],' ',$fila[9];
        echo '</td>';
        echo '<td>';
        echo $fila[4];
        echo '</td>';
        echo '<td>';
        echo $fila[10];
        echo '</td>';
        echo '<td>';
        echo $fila[11];
        echo '</td>';
        echo '<td>';        
        echo '<input type="checkbox" name="condicobros" value="'.$fila[6].'" id="condicionescobros'.$cont.'">';
        echo '</td>';
        echo '<td>';
        echo $fila[12];
        echo '</td>';
        echo '<td align=center>';
        echo $fila[14];
        echo '<br>';
        echo $fila[13];
        echo '</td>';           
        echo '</tr>';
        $cont++;
    }
    echo '</table>';
}
pg_close();
?>