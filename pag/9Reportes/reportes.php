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
    <script src="highcharts.js"></script>
    <script src="highcharts-3d.js"></script>
    <script src="exporting.js"></script>

    <link rel="stylesheet" href="../../css/jquery-ui.css">
    <link rel="shortcut icon" href="../../assets/ico/law.ico">

    <script>
  $(function() {
    $( "#desde" ).datepicker({
      changeMonth: true,
      changeYear: true,
      showOtherMonths: true,
      selectOtherMonths: true,
      showOn: "button",
      buttonImage: "../../img/calendar.gif",
      buttonImageOnly: true,
    });

    $( "#hasta" ).datepicker({
      changeMonth: true,
      changeYear: true,
      showOtherMonths: true,
      selectOtherMonths: true,
      showOn: "button",
      buttonImage: "../../img/calendar.gif",
      buttonImageOnly: true
    });
  });
  </script>

    <title>Saitel - Sistema Juridico</title>

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/ayudas.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../dashboard.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    

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
          <h1 class="page-header">Reportes</h1>                    
                    Desde: <input type="text" name="desde" id="desde" required >
                    Hasta: <input type="text" name="hasta" id="hasta" required >
                    <br>
                    <br>
                    <?php
                    $consulta="select tbl_pagina.pagina from tbl_pagina, tbl_privilegio where tbl_privilegio.id_pagina=tbl_pagina.id_pagina and tbl_privilegio.id_rol='".$_SESSION['idrol']."' and tbl_pagina.modulo='10' order by tbl_pagina.id_pagina"; 
                    $resultado=pg_query($consulta) or die (pg_last_error());
                    $total = pg_num_rows($resultado);
                    for($i=0;$i<=$total;$i++)
                    {
                      $fila=pg_fetch_array($resultado);
                      if($fila['pagina']=="gestionderecuperaciondecartera")
                      {
                        echo "<input  type='button' class='btn btn-primary' name='btn_generar' type=submit value='Reporte Cobranzas' onclick=genera(this)>&nbsp &nbsp";
                        echo "<input  type='button' class='btn btn-primary' name='btn_generareporte' type=submit value='Imprimir Reporte' onclick=generapdf(this)>";
                        echo "<br><br>";
                      }
                      if($fila['pagina']=="aprobacionodecartera")
                      {
                        echo "<input class='btn btn-info' name='btn_generarjuridico' type=submit value='Reporte Juridico'  onclick=generajuridico(this)> &nbsp &nbsp";
                        echo "<input class='btn btn-info' name='btn_generarjuridicoreporte' type=submit value='Imprimir Reporte' onclick=generajuridicopdf(this)>";
                        echo "<br><br>";
                      }
                      if($fila['pagina']=="registronotificaciones")
                      {
                        echo "<input class='btn btn-warning' name='btn_generarnotificacion' type=submit value='Reporte Notificaciones'  onclick=generanotif(this)> &nbsp &nbsp";
                        echo "<input class='btn btn-warning' name='btn_generarnotificacionreporte' type=submit value='Imprimir Reporte Notificaciones' onclick=generanotificacionespdf(this)>";
                      }
                    }
                  ?>

                    <script type="text/javascript">
                    function genera(mue){ 
                      document.getElementById("resultados").innerHTML="";
                      if(desde.value==''||hasta.value==''){
                        alert("los campos de fechas estan vacios");
                      }
                      else{
                        //document.getElementById("resultados").innerHTML = "";
                        //generarjuridico(desde.value, hasta.value);
                          var parametros = {
                            "desde" : desde.value,
                            "hasta" : hasta.value
                          };

                           $.ajax({
                              data:  parametros,
                              url:"reportecobranza.php",
                              dataType: 'jsonp',
                              success:function(data){
                                console.log(data);
                                  var con=0;
                                  var opcion = [];
                                  var numero = [];
                                  var i = 0

                                  for( ;  ; ){
                                    console.log(numero);
                                    if(data[0]['usuario'][i]!=data[0]['requerimiento'][0][con]){

                                      $("#resultados").append("<div id='hel"+i+"'></div>");
                                      Highcharts.chart('hel'+i, {
                                        chart: {
                                          type: 'pie',
                                          options3d: {
                                            enabled: true,
                                            alpha: 45,
                                            beta: 0
                                          }
                                        },
                                        title: {
                                          text: 'Reporte del usuario '+data[0]['usuario'][i]
                                        },
                                        tooltip: {
                                          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                        },
                                        plotOptions: {
                                          pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            depth: 35,
                                            dataLabels: {
                                              enabled: true,
                                              format: '{point.name}'
                                            }
                                          }
                                        },
                                        series: [{
                                          type: 'pie',
                                          name: 'Porcentaje',
                                          data: numero
                                        }]
                                      });

                                      i++;
                                      numero=[];
                                    }

                                    if (data[0]['usuario'][i]==data[0]['requerimiento'][0][con]) {
                                      opcion.push(data[0]['requerimiento'][1][con]+'('+data[0]['requerimiento'][2][con]+')', 
                                            parseInt(data[0]['requerimiento'][2][con]));
                                      console.log(opcion);
                                      numero.push(opcion);
                                      opcion=[];
                                    };
                                    if(i == (data[0]['usuario'].length)){
                                      break;
                                    }
                                    con++;
                                                
                                  }
                              },
                              error:function(data){
                                  console.log("error");
                                  console.log(data);
                              }
                          });
                        }                      
                    }

                    function generajuridico(mue){
                      document.getElementById("resultados").innerHTML="";
                      if(desde.value==''||hasta.value==''){
                        alert("los campos de fechas estan vacios");
                      }
                      else{
                        //document.getElementById("resultados").innerHTML = "";
                        //generarjuridico(desde.value, hasta.value);
                          var parametros = {
                            "desde" : desde.value,
                            "hasta" : hasta.value
                          };

                           $.ajax({
                              data:  parametros,
                              url:"reportecobranzajuridico.php",
                              dataType: 'jsonp',
                              success:function(data){

                                  var con=0;
                                  var opcion = [];
                                  var numero = [];
                                  var i = 0

                                  for( ;  ; ){
                                    console.log(numero);
                                    if(data[0]['usuario'][i]!=data[0]['requerimiento'][0][con]){

                                      $("#resultados").append("<div id='hel"+i+"'></div>");
                                      Highcharts.chart('hel'+i, {
                                        chart: {
                                          type: 'pie',
                                          options3d: {
                                            enabled: true,
                                            alpha: 45,
                                            beta: 0
                                          }
                                        },
                                        title: {
                                          text: 'Reporte del usuario '+data[0]['usuario'][i]
                                        },
                                        tooltip: {
                                          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                        },
                                        plotOptions: {
                                          pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            depth: 35,
                                            dataLabels: {
                                              enabled: true,
                                              format: '{point.name}'
                                            }
                                          }
                                        },
                                        series: [{
                                          type: 'pie',
                                          name: 'Porcentaje',
                                          data: numero
                                        }]
                                      });

                                      i++;
                                      numero=[];
                                    }

                                    if (data[0]['usuario'][i]==data[0]['requerimiento'][0][con]) {
                                      opcion.push(data[0]['requerimiento'][1][con]+'('+data[0]['requerimiento'][2][con]+')', 
                                            parseInt(data[0]['requerimiento'][2][con]));
                                      console.log(opcion);
                                      numero.push(opcion);
                                      opcion=[];
                                    };
                                    if(i == (data[0]['usuario'].length)){
                                      break;
                                    }
                                    con++;
                                                
                                  }
                              },
                              error:function(data){
                                  console.log("error");
                                  console.log(data);
                              }
                          });
                        }
                      }

                    function generanotif(mue){ 
                        if(desde.value==''||hasta.value=='')
                      {
                        alert("los campos de fechas estan vacios");
                      }
                      else
                      {
                        generarno(desde.value, hasta.value);
                      }  
                      
                    }

                    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
                    var diasSemana = new Array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"); 
                    var f=new Date(); 
                    var fe=(diasSemana[f.getDay()] + " " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

                    function generapdf(mue){ 
                      //alert(fe);
                      window.open('reportecobranzapdf.php?fec='+fe+'&des='+desde.value+'&has='+hasta.value);
                    }

                    function generajuridicopdf(mue){ 
                      //alert(fe);
                      
                      window.open('reportecobranzajuridicopdf.php?fec='+fe+'&des='+desde.value+'&has='+hasta.value);
                    }

                    function generanotificacionespdf(mue){ 
                      //alert(fe);
                      window.open('reportenotificacionespdf.php?fec='+fe+'&des='+desde.value+'&has='+hasta.value);
                    }
                    </script>
                <!--<form name="formularioconclu" action="gcrobranzas.php" method="POST">-->
                <br>
                <br>
                    <div id="resultados">
                    </div>
                <!--</form>-->

          
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