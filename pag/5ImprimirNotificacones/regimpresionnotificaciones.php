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

function seleccionarCobros(){
    $("input[name=checktodoscobros]").change(function(){
    $('input[name=condicobros]').each( function() {      
      if($("input[name=checktodoscobros]:checked").length == 1){
        this.checked = true;
      } else {
        this.checked = false;
      }
    });
  });
  }

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
          <h1 class="page-header">Impresion de Notificaciónes</h1>            
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
                      <input type="text" class="form-control" id="idusuario" name="idusuario"  onkeyup="consufiltronotifusu()" placeholder="Apellidos o Nombres" onKeyPress="if (event.keyCode >45 && event.keyCode  <57) event.returnValue =false;">
                      <span class="input-group-addon">CI</span>
                      <input type="text" class="form-control" id="ciusuario" name="ciusuario"  onkeyup="consufiltronotifci()"placeholder="N° de Cedula" onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue=false; ">
                    </div>

                    <br><br>
                    <input  class="btn btn-primary" name="btn_generar" type=submit value="Mostrar" onclick=generando(this)>
                    <input  class="btn btn-success" name="btn_imprimir" type=submit value="Imprimir" onclick=imprimo(this)> 
    
                    
                    <script type="text/javascript">

                    function generando(){
                        
                        if(desde.value==''||hasta.value=='')
                        {
                          alert("LLene todos los campos por favor");
                        }
                        else
                        {
                          consufiltronotif(provincia.value, ciudades.value, parroquias.value, desde.value, hasta.value, sucur.value);
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
                    
                    function imprimo(sal){
                      var ids='';
                      var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
                      var diasSemana = new Array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"); 
                      var f=new Date(); 
                      var fe=(diasSemana[f.getDay()] + " " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

                      for(var i=1;i<document.getElementById("selectable").rows.length;i++)
                        {                        
                          var elemento = document.getElementById("condiciones"+i+"");
                          if(elemento.checked)
                          {
                            ids+=selectable.rows[i].cells[1].childNodes[0].nodeValue+',';
                            guardarimpr(selectable.rows[i].cells[1].childNodes[0].nodeValue);
                            //alert(" Elemento: " + elemento.value + "\n Seleccionado: " + selectable.rows[i].cells[1].childNodes[0].nodeValue);                          
                          }
                      };
                      ids=ids.substr(0,ids.length-1);
                      //  setTimeout(consufiltronotif(provincia.value, ciudades.value, parroquias.value), 5000); 
                      pdf(ids, fe);
                      //imprimirpdf(ids);
                    }

                    function pdf(id, fecha){
                      var ids=id;
                      var fe=fecha;
                      for(var i=0;i<=10000;i++)
                      {
                        if(i==10000)
                        {
                          window.open('registronotificacionespdf.php?id='+ids+'&fecha='+fe);
                        }
                      }
                    }

                    function imprimoCobro(sal){
                      var ids='';
                      var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
                      var diasSemana = new Array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"); 
                      var f=new Date(); 
                      var fe=(diasSemana[f.getDay()] + " " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

                      for(var i=1;i<document.getElementById("selectableCobro").rows.length;i++)
                        {                        
                          var elemento = document.getElementById("condicionescobros"+i+"");
                          if(elemento.checked)
                          {
                            ids+=selectableCobro.rows[i].cells[1].childNodes[0].nodeValue+',';
                            guardarimprCobros(selectableCobro.rows[i].cells[1].childNodes[0].nodeValue);
                            //alert(" Elemento: " + elemento.value + "\n Seleccionado: " + selectableCobro.rows[i].cells[1].childNodes[0].nodeValue);                          
                          }
                      };
                      ids=ids.substr(0,ids.length-1);
                      pdfCobro(ids, fe);
                      //imprimirpdf(ids);
                    }

                    function pdfCobro(id, fecha){
                      var ids=id;
                      var fe=fecha;
                      for(var i=0;i<=10000;i++)
                      {
                        if(i==10000)
                        {
                          window.open('registronotificacionescobrospdf.php?id='+ids+'&fecha='+fe);
                        }
                      }
                    }

                    function guardar(sal){
                      for(var i=1;i<document.getElementById("selectable").rows.length;i++)
                      {
                        var elemento = document.getElementById("notificacion"+i+"");
                        if(elemento.checked)
                        {
                          guardarnotif(selectable.rows[i].cells[1].childNodes[0].nodeValue);
                          //alert(" Elemento: " + elemento.value + "\n Seleccionado: " + selectable.rows[i].cells[1].childNodes[0].nodeValue);
                        }                        
                      }
                      //consufiltronotif(provincia.value, ciudades.value, parroquias.value);
                    }
                    </script>
                
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
