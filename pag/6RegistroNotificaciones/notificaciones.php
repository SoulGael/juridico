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
          <h1 class="page-header">Registro de Notificaciones</h1>            
            <br> 
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
            <br><br>
            Desde: <input type="text" name="desde" id="desde" required STYLE="z-index:5">
            Hasta: <input type="text" name="hasta" id="hasta" required >
            <br><br>        
            Provincia 
            <select id="provincia" onChange="agregarciudades(this.form)" style="width:200px">
              <option>TODAS</option>
              <?php
              error_reporting(0);
              $consulta="select distinct ubicacion from tbl_ubicacion, tbl_instalacion where id_ubicacion=id_provincia order by ubicacion";
              $resultado=pg_query($consulta) or die (pg_last_error());
              while($tabla=pg_fetch_array($resultado))
              {
                echo "<option>".$tabla['ubicacion']."</option>";
              } 
              ?>
            </select>  
            Ciudades
            <select id="ciudades" onChange="agregarparroquias(this.form)" style="width:200px">

            </select>  
            Parroquias
            <select id="parroquias" style="width:200px">

            </select>   

                    <br>     <br>
                    <div class="input-group input-group-sm" STYLE="z-index:1">
                      <span class="input-group-addon">Nombres</span>
                      <input type="text" class="form-control" id="idusuario" name="idusuario"  onkeyup="notifiltrousu()" placeholder="Apellidos o Nombres" onKeyPress="if (event.keyCode >45 && event.keyCode  <57) event.returnValue =false;">
                      <span class="input-group-addon">CI</span>
                      <input type="text" class="form-control" id="ciusuario" name="ciusuario"  onkeyup="notifiltrousuci()"placeholder="N° de Cedula" onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue=false; ">
                    </div>

                    <br><br>
                    <input  type="button" class="btn btn-primary" name="btn_generar" type=submit value="Filtrar" onclick=generando(this)>
                    <input  type="button" class="btn btn-success" name="btn_guardar" type=submit value="Guardar Notificaciónes" onclick=guardar(this)> 
    
                    
                    <script type="text/javascript">

                    function generando(){
                        
                        if(desde.value==''||hasta.value=='')
                        {
                          alert("LLene todos los campos por favor");
                        }
                        else
                        {
                          notifconsulta(provincia.value, ciudades.value, parroquias.value, desde.value, hasta.value, sucur.value);
                        }
                    }

                    function agregarciudades(){ 
                        //alert(provincia.value);
                        consuciudades(provincia.value);                        
                    }

                    function agregarparroquias(){ 
                        consuparroquias(ciudades.value);
                        //alert(provincia.value);
                    }

                    function seleccionar(){
                      $("input[name=checktodos]").change(function(){
                      $('input[name=condi]').each( function() {      
                        if($("input[name=checktodos]:checked").length == 1){
                          this.checked = true;
                          } else {
                            this.checked = false;
                            }
                            });
                      });
                    }

                    function noti(){
                      $("input[name=checktodosnotif]").change(function(){
                      $('input[name=notif]').each( function() {      
                        if($("input[name=checktodosnotif]:checked").length == 1){
                          this.checked = true;
                          } else {
                            this.checked = false;
                            }
                            });
                      });
                    }

                    function guardar(sal){
                      //alert(document.getElementById("selectable").rows.length);
                        for(var i=1;i<document.getElementById("selectable").rows.length;i++)
                        {                          
                            var gesuno = $("#guno_"+i+"").val();
                            var gesdos = $("#gdos_"+i+"").val();
                            var gestres = $("#gtres_"+i+"").val();

                            var areauno = $("#areag1_"+i+"").val();
                            var areados = $("#areag2_"+i+"").val();
                            var areatres = $("#areag3_"+i+"").val();

                            var id= selectable.rows[i].cells[1].childNodes[0].nodeValue;
                            var usu = $("#usu_"+i+"").val();
                            var usu2 = $("#usu2_"+i+"").val();
                            var usu3 = $("#usu3_"+i+"").val();

                            var opcion="";

                            if(gesuno.toLowerCase()=='otros'&&areauno=='')
                            {
                              alert("OPCION OTROS: \n Por favor ingrese una Observacion en el Registro N° "+selectable.rows[i].cells[0].childNodes[0].nodeValue+" ");
                            }
                            else
                            {
                              if(gesuno!=''&&gesdos==''&&gestres==''&&usu==''&&usu2==''&&usu3=='')
                              {                        
                                opcion="gestion1";
                                guardarnotif(gesuno, gesdos, gestres, areauno, areados, areatres, id, opcion);
                              }
                              if(gesuno!=''&&gesdos!=''&&gestres==''&&usu!=''&&usu2==''&&usu3=='')
                              {
                                opcion="gestion2";                              
                                guardarnotif(gesuno, gesdos, gestres, areauno, areados, areatres, id, opcion);
                              }
                              if(gesuno!=''&&gesdos!=''&&gestres!=''&&usu!=''&&usu2!=''&&usu3=='')
                              {
                                opcion="gestion3";                              
                                guardarnotif(gesuno, gesdos, gestres, areauno, areados, areatres, id, opcion);
                              }
                            }
                        }
                        //consufiltro(tipos.value, desde.value, hasta.value, sucur.value);
                    }

                    function guardarcobros(sal){
                      //alert(document.getElementById("selectable").rows.length);
                        for(var i=1;i<document.getElementById("selectablecobros").rows.length;i++)
                        {                          
                            var gesuno = $("#gunoc_"+i+"").val();
                            var gesdos = $("#gdosc_"+i+"").val();
                            var gestres = $("#gtresc_"+i+"").val();

                            var areauno = $("#areagc1_"+i+"").val();
                            var areados = $("#areagc2_"+i+"").val();
                            var areatres = $("#areagc3_"+i+"").val();

                            var id= selectablecobros.rows[i].cells[1].childNodes[0].nodeValue;
                            var usu = $("#usuc_"+i+"").val();
                            var usu2 = $("#usuc2_"+i+"").val();
                            var usu3 = $("#usuc3_"+i+"").val();

                            var opcion="";

                            if(gesuno.toLowerCase()=='otros'&&areauno=='')
                            {
                              alert("OPCION OTROS: \n Por favor ingrese una Observacion en el Registro N° "+selectablecobros.rows[i].cells[0].childNodes[0].nodeValue+" ");
                            }
                            else
                            {
                              if(gesuno!=''&&gesdos==''&&gestres==''&&usu==''&&usu2==''&&usu3=='')
                              {                        
                                opcion="gestion1";
                                //alert(gesuno+" "+ gesdos+" "+ gestres+" "+ areauno+" "+ areados+" "+ areatres+" "+ id+" "+ opcion);
                                guardarnotifcobros(gesuno, gesdos, gestres, areauno, areados, areatres, id, opcion);
                              }
                              if(gesuno!=''&&gesdos!=''&&gestres==''&&usu!=''&&usu2==''&&usu3=='')
                              {
                                opcion="gestion2";
                                guardarnotifcobros(gesuno, gesdos, gestres, areauno, areados, areatres, id, opcion);
                              }
                              if(gesuno!=''&&gesdos!=''&&gestres!=''&&usu!=''&&usu2!=''&&usu3=='')
                              {
                                opcion="gestion3";                              
                                guardarnotifcobros(gesuno, gesdos, gestres, areauno, areados, areatres, id, opcion);
                              }
                            }
                        }
                        //consufiltro(tipos.value, desde.value, hasta.value, sucur.value);
                    }

                    function cambio_direccion(mue){  
                      var lista = document.getElementById("respu");
                      lista.innerHTML = "<div class='input-group input-group-sm'>"+
                      "<span class=input-group-addon>Nueva Direccion</span>"+
                      "<input type=text class=form-control id=ndireccion name=ndireccion></div>";

                      var titulo = document.getElementById("myModalLabel");
                      titulo.innerHTML="<button type='button' class='btn btn-default' id='iddireccion'"+
                      "value="+mue.cells[1].childNodes[0].nodeValue+"></button>"+mue.cells[7].childNodes[0].nodeValue;
                        //alert(mue.cells[1].childNodes[0].nodeValue);
                        //cambio_direccion(mue.cells[0].childNodes[0].nodeValue);                       
                        //window.open('../pag/factura.php?q='+mue.cells[0].childNodes[0].nodeValue,'','width=1050, height= 570, menubar=no, scrollbars=no, toolbar=no, location=no, directories=no, status=no, resizable=no, top=70, left=70');return false;
                    }

                    function cambiodguardar(mue){  
                      var id = document.getElementById("iddireccion").value;
                      var newdire = document.getElementById("ndireccion").value;
                      cambiodirec(id,newdire);
                        //alert(mue.cells[1].childNodes[0].nodeValue);
                        //cambio_direccion(mue.cells[0].childNodes[0].nodeValue);                       
                        //window.open('../pag/factura.php?q='+mue.cells[0].childNodes[0].nodeValue,'','width=1050, height= 570, menubar=no, scrollbars=no, toolbar=no, location=no, directories=no, status=no, resizable=no, top=70, left=70');return false;
                    }
                    </script>

                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Cambio de Direccion</h4>
                                </div>
                                <div class="modal-body" id="respu">

                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-success" onclick=cambiodguardar(this)>
                                    <span class="glyphicon glyphicon-ok-sign"> Guardar</span>
                                  </button>
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-remove"> Cerrar</span>
                                  </button>
                                </div>
                            </div>
                        </div>
                    </div>  
                
                <div id="resultados_notif">
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
