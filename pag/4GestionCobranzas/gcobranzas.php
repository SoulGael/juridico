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
    <!--<link href="../../css/ayudas.css" rel="stylesheet">-->

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
            <li><a href=""><?php echo $_SESSION['usu']; ?><input type="hidden" value="<?php echo $_SESSION['usu']; ?>" id="sesi" /></a></li>
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
          <h1 class="page-header">Gestión de Cobranzas</h1>
          <select name="sucur" id="sucur">
            <?php
            error_reporting(0);
            $consulta="select sucursal from tbl_sucursal order by id_sucursal";
            $resultado=pg_query($consulta) or die (pg_last_error());
            echo "<tr>";
            while($tabla=pg_fetch_array($resultado))
            {
              echo "<option>".$tabla['sucursal']."</option>";
            } 
            ?>
          </select>      
          <br>
          <br>
                    Tipo de Plan 
                    <select name="tipos" id="tipos">
                        <option>TODOS</option>
                        <?php
                            error_reporting(0);
                            $consulta="select plan from tbl_plan_isp order by plan='CORPORATIVO' desc, plan='CORPORATIVO ESPECIAL' desc, plan='SMALL' desc, plan='SMALL ESPECIAL' desc, plan='RESIDENCIAL' desc, plan='RESIDENCIAL ESPECIAL' desc, plan='NOCTURNO' desc, plan='NOCTURNO ESPECIAL' desc";
                            $resultado=pg_query($consulta) or die (pg_last_error());
                            echo "<tr>";
                            while($tabla=pg_fetch_array($resultado))
                            {
                                echo "<option>".$tabla['plan']."</option>";
                            } 
                        ?>
                    </select>                    
                    Desde: <input type="text" name="desde" id="desde" required >
                    Hasta: <input type="text" name="hasta" id="hasta" required >
                    <br>     
                    <input  class="btn btn-primary" name="btn_generar" type=submit value="Mostrar" onclick=genera(this)>
                    <input  class="btn btn-success" name="btn_imprimir" type=submit value="Reporte Mensajes" onclick=imprimirRep()>
                    
                    <script type="text/javascript">
                    function genera(mue){ 
                      var d = document.getElementById("resultados");
                      while (d.hasChildNodes())
                      d.removeChild(d.firstChild);
                      //alert(tipos.value + desde.value + hasta.value);
                      if(desde.value==''||hasta.value=='')
                      {
                        alert('LLene todos los campos por favor');
                      }
                      else
                      {
                        consufiltro(tipos.value, desde.value, hasta.value, sucur.value);
                      }
                    }

                    function imprimirRep(){
                      console
                      if(desde.value==''||hasta.value==''){
                        alert('LLene todos los campos de las fechas por favor');
                      }
                      else{
                        window.open('impresiontelefono.php?des='+desde.value+'&has='+hasta.value);
                      }
                    }
                    function guardar(id){
                      var gesuno = $("#guno_"+id+"").val();
                      var areauno = $("#areag1_"+id+"").val();
                      var nombre = $("#nombre_"+id+"").val();
                      var opc = 'gestion1';
                      var sesi = $("#sesi").val();
                      //alert(id+' '+gesuno+' '+areauno+' '+nombre+' '+opc+' '+sesi);
                      if (gesuno!='') {
                        guardarfiltrog1(id, gesuno, areauno, nombre, opc, sesi);
                      }
                      else{
                        alert("Campo Vacio");
                      }
                      //
                    }

                    function guardar2(id){
                      var gesdos = $("#gdos_"+id+"").val();
                      var areados = $("#areag2_"+id+"").val();
                      var nombre = $("#nombre_"+id+"").val();
                      var opc = 'gestion2';
                      var sesi = $("#sesi").val();
                      if (gesdos!='') {
                        guardarfiltrog1(id, gesdos, areados, nombre, opc, sesi);
                      }
                      else{
                        alert("Campo Vacio");
                      }
                      //alert(id+' '+gesdos+' '+areados+' '+nombre+' '+opc+' '+sesi);
                    }

                    function guardar3(id){
                      var gesdos = $("#gjur_"+id+"").val();
                      var areados = $("#areagj_"+id+"").val();
                      var nombre = $("#nombre_"+id+"").val();
                      var opc = 'gestion3';
                      var sesi = $("#sesi").val();
                      if (gesdos!='') {
                        guardarfiltrog1(id, gesdos, areados, nombre, opc, sesi);
                      }
                      else{
                        alert("Campo Vacio");
                      }
                      //alert(id+' '+gesdos+' '+areados+' '+nombre+' '+opc+' '+sesi);
                    }

                    //Modulo de cobros
                    function guardarc(id){
                      var gesuno = $("#gunoc_"+id+"").val();
                      var areauno = $("#areag1c_"+id+"").val();
                      var nombre = $("#nombrec_"+id+"").val();
                      var opc = 'gestionc1';
                      var sesi = $("#sesi").val();
                      //alert(id+' '+gesuno+' '+areauno+' '+nombre+' '+opc+' '+sesi);
                      if (gesuno!='') {
                        guardarfiltrog1(id, gesuno, areauno, nombre, opc, sesi);
                      }
                      else{
                        alert("Campo Vacio");
                      }
                    }

                    function guardarc2(id){
                      var gesdos = $("#gdosc_"+id+"").val();
                      var areados = $("#areag2c_"+id+"").val();
                      var nombre = $("#nombrec_"+id+"").val();
                      var opc = 'gestionc2';
                      var sesi = $("#sesi").val();
                      if (gesdos!='') {
                        guardarfiltrog1(id, gesdos, areados, nombre, opc, sesi);
                      }
                      else{
                        alert("Campo Vacio");
                      }
                    }

                    function guardarc3(id){
                      var gesdos = $("#gjurc_"+id+"").val();
                      var areados = $("#areagjc_"+id+"").val();
                      var nombre = $("#nombrec_"+id+"").val();
                      var opc = 'gestionc3';
                      var sesi = $("#sesi").val();
                      if (gesdos!='') {
                        guardarfiltrog1(id, gesdos, areados, nombre, opc, sesi);
                      }
                      else{
                        alert("Campo Vacio");
                      }
                    }
                    </script>
                <!--<form name="formularioconclu" action="gcrobranzas.php" method="POST">-->
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
