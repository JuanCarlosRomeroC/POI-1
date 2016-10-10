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
<?php
	if(isset($_GET['newactivity']) && !isset($_GET['edit']) && !isset($_GET['details'])){
?>
							<li><a href="?">Actividades</a></li>
                            <li class="active">Nueva Actividad</li>
<?php
	}else if(!isset($_GET['newactivity']) && isset($_GET['edit']) && !isset($_GET['details'])){
?>
							<li><a href="?">Actividades</a></li>
                            <li class="active">Editar Actividad</li>
<?php
	}else if(!isset($_GET['newactivity']) && !isset($_GET['edit']) && isset($_GET['details'])){
?>
							<li><a href="?">Actividades</a></li>
                            <li class="active">Detalles Actividad</li>
<?php
	}else {
?>
							<li class="active">Actividades</li>
<?php } ?>
						</ol>
					</div>
                    <div class="section-header">
						<h2 style="color: rgb(169, 43, 46); text-shadow: 1px 1.5px rgb(51, 51, 51);">Programaci&oacute;n de Actividades y Proyectos</h2>
					</div>
<!--  NUEVA ACTIVIDAD -->
<?php
	if(isset($_GET['newactivity']) && !isset($_GET['edit']) && !isset($_GET['details'])){
?>
					<div class="section-body ">
                    	<div class="col-lg-offset-1 col-md-10">
								<form class="form form-validate floating-label" novalidate method="post" action="crudactivity.php" onSubmit="return validateForm()">
                                	<input type="hidden" name="gerencia" value="<?php echo $idgerencia;?>">
                                    <input type="hidden" name="subgerencia" value="<?php echo $idsubgerencia;?>">
									<div class="card">
                                    	<div class="card-head style-primary">
											<header>Nueva Actividad</header>
										</div>
										<div class="card-body">
                                            <div class="form-group">
                                                    
                                                    <select class="form-control select2-list" name="objetivo" id="objetivo" required>
                                                    <option value="">&nbsp;</option>
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getObjetivos('1', 0)";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_array($result)){
?>		
													<optgroup label="<?php echo $row[1]?>">								
<?php
	$c1 = $conn->conectarBD();
	$q1 = "CALL sp_getObjetivos('2', ".$row[0].")";
	$r1 = mysqli_query($c1, $q1);
	if(mysqli_num_rows($r1) > 0){
		while($f1 = mysqli_fetch_array($r1)){
?>
														<optgroup label="<?php echo $f1[1]?>">
<?php
	$c2 = $conn->conectarBD();
	$q2 = "CALL sp_getObjetivos('3', ".$f1[0].")";
	$r2 = mysqli_query($c2, $q2);
	if(mysqli_num_rows($r2) > 0){
		while($f2 = mysqli_fetch_array($r2)){
?>
															<option value="<?php echo $f2[0]?>"><?php echo $f2[1]?></option>
<?php
		}
	}
	mysqli_close($c2);
?>
														</optgroup>
<?php
		}
	}
	mysqli_close($c1);
?>
													</optgroup>
<?php
		}
	}
	mysqli_close($link);
?>
                                                        
                                                    </select>
                                                    <label for="objetivos" class="control-label">Objetivo</label>
                                            </div>
                                            <div class="form-group">
												<input type="text" class="form-control" id="actividad" name="actividad" required data-rule-minlength="2">
												<label for="Name1">Actividad / proyecto</label>
											</div>
                                            <div class="form-group">
                                                    
                                                    <select class="form-control select2-list" name="unimedida" id="unimedida" required>
                                                    <option value="">&nbsp;</option>
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getUnidadMedida()";
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
                                            <div class="form-group">
												<input type="text" class="form-control" id="cantidad" name="cantidad" data-rule-digits="true" required>
												<label for="digits2">Cantidad</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group">
												<textarea name="resultado" id="resultado" class="form-control" rows="2" required></textarea>
												<label for="textarea1">Resultado</label>
											</div>
                                             <div class="form-group col-sm-3">
												<input type="text" class="form-control" id="trii" name="trii" data-rule-digits="true" required>
												<label for="trii">Trimestre I</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group col-sm-3">
												<input type="text" class="form-control" id="triii" name="triii" data-rule-digits="true" required>
												<label for="triii">Trimestre II</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group col-sm-3">
												<input type="text" class="form-control" id="triiii" name="triiii" data-rule-digits="true" required>
												<label for="triiii">Trimestre III</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group col-sm-3">
												<input type="text" class="form-control" id="triiv" name="triiv" data-rule-digits="true" required>
												<label for="triiv">Trimestre IV</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group col-sm-12">
												<input type="text" class="form-control" id="responsable" name="responsable" required>
												<label for="responsable">Responsable</label>
											</div>
										</div><!--end .card-body -->
										<div class="card-actionbar style-primary">
											<div class="card-actionbar-row">
                                            	<a href="?"><button type="button" class="btn btn-raised btn-default-dark ink-reaction col-sm-2">Cancelar</button></a>
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
	}else if(!isset($_GET['newactivity']) && isset($_GET['edit']) && !isset($_GET['details'])){
?>
					<div class="section-body ">
                    	<div class="col-lg-offset-1 col-md-10">
								<form class="form form-validate floating-label" novalidate method="post" action="crudactivity.php" onSubmit="return validateForm2()">
                                	<input type="hidden" name="gerencia" value="<?php echo $idgerencia;?>">
                                    <input type="hidden" name="subgerencia" value="<?php echo $idsubgerencia;?>">
                                    <input type="hidden" name="idact" value="<?php echo $_GET['id'];?>">
									<div class="card">
                                    	<div class="card-head style-primary">
											<header>Editar Actividad</header>
										</div>
										<div class="card-body">
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getDetails('A', ".$_GET['id'].")";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_array($result);
		$o = $row[0];
		$a = $row[1];
		$u = $row[2];
		$c = $row[3];
		$r = $row[4];
		$t1 = $row[5];
		$t2 = $row[6];
		$t3 = $row[7];
		$t4 = $row[8];
		$re = $row[9];
		$oo = $row[10];
		$uu = $row[11];
	}
	mysqli_close();
?>
		<input type="hidden" name="oe" id="oe" value="<?php echo $oo?>">
        <input type="hidden" name="aa" id="ae" value="<?php echo $a?>">
        <input type="hidden" name="ue" id="ue" value="<?php echo $uu?>">
        <input type="hidden" name="ce" id="ce" value="<?php echo $c?>">
        <input type="hidden" name="re" id="re" value="<?php echo $r?>">
        <input type="hidden" name="t1e" id="t1e" value="<?php echo $t1?>">
        <input type="hidden" name="t2e" id="t2e" value="<?php echo $t2?>">
        <input type="hidden" name="t3e" id="t3e" value="<?php echo $t3?>">
        <input type="hidden" name="t4e" id="t4e" value="<?php echo $t4?>">
        <input type="hidden" name="ree" id="ree" value="<?php echo $re?>">
                                            <div class="form-group">
                                                    
                                                    <select class="form-control select2-list" name="objetivo" id="objetivo" required>
                                                    <option value="">&nbsp;</option>
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getObjetivos('1', 0)";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_array($result)){
?>		
													<optgroup label="<?php echo $row[1]?>">								
<?php
	$c1 = $conn->conectarBD();
	$q1 = "CALL sp_getObjetivos('2', ".$row[0].")";
	$r1 = mysqli_query($c1, $q1);
	if(mysqli_num_rows($r1) > 0){
		while($f1 = mysqli_fetch_array($r1)){
?>
														<optgroup label="<?php echo $f1[1]?>">
<?php
	$c2 = $conn->conectarBD();
	$q2 = "CALL sp_getObjetivos('3', ".$f1[0].")";
	$r2 = mysqli_query($c2, $q2);
	if(mysqli_num_rows($r2) > 0){
		while($f2 = mysqli_fetch_array($r2)){
?>
															<option value="<?php echo $f2[0]?>"<?php if($f2[1] == $o){?> selected="selected"<?php }?>><?php echo $f2[1]?></option>
<?php
		}
	}
	mysqli_close($c2);
?>
														</optgroup>
<?php
		}
	}
	mysqli_close($c1);
?>
													</optgroup>
<?php
		}
	}
	mysqli_close($link);
?>
                                                        
                                                    </select>
                                                    <label for="objetivos" class="control-label">Objetivo</label>
                                            </div>
                                            <div class="form-group">
												<input type="text" class="form-control" id="actividad" name="actividad" required data-rule-minlength="2" value="<?php echo $a;?>">
												<label for="Name1">Actividad / proyecto</label>
											</div>
                                            <div class="form-group">
                                                    
                                                    <select class="form-control select2-list" name="unimedida" id="unimedida" required>
                                                    <option value="">&nbsp;</option>
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getUnidadMedida()";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_array($result)){
?>
													<option value="<?php echo $row[0]; ?>" <?php if($row[1] == $u) {?> selected="selected"<?php }?>><?php echo $row[1]; ?></option>
<?php
		}
	}
	mysqli_close($link);
?>                                        
                                                    </select>
                                                    <label for="unimedida" class="control-label">Unidad de Medida</label>
                                            </div>
                                            <div class="form-group">
												<input type="text" class="form-control" id="cantidad" name="cantidad" data-rule-digits="true" required value="<?php echo $c;?>">
												<label for="digits2">Cantidad</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group">
												<textarea name="resultado" id="resultado" class="form-control" rows="2" required><?php echo $r;?></textarea>
												<label for="textarea1">Resultado</label>
											</div>
                                             <div class="form-group col-sm-3">
												<input type="text" class="form-control" id="trii" name="trii" data-rule-digits="true" required value="<?php echo $t1;?>">
												<label for="trii">Trimestre I</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group col-sm-3">
												<input type="text" class="form-control" id="triii" name="triii" data-rule-digits="true" required value="<?php echo $t2;?>">
												<label for="triii">Trimestre II</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group col-sm-3">
												<input type="text" class="form-control" id="triiii" name="triiii" data-rule-digits="true" required value="<?php echo $t3;?>">
												<label for="triiii">Trimestre III</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group col-sm-3">
												<input type="text" class="form-control" id="triiv" name="triiv" data-rule-digits="true" required value="<?php echo $t4;?>">
												<label for="triiv">Trimestre IV</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group col-sm-12">
												<input type="text" class="form-control" id="responsable" name="responsable" required value="<?php echo $re;?>">
												<label for="responsable">Responsable</label>
											</div>
										</div><!--end .card-body -->
										<div class="card-actionbar style-primary">
											<div class="card-actionbar-row">
                                            	<a href="?"><button type="button" class="btn btn-raised btn-default-dark ink-reaction col-sm-2">Cancelar</button></a>
												<button type="submit" class="btn btn-raised btn-success ink-reaction col-sm-2 col-sm-offset-8" name="editar">Guardar Cambios</button>
											</div>
										</div><!--end .card-actionbar -->
									</div><!--end .card -->
									<em class="text-caption">Debe completar todos los campos</em>
								</form>
							</div>
                    </div>
<!-- DETALLES DE LA ACTIVIDAD -->
<?php
	}else if(!isset($_GET['newactivity']) && !isset($_GET['edit']) && isset($_GET['details'])){
?>
					<div class="section-body ">
                    	<div class="col-lg-offset-1 col-md-10">
								<form class="form floating-label" method="post" action="#">
									<div class="card">
                                    	<div class="card-head style-primary">
											<header>Detalles de Actividad</header>
										</div>
										<div class="card-body">
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getDetails('A', ".$_GET['id'].")";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_array($result);
?>
                                            <div class="form-group">
                                            	<input type="text" class="form-control static dirty" id="objetivo" name="objetivo" readonly value="<?php echo $row[0];?>">
                                                    <label for="objetivos" class="control-label">Objetivo</label>
                                            </div>
                                            <div class="form-group">
												<input type="text" class="form-control static dirty" id="actividad" name="actividad" value="<?php echo $row[1];?>" readonly>
												<label for="Name1">Actividad / proyecto</label>
											</div>
                                            <div class="form-group">
                                                    <input type="text" class="form-control static dirty" id="unim" name="unim" readonly value="<?php echo $row[2];?>">
                                                    <label for="unimedida" class="control-label">Unidad de Medida</label>
                                            </div>
                                            <div class="form-group">
												<input type="text" class="form-control static dirty" id="cant" name="cant" readonly value="<?php echo $row[3];?>">
												<label for="digits2">Cantidad</label>
											</div>
                                            <div class="form-group">
												<textarea name="resultado" id="resultado" class="form-control static dirty" readonly rows="2"><?php echo $row[4];?></textarea>
												<label for="textarea1">Resultado</label>
											</div>
                                             <div class="form-group col-sm-3">
												<input type="text" class="form-control static dirty" id="cant" name="cant" readonly value="<?php echo $row[5];?>">
												<label for="trii">Trimestre I</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group col-sm-3">
												<input type="text" class="form-control static dirty" id="cant" name="cant" readonly value="<?php echo $row[6];?>">
												<label for="triii">Trimestre II</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group col-sm-3">
												<input type="text" class="form-control static dirty" id="cant" name="cant" readonly value="<?php echo $row[7];?>">
												<label for="triiii">Trimestre III</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group col-sm-3">
												<input type="text" class="form-control static dirty" id="cant" name="cant" readonly value="<?php echo $row[8];?>">
												<label for="triiv">Trimestre IV</label>
												<p class="help-block">Solamente n&uacute;meros</p>
											</div>
                                            <div class="form-group col-sm-12">
												<input type="text" class="form-control static dirty" id="cant" name="cant" readonly value="<?php echo $row[9];?>">
												<label for="responsable">Responsable</label>
											</div>
<?php
	}
	mysqli_close($link);
?>
										</div><!--end .card-body -->
										<div class="card-actionbar style-primary">
											<div class="card-actionbar-row">
                                            	<a href="?"><button type="button" class="btn btn-raised btn-default-dark ink-reaction col-sm-2 col-sm-offset-10">Regresar</button></a>
											</div>
										</div><!--end .card-actionbar -->
                                        
									</div><!--end .card -->
									<em class="text-caption">Se muestran los detalles de la actividad.</em>
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
                                	
                                	<strong>Exito!</strong> la operaci&oacute;n se ejecuto con exito.
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
                                    	<header>Lista de Actividades y/o Proyecto</header>
                                        <div class="tools" style="width:370px;">
                                            <a class="btn" href="?newactivity">
                                            	<i class="md md-add-circle"></i>&nbsp;Nueva Actividad
                                            </a>
                                            &nbsp;|&nbsp;
                                            <a class="btn" href="../administrator/reporteexcelpoi.php?sub=<?php echo $subgerencia?>&ger=<?php echo $gerencia?>&ids=<?php echo $idsubgerencia?>&idg=<?php echo $idgerencia?>">
                                            	<i class="fa fa-file-text"></i>&nbsp;Reporte General
                                            </a>
                                    
                                        </div>                                    
                                    </div>
                                    
                                    
                                    
                                	<div class="card-body">
								<div class="table-responsive">
									<table id="datatable1" class="table table-striped table-hover">
										<thead>
											<tr>
												<th>Objetivos Especificos</th>
												<th>Actividad / Proyecto</th>
												<th>Unidad Medida</th>
												<th class="sort-numeric">Cantidad</th>
                                                <th class="text-center">Acciones</th>
											</tr>
										</thead>
										<tbody>
<?php
	$link = $conn->conectarBD();
	if($subgerencia == ''){
		$query = "CALL sp_getActivities('G', 0, '".$idgerencia."')";
	}
	else{
		$query = "CALL sp_getActivities('S','".$idsubgerencia."', 0)";
	}
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_array($result)){
?>
											<tr class="gradeX">
												<td><?php echo $row[0]?></td>
												<td><?php echo $row[1]?></td>
												<td><?php echo $row[2]?></td>
												<td><?php echo $row[3]?></td>
                                                <td class="text-right">
                                                <a href="?details&id=<?php echo $row[4];?>"><button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Detalles de la actividad"><i class="md md-info" style="color: rgb(36, 87, 231);"></i></button></a>
										<a href="?edit&id=<?php echo $row[4];?>"><button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Editar actividad"><i class="fa fa-pencil" style="color:  rgb(75, 231, 36);"></i></button></a>
										<a href="needs.php?id=<?php echo $row[4]?>"><button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Cuadro de necesidades"><i class="md md-attach-file" style="color: rgb(231, 77, 36);"></i></button></a>
										<a href="staff.php?id=<?php echo $row[4]?>"><button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Cuadro de personal"><i class="md md-person" style="color: rgb(0, 0, 0);"></i></button></a>
                                        <a href="javascript: eliminarRegistro(<?php echo $row[4];?>)">       
										<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar actividad"><i class="md md-delete" style="color:  rgb(255, 0, 0);"></i></button>
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
							<a href="../assets/docs/unidad_medida_metas_operativas.pdf" target="_blank">
								<div class="gui-icon"><i class="fa fa-heartbeat"></i></div>
								<span class="title">Unidades Medida</span>
							</a>
						</li>
<?php
	if($nivel != "A") {
?>
                        <li>
							<a href="#" class="active">
								<div class="gui-icon"><i class="fa fa-list-ol"></i></div>
								<span class="title">Programaci&oacute;n de Actividades</span>
							</a>
						</li>
<?php
	}
?>
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
				var o = $('#objetivo').val();
				var u = $('#unimedida').val();
				var c = $('#cantidad').val();
				var tri = parseInt($('#trii').val()) + parseInt($('#triii').val()) + parseInt($('#triiii').val()) + parseInt($('#triiv').val());
				
				if(o == '' && u == ''){
					alert("Seleccione su objetivo y unidad de medida");
					return false;
				}
				else if(o == ''){
					alert("Seleccione su objetivo");
					return false;
				}
				else if(u == ''){
					alert("Seleccione unidad de medida");
					return false;
				}
				else if(c != String(tri)){
					alert("La cantidad debe concordar con la programación trimestral");
					return false;
				}
				else{
					return true;
				}
				return false;
			}
			function validateForm2(){
				if($('#objetivo').val() == $('#oe').val() && $('#actividad').val() == $('#ae').val() && $('#unimedida').val() == $('#ue').val() && $('#cantidad').val() == $('#ce').val() && $('#resultado').val() == $('#re').val() && $('#trii').val() == $('#t1e').val() && $('#triii').val() == $('#t2e').val() && $('#triiii').val() == $('#t3e').val() && $('#triiv').val() == $('#t4e').val() && $('#responsable').val() == $('#ree').val()){
					
					alert("No se detectaron cambios");return false;
				}
				else{
					var o = $('#objetivo').val();
					var u = $('#unimedida').val();
					var c = $('#cantidad').val();
					var tri = parseInt($('#trii').val()) + parseInt($('#triii').val()) + parseInt($('#triiii').val()) + parseInt($('#triiv').val());
					if(o == '' && u == ''){
					alert("Seleccione su objetivo y unidad de medida");
					return false;
					}
					else if(o == ''){
						alert("Seleccione su objetivo");
						return false;
					}
					else if(u == ''){
						alert("Seleccione unidad de medida");
						return false;
					}
					else if(c != String(tri)){
						alert("La cantidad debe concordar con la programación trimestral");
						return false;
					}
					else{
						return true;
					}
				}
				return false;
				
			}
			function eliminarRegistro(ida){
				confirmar = confirm("¿En serio desea eliminar el registro, una vez hecho ello no hay forma de recuperarlo.?")
				if(confirmar){
					window.location.href="crudactivity.php?delete=N&id="+ida;
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