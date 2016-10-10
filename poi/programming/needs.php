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
	if(isset($_GET['newneed']) && !isset($_GET['edit']) && !isset($_GET['details'])){
?>
							<li><a href="?id=<?php echo $_GET['id']?>">Cuadro de Necesidades</a></li>
                            <li class="active">Nueva Necesidad</li>
<?php
	}else if(!isset($_GET['newneed']) && isset($_GET['edit']) && !isset($_GET['details'])){
?>
							<li><a href="?id=<?php echo $_GET['id']?>">Cuadro de Necesidades</a></li>
                            <li class="active">Editar Necesidad</li>
<?php
	}else if(!isset($_GET['newneed']) && !isset($_GET['edit']) && isset($_GET['details'])){
?>
							<li><a href="?id=<?php echo $_GET['id']?>">Cuadro de Necesidades</a></li>
                            <li class="active">Detalles de la Necesidad</li>
<?php
	}else {
?>
							<li class="active">Cuadro de Necesidades</li>
<?php } ?>
						</ol>
					</div>
                    <div class="section-header">
						<h2 style="color: rgb(169, 43, 46); text-shadow: 1px 1.5px rgb(51, 51, 51);">Cuadro de necesidades de bienes y servicios</h2>
					</div>
<!--  NUEVA ACTIVIDAD -->
<?php
	if(isset($_GET['newneed']) && !isset($_GET['edit']) && !isset($_GET['details'])){
?>
					<div class="section-body ">
                    	<div class="col-lg-offset-1 col-md-10">
								<form class="form form-validate floating-label" novalidate method="post" action="crudneed.php" onSubmit="return validateForm()">
                                	<input type="hidden" name="actividad" value="<?php echo $_GET['id']?>">
									<div class="card">
                                    	<div class="card-head style-primary">
											<header>Nueva Necesidad</header>
										</div>
										<div class="card-body">
                                            <div class="form-group">
												<input type="text" class="form-control" id="descripcion" name="descripcion" required data-rule-minlength="2">
												<label for="descripcion">Descripci&oacute;n</label>
											</div>
                                            <p>Cantidad de bienes y servicios por mes</p>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="enero" name="enero" data-rule-digits="true" required value="0" onBlur="contar()">
                                                <label for="enero" class="control-label">Enero</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="febrero" name="febrero" data-rule-digits="true" required value="0" onBlur="contar()">
                                                <label for="febrero" class="control-label">Febrero</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="marzo" name="marzo" data-rule-digits="true" required value="0" onBlur="contar()">
                                                <label for="marzo" class="control-label">Marzo</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="abril" name="abril" data-rule-digits="true" required value="0" onBlur="contar()">
                                                <label for="abril" class="control-label">Abril</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="mayo" name="mayo" data-rule-digits="true" required value="0" onBlur="contar()">
                                                <label for="mayo" class="control-label">Mayo</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="junio" name="junio" data-rule-digits="true" required value="0" onBlur="contar()">
                                                <label for="junio" class="control-label">Junio</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="julio" name="julio" data-rule-digits="true" required value="0" onBlur="contar()">
                                                <label for="julio" class="control-label">Julio</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="agosto" name="agosto" data-rule-digits="true" required value="0" onBlur="contar()">
                                                <label for="agosto" class="control-label">Agosto</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="setiembre" name="setiembre" data-rule-digits="true" required value="0" onBlur="contar()">
                                                <label for="setiembre" class="control-label">Setiembre</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="octubre" name="octubre" data-rule-digits="true" required value="0" onBlur="contar()">
                                                <label for="octubre" class="control-label">Octubre</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="noviembre" name="noviembre" data-rule-digits="true" required value="0" onBlur="contar()">
                                                <label for="noviembre" class="control-label">Noviembre</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="diciembre" name="diciembre" data-rule-digits="true" required value="0" onBlur="contar()">
                                                <label for="diciembre" class="control-label">Diciembre</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                    
                                                    <select class="form-control select2-list" name="unimedida" id="unimedida" required>
                                                    <option value="">&nbsp;</option>
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getUniMedida()";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_array($result)){
?>
													<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
<?php
		}
	}
	mysqli_close($link);
?>                                        
                                                    </select>
                                                    <label for="unimedida" class="control-label">Unidad de Medida</label>
                                            </div>
                                            <div class="form-group col-sm-12">
												<input type="text" class="form-control static-dirty" id="anual" name="anual" data-rule-number="true" required value="0" readonly>
												<label for="anual">Total anual programado</label>
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
	}else if(!isset($_GET['newneed']) && isset($_GET['edit']) && !isset($_GET['details'])){
?>
					<div class="section-body ">
                    	<div class="col-lg-offset-1 col-md-10">
								<form class="form form-validate floating-label" novalidate method="post" action="crudneed.php" onSubmit="return validateForm2()">
                                	<input type="hidden" name="actividad" value="<?php echo $_GET['id']?>">
                                    <input type="hidden" name="necesidad" value="<?php echo $_GET['idn']?>">
									<div class="card">
                                    	<div class="card-head style-primary">
											<header>Editar Necesidad</header>
										</div>
										<div class="card-body">
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getDetails('N', ".$_GET['idn'].")";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_array($result);
		$d = $row[0];
		$m1 = $row[1];
		$m2 = $row[2];
		$m3 = $row[3];
		$m4 = $row[4];
		$m5 = $row[5];
		$m6 = $row[6];
		$m7 = $row[7];
		$m8 = $row[8];
		$m9 = $row[9];
		$m10 = $row[10];
		$m11 = $row[11];
		$m12 = $row[12];
		$uni = $row[13];
		$t = $row[14];
		$fu = $row[15]; 
	}
?>
		<input type="hidden" id="de" value="<?php echo $d;?>">
        <input type="hidden" id="m1e" value="<?php echo $m1;?>">
        <input type="hidden" id="m2e" value="<?php echo $m2;?>">
        <input type="hidden" id="m3e" value="<?php echo $m3;?>">
        <input type="hidden" id="m4e" value="<?php echo $m4;?>">
        <input type="hidden" id="m5e" value="<?php echo $m5;?>">
        <input type="hidden" id="m6e" value="<?php echo $m6;?>">
        <input type="hidden" id="m7e" value="<?php echo $m7;?>">
        <input type="hidden" id="m8e" value="<?php echo $m8;?>">
        <input type="hidden" id="m9e" value="<?php echo $m9;?>">
        <input type="hidden" id="m10e" value="<?php echo $m10;?>">
        <input type="hidden" id="m11e" value="<?php echo $m11;?>">
        <input type="hidden" id="m12e" value="<?php echo $m12;?>">
        <input type="hidden" id="unie" value="<?php echo $fu;?>">
        <input type="hidden" id="te" value="<?php echo $t;?>">	
                                            <div class="form-group">
												<input type="text" class="form-control" id="descripcion" name="descripcion" required data-rule-minlength="2" value="<?php echo $d;?>">
												<label for="descripcion">Descripci&oacute;n</label>
											</div>
                                            <p>Cantidad de bienes y servicios por mes</p>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="enero" name="enero" data-rule-digits="true" required value="<?php echo $m1;?>">
                                                <label for="enero" class="control-label">Enero</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="febrero" name="febrero" data-rule-digits="true" required value="<?php echo $m2;?>">
                                                <label for="febrero" class="control-label">Febrero</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="marzo" name="marzo" data-rule-digits="true" required value="<?php echo $m3;?>">
                                                <label for="marzo" class="control-label">Marzo</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="abril" name="abril" data-rule-digits="true" required value="<?php echo $m4;?>">
                                                <label for="abril" class="control-label">Abril</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="mayo" name="mayo" data-rule-digits="true" required value="<?php echo $m5;?>">
                                                <label for="mayo" class="control-label">Mayo</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="junio" name="junio" data-rule-digits="true" required value="<?php echo $m6;?>">
                                                <label for="junio" class="control-label">Junio</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="julio" name="julio" data-rule-digits="true" required value="<?php echo $m7;?>">
                                                <label for="julio" class="control-label">Julio</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="agosto" name="agosto" data-rule-digits="true" required value="<?php echo $m8;?>">
                                                <label for="agosto" class="control-label">Agosto</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="setiembre" name="setiembre" data-rule-digits="true" required value="<?php echo $m9;?>">
                                                <label for="setiembre" class="control-label">Setiembre</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="octubre" name="octubre" data-rule-digits="true" required value="<?php echo $m10;?>">
                                                <label for="octubre" class="control-label">Octubre</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="noviembre" name="noviembre" data-rule-digits="true" required value="<?php echo $m11;?>">
                                                <label for="noviembre" class="control-label">Noviembre</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control" id="diciembre" name="diciembre" data-rule-digits="true" required value="<?php echo $m12;?>">
                                                <label for="diciembre" class="control-label">Diciembre</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                    
                                                    <select class="form-control select2-list" name="unimedida" id="unimedida" required>
                                                    <option value="">&nbsp;</option>
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getUniMedida()";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_array($result)){
?>
													<option value="<?php echo $row[0]; ?>" <?php if($row[1] == $uni){?> selected="selected"<?php }?>><?php echo $row[1]; ?></option>
<?php
		}
	}
	mysqli_close($link);
?>                                        
                                                    </select>
                                                    <label for="unimedida" class="control-label">Unidad de Medida</label>
                                            </div>
                                            <div class="form-group col-sm-12">
												<input type="text" class="form-control" id="anual" name="anual" data-rule-number="true" required value="<?php echo $t;?>">
												<label for="anual">Total anual programado</label>
											</div>
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
	}else if(!isset($_GET['newneed']) && !isset($_GET['edit']) && isset($_GET['details'])){
?>
					<div class="section-body ">
                    	<div class="col-lg-offset-1 col-md-10">
								<form class="form floating-label" method="post" action="#">
                                	
									<div class="card">
                                    	<div class="card-head style-primary">
											<header>Detalles de Necesidad</header>
										</div>
										<div class="card-body">
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getDetails('N', ".$_GET['idn'].")";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_array($result);
?>
                                            <div class="form-group">
												<input type="text" class="form-control static dirty" id="desc" name="desc" value="<?php echo $row[0];?>" readonly>
												<label for="descripcion">Descripci&oacute;n</label>
											</div>
                                            <p>Cantidad de bienes y servicios por mes</p>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control static dirty" id="e" name="e" value="<?php echo $row[1];?>" readonly>
                                                <label for="enero" class="control-label">Enero</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control static dirty" id="f" name="f" value="<?php echo $row[2];?>" readonly>
                                                <label for="febrero" class="control-label">Febrero</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control static dirty" id="m" name="m" value="<?php echo $row[3];?>" readonly>
                                                <label for="marzo" class="control-label">Marzo</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control static dirty" id="a" name="a" value="<?php echo $row[4];?>" readonly>
                                                <label for="abril" class="control-label">Abril</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control static dirty" id="ma" name="ma" value="<?php echo $row[5];?>" readonly>
                                                <label for="mayo" class="control-label">Mayo</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control static dirty" id="j" name="j" value="<?php echo $row[6];?>" readonly>
                                                <label for="junio" class="control-label">Junio</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control static dirty" id="ju" name="ju" value="<?php echo $row[7];?>" readonly>
                                                <label for="julio" class="control-label">Julio</label>
                                            </div>
                                             <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control static dirty" id="ag" name="ag" value="<?php echo $row[8];?>" readonly>
                                                <label for="agosto" class="control-label">Agosto</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control static dirty" id="s" name="s" value="<?php echo $row[9];?>" readonly>
                                                <label for="setiembre" class="control-label">Setiembre</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control static dirty" id="o" name="o" value="<?php echo $row[10];?>" readonly>
                                                <label for="octubre" class="control-label">Octubre</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control static dirty" id="n" name="n" value="<?php echo $row[11];?>" readonly>
                                                <label for="noviembre" class="control-label">Noviembre</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                            	<input type="text" class="form-control static dirty" id="d" name="d" value="<?php echo $row[12];?>" readonly>
                                                <label for="diciembre" class="control-label">Diciembre</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                            	<input type="text" class="form-control static dirty" id="uni" name="uni" value="<?php echo $row[13];?>" readonly>
                                                    <label for="unimedida" class="control-label">Unidad de Medida</label>
                                            </div>
                                            <div class="form-group col-sm-12">
												<input type="text" class="form-control static dirty" id="t" name="t" value="<?php echo $row[14];?>" readonly>
												<label for="anual">Total anual programado</label>
											</div>
<?php
	}mysqli_close($link);
?>
										</div><!--end .card-body -->
										<div class="card-actionbar style-primary">
											<div class="card-actionbar-row">
                                            	<a href="?id=<?php echo $_GET['id']?>"><button type="button" class="btn btn-raised btn-default-dark ink-reaction col-sm-2 col-sm-offset-10">Regresar</button></a>
											</div>
										</div><!--end .card-actionbar -->
									</div><!--end .card -->
									<em class="text-caption">Se muestran los detalles de la necesidad.</em>
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
                                            </a>&nbsp; | &nbsp;
                                            <a class="btn" href="?newneed&id=<?php echo $_GET['id']?>">
                                            	<i class="md md-add-circle"></i>&nbsp;Nueva necesidad
                                            </a>
                                    
                                        </div>                                    
                                    </div>
                                    
                                    
                                    
                                	<div class="card-body">
								<div class="table-responsive">
									<table id="datatable1" class="table table-striped table-hover">
										<thead>
											<tr>
												<th>Descripci&oacute;n</th>
												<th>Cantidad total anual</th>
												<th>Unidad Medida</th>
												<th class="sort-numeric">Total anual programado</th>
                                                <th class="text-center">Acciones</th>
											</tr>
										</thead>
										<tbody>
<?php
		$link = $conn->conectarBD();
		$query = "CALL sp_getNeeds(".$_GET['id'].")";
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_array($result)){
?>
											<tr class="gradeX">
												<td><?php echo $row[0]?></td>
												<td><?php echo $row[1]+$row[2]+$row[3]+$row[4]+$row[5]+$row[6]+$row[7]+$row[8]+$row[9]+$row[10]+$row[11]+$row[12]?></td>
												<td><?php echo $row[13]?></td>
												<td><?php echo $row[14]?></td>
                                                <td class="text-right">
                                                <a href="?details&id=<?php echo $_GET['id']?>&idn=<?php echo $row[15];?>"><button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Detalles de la necesidad"><i class="md md-info" style="color: rgb(36, 87, 231);"></i></button></a>
                                         <a href="?edit&id=<?php echo $_GET['id']?>&idn=<?php echo $row[15];?>">       
										<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Editar necesidad"><i class="fa fa-pencil" style="color:  rgb(75, 231, 36);"></i></button>
                                        </a>
                                        <a href="javascript: eliminarRegistro(<?php echo $_GET['id']?>,<?php echo $row[15];?>)">       
										<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar necesidad"><i class="md md-delete" style="color:  rgb(255, 0, 0);"></i></button>
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
							<a href="../assets/docs/objetivos_poi_2016.pdf" target="_blank" >
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
				var u = $('#unimedida').val();
				var total = parseInt($('#enero').val()) + parseInt($('#febrero').val()) + parseInt($('#marzo').val()) + parseInt($('#abril').val()) + parseInt($('#mayo').val()) + parseInt($('#junio').val()) + parseInt($('#julio').val()) + parseInt($('#agosto').val()) + parseInt($('#setiembre').val()) + parseInt($('#octubre').val()) + parseInt($('#noviembre').val()) + parseInt($('#diciembre').val());
				if(u == ''){
					alert("Seleccione unidad de medida");
					return false;
				}
				else if(total == 0){
					alert("La programacion anual no puede ser cero");
					return false;
				}
				else{
					return true;
				}
				return false;
			}
			function validateForm2(){
				if($('#descripcion').val() == $('#de').val() && $('#enero').val() == $('#m1e').val() && $('#febrero').val() == $('#m2e').val() && $('#marzo').val() == $('#m3e').val() && $('#abril').val() == $('#m4e').val() && $('#mayo').val() == $('#m5e').val() && $('#junio').val() == $('#m6e').val() && $('#julio').val() == $('#m7e').val() && $('#agosto').val() == $('#m8e').val() && $('#setiembre').val() == $('#m9e').val() && $('#octubre').val() == $('#m10e').val() && $('#noviembre').val() == $('#m11e').val() && $('#diciembre').val() == $('#m12e').val() && $('#unimedida').val() == $('#unie').val() && $('#anual').val() == $('#te').val()){
					alert("No se detectaron cambios");
					return false;	
				}
				else{
					var u = $('#unimedida').val();
					if(u == ''){
						alert("Seleccione unidad de medida");
						return false;
					}
					else{
						return true;
					}
				}
				return false;
			}
			function eliminarRegistro(id, idn){
				confirmar = confirm("¿En serio desea eliminar el registro, una vez hecho ello no hay forma de recuperarlo.?")
				if(confirmar){
					window.location.href="crudneed.php?delete=N&id="+id+"&idn="+idn;
				}
			}
			function contar(){
				var total = parseInt($('#enero').val()) + parseInt($('#febrero').val()) + parseInt($('#marzo').val()) + parseInt($('#abril').val()) + parseInt($('#mayo').val()) + parseInt($('#junio').val()) + parseInt($('#julio').val()) + parseInt($('#agosto').val()) + parseInt($('#setiembre').val()) + parseInt($('#octubre').val()) + parseInt($('#noviembre').val()) + parseInt($('#diciembre').val());
				$('#anual').val(total);
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