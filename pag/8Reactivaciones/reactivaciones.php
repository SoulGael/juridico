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
          <h1 class="page-header">Reactivaciones</h1>
            <div class="input-group input-group-sm">
              <span class="input-group-addon">Nombres</span>
              <input type="text" class="form-control" id="idusuario" name="idusuario"  onkeyup="reactivacionconsu()" placeholder="Apellidos o Nombres" onKeyPress="if (event.keyCode >45 && event.keyCode  <57) event.returnValue =false;">
              <span class="input-group-addon">CI</span>
              <input type="text" class="form-control" id="ciusuario" name="ciusuario"  onkeyup="reactivacionconsuci()"placeholder="N° de Cedula" onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue=false; ">
            </div>
                    
                    <!-- al momento de hacer cic-->
                    <script type="text/javascript"> 
                    function lamuestra(objeto){
                    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
                      var diasSemana = new Array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"); 
                      var f=new Date(); 
                      var fe=(diasSemana[f.getDay()] + " " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

                    confirmar=confirm("Reactivar al Cliente?"); 
                      if (confirmar) {
                        //alert(objeto.cells[0].childNodes[0].nodeValue);
                        pdf(fe, 
                          objeto.cells[2].childNodes[0].nodeValue,
                          objeto.cells[1].childNodes[0].nodeValue);

                        reactivarcliente(objeto.cells[0].childNodes[0].nodeValue);
                      }
                    }

                    function lamuestracobros(objeto){
                    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
                      var diasSemana = new Array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"); 
                      var f=new Date(); 
                      var fe=(diasSemana[f.getDay()] + " " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

                    confirmar=confirm("Reactivar al Cliente o clienta?"); 
                      if (confirmar) {
                        pdf(fe, 
                          objeto.cells[2].childNodes[0].nodeValue,
                          objeto.cells[1].childNodes[0].nodeValue);
                        
                        reactivarcliente(objeto.cells[0].childNodes[0].nodeValue);
                      }
                    }

                    function pdf(fecha,nombre,cedula){
                      var fe=fecha;
                      var nom=nombre;
                      var ced=cedula;
                        for(var i=0;i<=10000;i++)
                        {
                          if(i==10000)
                          {
                            window.open('reactivacionespdf.php?fec='+fe+'&nomb='+nom+'&cedu='+ced);
                          }
                        }
                    }
                    </script>   
                    <br>
                    <div id="clientes">

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
