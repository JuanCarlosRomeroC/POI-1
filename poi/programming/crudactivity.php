<?php
	session_start();
	require('../settings/connection.php');
	if(isset($_SESSION['poimps'])){
		if(isset($_POST['newguardar'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$obj = mysqli_real_escape_string($link, $_POST['objetivo']);
			$act = mysqli_real_escape_string($link, $_POST['actividad']);
			$uni = mysqli_real_escape_string($link, $_POST['unimedida']);
			$can = mysqli_real_escape_string($link, $_POST['cantidad']);
			$res = mysqli_real_escape_string($link, $_POST['resultado']);
			$t1 = mysqli_real_escape_string($link, $_POST['trii']);
			$t2 = mysqli_real_escape_string($link, $_POST['triii']);
			$t3 = mysqli_real_escape_string($link, $_POST['triiii']);
			$t4 = mysqli_real_escape_string($link, $_POST['triiv']);
			$rep = mysqli_real_escape_string($link, $_POST['responsable']);
			$sub = mysqli_real_escape_string($link, $_POST['subgerencia']);
			$ger = mysqli_real_escape_string($link, $_POST['gerencia']);
			if($sub == '') {
				$query = "CALL sp_crudActivity('N',".$obj.", '".$act."', ".$uni.", ".$can.", '".$res."', ".$t1.", ".$t2.", ".$t3.",".$t4.", '".$rep."', NULL, '".$ger."', 0)";
			}
			else{
				$query = "CALL sp_crudActivity('N',".$obj.", '".$act."', ".$uni.", ".$can.", '".$res."', ".$t1.", ".$t2.", ".$t3.",".$t4.", '".$rep."', '".$sub."', NULL, 0)";
			}
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				mysqli_close($link);
				header("Location: activities.php?exi");
			}
			else{
				mysqli_close($link);
				header("Location: activities.php?err");
			}
		}
		else if(isset($_POST['editar'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$obj = mysqli_real_escape_string($link, $_POST['objetivo']);
			$act = mysqli_real_escape_string($link, $_POST['actividad']);
			$uni = mysqli_real_escape_string($link, $_POST['unimedida']);
			$can = mysqli_real_escape_string($link, $_POST['cantidad']);
			$res = mysqli_real_escape_string($link, $_POST['resultado']);
			$t1 = mysqli_real_escape_string($link, $_POST['trii']);
			$t2 = mysqli_real_escape_string($link, $_POST['triii']);
			$t3 = mysqli_real_escape_string($link, $_POST['triiii']);
			$t4 = mysqli_real_escape_string($link, $_POST['triiv']);
			$rep = mysqli_real_escape_string($link, $_POST['responsable']);
			$sub = mysqli_real_escape_string($link, $_POST['subgerencia']);
			$ger = mysqli_real_escape_string($link, $_POST['gerencia']);
			$idact = mysqli_real_escape_string($link, $_POST['idact']);
			if($sub == '') {
				$query = "CALL sp_crudActivity('E',".$obj.", '".$act."', ".$uni.", ".$can.", '".$res."', ".$t1.", ".$t2.", ".$t3.",".$t4.", '".$rep."', NULL, '".$ger."', ".$idact.")";
			}
			else{
				$query = "CALL sp_crudActivity('E',".$obj.", '".$act."', ".$uni.", ".$can.", '".$res."', ".$t1.", ".$t2.", ".$t3.",".$t4.", '".$rep."', '".$sub."','".$ger."', ".$idact.")";
			}
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				mysqli_close($link);
				header("Location: activities.php?exi");
			}
			else{
				mysqli_close($link);
				header("Location: activities.php?err");
			}
		}
		else if(isset($_GET['delete'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$ida = mysqli_real_escape_string($link, $_GET['id']);
			$query = "CALL sp_deleteRecord('A',".$ida.")";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result)){
				mysqli_close($link);
				header("Location: activities.php");
			}
			else{
				mysqli_close($link);
				header("Location: activities.php");
			}
			mysqli_close($link);
		}
	}
	else{
		header("Location: ../login.php");
	}
?>