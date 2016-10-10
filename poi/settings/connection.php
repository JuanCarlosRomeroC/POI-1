<?php
	error_reporting(E_ERROR);
	class ConexionBD
	{
		private $host = "localhost";
		private $user = "root";
		private $pass = "rootmysql3";
		private $bd = "bdpoi";
		function conectarBD(){
			$mysqli = mysqli_connect($this->host, $this->user, $this->pass, $this->bd);
			mysqli_query("SET NAMES 'UTF8'");
			return $mysqli;
		}
		function desconectarBD($link){
			mysqli_close($link);
		}
	}
?>