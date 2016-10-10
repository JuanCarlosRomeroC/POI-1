<?php
	session_start();
	require('../assets/plugins/fpdf17/fpdf.php');
	require('../settings/connection.php');
			
	class PDF extends FPDF
	{
		// Cabecera de página
		function Header()
		{
			// Logo
			//$pdf->Image('ddd',10,8,33);
			// Arial bold 15
			$this->SetFont('Arial','B',15);
			// Movernos a la derecha
			$this->Cell(55);
			// Título
			$this->Cell(0,10,'REPORTE POI',0,0);
			// Salto de línea
			$this->Ln(20);
		}
		
		// Pie de página
		function Footer()
		{
			// Posición: a 1,5 cm del final
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Número de página
			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}
		
	// Creación del objeto de la clase heredada
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',12);	
	if(isset($_SESSION['poimps'])){	
		if(isset($_GET['op']) && $_GET['op'] == 'g'){
			$header = array('Descripción de la Gerencia', 'Cantidad');
			$pdf->SetFillColor(255,0,0);
			$pdf->SetTextColor(255);
			$pdf->SetDrawColor(128,0,0);
			$pdf->SetLineWidth(.3);
			$pdf->SetFont('','B');
			// Cabecera
			$w = array(170, 25);
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
			$pdf->Ln();
			// Restauración de colores y fuentes
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Datos
			$fill = false;
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$query = "CALL sp_getRanking('G')";
			$result = mysqli_query($link, $query);
			
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					$pdf->Cell($w[0],6,$row[1],'LR',0,'L',$fill);
					$pdf->Cell($w[1],6,number_format($row[0]),'LR',0,'R',$fill);
					$pdf->Ln();
					$fill = !$fill;
				}
			}
			// Línea de cierre
			$pdf->Cell(array_sum($w),0,'','T');
		}
		else if(isset($_GET['op']) && $_GET['op'] == 's'){
			$header = array('Descripción de la Subgerencia', 'Cantidad');
			$pdf->SetFillColor(255,0,0);
			$pdf->SetTextColor(255);
			$pdf->SetDrawColor(128,0,0);
			$pdf->SetLineWidth(.3);
			$pdf->SetFont('','B');
			// Cabecera
			$w = array(170, 25);
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
			$pdf->Ln();
			// Restauración de colores y fuentes
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Datos
			$fill = false;
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$query = "CALL sp_getRanking('S')";
			$result = mysqli_query($link, $query);
			
			if(mysqli_num_rows($result) > 0){
				$pdf->SetFont('', '', 10);
				while($row = mysqli_fetch_array($result)){
					$pdf->Cell($w[0],6,$row[1],'LR',0,'L',$fill);
					$pdf->Cell($w[1],6,number_format($row[0]),'LR',0,'R',$fill);
					$pdf->Ln();
					$fill = !$fill;
				}
			}
			// Línea de cierre
			$pdf->Cell(array_sum($w),0,'','T');
		}
		else if(isset($_GET['op']) && $_GET['op'] == 't'){
			$header = array('Descripción de la Gerencia', 'Cantidad');
			$pdf->SetFillColor(255,0,0);
			$pdf->SetTextColor(255);
			$pdf->SetDrawColor(128,0,0);
			$pdf->SetLineWidth(.3);
			$pdf->SetFont('','B');
			// Cabecera
			$w = array(170, 25);
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
			$pdf->Ln();
			// Restauración de colores y fuentes
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Datos
			$fill = false;
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$query = "CALL sp_getRanking('G')";
			$result = mysqli_query($link, $query);
			
			if(mysqli_num_rows($result) > 0){
				$pdf->SetFont('', '', 10);
				while($row = mysqli_fetch_array($result)){
					$pdf->Cell($w[0],6,$row[1],'LR',0,'L',$fill);
					$pdf->Cell($w[1],6,number_format($row[0]),'LR',0,'R',$fill);
					$pdf->Ln();
					$fill = !$fill;
				}
			}
			mysqli_close($link);
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$query = "CALL sp_getRanking('S')";
			$result = mysqli_query($link, $query);
			
			if(mysqli_num_rows($result) > 0){
				$pdf->SetFont('', '', 10);
				while($row = mysqli_fetch_array($result)){
					$pdf->Cell($w[0],6,$row[1],'LR',0,'L',$fill);
					$pdf->Cell($w[1],6,number_format($row[0]),'LR',0,'R',$fill);
					$pdf->Ln();
					$fill = !$fill;
				}
			}
			mysqli_close($link);
			// Línea de cierre
			$pdf->Cell(array_sum($w),0,'','T');
		}
		
	}
	
	else{
		header("Location: ../login.php");
	}
	
	
	$pdf->Output();
?>