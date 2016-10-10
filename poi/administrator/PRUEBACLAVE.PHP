<?php
	require("../settings/connection.php");
	session_start();
	if(isset($_POST['acceso'])){
		$miClaseConn = new ConexionBD;
		$link = $miClaseConn->conectarBD();
		$pass = openssl_digest('1234', 'sha512'); 
		$query = "update usuario set contrasenia='$pass'";
		
		$result = mysqli_query($link, $query);
		
	}
?>