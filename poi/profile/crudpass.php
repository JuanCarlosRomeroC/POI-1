<?php
	session_start();
	require('../settings/connection.php');
	if(isset($_SESSION['poimps'])){
		if(isset($_POST['v'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$p = mysqli_real_escape_string($link, $_POST['p']);
			$pass = openssl_digest($p, 'sha512');
			$query = "select id_usuario from usuario where contrasenia = '".$pass."' and id_usuario = '". substr($_SESSION['poimps'], 0,5)."'";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){ 
?>
			<div class="form-group">
                            <div class="col-sm-3">
                                <label for="password1" class="control-label">Nueva Password</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" name="npass" id="npass" class="form-control" placeholder="Nueva Password" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="password1" class="control-label">Repetir Password</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" name="nrpass" id="nrpass" class="form-control" placeholder="Repetir Password" required data-rule-equalto="#npass">
                            </div>
                        </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="cambiarpass">Cambiar Password</button>
                    </div>
<?php
			}
			else{
				echo "su contraseña no coincide con la actual";
			}
		}
		else if(isset($_POST['cambiarpass'])){
			$conn = new ConexionBD;
			$link = $conn->conectarBD();
			$p = mysqli_real_escape_string($link, $_POST['npass']);
			$pass = openssl_digest($p, 'sha512');
			$query = "CALL sp_cambiarPass('".$pass."', '".substr($_SESSION['poimps'], 0,5)."')";
			//echo $query;
			$result = mysqli_query($link, $query);
			//echo mysqli_affected_rows($link);
			if(mysqli_affected_rows($link)){
				header("Location: profile.php?exi");
			}
			else{
				header("Location: profile.php?err");
			}
		}
	}
?>