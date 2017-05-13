<?php  
function opciones() {

     if (!$_SESSION){
     echo '<script language = javascript>
     alert("usuario no autenticado")
     self.location = "../index.php"
     </script>';
     }

$consulta="select tbl_pagina.pagina from tbl_pagina, tbl_privilegio where tbl_privilegio.id_pagina=tbl_pagina.id_pagina and tbl_privilegio.id_rol='".$_SESSION['idrol']."' and tbl_pagina.modulo='10' order by tbl_pagina.orden_modulo"; 
$resultado=pg_query($consulta) or die (pg_last_error());
$total = pg_num_rows($resultado);
for($i=0;$i<=$total;$i++)
{
     $fila=pg_fetch_array($resultado);
     if($fila['pagina']=="gestiondelconocimiento")
     {
      //echo "<a href='../pag/gconocimiento.php'><h4 style='margin-top:10px; margin-bottom:10px;'><img src='../img/gestioncon.png'>&nbsp G. del Conocimiento</h4></a>";
      echo "<li><a href='../../pag/1GestionConocimiento/index.php'><img src='../../img/gestioncon.png'>Gestion del Conocimiento</a></li>";
     }

     if($fila['pagina']=="conclusiones")
     {
      //echo "<a href='../pag/conclusiones.php'><h4 style='margin-top:10px; margin-bottom:10px;'><img src='../img/conclu.png'>&nbsp Conclusiones</h4></a>";
      echo "<li><a href='../../pag/2Conclusiones/conclusiones.php'><img src='../../img/conclu.png'>Conclusiones</a></li>";
     }

     if($fila['pagina']=="conclusionesdenotificaciones")
     {
      //echo "<a href='../pag/cdenotificaciones.php'><h4 style='margin-top:10px; margin-bottom:10px;'><img src='../img/concluynotifi.png'>&nbsp C. de Notificaciones</h4></a>";
      echo "<li><a href='../../pag/3ConclusionesNotificaciones/cdenotificaciones.php'><img src='../../img/concluynotifi.png'>Conclusiones de Notificaciones</a></li>";
     }

     if($fila['pagina']=="gestionderecuperaciondecartera")
     {
      //echo "<a href='../pag/gcobranzas.php'><h4 style='margin-top:10px; margin-bottom:10px;'><img src='../img/gestiondecobranzas.png'>&nbsp G. de Cobranzas</h4></a>";
      echo "<li><a href='../../pag/4GestionCobranzas/gcobranzas.php'><img src='../../img/gestiondecobranzas.png'>Gestion de Cobranzas</a></li>";
     }

     if($fila['pagina']=="aprobacionodecartera")
     {
      //echo "<a href='../pag/registronotificaciones.php'><h4 style='margin-top:10px; margin-bottom:10px;'><img src='../img/gestiondecobranzas.png'>&nbsp R. de Notificaciones</h4></a>";
      echo "<li><a href='../../pag/5ImprimirNotificacones/regimpresionnotificaciones.php'><img src='../../img/130.png'>Imprimir Notificaciones</a></li>";
     }

     if($fila['pagina']=="registronotificaciones")
     {
      //echo "<a href='../pag/reportes.php'><h4 style='margin-top:10px; margin-bottom:10px;'><img src='../img/reporte.png'>&nbsp Reportes</h4></a>";
      echo "<li><a href='../../pag/6RegistroNotificaciones/notificaciones.php'><img src='../../img/notificaciones.png'>Registro de Notificaciones</a></li>";
     }

     if($fila['pagina']=="bitacoradeclientes")
     {
      //echo "<a href='../pag/bclientes.php'><h4 style='margin-top:10px; margin-bottom:10px;'><img src='../img/bitacoraclientes.png'>&nbsp Bitacora de Clientes</h4></a>";
      echo "<li><a href='../../pag/7BitacoraClientes/bclientes.php'><img src='../../img/bitacoraclientes.png'>Bitacora de Clientes</a></li>";
     }

     if($fila['pagina']=="reactivaciones")
     {
      //echo "<a href='../pag/reactivaciones.php'><h4 style='margin-top:10px; margin-bottom:10px;'><img src='../img/reactivacion.png'>&nbsp Reactivaciones</h4></a>";
      echo "<li><a href='../../pag/8Reactivaciones/reactivaciones.php'><img src='../../img/reactivacion.png'>Reactivaciones</a></li>";
     }

     if($fila['pagina']=="reportes")
     {
      //echo "<a href='../pag/reportes.php'><h4 style='margin-top:10px; margin-bottom:10px;'><img src='../img/reporte.png'>&nbsp Reportes</h4></a>";
      echo "<li><a href='../../pag/9Reportes/reportes.php'><img src='../../img/reporte.png'>Reportes</a></li>";
     }
   }
}
?>
