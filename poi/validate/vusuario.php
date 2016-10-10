<?php
	require("../settings/connection.php");
	session_start();
	if(isset($_POST['acceso'])){
		$miClaseConn = new ConexionBD;
		$link = $miClaseConn->conectarBD();
		$user = mysqli_real_escape_string($link, $_POST["username"]);
		$p = mysqli_real_escape_string($link, $_POST["password"]);
		$pass = openssl_digest($p, 'sha512'); 
		$query = "CALL sp_login('".$user."','".$pass."')";
		
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_array($result);
			if($row[0] == "N"){
				header("Location: ../login.php?errn=1");
			}else if($row[0] == "B"){
				header("Location: ../login.php?errb=1");
			}else if($row[0] == "I"){
				header("Location: ../login.php?erri=1");
			}
			else{
				$_SESSION['poimps'] = $row[0] . $row[1] . $row[2];
				header("Location: ../index.php");
			}
		}
		else{
			header("Location: ../login.php?");
		}
	}
?>