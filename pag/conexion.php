<?php
function conectarse() {
	if (!($conexion = pg_connect("host='127.0.0.1' port=5432 dbname='db_isp' user='gestion_juridica' password='91GGr15da19'"))) 
    //if (!($conexion = pg_connect("host='localhost' port=5432 dbname='db_isp' user='postgres' password='postgres'"))) 
    {			
        exit();
    }
    else {       
    }
    return $conexion;
}
?>
