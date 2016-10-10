<?php
	session_start();
	require('../settings/connection.php');
	if(isset($_SESSION['poimps'])){
		if(isset($_POST['op']) && $_POST['op'] == 'g'){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$query = "CALL sp_getDetails('G', 0)";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				echo "<option value=''>&nbsp;</option>";
				while($row = mysqli_fetch_array($result)){
?>
												<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
<?php
				}
			}
			mysqli_close($link);

		}
		else if(isset($_POST['op']) && $_POST['op'] == 's'){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$query = "CALL sp_getDetails('S', 0)";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				echo "<option value=''>&nbsp;</option>";
				while($row = mysqli_fetch_array($result)){
?>
											<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
<?php
				}
			}
			mysqli_close($link);
		}
	}else{
		header("Location: ../login.php");
	}
?>