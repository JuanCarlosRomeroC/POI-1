<?php
	session_start();
	require('../settings/connection.php');
	if(isset($_SESSION['poimps'])){
		if(isset($_POST['newguardar'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$nameu = mysqli_real_escape_string($link, strtoupper($_POST['unimedida']));
			$query = "insert into uni_medida values (NULL, '".$nameu."')";
			$result = mysqli_query($link, $query);
			if(mysqli_affected_rows($link) > 0){
				mysqli_close($link);
				header("Location: unimedida.php?exi");
			}
			else{
				mysqli_close($link);
				header("Location: unimedida.php?err");
			}
		}
		else if(isset($_POST['editar'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$idu = mysqli_real_escape_string($link, $_POST['idu']);
			$nombre = mysqli_real_escape_string($link, strtoupper($_POST['unimedida']));
			$query = "UPDATE uni_medida SET descripcion = '".$nombre."' WHERE id_unimedida = ".$idu;
			$result = mysqli_query($link, $query);
			if(mysqli_affected_rows($link)){
				mysqli_close($link);
				header("Location: unimedida.php?exi");
			}
			else{
				mysqli_close($link);
				header("Location: unimedida.php?err");
			}
		}
		else if(isset($_GET['delete'])){
				$conn = new ConexionBD;
				$link = $conn->conectarBD();
				$ida = mysqli_real_escape_string($link, $_GET['id']);
				$query = "DELETE FROM uni_medida WHERE id_unimedida = ".$ida;
				$result = mysqli_query($link, $query);
				if(mysqli_affected_rows($link) > 0){
					mysqli_close($link);
					header("Location: unimedida.php?exi");
				}
				else{
					mysqli_close($link);
					header("Location: unimedida.php?err");
				}
				mysqli_close($link);
			
		}
	}
	else{
		header("Location: ../login.php");
	}
?>