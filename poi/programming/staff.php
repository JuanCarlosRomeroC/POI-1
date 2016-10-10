<?php
	session_start();
	require('../settings/connection.php');
	if(isset($_SESSION['poimps'])){
		$conn = new ConexionBD;
		$nivel = substr($_SESSION['poimps'], 5,1);
		$link = $conn->conectarBD();
		$query = "CALL sp_getGerenciaUsuario('G', 0, '".substr($_SESSION['poimps'], 0,5)."')";
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_array($result);
			$idgerencia = $row[0];
			$gerencia = $row[1];	
		}	
		else{
			mysqli_close($link);
			$link = $conn->conectarBD();
			$query = "CALL sp_getGerenciaUsuario('S', '0', '".substr($_SESSION['poimps'], 0,5)."')";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				$row = mysqli_fetch_array($result);
				$idsubgerencia = $row[0];
				$subgerencia = $row[1];
				mysqli_close($link);
				$link = $conn->conectarBD();
				$query = "CALL sp_getGerenciaUsuario('D', '".substr($idsubgerencia, 0, 2)."' , '".substr($_SESSION['poimps'], 0,5)."')";
				$result = mysqli_query($link, $query);
				if(mysqli_num_rows($result) > 0){
					$row = mysqli_fetch_array($result);
					$idgerencia = $row[0];
					$gerencia = $row[1];	
				}
			}
		}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>.: SISTEMA POI :.</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="">
        <meta content="MUNICIPALIDAD PROVINCIAL DEL SANTA" name="description" />
		<meta content="WILSON VARGAS AGURTO" name="author" />
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/bootstrap.css?1422792965" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/materialadmin.css?1425466319" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/font-awesome.min.css?1422529194" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/rickshaw/rickshaw.css?1422792967" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/morris/morris.core.css?1420463396" />
        <link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/DataTables/jquery.dataTables.css?1423553989" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/DataTables/extensions/dataTables.colVis.css?1423553990" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css?1423553990" />
        <link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/select2/select2.css?1424887856" />
		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="../assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="../assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
	</head>
	<body class="menubar-hoverable header-fixed ">

		<!-- BEGIN HEADER-->
		<header id="header" >
			<div class="headerbar">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="headerbar-left">
					<ul class="header-nav header-nav-options">
						<li class="header-nav-brand" >
							<div class="brand-holder">
								<a href="../index.php">
									<span class="text-lg text-bold" style="color: rgb(214, 228, 81);">SISTEMA POI</span>
								</a>
							</div>
						</li>
						<li>
							<a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
								<i class="fa fa-bars"></i>
							</a>
						</li>
					</ul>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="headerbar-right">
					<ul class="header-nav header-nav-options">
					</ul><!--end .header-nav-options -->
					<ul class="header-nav header-nav-profile">
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
								<img src="../assets/img/user.png" alt="" />

								<span class="profile-info">
									<?php echo substr($_SESSION['poimps'], 6)?>
								</span>
							</a>
							<ul class="dropdown-menu animation-dock">
								<li><a href="../profile/profile.php">Mi perfil</a></li>
								<li class="divider"></li>
								<li><a href="../login.php?logout"><i class="fa fa-fw fa-power-off text-danger"></i> Salir</a></li>
							</ul><!--end .dropdown-menu -->
						</li><!--end .dropdown -->
					</ul><!--end .header-nav-profile -->
					<!--ul class="header-nav header-nav-toggle">
						<li>
							<a class="btn btn-icon-toggle btn-default" href="#offcanvas-search" data-toggle="offcanvas" data-backdrop="false">
								<i class="fa fa-ellipsis-v"></i>
							</a>
						</li>
					</ul><!--end .header-nav-toggle -->
				</div><!--end #header-navbar-collapse -->
			</div>
		</header>
		<!-- END HEADER-->

		<!-- BEGIN BASE-->
		<div id="base">

			<!-- BEGIN OFFCANVAS LEFT -->
			<div class="offcanvas">
			</div><!--end .offcanvas-->
			<!-- END OFFCANVAS LEFT -->

			<!-- BEGIN CONTENT-->
			<div id="content">
            	<section>
                	<div class="section-header">
						<ol class="breadcrumb">
							<li><a href="../index.php">Inicio</a></li>
                            <li><a href="#">Programaci&oacute;n de Actividades</a></li>
                            <li><a href="activities.php">Actividades</a></li>
<?php
	if(isset($_GET['newstaff']) && !isset($_GET['edit']) && !isset($_GET['details'])){
?>
							<li><a href="?id=<?php echo $_GET['id']?>">Cuadro de Personal</a></li>
                            <li class="active">Nuevo Personal</li>
<?php
	}else if(!isset($_GET['newstaff']) && isset($_GET['edit']) && !isset($_GET['details'])){
?>
							<li><a href="?id=<?php echo $_GET['id']?>">Cuadro de Personal</a></li>
                            <li class="active">Editar Personal</li>
<?php
	}else if(!isset($_GET['newstaff']) && !isset($_GET['edit']) && isset($_GET['details'])){
?>
							<li><a href="?id=<?php echo $_GET['id']?>">Cuadro de Personal</a></li>
                            <li class="active">Detalles del Personal</li>
<?php
	}else {
?>
							<li class="active">Cuadro de Personal</li>
<?php } ?>
						</ol>
					</div>
                    <div class="section-header">
						<h2 style="color: rgb(169, 43, 46); text-shadow: 1px 1.5px rgb(51, 51, 51);">Cuadro de Personal</h2>
					</div>
<!--  NUEVA ACTIVIDAD -->
<?php
	if(isset($_GET['newstaff']) && !isset($_GET['edit']) && !isset($_GET['details'])){
?>
					<div class="section-body ">
                    	<div class="col-lg-offset-1 col-md-10">
								<form class="form form-validate floating-label" novalidate method="post" action="crudstaff.php">
                                	<input type="hidden" name="actividad" value="<?php echo $_GET['id']?>">
									<div class="card">
                                    	<div class="card-head style-primary">
											<header>Nuevo Personal</header>
										</div>
										<div class="card-body">
                                            <p><h4>Directivos</h4></p>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="estd" name="estd" data-rule-digits="true" required value="0">
                                                <label for="estd" class="control-label">Est</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="fund" name="fund" data-rule-digits="true" required value="0">
                                                <label for="fun" class="control-label">Fun</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="casd" name="casd" data-rule-digits="true" required value="0">
                                                <label for="marzo" class="control-label">Cas</label>
                                            </div>
                                            <p><h4>Profesionales<h4></p>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="estp" name="estp" data-rule-digits="true" required value="0">
                                                <label for="estp" class="control-label">Est</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="casp" name="casp" data-rule-digits="true" required value="0">
                                                <label for="casp" class="control-label">Cas</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="snpp" name="snpp" data-rule-digits="true" required value="0">
                                                <label for="snpp" class="control-label">Terceros</label>
                                            </div>
                                            <p><h4>T&eacute;cnicos</h4></p>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="estt" name="estt" data-rule-digits="true" required value="0">
                                                <label for="estt" class="control-label">Est</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="cast" name="cast" data-rule-digits="true" required value="0">
                                                <label for="cast" class="control-label">Cas</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="snpt" name="snpt" data-rule-digits="true" required value="0">
                                                <label for="snpt" class="control-label">Terceros</label>
                                            </div>
                                            <p><h4>Auxiliares</h4></p>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="esta" name="esta" data-rule-digits="true" required value="0">
                                                <label for="esta" class="control-label">Est</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="casa" name="casa" data-rule-digits="true" required value="0">
                                                <label for="casa" class="control-label">Cas</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="snpa" name="snpa" data-rule-digits="true" required value="0">
                                                <label for="snpa" class="control-label">Terceros</label>
                                            </div>
                                            <p><h4>Obreros</h4></p>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="esto" name="esto" data-rule-digits="true" required value="0">
                                                <label for="esto" class="control-label">Est</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="caso" name="caso" data-rule-digits="true" required value="0">
                                                <label for="caso" class="control-label">Cas</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="snpo" name="snpo" data-rule-digits="true" required value="0">
                                                <label for="snpo" class="control-label">Terceros</label>
                                            </div>
										</div><!--end .card-body -->
										<div class="card-actionbar style-primary">
											<div class="card-actionbar-row">
                                            	<a href="?id=<?php echo $_GET['id']?>"><button type="button" class="btn btn-raised btn-default-dark ink-reaction col-sm-2">Cancelar</button></a>
												<button type="submit" class="btn btn-raised btn-success ink-reaction col-sm-2 col-sm-offset-8" name="newguardar">Guardar</button>
											</div>
										</div><!--end .card-actionbar -->
									</div><!--end .card -->
									<em class="text-caption">Debe completar todos los campos</em>
								</form>
							</div>
                    </div>


<!--  EDITAR ACTIVIDAD -->
<?php
	}else if(!isset($_GET['newstaff']) && isset($_GET['edit']) && !isset($_GET['details'])){
?>
					<div class="section-body ">
                    	<div class="col-lg-offset-1 col-md-10">
								<form class="form form-validate floating-label" novalidate method="post" action="crudstaff.php" onSubmit="return validateForm()">
                                	<input type="hidden" name="actividad" value="<?php echo $_GET['id']?>">
                                    <input type="hidden" name="idpersonal" value="<?php echo $_GET['idn']?>">
									<div class="card">
                                    	<div class="card-head style-primary">
											<header>Editar Personal</header>
										</div>
										<div class="card-body">
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getDetails('P', ".$_GET['idn'].")";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_array($result);
?>
		<input type="hidden" id="e1" value="<?php echo $row[2];?>">
        <input type="hidden" id="e2" value="<?php echo $row[3];?>">
        <input type="hidden" id="e3" value="<?php echo $row[4];?>">
        <input type="hidden" id="e4" value="<?php echo $row[5];?>">
        <input type="hidden" id="e5" value="<?php echo $row[6];?>">
        <input type="hidden" id="e6" value="<?php echo $row[7];?>">
        <input type="hidden" id="e7" value="<?php echo $row[8];?>">
        <input type="hidden" id="e8" value="<?php echo $row[9];?>">
        <input type="hidden" id="e9" value="<?php echo $row[10];?>">
        <input type="hidden" id="e10" value="<?php echo $row[11];?>">
        <input type="hidden" id="e11" value="<?php echo $row[12];?>">
        <input type="hidden" id="e12" value="<?php echo $row[13];?>">
		<input type="hidden" id="e13" value="<?php echo $row[14];?>">
        <input type="hidden" id="e14" value="<?php echo $row[15];?>">
        <input type="hidden" id="e15" value="<?php echo $row[16];?>">

                                            <p><h4>Directivos</h4></p>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="estd" name="estd" data-rule-digits="true" required value="<?php echo $row[2];?>">
                                                <label for="estd" class="control-label">Est</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="fund" name="fund" data-rule-digits="true" required value="<?php echo $row[3];?>">
                                                <label for="fun" class="control-label">Fun</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="casd" name="casd" data-rule-digits="true" required value="<?php echo $row[4];?>">
                                                <label for="marzo" class="control-label">Cas</label>
                                            </div>
                                            <p><h4>Profesionales<h4></p>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="estp" name="estp" data-rule-digits="true" required value="<?php echo $row[5];?>">
                                                <label for="estp" class="control-label">Est</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="casp" name="casp" data-rule-digits="true" required value="<?php echo $row[6];?>">
                                                <label for="casp" class="control-label">Cas</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="snpp" name="snpp" data-rule-digits="true" required value="<?php echo $row[7];?>">
                                                <label for="snpp" class="control-label">Terceros</label>
                                            </div>
                                            <p><h4>T&eacute;cnicos</h4></p>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="estt" name="estt" data-rule-digits="true" required value="<?php echo $row[8];?>">
                                                <label for="estt" class="control-label">Est</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="cast" name="cast" data-rule-digits="true" required value="<?php echo $row[9];?>">
                                                <label for="cast" class="control-label">Cas</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="snpt" name="snpt" data-rule-digits="true" required value="<?php echo $row[10];?>">
                                                <label for="snpt" class="control-label">Terceros</label>
                                            </div>
                                            <p><h4>Auxiliares</h4></p>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="esta" name="esta" data-rule-digits="true" required value="<?php echo $row[11];?>">
                                                <label for="esta" class="control-label">Est</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="casa" name="casa" data-rule-digits="true" required value="<?php echo $row[12];?>">
                                                <label for="casa" class="control-label">Cas</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="snpa" name="snpa" data-rule-digits="true" required value="<?php echo $row[13];?>">
                                                <label for="snpa" class="control-label">Terceros</label>
                                            </div>
                                            <p><h4>Obreros</h4></p>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="esto" name="esto" data-rule-digits="true" required value="<?php echo $row[14];?>">
                                                <label for="esto" class="control-label">Est</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="caso" name="caso" data-rule-digits="true" required value="<?php echo $row[15];?>">
                                                <label for="caso" class="control-label">Cas</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control" id="snpo" name="snpo" data-rule-digits="true" required value="<?php echo $row[16];?>">
                                                <label for="snpo" class="control-label">Terceros</label>
                                            </div>
<?php } mysqli_close($link); ?>
										</div><!--end .card-body -->
										<div class="card-actionbar style-primary">
											<div class="card-actionbar-row">
                                            	<a href="?id=<?php echo $_GET['id']?>"><button type="button" class="btn btn-raised btn-default-dark ink-reaction col-sm-2">Cancelar</button></a>
                                                <button type="submit" class="btn btn-raised btn-success ink-reaction col-sm-2 col-sm-offset-8" name="editar">Guardar cambios</button>
											</div>
										</div><!--end .card-actionbar -->
									</div><!--end .card -->
									<em class="text-caption">Debe completar todos los campos</em>
								</form>
							</div>
                    </div>
<!-- DETALLES DE LA ACTIVIDAD -->
<?php
	}else if(!isset($_GET['newstaff']) && !isset($_GET['edit']) && isset($_GET['details'])){
?>
					<div class="section-body ">
                    	<div class="col-lg-offset-1 col-md-10">
								<form class="form floating-label" method="post" action="#">
                                	<input type="hidden" name="actividad" value="<?php echo $_GET['id']?>">
									<div class="card">
                                    	<div class="card-head style-primary">
											<header>Detalles del Personal</header>
										</div>
										<div class="card-body">
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getDetails('P', ".$_GET['idn'].")";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_array($result);
?>
                                            <p><h4>Directivos</h4></p>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="e1" name="d1" value="<?php echo $row[2];?>" readonly>
                                                <label for="estd" class="control-label">Est</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d2" name="d2" value="<?php echo $row[3];?>" readonly>
                                                <label for="fun" class="control-label">Fun</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d3" name="d3" value="<?php echo $row[4];?>" readonly>
                                                <label for="marzo" class="control-label">Cas</label>
                                            </div>
                                            <p><h4>Profesionales<h4></p>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d4" name="d4" value="<?php echo $row[5];?>" readonly>
                                                <label for="estp" class="control-label">Est</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d5" name="d5" value="<?php echo $row[6];?>" readonly>
                                                <label for="casp" class="control-label">Cas</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d6" name="d6" value="<?php echo $row[7];?>" readonly>
                                                <label for="snpp" class="control-label">Terceros</label>
                                            </div>
                                            <p><h4>T&eacute;cnicos</h4></p>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d7" name="d7" value="<?php echo $row[8];?>" readonly>
                                                <label for="estt" class="control-label">Est</label>
                                            </div>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d8" name="d8" value="<?php echo $row[9];?>" readonly>
                                                <label for="cast" class="control-label">Cas</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d9" name="d9" value="<?php echo $row[10];?>" readonly>
                                                <label for="snpt" class="control-label">Terceros</label>
                                            </div>
                                            <p><h4>Auxiliares</h4></p>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d10" name="d10" value="<?php echo $row[11];?>" readonly>
                                                <label for="esta" class="control-label">Est</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d11" name="d11" value="<?php echo $row[12];?>" readonly>
                                                <label for="casa" class="control-label">Cas</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d12" name="d12" value="<?php echo $row[13];?>" readonly>
                                                <label for="snpa" class="control-label">Terceros</label>
                                            </div>
                                            <p><h4>Obreros</h4></p>
                                             <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d13" name="d13" value="<?php echo $row[14];?>" readonly>
                                                <label for="esto" class="control-label">Est</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d14" name="d14" value="<?php echo $row[15];?>" readonly>
                                                <label for="caso" class="control-label">Cas</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                            	<input type="text" class="form-control static dirty" id="d15" name="d15" value="<?php echo $row[16];?>" readonly>
                                                <label for="snpo" class="control-label">Terceros</label>
                                            </div>
<?php } mysqli_close($link); ?>
										</div><!--end .card-body -->
										<div class="card-actionbar style-primary">
											<div class="card-actionbar-row">
                                            	<a href="?id=<?php echo $_GET['id']?>"><button type="button" class="btn btn-raised btn-default-dark ink-reaction col-sm-2 col-sm-offset-10">Cancelar</button></a>
											</div>
										</div><!--end .card-actionbar -->
									</div><!--end .card -->
									<em class="text-caption">Debe completar todos los campos</em>
								</form>
							</div>
                    </div>
<!-- LISTAR ACTIVIDADES -->
<?php
	}else {
?>
					<div class="section-body ">
                    	<div class="row">
							<div class="col-md-8">
								<article class="margin-bottom-xxl">
									<p class="lead" style="color: rgb(201, 181, 79); text-shadow: 1px 1px rgb(222, 76, 76);">
										Gerencia: <label style="color: rgb(0, 0, 0); text-shadow: 2px 2px rgb(255, 255, 255);"><?php echo $gerencia;?></label>

                                       <br>
                                        Subgerencia: <label style="color: rgb(0, 0, 0); text-shadow: 2px 2px rgb(255, 255, 255);"><?php echo $subgerencia;?></label><br>
                                        Actividad: <label style="color: rgb(0, 0, 0); text-shadow: 2px 2px rgb(255, 255, 255);">
<?php
	$link = $conn->conectarBD();
	$query = "SELECT actividad FROM prog_actividad where id_prog_actividad = ".$_GET['id'];
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	echo $row[0];
	mysqli_close($link);
?>
                                        
                                        </label>
									</p>
								</article>
							</div><!--end .col -->
						</div><!--end .row -->
<?php
	if(isset($_GET['exi'])){
?>
                        <div class="row">
                        	<div class="col-sm-12">	
                            	<div class="alert alert-success" role="alert">
                                	<strong>Exito!</strong> la acci&oacute;n se ejecuto correctamente.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            </div>
                        </div>
<?php
	}else if(isset($_GET['err'])){
?>
					 	<div class="row">
                        	<div class="col-sm-12">	
                            	<div class="alert alert-danger" role="alert">
                                	<strong>Oh no puede ser!</strong> ocurrio un error.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            </div>
                        </div>
<?php
	}
?>
                        <div class="row">
							<div class="col-md-12 ">
								<h4></h4>
							</div><!--end .col -->
							<div class="col-lg-12 ">
                            	<div class="card card-outlined card-underline">
                                	<div class="card-head">
                                    	<header></header>
                                        <div class="tools" style="width:430px;">
                                            <a class="btn" href="activities.php">
                                            	<i class="md md-keyboard-arrow-left "></i>&nbsp;Regresar a Actividades
                                            </a>
<?php
	$link = $conn->conectarBD();
	$query = "SELECT COUNT(id_cuadro_personal) FROM cuadro_personal WHERE fk_prog_actividad =".$_GET['id'];
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_array($result);
		if($row[0] == "0"){
?>
                                            
                                            &nbsp; | &nbsp;
                                            <a class="btn" href="?newstaff&id=<?php echo $_GET['id']?>">
                                            	<i class="md md-add-circle"></i>&nbsp;Personal
                                            </a>
<?php
		}
		else{
?>
											&nbsp; | &nbsp;
                                            <a class="btn ink-reaction btn-flat disabled" href="?newstaff&id=<?php echo $_GET['id']?>">
                                            	<i class="md md-add-circle"></i>&nbsp;Personal
                                            </a>
<?php
		}
	}mysqli_close($link);
?>
                                        </div>                                    
                                    </div>
                                    
                                    
                                    
                                	<div class="card-body">
								<div class="table-responsive">
									<table id="datatable1" class="table table-striped table-hover">
										<thead>
											<tr>
												<th>Directivos</th>
												<th>Profesionales</th>
												<th>T&eacute;cnicos</th>
												<th>Auxiliares</th>
                                                <th>Obreros</th>
                                                <th class="text-center">Acciones</th>
											</tr>
										</thead>
										<tbody>
<?php
		$link = $conn->conectarBD();
		$query = "CALL sp_getStaff(".$_GET['id'].")";
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_array($result)){
?>
											<tr class="gradeX">
												<td><?php echo $row[2]+$row[3]+$row[4]?></td>
												<td><?php echo $row[5]+$row[6]+$row[7]?></td>
												<td><?php echo $row[8]+$row[9]+$row[10]?></td>
												<td><?php echo $row[11]+$row[12]+$row[13]?></td>
                                                <td><?php echo $row[14]+$row[15]+$row[16]?></td>
                                                <td class="text-right">
                                                <a href="?details&id=<?php echo $_GET['id']?>&idn=<?php echo $row[0];?>"><button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Detalles de la necesidad"><i class="md md-info" style="color: rgb(36, 87, 231);"></i></button></a>
                                         <a href="?edit&id=<?php echo $_GET['id']?>&idn=<?php echo $row[0];?>">       
										<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Editar necesidad"><i class="fa fa-pencil" style="color:  rgb(75, 231, 36);"></i></button>
                                        </a>
                                        <a href="javascript: eliminarRegistro(<?php echo $_GET['id']?>,<?php echo $row[0];?>)">       
										<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar personal"><i class="md md-delete" style="color:  rgb(255, 0, 0);"></i></button>
                                        </a>
												</td>
											</tr>				
<?php
			}
		}
	mysqli_close($link);
?>
											
										</tbody>
									</table>
								</div><!--end .table-responsive -->
                                </div></div>
							</div><!--end .col -->
						</div>
						<!--end .row -->
					</div><!--end .section-body -->
                    
				
<?php
	}
?>
				</section>
			</div><!--end #content-->
			<!-- END CONTENT -->

			<!-- BEGIN MENUBAR-->
			<div id="menubar" class="menubar-inverse ">
				<div class="menubar-fixed-panel">
					<div>
						<a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
							<i class="fa fa-bars"></i>
						</a>
					</div>
					<div class="expanded">
						<a href="index.php">
							<span class="text-lg text-bold text-primary ">SISTEMA&nbsp;POI</span>
						</a>
					</div>
				</div>
				<div class="menubar-scroll-panel">

					<!-- BEGIN MAIN MENU -->
					<ul id="main-menu" class="gui-controls">

						<!-- BEGIN DASHBOARD -->
						<li>
							<a href="../index.php">
								<div class="gui-icon"><i class="md md-home"></i></div>
								<span class="title">Inicio</span>
							</a>
						</li><!--end /menu-li -->
						<!-- END DASHBOARD -->

						<!-- BEGIN EMAIL -->
                        <li>
							<a href="../assets/docs/estructura_organica.pdf" target="_blank">
								<div class="gui-icon"><i class="fa fa-sitemap"></i></div>
								<span class="title">Estructura organica</span>
							</a>
						</li><!--end /menu-li -->
                        <li>
							<a href="../assets/docs/objetivos_poi_2016.pdf" target="_blank">
								<div class="gui-icon"><i class="md md-share"></i></div>
								<span class="title">Objetivos POI</span>
							</a>
						</li>
                        <li>
							<a href="../assets/docs/unidad_medida_metas_operativas.pdf" target="_blank" >
								<div class="gui-icon"><i class="fa fa-heartbeat"></i></div>
								<span class="title">Unidades Medida</span>
							</a>
						</li>
                        <li>
							<a href="#" class="active">
								<div class="gui-icon"><i class="fa fa-list-ol"></i></div>
								<span class="title">Programaci&oacute;n de Actividades</span>
							</a>
						</li>
						<!-- BEGIN UI -->
<?php
	if($nivel == "A") {
?>
						<li class="gui-folder">
							<a>
								<div class="gui-icon"><i class="fa fa-gears"></i></div>
								<span class="title">Administraci&oacute;n</span>
							</a>
							<!--start submenu -->
							<ul>
								<li><a href="../administrator/users.php" ><span class="title">Usuarios</span></a></li>
								<li><a href="../administrator/ranking.php"><span class="title">Ranking</span></a></li>
							</ul><!--end /submenu -->
						</li><!--end /menu-li -->
<?php
	}
?>

					</ul><!--end .main-menu -->
					<!-- END MAIN MENU -->

					<div class="menubar-foot-panel">
						<small class="no-linebreak hidden-folded">
							<span class="opacity-75">Copyright &copy; <?php if(date('Y') == "2015"){echo date('Y'); } else { echo "2015 - ".date('Y'); } ?></span> <strong>MPS</strong>
						</small>
					</div>
				</div><!--end .menubar-scroll-panel-->
			</div><!--end #menubar-->
			<!-- END MENUBAR -->

			<!-- BEGIN OFFCANVAS RIGHT -->
			<!--end .offcanvas-->
			<!-- END OFFCANVAS RIGHT -->

		</div><!--end #base-->
		<!-- END BASE -->

		<!-- BEGIN JAVASCRIPT -->
		<script src="../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../assets/js/libs/spin.js/spin.min.js"></script>
		<script src="../assets/js/libs/autosize/jquery.autosize.min.js"></script>
		<script src="../assets/js/libs/moment/moment.min.js"></script>
		<script src="../assets/js/libs/flot/curvedLines.js"></script>
		<script src="../assets/js/libs/jquery-knob/jquery.knob.min.js"></script>
		<script src="../assets/js/libs/sparkline/jquery.sparkline.min.js"></script>
		<script src="../assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
        <script src="../assets/js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="../assets/js/libs/jquery-validation/dist/additional-methods.min.js"></script>
		<script src="../assets/js/libs/d3/d3.min.js"></script>
		<script src="../assets/js/libs/d3/d3.v3.js"></script>
		<script src="../assets/js/libs/rickshaw/rickshaw.min.js"></script>
		<script src="../assets/js/core/source/App.js"></script>
		<script src="../assets/js/core/source/AppNavigation.js"></script>
		<script src="../assets/js/core/source/AppOffcanvas.js"></script>
		<script src="../assets/js/core/source/AppCard.js"></script>
		<script src="../assets/js/core/source/AppForm.js"></script>
		<script src="../assets/js/core/source/AppNavSearch.js"></script>
		<script src="../assets/js/core/source/AppVendor.js"></script>
		<script src="../assets/js/core/demo/Demo.js"></script>
        <script src="../assets/js/libs/DataTables/jquery.dataTables.min.js"></script>
		<script src="../assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
		<script src="../assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
        <script src="../assets/js/libs/select2/select2.min.js"></script>
        <script src="../assets/js/core/demo/DemoTableDynamic.js"></script>
        <script src="../assets/js/core/demo/DemoFormComponents.js"></script>
        <script>
			function validateForm(){
				if($('#e1').val() == $('#estd').val() && $('#e2').val() == $('#fund').val() && $('#e3').val() == $('#casd').val() && $('#e4').val() == $('#estp').val() && $('#e5').val() == $('#casp').val() && $('#e6').val() == $('#snpp').val() && $('#e7').val() == $('#estt').val() && $('#e8').val() == $('#cast').val() && $('#e9').val() == $('#snpt').val() && $('#e10').val() == $('#esta').val() && $('#e11').val() == $('#casa').val() && $('#e12').val() == $('#snpa').val() && $('#e13').val() == $('#esto').val() && $('#e14').val() == $('#caso').val() && $('#e15').val() == $('#snpo').val()){
					alert("No se detectaron cambios");
					return false;
				}
				else{
					return true;
				}
				return false;
			}
			function eliminarRegistro(id, idn){
				confirmar = confirm("¿En serio desea eliminar el registro, una vez hecho ello no hay forma de recuperarlo.?")
				if(confirmar){
					window.location.href="crudstaff.php?delete=N&id="+id+"&idn="+idn;
				}
			}
		</script>
		<!-- END JAVASCRIPT -->
<div id="flotante2">
                    	<span>
                                	Municipalidad Provincial del Santa
                                </span>
                    </div>
                    <div id="flotante">
                            	<span>
                                	Gerencia de Planeamiento y Presupuesto
                                </span>
                    </div>
                    <div id="flotante3">
                    	<img src="../assets/img/logo_30_30.png"/>&nbsp;<img src="../assets/img/pescadito.png"/>
                    </div>
	</body>
</html>




<?php
	}
	else{
		header("Location: ../login.php");
	}
?>