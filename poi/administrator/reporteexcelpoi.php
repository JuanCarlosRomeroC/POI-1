<?php
	session_start();
	require('../settings/connection.php');
	require('../assets/plugins/phpexcel/PHPExcel.php');
	if(isset($_SESSION['poimps'])){
		date_default_timezone_set('America/Mexico_City');
		if (PHP_SAPI == 'cli'){
			die('Este archivo solo se puede ver desde un navegador web');
		}
		$conn = new ConexionBD;
		$link = $conn->conectarBD();
		if($_GET['sub'] == ''){
			$query = "CALL sp_getActivities('P', '', '".$_GET['idg']."')";
		}
		// si es subgerencia
		else{
			$query = "CALL sp_getActivities('R', '".$_GET['ids']."', '')";
		}
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) > 0){
		$objPHPExcel = new PHPExcel();
		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("WilsonVargas") //Autor
							 ->setLastModifiedBy("WilsonVargas") //Ultimo usuario que lo modificó
							 ->setTitle("Reporte POI")
							 ->setSubject("Reporte POI")
							 ->setDescription("Reporte de actividades")
							 ->setKeywords("reporte de actividades del poi")
							 ->setCategory("Reporte poi");
		$titulo1 = "PROGRAMACIÓN DE ACTIVIDADES Y PROYECTOS";
		$titulo2 = "MUNICIPALIDAD PROVINCIAL DEL SANTA";
		$subtitulo1 = "GERENCIA:";
		$subtitulo2 = "SUBGERENCIA:";
		$titulosColumnas = array('OBJETIVOS ESPECIFICOS', 'ACTIVIDAD/PROYECTO', 'META FISICA ANUAL', 'UNIDAD DE MEDIDA', 'CANTIDAD', 'RESULTADO', 'CRONOGRAMA TRIMESTRAL', 'I', 'II', 'III', 'IV', 'RESPONSABLE');
		
		$objPHPExcel->setActiveSheetIndex(0)
        		    ->mergeCells('A2:J2')
					->mergeCells('A3:J3')
					->mergeCells('B5:J5')
					->mergeCells('B6:J6')
					->mergeCells('A8:A9')
					->mergeCells('B8:B9')
					->mergeCells('C8:D8')
					->mergeCells('E8:E9')
					->mergeCells('F8:I8')
					->mergeCells('J8:J9');
						
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A2', $titulo1)
					->setCellValue('A3', $titulo2)
					->setCellValue('A5', $subtitulo1." ".$_GET['ger'])
					->setCellValue('A6', $subtitulo2." ".$_GET['sub'])
					->setCellValue('A8', $titulosColumnas[0])
					->setCellValue('B8', $titulosColumnas[1])
					->setCellValue('C8', $titulosColumnas[2])
					->setCellValue('C9', $titulosColumnas[3])
					->setCellValue('D9', $titulosColumnas[4])
					->setCellValue('E8', $titulosColumnas[5])
					->setCellValue('F8', $titulosColumnas[6])
					->setCellValue('F9', $titulosColumnas[7])
					->setCellValue('G9', $titulosColumnas[8])
					->setCellValue('H9', $titulosColumnas[9])
					->setCellValue('I9', $titulosColumnas[10])
					->setCellValue('J8', $titulosColumnas[11]);
					
			$i = 10;
			while($row = mysqli_fetch_array($result)){
				$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('A'.$i,  $row[0])
		            ->setCellValue('B'.$i,  $row[1])
        		    ->setCellValue('C'.$i,  $row[2])
            		->setCellValue('D'.$i,  $row[3])
					->setCellValue('E'.$i,  $row[4])
					->setCellValue('F'.$i,  $row[5])
					->setCellValue('G'.$i,  $row[6])
					->setCellValue('H'.$i,  $row[7])
					->setCellValue('I'.$i,  $row[8])
					->setCellValue('J'.$i,  $row[9]);
					$i++;
			}
		$estiloTituloReporte = array(
        	'font' => array(
	        	'name'      => 'Calibri',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>12,
	            	'color'     => array(
    	            	'rgb' => '000000'
        	       	)
            ),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_NONE                    
               	)
            ), 
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );
		$estiloTituloReporte2 = array(
        	'font' => array(
	        	'name'      => 'Calibri',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>11,
	            	'color'     => array(
    	            	'rgb' => '000000'
        	       	)
            ),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_NONE                    
               	)
            ), 
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );
		$estiloTituloReporte3 = array(
        	'font' => array(
	        	'name'      => 'Calibri',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>11,
	            	'color'     => array(
    	            	'rgb' => '000000'
        	       	)
            ),
			'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('rgb' => 'd9d9d9')
			),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
                        'rgb' => '000000'
                    )                    
               	)
            ), 
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );
		$estilo7 = array(
        	'font' => array(
	        	'name'      => 'Calibri',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>9,
	            	'color'     => array(
    	            	'rgb' => '000000'
        	       	)
            ),
			'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('rgb' => 'd9d9d9')
			),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
                        'rgb' => '000000'
                    )                    
               	)
            ), 
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );
		$estiloTituloReporte4 = array(
        	'font' => array(
	        	'name'      => 'Calibri',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>9,
	            	'color'     => array(
    	            	'rgb' => '000000'
        	       	)
            ),
			'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('rgb' => 'd9d9d9')
			),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
                        'rgb' => '000000'
                    )                    
               	)
            ), 
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );
		$estiloTituloReporte5 = array(
        	'font' => array(
	        	'name'      => 'Calibri',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>7,
	            	'color'     => array(
    	            	'rgb' => '000000'
        	       	)
            ),
			'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('rgb' => 'd9d9d9')
			),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
                        'rgb' => '000000'
                    )                    
               	)
            ), 
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );
		$estilo5 = array(
        	'font' => array(
	        	'name'      => 'Calibri',
    	        'bold'      => false,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>9,
	            	'color'     => array(
    	            	'rgb' => '000000'
        	       	)
            ),
			'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('rgb' => 'FABF8F')
			),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
                        'rgb' => '000000'
                    )                    
               	)
            ), 
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );
		$estilo6 = array(
        	'font' => array(
	        	'name'      => 'Calibri',
    	        'bold'      => false,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>9,
	            	'color'     => array(
    	            	'rgb' => '000000'
        	       	)
            ),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
                        'rgb' => '000000'
                    )                    
               	)
            ), 
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );
		$valor = $i - 1;
		$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($estiloTituloReporte2);
		$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($estiloTituloReporte2);
		$objPHPExcel->getActiveSheet()->getStyle('A8:E8')->applyFromArray($estiloTituloReporte3);
		$objPHPExcel->getActiveSheet()->getStyle('J8')->applyFromArray($estiloTituloReporte3);
		$objPHPExcel->getActiveSheet()->getStyle('A9:J9')->applyFromArray($estiloTituloReporte4);
		$objPHPExcel->getActiveSheet()->getStyle('F8:I8')->applyFromArray($estiloTituloReporte5);
		$objPHPExcel->getActiveSheet()->getStyle('A10:A'.$valor)->applyFromArray($estilo6);
		$objPHPExcel->getActiveSheet()->getStyle('B10:B'.$valor)->applyFromArray($estilo6);
		$objPHPExcel->getActiveSheet()->getStyle('C10:C'.$valor)->applyFromArray($estilo6);
		$objPHPExcel->getActiveSheet()->getStyle('E10:E'.$valor)->applyFromArray($estilo6);
		$objPHPExcel->getActiveSheet()->getStyle('J10:J'.$valor)->applyFromArray($estilo6);
		$objPHPExcel->getActiveSheet()->getStyle('D10:D'.$valor)->applyFromArray($estilo5);
		$objPHPExcel->getActiveSheet()->getStyle('F10:F'.$valor)->applyFromArray($estilo5);
		$objPHPExcel->getActiveSheet()->getStyle('G10:G'.$valor)->applyFromArray($estilo5);
		$objPHPExcel->getActiveSheet()->getStyle('H10:H'.$valor)->applyFromArray($estilo5);
		$objPHPExcel->getActiveSheet()->getStyle('I10:I'.$valor)->applyFromArray($estilo5);
		
		for($i = 'A'; $i <= 'J'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('ACTIVIDADES Y PY');

		
		mysqli_close($link);
		
		/*   NUEVA PESTAÑA ============================================================00===== */
		
		
		$positionInExcel=1; //Loque mencionaste
		$objPHPExcel->createSheet($positionInExcel); //Loque mencionaste
		$objPHPExcel->setActiveSheetIndex(1);
		$objPHPExcel->getActiveSheet()->setTitle('Cuadro Necesidades');
		$objPHPExcel->setActiveSheetIndex(1)
        		    ->mergeCells('A2:P2')
					->mergeCells('A3:P3')
					->mergeCells('A5:P5')
					->mergeCells('A6:P6');
		
		$objPHPExcel->setActiveSheetIndex(1)
							->setCellValue('A2', 'CUADRO DE NECESIDADES DE BIENES Y SERVICIOS')
							->setCellValue('A3', 'MUNICIPALIDAD PROVINCIAL DEL SANTA')
							->setCellValue('A5', "GERENCIA: ".$_GET['ger'])
							->setCellValue('A6', "SUBGERENCIA: ".$_GET['sub']);
		
		
		$link = $conn->conectarBD();
		if($_GET['sub'] == ''){
			$query = "CALL sp_getActivities('N', '', '".$_GET['idg']."')";
		}
		// si es subgerencia
		else{
			$query = "CALL sp_getActivities('O', '".$_GET['ids']."', '')";
		}
		$titulosColumnas2 = array('BIENES Y SERVICIOS', 'CANTIDAD DE BIENES Y SERVICIOS POR MES', 'UNIDAD DE MEDIDA', 'TOTAL ANUAL PROGRAMADO', 'ACTIVIDAD / PROYECTO', 'DESCRIPCION', 'I TRIMESTRE', 'II TRIMESTRE', 'III TRIMESTRE', 'IV TRIMESTRE', 'E', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D');
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) > 0){ 
			$conta = 6;
			$objPHPExcel->setActiveSheetIndex(1)
									->mergeCells('A'.($conta+2).':B'.($conta+2))
									->mergeCells('C'.($conta+2).':N'.($conta+2))
									->mergeCells('O'.($conta+2).':O'.($conta+4))
									->mergeCells('P'.($conta+2).':P'.($conta+4))
									->mergeCells('A'.($conta+3).':A'.($conta+4))
									->mergeCells('B'.($conta+3).':B'.($conta+4))
									->mergeCells('C'.($conta+3).':E'.($conta+3))
									->mergeCells('F'.($conta+3).':H'.($conta+3))
									->mergeCells('I'.($conta+3).':K'.($conta+3))
									->mergeCells('L'.($conta+3).':N'.($conta+3));
									
						$objPHPExcel->setActiveSheetIndex(1)
									->setCellValue('A'.($conta+2), $titulosColumnas2[0])
									->setCellValue('C'.($conta+2), $titulosColumnas2[1])
									->setCellValue('O'.($conta+2), $titulosColumnas2[2])
									->setCellValue('P'.($conta+2), $titulosColumnas2[3])
									->setCellValue('A'.($conta+3), $titulosColumnas2[4])
									->setCellValue('B'.($conta+3), $titulosColumnas2[5])
									->setCellValue('C'.($conta+3), $titulosColumnas2[6])
									->setCellValue('F'.($conta+3), $titulosColumnas2[7])
									->setCellValue('I'.($conta+3), $titulosColumnas2[8])
									->setCellValue('L'.($conta+3), $titulosColumnas2[9])
									->setCellValue('C'.($conta+4), $titulosColumnas2[10])
									->setCellValue('D'.($conta+4), $titulosColumnas2[11])
									->setCellValue('E'.($conta+4), $titulosColumnas2[12])
									->setCellValue('F'.($conta+4), $titulosColumnas2[13])
									->setCellValue('G'.($conta+4), $titulosColumnas2[14])
									->setCellValue('H'.($conta+4), $titulosColumnas2[15])
									->setCellValue('I'.($conta+4), $titulosColumnas2[16])
									->setCellValue('J'.($conta+4), $titulosColumnas2[17])
									->setCellValue('K'.($conta+4), $titulosColumnas2[18])
									->setCellValue('L'.($conta+4), $titulosColumnas2[19])
									->setCellValue('M'.($conta+4), $titulosColumnas2[20])
									->setCellValue('N'.($conta+4), $titulosColumnas2[21]);
									$i = 10;
			while($row = mysqli_fetch_array($result)){
				$i++;
				$actividadneed = $row[0];
				$c = $conn->conectarBD();
				$consulta = "CALL sp_getNeedStaff('N', ".$row[1].")";
				$res = mysqli_query($c, $consulta);
				if(mysqli_num_rows($res) > 0){
					//$i = $conta + 5;
					$f = 1;
					while($r = mysqli_fetch_array($res)){
						if($f == 1){
						$objPHPExcel->setActiveSheetIndex(1)
							->setCellValue('A'.$i,  $actividadneed)
							->setCellValue('B'.$i,  $r[2])
							->setCellValue('C'.$i,  $r[3])
							->setCellValue('D'.$i,  $r[4])
							->setCellValue('E'.$i,  $r[5])
							->setCellValue('F'.$i,  $r[6])
							->setCellValue('G'.$i,  $r[7])
							->setCellValue('H'.$i,  $r[8])
							->setCellValue('I'.$i,  $r[9])
							->setCellValue('J'.$i,  $r[10])
							->setCellValue('K'.$i,  $r[11])
							->setCellValue('L'.$i,  $r[12])
							->setCellValue('M'.$i,  $r[13])
							->setCellValue('N'.$i,  $r[14])
							->setCellValue('O'.$i,  $r[17])
							->setCellValue('P'.$i,  $r[16]);
						}
						else{
							$objPHPExcel->setActiveSheetIndex(1)
							->setCellValue('A'.$i,  '')
							->setCellValue('B'.$i,  $r[2])
							->setCellValue('C'.$i,  $r[3])
							->setCellValue('D'.$i,  $r[4])
							->setCellValue('E'.$i,  $r[5])
							->setCellValue('F'.$i,  $r[6])
							->setCellValue('G'.$i,  $r[7])
							->setCellValue('H'.$i,  $r[8])
							->setCellValue('I'.$i,  $r[9])
							->setCellValue('J'.$i,  $r[10])
							->setCellValue('K'.$i,  $r[11])
							->setCellValue('L'.$i,  $r[12])
							->setCellValue('M'.$i,  $r[13])
							->setCellValue('N'.$i,  $r[14])
							->setCellValue('O'.$i,  $r[17])
							->setCellValue('P'.$i,  $r[16]);
						}
							$i++;
							$f++;
					}
					$objPHPExcel->setActiveSheetIndex(1)
							->setCellValue('A'.$i,  '')
							->setCellValue('B'.$i,  '')
							->setCellValue('C'.$i,  '')
							->setCellValue('D'.$i,  '')
							->setCellValue('E'.$i,  '')
							->setCellValue('F'.$i,  '')
							->setCellValue('G'.$i,  '')
							->setCellValue('H'.$i,  '')
							->setCellValue('I'.$i,  '')
							->setCellValue('J'.$i,  '')
							->setCellValue('K'.$i,  '')
							->setCellValue('L'.$i,  '')
							->setCellValue('M'.$i,  '')
							->setCellValue('N'.$i,  '')
							->setCellValue('O'.$i,  '')
							->setCellValue('P'.$i,  '');
					mysqli_close($c);
					//$conta = ($i - 4);
				}
				else{
					$objPHPExcel->setActiveSheetIndex(1)
							->setCellValue('A'.$i,  $actividadneed)
							->setCellValue('B'.$i,  '')
							->setCellValue('C'.$i,  '')
							->setCellValue('D'.$i,  '')
							->setCellValue('E'.$i,  '')
							->setCellValue('F'.$i,  '')
							->setCellValue('G'.$i,  '')
							->setCellValue('H'.$i,  '')
							->setCellValue('I'.$i,  '')
							->setCellValue('J'.$i,  '')
							->setCellValue('K'.$i,  '')
							->setCellValue('L'.$i,  '')
							->setCellValue('M'.$i,  '')
							->setCellValue('N'.$i,  '')
							->setCellValue('O'.$i,  '')
							->setCellValue('P'.$i,  '');
					$objPHPExcel->setActiveSheetIndex(1)
							->setCellValue('A'.($i+1), 'NO EXISTE CUADRO DE NECESIDADES PARA ESTA ACTIVIDAD');
							$i = $i + 2;
					mysqli_close($c);
					//$conta = $conta + 5;
				}
			}
			$objPHPExcel->getActiveSheet()->getStyle('A8:P8')->applyFromArray($estiloTituloReporte3);
					$objPHPExcel->getActiveSheet()->getStyle('A9:P9')->applyFromArray($estiloTituloReporte3);
					$objPHPExcel->getActiveSheet()->getStyle('A9:P9')->applyFromArray($estiloTituloReporte4);
					$objPHPExcel->getActiveSheet()->getStyle('A10:P10')->applyFromArray($estiloTituloReporte3);
					$objPHPExcel->getActiveSheet()->getStyle('A11:A'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('B11:B'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('C11:C'.($i-1))->applyFromArray($estilo5);
					$objPHPExcel->getActiveSheet()->getStyle('D11:D'.($i-1))->applyFromArray($estilo5);
					$objPHPExcel->getActiveSheet()->getStyle('E11:E'.($i-1))->applyFromArray($estilo5);
					$objPHPExcel->getActiveSheet()->getStyle('F11:F'.($i-1))->applyFromArray($estilo5);
					$objPHPExcel->getActiveSheet()->getStyle('G11:G'.($i-1))->applyFromArray($estilo5);
					$objPHPExcel->getActiveSheet()->getStyle('H11:H'.($i-1))->applyFromArray($estilo5);
					$objPHPExcel->getActiveSheet()->getStyle('I11:I'.($i-1))->applyFromArray($estilo5);
					$objPHPExcel->getActiveSheet()->getStyle('J11:J'.($i-1))->applyFromArray($estilo5);
					$objPHPExcel->getActiveSheet()->getStyle('K11:K'.($i-1))->applyFromArray($estilo5);
					$objPHPExcel->getActiveSheet()->getStyle('L11:L'.($i-1))->applyFromArray($estilo5);
					$objPHPExcel->getActiveSheet()->getStyle('M11:M'.($i-1))->applyFromArray($estilo5);
					$objPHPExcel->getActiveSheet()->getStyle('N11:N'.($i-1))->applyFromArray($estilo5);
					$objPHPExcel->getActiveSheet()->getStyle('O11:O'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('P11:P'.($i-1))->applyFromArray($estilo6);
			
			
			
			
			for($i = 'A'; $i <= 'P'; $i++){
			$objPHPExcel->setActiveSheetIndex(1)			
				->getColumnDimension($i)->setAutoSize(TRUE);
			}
			mysqli_close($link);
		}
		$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A3:P3')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($estiloTituloReporte2);
		$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($estiloTituloReporte2);
		
		
		
		/*   NUEVA PESTAÑA ============================================================00===== */
		
		
		$positionInExcel=2; //Loque mencionaste
		$objPHPExcel->createSheet($positionInExcel); //Loque mencionaste
		$objPHPExcel->setActiveSheetIndex(2);
		$objPHPExcel->getActiveSheet()->setTitle('CUADRO DE PERSONAL');
		$objPHPExcel->setActiveSheetIndex(2)
        		    ->mergeCells('A2:P2')
					->mergeCells('A3:P3')
					->mergeCells('A5:P5')
					->mergeCells('A6:P6');
		
		$objPHPExcel->setActiveSheetIndex(2)
							->setCellValue('A2', 'CUADRO DE PERSONAL')
							->setCellValue('A3', 'MUNICIPALIDAD PROVINCIAL DEL SANTA')
							->setCellValue('A5', "GERENCIA: ".$_GET['ger'])
							->setCellValue('A6', "SUBGERENCIA: ".$_GET['sub']);
		
		
		$link = $conn->conectarBD();
		if($_GET['sub'] == ''){
			$query = "CALL sp_getActivities('N', '', '".$_GET['idg']."')";
		}
		// si es subgerencia
		else{
			$query = "CALL sp_getActivities('O', '".$_GET['ids']."', '')";
		}
		$titulosColumnas3 = array('PRESUPUESTO DE PERSONAL', 'ACTIVIDAD / PROYECTO', 'DIRECTIVOS', 'PROFESIONALES ', 'TÉCNICOS', 'AUXILIARES ', 'OBREROS', 'EST', 'FUN', 'CAS', 'EST', 'CAS', 'TERCEROS', 'EST', 'CAS', 'TERCEROS', 'EST', 'CAS', 'TERCEROS', 'EST', 'CAS', 'TERCEROS');
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) > 0){ 
			$conta = 6;
			$objPHPExcel->setActiveSheetIndex(2)
									->mergeCells('A'.($conta+2).':P'.($conta+2))
									->mergeCells('A'.($conta+3).':A'.($conta+4))
									->mergeCells('B'.($conta+3).':D'.($conta+3))
									->mergeCells('E'.($conta+3).':G'.($conta+3))
									->mergeCells('H'.($conta+3).':J'.($conta+3))
									->mergeCells('K'.($conta+3).':M'.($conta+3))
									->mergeCells('N'.($conta+3).':P'.($conta+3));
									
						$objPHPExcel->setActiveSheetIndex(2)
									->setCellValue('A'.($conta+2), $titulosColumnas3[0])
									->setCellValue('A'.($conta+3), $titulosColumnas3[1])
									->setCellValue('B'.($conta+3), $titulosColumnas3[2])
									->setCellValue('E'.($conta+3), $titulosColumnas3[3])
									->setCellValue('H'.($conta+3), $titulosColumnas3[4])
									->setCellValue('K'.($conta+3), $titulosColumnas3[5])
									->setCellValue('N'.($conta+3), $titulosColumnas3[6])
									->setCellValue('B'.($conta+4), $titulosColumnas3[7])
									->setCellValue('C'.($conta+4), $titulosColumnas3[8])
									->setCellValue('D'.($conta+4), $titulosColumnas3[9])
									->setCellValue('E'.($conta+4), $titulosColumnas3[10])
									->setCellValue('F'.($conta+4), $titulosColumnas3[11])
									->setCellValue('G'.($conta+4), $titulosColumnas3[12])
									->setCellValue('H'.($conta+4), $titulosColumnas3[13])
									->setCellValue('I'.($conta+4), $titulosColumnas3[14])
									->setCellValue('J'.($conta+4), $titulosColumnas3[15])
									->setCellValue('K'.($conta+4), $titulosColumnas3[16])
									->setCellValue('L'.($conta+4), $titulosColumnas3[17])
									->setCellValue('M'.($conta+4), $titulosColumnas3[18])
									->setCellValue('N'.($conta+4), $titulosColumnas3[19])
									->setCellValue('O'.($conta+4), $titulosColumnas3[20])
									->setCellValue('P'.($conta+4), $titulosColumnas3[21]);
			
			$i = 10;
			while($row = mysqli_fetch_array($result)){
				$i++;
				$actividadstaff = $row[0];
				$c = $conn->conectarBD();
				$consulta = "CALL sp_getNeedStaff('S', ".$row[1].")";
				$res = mysqli_query($c, $consulta);
				if(mysqli_num_rows($res) > 0){
					//$i = $conta + 5;
					$f = 1;
					while($r = mysqli_fetch_array($res)){
						if($f == 1){
						$objPHPExcel->setActiveSheetIndex(2)
							->setCellValue('A'.$i,  $actividadstaff)
							->setCellValue('B'.$i,  $r[2])
							->setCellValue('C'.$i,  $r[3])
							->setCellValue('D'.$i,  $r[4])
							->setCellValue('E'.$i,  $r[5])
							->setCellValue('F'.$i,  $r[6])
							->setCellValue('G'.$i,  $r[7])
							->setCellValue('H'.$i,  $r[8])
							->setCellValue('I'.$i,  $r[9])
							->setCellValue('J'.$i,  $r[10])
							->setCellValue('K'.$i,  $r[11])
							->setCellValue('L'.$i,  $r[12])
							->setCellValue('M'.$i,  $r[13])
							->setCellValue('N'.$i,  $r[14])
							->setCellValue('O'.$i,  $r[15])
							->setCellValue('P'.$i,  $r[16]);
						}
						else{
							$objPHPExcel->setActiveSheetIndex(2)
							->setCellValue('A'.$i,  '')
							->setCellValue('B'.$i,  $r[2])
							->setCellValue('C'.$i,  $r[3])
							->setCellValue('D'.$i,  $r[4])
							->setCellValue('E'.$i,  $r[5])
							->setCellValue('F'.$i,  $r[6])
							->setCellValue('G'.$i,  $r[7])
							->setCellValue('H'.$i,  $r[8])
							->setCellValue('I'.$i,  $r[9])
							->setCellValue('J'.$i,  $r[10])
							->setCellValue('K'.$i,  $r[11])
							->setCellValue('L'.$i,  $r[12])
							->setCellValue('M'.$i,  $r[13])
							->setCellValue('N'.$i,  $r[14])
							->setCellValue('O'.$i,  $r[15])
							->setCellValue('P'.$i,  $r[16]);
						}
							$i++;
							$f++;
					}
					$objPHPExcel->setActiveSheetIndex(2)
							->setCellValue('A'.$i,  '')
							->setCellValue('B'.$i,  '')
							->setCellValue('C'.$i,  '')
							->setCellValue('D'.$i,  '')
							->setCellValue('E'.$i,  '')
							->setCellValue('F'.$i,  '')
							->setCellValue('G'.$i,  '')
							->setCellValue('H'.$i,  '')
							->setCellValue('I'.$i,  '')
							->setCellValue('J'.$i,  '')
							->setCellValue('K'.$i,  '')
							->setCellValue('L'.$i,  '')
							->setCellValue('M'.$i,  '')
							->setCellValue('N'.$i,  '')
							->setCellValue('O'.$i,  '')
							->setCellValue('P'.$i,  '');
					
					mysqli_close($c);
				}
				else{
					$objPHPExcel->setActiveSheetIndex(2)
							->setCellValue('A'.$i,  $actividadstaff)
							->setCellValue('B'.$i,  '')
							->setCellValue('C'.$i,  '')
							->setCellValue('D'.$i,  '')
							->setCellValue('E'.$i,  '')
							->setCellValue('F'.$i,  '')
							->setCellValue('G'.$i,  '')
							->setCellValue('H'.$i,  '')
							->setCellValue('I'.$i,  '')
							->setCellValue('J'.$i,  '')
							->setCellValue('K'.$i,  '')
							->setCellValue('L'.$i,  '')
							->setCellValue('M'.$i,  '')
							->setCellValue('N'.$i,  '')
							->setCellValue('O'.$i,  '')
							->setCellValue('P'.$i,  '');
					$objPHPExcel->setActiveSheetIndex(2)
							->setCellValue('A'.($i+1), 'NO EXISTE CUADRO DE PERSONAL PARA ESTA ACTIVIDAD');
					mysqli_close($c);
					$i = $i + 2;
				}
			}
			$objPHPExcel->getActiveSheet()->getStyle('A8:P8')->applyFromArray($estilo7);
					$objPHPExcel->getActiveSheet()->getStyle('A9:P9')->applyFromArray($estilo7);
					$objPHPExcel->getActiveSheet()->getStyle('A10:P10')->applyFromArray($estilo7);
					$objPHPExcel->getActiveSheet()->getStyle('A11:A'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('B11:B'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('C11:C'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('D11:D'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('E11:E'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('F11:F'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('G11:G'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('H11:H'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('I11:I'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('J11:J'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('K11:K'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('L11:L'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('M11:M'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('N11:N'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('O11:O'.($i-1))->applyFromArray($estilo6);
					$objPHPExcel->getActiveSheet()->getStyle('P11:P'.($i-1))->applyFromArray($estilo6);
			for($i = 'A'; $i <= 'P'; $i++){
			$objPHPExcel->setActiveSheetIndex(2)			
				->getColumnDimension($i)->setAutoSize(TRUE);
			}
			mysqli_close($link);
		}
		$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A3:P3')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($estiloTituloReporte2);
		$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($estiloTituloReporte2);
		
		
		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);
		// Inmovilizar paneles 
		//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);
		
		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Reportedealumnos.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
		}
		else{
			print_r('No hay resultados para mostrar');
			echo " <input type='button' value='VOLVER ATRÁS' name='Back2' onclick='history.back()' />";
		}
	}
?>