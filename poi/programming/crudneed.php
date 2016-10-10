<?php
	session_start();
	require('../settings/connection.php');
	if(isset($_SESSION['poimps'])){
		if(isset($_POST['newguardar'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$desc = mysqli_real_escape_string($link, $_POST['descripcion']);
			$act = mysqli_real_escape_string($link, $_POST['actividad']);
			$e = mysqli_real_escape_string($link, $_POST['enero']);
			$f = mysqli_real_escape_string($link, $_POST['febrero']);
			$m = mysqli_real_escape_string($link, $_POST['marzo']);
			$a = mysqli_real_escape_string($link, $_POST['abril']);
			$ma = mysqli_real_escape_string($link, $_POST['mayo']);
			$j = mysqli_real_escape_string($link, $_POST['junio']);
			$ju = mysqli_real_escape_string($link, $_POST['julio']);
			$ag = mysqli_real_escape_string($link, $_POST['agosto']);
			$s = mysqli_real_escape_string($link, $_POST['setiembre']);
			$o = mysqli_real_escape_string($link, $_POST['octubre']);
			$n = mysqli_real_escape_string($link, $_POST['noviembre']);
			$d = mysqli_real_escape_string($link, $_POST['diciembre']);
			$uni = mysqli_real_escape_string($link, $_POST['unimedida']);
			$anual = mysqli_real_escape_string($link, $_POST['anual']);
			$query = "CALL sp_crudNeed('N','".$desc."', ".$act.", ".$e.", ".$f.", ".$m.", ".$a.", ".$ma.", ".$j.",".$ju.", ".$ag.", ".$s.",".$o.",  ".$n.", ".$d.", ".$uni.", ".$anual.", 0)";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				mysqli_close($link);
				header("Location: needs.php?exi&id=$act");
				
			}
			else{
				mysqli_close($link);
				header("Location: needs.php?err&id=$act");
			}
			mysqli_close($link);
		}
		else if(isset($_POST['editar'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$desc = mysqli_real_escape_string($link, $_POST['descripcion']);
			$act = mysqli_real_escape_string($link, $_POST['actividad']);
			$nec = mysqli_real_escape_string($link, $_POST['necesidad']);
			$e = mysqli_real_escape_string($link, $_POST['enero']);
			$f = mysqli_real_escape_string($link, $_POST['febrero']);
			$m = mysqli_real_escape_string($link, $_POST['marzo']);
			$a = mysqli_real_escape_string($link, $_POST['abril']);
			$ma = mysqli_real_escape_string($link, $_POST['mayo']);
			$j = mysqli_real_escape_string($link, $_POST['junio']);
			$ju = mysqli_real_escape_string($link, $_POST['julio']);
			$ag = mysqli_real_escape_string($link, $_POST['agosto']);
			$s = mysqli_real_escape_string($link, $_POST['setiembre']);
			$o = mysqli_real_escape_string($link, $_POST['octubre']);
			$n = mysqli_real_escape_string($link, $_POST['noviembre']);
			$d = mysqli_real_escape_string($link, $_POST['diciembre']);
			$uni = mysqli_real_escape_string($link, $_POST['unimedida']);
			$anual = mysqli_real_escape_string($link, $_POST['anual']);
			$query = "CALL sp_crudNeed('E','".$desc."', ".$act.", ".$e.", ".$f.", ".$m.", ".$a.", ".$ma.", ".$j.",".$ju.", ".$ag.", ".$s.",".$o.",  ".$n.", ".$d.", ".$uni.", ".$anual.", ".$nec.")";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				mysqli_close($link);
				header("Location: needs.php?exi&id=$act");
			}
			else{
				mysqli_close($link);
				header("Location: needs.php?err&id=$act");
			}
			mysqli_close($link);
		}
		else if(isset($_GET['delete'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$id = mysqli_real_escape_string($link, $_GET['id']);
			$idn = mysqli_real_escape_string($link, $_GET['idn']);
			$query = "CALL sp_deleteRecord('N',".$idn.")";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result)){
				mysqli_close($link);
				header("Location: needs.php?id=".$id);
			}
			else{
				mysqli_close($link);
				header("Location: needs.php?&id=".$id);
			}
			mysqli_close($link);
		}
	}
	else{
		header("Location: ../login.php");
	}
?>