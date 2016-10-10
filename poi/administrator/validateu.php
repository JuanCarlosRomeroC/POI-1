<?php
	session_start();
	require('../settings/connection.php');
	if(isset($_SESSION['poimps'])){
		if(isset($_POST['u'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$u = mysqli_real_escape_string($link, $_POST['u']);
			$query = "SELECT nombre_usuario FROM usuario WHERE nombre_usuario = '".$u."'";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
?>
				<label class="text-danger"><i class="md md-block"></i>&nbsp;Este nombre de usuario existe</label>
<?php
			}
			mysqli_close($link);

		}
		
	}else{
		header("Location: ../login.php");
	}
?>