<?php
include '../conexion.php';
conectarse();
error_reporting(0);
$f_inicio=$_GET['des'];
$f_fin=$_GET['has'];

$consulta="select case when length(movil_claro)>1 then movil_claro else movil_movistar end, total from vta_prefactura 
    where fecha_prefactura between '".$f_inicio."' and '".$f_fin."' and fecha_emision is null and (length(movil_claro)=10 or length(movil_movistar)=10 ) and total>0";

$resultado=pg_query($consulta) or die (pg_last_error());

    if(pg_num_rows($resultado)>0){

        if (PHP_SAPI == 'cli')
            die('Este archivo solo se puede ver desde un navegador web');

        /** Se agrega la libreria PHPExcel */
        require_once 'lib/PHPExcel/PHPExcel.php';

        // Se crea el objeto PHPExcel
        $objPHPExcel = new PHPExcel();

        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("Romero Giovanni-0987868133") //Autor
                             ->setLastModifiedBy("Saitel") //Ultimo usuario que lo modificó
                             ->setTitle("Reporte para llamadas telefonicas")
                             ->setSubject("Reporte Movistar")
                             ->setDescription("Reporte para las llamadas telefonicas con el valor a pagar")
                             ->setKeywords("Reclamos Movistar")
                             ->setCategory("Reportes Saitel");

        /*$tituloReporte = "PORCENTAJE DE RECLAMOS GENERALES PROCEDENTES Y TIEMPO MÁXIMO DE RESOLUCIÓN";
        $subtituloReporte = "1) DATOS DEL INGRESO DEL RECLAMO";
        $subsubtituloReporte = "2) DETALLES DEL RECLAMO";
        $titulosColumnas = array('ITEM', 'PROVINCIA', 'MES','FECHA Y HORA DEL REGISTRO DEL RECLAMO (dd/mm/aaaa hh:mm)', 
            'NOMBRE DE LA PERSONA QUE REALIZA EL RECLAMO','NÚMERO TELEFÓNICO DE CONTACTO DEL USUARIO','TIPO DE CONEXIÓN (CONMUTADA O NO CONMUTADA)',
            'CANAL DE RECLAMO (PERSONALIZADO, TELEFÓNICO, CORREO ELECTRÓNICO, OFICIO, PÁGINA WEB)', 'TIPO DE RECLAMO', 
            'FECHA Y HORA DE SOLUCIÓN DEL RECLAMO (dd/mm/aaaa hh:mm)','TIEMPO DE RESOLUCIÓN DEL RECLAMO (calculo en HORAS) ( Campo No obligatorio)',
            'DESCRIPCIÓN DE LA SOLUCIÓN');*/
        
        /*$objPHPExcel->setActiveSheetIndex(0)
                    ->mergeCells('A1:L1')
                    ->mergeCells('A2:G2')
                    ->mergeCells('H2:L2');
                        
        // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1',$tituloReporte)
                    ->setCellValue('A2',$subtituloReporte)
                    ->setCellValue('H2',$subsubtituloReporte)
                    ->setCellValue('A3',  $titulosColumnas[0])
                    ->setCellValue('B3',  $titulosColumnas[1])
                    ->setCellValue('C3',  $titulosColumnas[2])
                    ->setCellValue('D3',  $titulosColumnas[3])
                    ->setCellValue('E3',  $titulosColumnas[4])
                    ->setCellValue('F3',  $titulosColumnas[5])
                    ->setCellValue('G3',  $titulosColumnas[6])
                    ->setCellValue('H3',  $titulosColumnas[7])
                    ->setCellValue('I3',  $titulosColumnas[8])
                    ->setCellValue('J3',  $titulosColumnas[9])
                    ->setCellValue('K3',  $titulosColumnas[10])
                    ->setCellValue('L3',  $titulosColumnas[11]);*/
        
        //Se agregan los datos de los alumnos
        $i = 1;
        while ($fila =pg_fetch_array($resultado)) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i,  $fila[0])
                    ->setCellValue('B'.$i,  $fila[1]);
                    $i++;
        }
        
        $estiloTituloReporte = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => false,
                'italic'    => false,
                'strike'    => false,
                'size' =>12
                //'color'     => array('rgb' => '96BEE6')
            ),
            'fill' => array(
                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('argb' => '96BEE6')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN                    
                )
            ), 
            'alignment' =>  array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    //'wrap'          => TRUE
            )
        );

        $estiloTituloColumnas = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'fill'  => array(
                'type'      => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'rotation'   => 90,
                'startcolor' => array(
                    'rgb' => 'c47cf2'
                ),
                'endcolor'   => array(
                    'argb' => 'FF431a5d'
                )
            ),
            'borders' => array(
                'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '143860'
                    )
                ),
                'bottom'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '143860'
                    )
                )
            ),
            'alignment' =>  array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'          => TRUE
            ));
            
        $estiloInformacion = new PHPExcel_Style();
        $estiloInformacion->applyFromArray(
            array(
                'font' => array(
                'name'      => 'Arial',               
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill'  => array(
                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                'color'     => array('argb' => 'FFd9b7f4')
            ),
            'borders' => array(
                'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '3a2a47'
                    )
                )             
            )
        ));
         
        /*$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($estiloTituloReporte);
        $objPHPExcel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($estiloTituloReporte);
        $objPHPExcel->getActiveSheet()->getStyle('A3:L3')->applyFromArray($estiloTituloReporte);*/
        //$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($estiloTituloColumnas);     
        //$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:D".($i-1));
        
        for($i = 'A'; $i <= 'B'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)            
                ->getColumnDimension($i)->setAutoSize(TRUE);
        }
        
        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle('Hoja1');

        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);
        // Inmovilizar paneles 
        //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
        //$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);
        ini_set("memory_limit","1000M");
        ini_set('max_execution_time', 300);

        // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ReporteDeTelefonos'.$f_inicio.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
        
    }
    else{
        print_r('No hay resultados para mostrar');
    }
pg_close();
?>