<?php  
include '../conexion.php';
conectarse();
$q=$_POST['q'];
$consulta="select ubicacion 
from tbl_ubicacion 
where id_padre=(select id_ubicacion from tbl_ubicacion where ubicacion='".$q."' limit 1 offset 0)";
$resultado=pg_query($consulta) or die (pg_last_error());

if(pg_num_rows($resultado)==0){

echo '<b>No hay sugerencias</b>';

}else{
	echo "<option> </option>";
    while($tabla=pg_fetch_array($resultado))
        {
            echo "<option>".$tabla['ubicacion']."</option>";
        }
}
pg_close();
 ?>