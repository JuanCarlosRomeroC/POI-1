<?php
	session_start();
	require('../settings/connection.php');
	if(isset($_SESSION['poimps'])){
		if(isset($_POST['op']) && $_POST['op'] == 'g'){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$query = "CALL sp_getRanking('G')";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				echo "<tbody>";
				while($row = mysqli_fetch_array($result)){
?>
											<tr class="gradeX">
												<td><?php echo $row[0]; ?></td>
												<td><?php echo $row[1]; ?></td>
											</tr>
<?php
				}
				echo "</tbody>";
			}
			mysqli_close($link);

		}
		else if(isset($_POST['op']) && $_POST['op'] == 's'){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$query = "CALL sp_getRanking('S')";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				echo "<tbody>";
				while($row = mysqli_fetch_array($result)){
?>
											<tr class="gradeX">
												<td><?php echo $row[0]; ?></td>
												<td><?php echo $row[1]; ?></td>
											</tr>
<?php
				}
				echo "</tbody>";
			}
			mysqli_close($link);
		}
	}else{
		header("Location: ../login.php");
	}
?>