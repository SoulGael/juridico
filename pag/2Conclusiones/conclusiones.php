<?php
session_start();
include '../conexion.php';
conectarse();
include '../autenticacion.php';
autenticar();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="../../js/jquery-1.11.1.js"></script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/busqueda.js"></script>

    <link rel="stylesheet" href="../../css/jquery-ui.css">
    <link rel="shortcut icon" href="../../assets/ico/law.ico">

    <title>Saitel - Sistema Juridico</title>

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/ayudas.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Saitel-Sistema Juridico</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Sistema Juridico</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href=""><?php echo $_SESSION['usu']; ?></a></li>
            <li><a href="../../index.php">Cerrar Sesion</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <?php
            include '../opcionesdeusuario.php';
            opciones();
            ?>
          </ul>          
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Conclusiones</h1>
            <form name="formularioconclu" action="conclusiones.php" method="POST">
                    <h4>Ingrese el Nuevo Requerimiento:  </h4>
                    <input class="form-control" name ="txtrequerimiento" type="text" placeholder="Requerimiento">
                    <textarea class="form-control" name ="area" rows="3" placeholder="Descripcion"></textarea>
                    <br>
                    <!--<button type="button" name="btn_guardar" class="btn btn-primary" type=submit value="Guardar">Guardar</button>
                    <button type="button" name="btn_modificar" type=submit class="btn btn-primary">Modificar</button>
                    <button type="button" name="btn_eliminar" type=submit class="btn btn-primary">Eliminar</button>
                    <button type="button" name="btn_nuevo" type=reset type=submit class="btn btn-primary"onclick="accion(this)">Nuevo</button>
                    -->
                    <input  class="btn btn-success" name="btn_guardar" type=submit value="Guardar">
                    <input  class="btn btn-primary" name="btn_modificar" type=submit value="Modificar">
                    <input  class="btn btn-danger" name="btn_eliminar" type=submit value="Eliminar"> 
                    <input  class="btn btn-info" name="btn_nuevo" type=reset value="Nuevo" onclick="accion(this)">                     
            </form>     
                    <br>
                    <button type="button" class="btn btn-primary" name="btn_recargar" type=reset type=submit class="btn btn-primary" onclick="accion(this)">Actualizar</button>
                    <br><br>
                    <div id="tabla">
                        <?php  
                        $consulta="select * from tbl_conclusiones order by requerimiento asc";
                        $resultado=pg_query($consulta) or die (pg_last_error());

                        if(pg_num_rows($resultado)==0){
                            echo '<b>No hay Datos</b>';
                        }
                        else
                        {
                            echo '<table id="selectable" class="table table-hover">';
                            echo '<thead bgcolor="#FF4900">
                                            <tr>
                                              <th>Requerimientos</th>  
                                              <th>Descripcion</th>
                                            </tr>
                                          </thead>';
                            while($fila=pg_fetch_array($resultado)){
                                echo '<tr onclick=reque(this)>';
                                echo '<td>';
                                echo $fila[0];
                                echo '</td>';
                                echo '<td>';
                                echo $fila[1];
                                echo '</td>';
                                echo '</tr>';
                            }
                            echo '</table>';
                        }
                        ?>
                    </div>

                    <script type="text/javascript">
                    function accion(){ 
                        location.reload();
                    }
                    </script> 

                    <script type="text/javascript">
                    function reque(objeto){ 
                            document.formularioconclu.txtrequerimiento.value=objeto.cells[0].childNodes[0].nodeValue;
                            document.formularioconclu.area.value=objeto.cells[1].childNodes[0].nodeValue;                            
                    }
                    </script>
                    <?php
                        if(isset($_POST["btn_guardar"]))
                        {
                            pg_query("insert into tbl_conclusiones(requerimiento, descripcion) 
                            values('$_POST[txtrequerimiento]','$_POST[area]')") or die('<script language="javascript">
                            alert("El Dato Ya Existe");
                            </script>' );
                        }
                        if(isset($_POST["btn_modificar"]))
                        {
                            pg_query("update tbl_conclusiones set descripcion='$_POST[area]' where requerimiento='$_POST[txtrequerimiento]'") or die('<script language="javascript">
                            alert("No se pudo Modificar");
                            </script>' );
                        }
                        if(isset($_POST["btn_eliminar"]))
                        {
                            pg_query("delete from tbl_conclusiones where requerimiento='$_POST[txtrequerimiento]'") or die('<script language="javascript">
                            alert("No se pudo Eliminar");
                            </script>' );
                        }
                    ?>
          
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
  </body>
</html>
