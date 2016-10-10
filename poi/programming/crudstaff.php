<?php
	session_start();
	require('../settings/connection.php');
	if(isset($_SESSION['poimps'])){
		if(isset($_POST['newguardar'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$act = mysqli_real_escape_string($link, $_POST['actividad']);
			$estd = mysqli_real_escape_string($link, $_POST['estd']);
			$fund = mysqli_real_escape_string($link, $_POST['fund']);
			$casd = mysqli_real_escape_string($link, $_POST['casd']);
			$estp = mysqli_real_escape_string($link, $_POST['estp']);
			$casp = mysqli_real_escape_string($link, $_POST['casp']);
			$snpp = mysqli_real_escape_string($link, $_POST['snpp']);
			$estt = mysqli_real_escape_string($link, $_POST['estt']);
			$cast = mysqli_real_escape_string($link, $_POST['cast']);
			$snpt = mysqli_real_escape_string($link, $_POST['snpt']);
			$esta = mysqli_real_escape_string($link, $_POST['esta']);
			$casa = mysqli_real_escape_string($link, $_POST['casa']);
			$snpa = mysqli_real_escape_string($link, $_POST['snpa']);
			$esto = mysqli_real_escape_string($link, $_POST['esto']);
			$caso = mysqli_real_escape_string($link, $_POST['caso']);
			$snpo = mysqli_real_escape_string($link, $_POST['snpo']);
			$query = "CALL sp_crudStaff('N',".$act.", ".$estd.", ".$fund.", ".$casd.", ".$estp.", ".$casp.", ".$snpp.", ".$estt.", ".$cast.", ".$snpt.", ".$esta.", ".$casa.", ".$snpa.",  ".$esto.", ".$caso.", ".$snpo.", 0)";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				mysqli_close($link);
				header("Location: staff.php?exi&id=$act");
			}
			else{
				mysqli_close($link);
				header("Location: staff.php?err&id=$act");
			}
		}
		else if(isset($_POST['editar'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$act = mysqli_real_escape_string($link, $_POST['actividad']);
			$idp = mysqli_real_escape_string($link, $_POST['idpersonal']);
			$estd = mysqli_real_escape_string($link, $_POST['estd']);
			$fund = mysqli_real_escape_string($link, $_POST['fund']);
			$casd = mysqli_real_escape_string($link, $_POST['casd']);
			$estp = mysqli_real_escape_string($link, $_POST['estp']);
			$casp = mysqli_real_escape_string($link, $_POST['casp']);
			$snpp = mysqli_real_escape_string($link, $_POST['snpp']);
			$estt = mysqli_real_escape_string($link, $_POST['estt']);
			$cast = mysqli_real_escape_string($link, $_POST['cast']);
			$snpt = mysqli_real_escape_string($link, $_POST['snpt']);
			$esta = mysqli_real_escape_string($link, $_POST['esta']);
			$casa = mysqli_real_escape_string($link, $_POST['casa']);
			$snpa = mysqli_real_escape_string($link, $_POST['snpa']);
			$esto = mysqli_real_escape_string($link, $_POST['esto']);
			$caso = mysqli_real_escape_string($link, $_POST['caso']);
			$snpo = mysqli_real_escape_string($link, $_POST['snpo']);
			$query = "CALL sp_crudStaff('E',".$act.", ".$estd.", ".$fund.", ".$casd.", ".$estp.", ".$casp.", ".$snpp.", ".$estt.", ".$cast.", ".$snpt.", ".$esta.", ".$casa.", ".$snpa.",  ".$esto.", ".$caso.", ".$snpo.", ".$idp.")";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				mysqli_close($link);
				header("Location: staff.php?exi&id=$act");
			}
			else{
				mysqli_close($link);
				header("Location: staff.php?err&id=$act");
			}
		}
		else if(isset($_GET['delete'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$id = mysqli_real_escape_string($link, $_GET['id']);
			$idn = mysqli_real_escape_string($link, $_GET['idn']);
			$query = "CALL sp_deleteRecord('P',".$idn.")";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result)){
				mysqli_close($link);
				header("Location: staff.php?id=".$id);
			}
			else{
				mysqli_close($link);
				header("Location: staff.php?&id=".$id);
			}
			mysqli_close($link);
		}
	}
	else{
		header("Location: ../login.php");
	}
?>