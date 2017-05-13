<?php
session_start();
include '../conexion.php';
conectarse();
include '../autenticacion.php';
autenticar();
include '../chaoip.php';
eliminar();
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
            <li><a href="index.php"><?php echo $_SESSION['usu']; ?></a></li>
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
          <h1 class="page-header">Gestion del Conocimiento</h1>
            <div class="input-group input-group-sm">
              <span class="input-group-addon">Nombres</span>
              <input type="text" class="form-control" id="idusuario" name="idusuario"  onkeyup="loadXMLDoc()" placeholder="Apellidos o Nombres" onKeyPress="if (event.keyCode >45 && event.keyCode  <57) event.returnValue =false;">
              <span class="input-group-addon">CI</span>
              <input type="text" class="form-control" id="ciusuario" name="ciusuario"  onkeyup="loadXMLDoci()"placeholder="N° de Cedula" onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue=false; ">
            </div>

            <br>
            <div id="consu">

            </div>
                    
                    <!-- al momento de hacer cic-->
                    <script type="text/javascript"> 
                        function muestra(objeto){                         
                        consultahistorialpagos(objeto.cells[0].childNodes[0].nodeValue);
                        consultaprefacturapendiente(objeto.cells[0].childNodes[0].nodeValue);
                        suspencionestemporales(objeto.cells[0].childNodes[0].nodeValue);
                        ordenesdetrabajo(objeto.cells[0].childNodes[0].nodeValue);
                        idusuario.value = "";
                        document.getElementById("consu").innerHTML="";

                        var div = document.getElementById("barracontenido");
                        var nestedDiv = document.getElementById("consu");
                        nestedDiv.textContent = objeto.cells[1].childNodes[0].nodeValue + " - " + objeto.cells[2].childNodes[0].nodeValue;
                        var text = "[" + div.textContent + "]";
                        
                        // tiene que aparecer pepe  value="simon" disabled
                        //si quiero saber el id de la tabla, que no deja de ser un parametro 
                        //alert(objeto.parentNode.parentNode.id);// tiene que aparecer TABLApepe o TABLApepe2  
                        //parentNode lo que haces es preguntar por el padre del TR, osea el TBODY y luego su padre, que es la tabla y nos da el id 
                        //alert(objeto.offsetParent.id);// tambien aparecera TABLApepe o TABLApepe2 
                        //offsetParent nos situará en la tabla 
                    } 
                    </script>   
                    <script type="text/javascript">
                    function detallefac(mue){  
                        factu(mue.cells[0].childNodes[0].nodeValue);                       
                        //window.open('../pag/factura.php?q='+mue.cells[0].childNodes[0].nodeValue,'','width=1050, height= 570, menubar=no, scrollbars=no, toolbar=no, location=no, directories=no, status=no, resizable=no, top=70, left=70');return false;
                    }
                    </script> 

                    <br>
                    <div id="tabs">
                        <ul>
                            <li><a href="#histopagos"><span>Historial de Pagos</span></a></li>
                            <li><a href="#prefacturapendiente"><span>Prefacturas Pendientes</span></a></li>
                            <li><a href="#suspencionteporal"><span>Susp. Temporales, Req. Adicionales y Definitivas</span></a></li>
                            <li><a href="#ordendesinstalacion"><span>Ordenes de Trabajo</span></a></li>
                        </ul>

                        <div id="histopagos">                             

                        </div>
                        <div id="prefacturapendiente">
                        
                        </div>
                        <div id="suspencionteporal">
                        
                        </div>
                        <div id="ordendesinstalacion">
                        
                        </div>   
                    </div>
 
                    <script>
                        $( "#tabs" ).tabs();
                    </script>
                    
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Factura</h4>
                                </div>
                                <div class="modal-body" id="respu">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>   
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
