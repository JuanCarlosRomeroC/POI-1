<?php
	session_start();
	require('../settings/connection.php');
	if(isset($_SESSION['poimps'])){
		if(isset($_POST['newguardar'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$nameu = mysqli_real_escape_string($link, $_POST['nameuser']);
			$p = mysqli_real_escape_string($link, $_POST['pass']);
			$pass = openssl_digest($p, 'sha512'); 
			$nombre = mysqli_real_escape_string($link, $_POST['nombre']);
			$email = mysqli_real_escape_string($link, $_POST['email']);
			$pertenece = mysqli_real_escape_string($link, $_POST['pertenece']);
			$area = mysqli_real_escape_string($link, $_POST['area']);
			if($pertenece == 'g') {
				$query = "CALL sp_crudUser('N', '".$nameu."', '".$pass."', '".$nombre."', '".$email."', NULL, '".$area."')";
			}
			else{
				$query = "CALL sp_crudUser('N', '".$nameu."', '".$pass."', '".$nombre."', '".$email."', '".$area."', NULL)";
			}
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				mysqli_close($link);
				header("Location: users.php?exi");
			}
			else{
				mysqli_close($link);
				header("Location: users.php?err");
			}
		}
		else if(isset($_POST['editar'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$idu = mysqli_real_escape_string($link, $_POST['idu']);
			$nombre = mysqli_real_escape_string($link, $_POST['nombree']);
			$email = mysqli_real_escape_string($link, $_POST['emaile']);
			$query = "CALL sp_crudUser('E', '".$idu."', '', '".$nombre."', '".$email."', '','')";
			$result = mysqli_query($link, $query);
			if(mysqli_affected_rows($link)){
				mysqli_close($link);
				header("Location: users.php?exi");
			}
			else{
				mysqli_close($link);
				header("Location: users.php?err");
			}
		}
		else if(isset($_GET['delete'])){
				$conn = new ConexionBD;
				$link = $conn->conectarBD();
				$ida = mysqli_real_escape_string($link, $_GET['id']);
				$query = "CALL sp_deleteUser('".$ida."')";
				$result = mysqli_query($link, $query);
				if(mysqli_num_rows($result) > 0){
					mysqli_close($link);
					header("Location: users.php?exi");
				}
				else{
					mysqli_close($link);
					header("Location: users.php?err");
				}
				mysqli_close($link);
			
		}
		else if(isset($_GET['bloquear'])){
				$conn = new ConexionBD;
				$link = $conn->conectarBD();
				$ida = mysqli_real_escape_string($link, $_GET['id']);
				$query = "UPDATE usuario SET estado = 'B' WHERE id_usuario = '".$ida."'";
				$result = mysqli_query($link, $query);
				if(mysqli_affected_rows($link) > 0){
					mysqli_close($link);
					header("Location: users.php?exi");
				}
				else{
					mysqli_close($link);
					header("Location: users.php?err");
				}
				mysqli_close($link);
			
		}
		else if(isset($_GET['desbloquear'])){
				$conn = new ConexionBD;
				$link = $conn->conectarBD();
				$ida = mysqli_real_escape_string($link, $_GET['id']);
				$query = "UPDATE usuario SET estado = 'A' WHERE id_usuario = '".$ida."'";
				$result = mysqli_query($link, $query);
				if(mysqli_affected_rows($link) > 0){
					mysqli_close($link);
					header("Location: users.php?exi");
				}
				else{
					mysqli_close($link);
					header("Location: users.php?err");
				}
				mysqli_close($link);
			
		}
		else if(isset($_GET['reestablecer'])){
				$conn = new ConexionBD;
				$link = $conn->conectarBD();
				$ida = mysqli_real_escape_string($link, $_GET['id']);
				$pass = openssl_digest('123456', 'sha512'); 
				$query = "UPDATE usuario SET contrasenia = '".$pass."' WHERE id_usuario = '".$ida."'";
				$result = mysqli_query($link, $query);
				if(mysqli_affected_rows($link) > 0){
					mysqli_close($link);
					header("Location: users.php?edit&id=".$ida."&exi");
				}
				else{
					mysqli_close($link);
					header("Location: users.php?edit&id=".$ida."&err");
				}
				mysqli_close($link);
			
		}
	}
	else{
		header("Location: ../login.php");
	}
?>