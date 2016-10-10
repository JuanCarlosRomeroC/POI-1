<?php
	session_start();
	require('settings/connection.php');
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
		<link type="text/css" rel="stylesheet" href="assets/css/theme-default/bootstrap.css?1422792965" />
		<link type="text/css" rel="stylesheet" href="assets/css/theme-default/materialadmin.css?1425466319" />
		<link type="text/css" rel="stylesheet" href="assets/css/theme-default/font-awesome.min.css?1422529194" />
		<link type="text/css" rel="stylesheet" href="assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
		<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/rickshaw/rickshaw.css?1422792967" />
		<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/morris/morris.core.css?1420463396" />
        <link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
        <link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/DataTables/jquery.dataTables.css?1423553989" />
		<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/DataTables/extensions/dataTables.colVis.css?1423553990" />
		<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css?1423553990" />
		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="assets/js/libs/utils/respond.min.js?1403934956"></script>
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
								<a href="html/dashboards/dashboard.html">
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
								<img src="assets/img/user.png" alt="" />
								<span class="profile-info">
									<?php echo substr($_SESSION['poimps'], 6)?>
								</span>
							</a>
							<ul class="dropdown-menu animation-dock">
								<li><a href="profile/profile.php">Mi perfil</a></li>
								<li class="divider"></li>
								<li><a href="login.php?logout"><i class="fa fa-fw fa-power-off text-danger"></i> Salir</a></li>
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
					<div class="section-body">
                    	<div class="row">
							<!-- BEGIN ALERT - TIME ON SITE -->
<?php
	if($nivel != "A") {
?>
							<div class="col-md-6 col-sm-12">
								<div class="card card-outlined style-success">
									<div class="card-body no-padding">
										<div class="alert alert-callout alert-success no-margin">
											<h1 class="pull-right text-success"><i class="fa fa-list-ol"></i></h1>
<?php
	$link = $conn->conectarBD();
	if($subgerencia == ''){
		$query = "CALL sp_getActivities('G', 0, '".$idgerencia."')";
	}
	else{
		$query = "CALL sp_getActivities('S','".$idsubgerencia."', '".$idgerencia."')";
	}
		$result = mysqli_query($link, $query);
		$row = mysqli_num_rows($result);
?>
                                            
                                            
                                            
											<strong class="text-xl"><?php echo $row;?> &nbsp; Actividades programadas para el año <?php echo (date('Y') + 1)?></strong><br/>
											<span class="opacity-50">Programaci&oacute;n de actividades y proyectos que se realizaran por la <strong><?php if($subgerencia==''){echo $gerencia;}else{echo $subgerencia;}?>.</strong> </span>
<?php
	mysqli_close($link);
?>
										</div>
									</div><!--end .card-body -->
								</div><!--end .card -->
                                
							</div><!--end .col -->

                            <div class="col-sm-3 col-sm-offset-3">
                            	<div class="card card-outlined style-info">
									<div class="card-body">
										<form class="form">
											<div id="demo-date-inline"></div>
										</form>
									</div><!--end .card-body -->
								</div><!--end .card -->
                            </div>
							<!-- END ALERT - TIME ON SITE -->
						</div>

                        <hr class="col-sm-8" size="3" style="top:-190px;">
                        <div class="row">
                        <div class="col-sm-9" style="top:-180px;">
                        	<div class="card card-outlined style-danger" >
									<div class="card-body no-padding">
										<div class="alert alert-callout alert-danger no-margin">
											<h1 class="pull-right text-danger"><i class="md md-local-parking"></i><i class="md md-tonality "></i><i class="md md-more-vert "></i></h1>
											<strong class="text-xl">Bienvenido (a) <?php echo substr($_SESSION['poimps'], 6)?></strong><br/>
											<span class="opacity-50">Este es el sistema para ayudarle a gestionar el <strong>PLAN OPERATIVO INSTITUCIONAL</strong> de la  <strong><?php if($subgerencia==''){echo $gerencia;}else{echo $subgerencia;}?></strong>, a la que su digna persona pertenece.</span>
<?php
	mysqli_close($link);
?>
										</div>
									</div><!--end .card-body -->
								</div>
                        
                        </div>
                       
	                       
                        </div> 
<?php
	}else{
?> 
						<div class="row">
                        	 <div class="col-sm-9">
                                <div class="card card-outlined style-danger" >
                                        <div class="card-body no-padding">
                                            <div class="alert alert-callout alert-danger no-margin">
                                                <h1 class="pull-right text-danger"><i class="md md-local-parking"></i><i class="md md-tonality "></i><i class="md md-more-vert "></i></h1>
                                                <strong class="text-xl">Bienvenido (a) <?php echo substr($_SESSION['poimps'], 6)?></strong><br/>
                                                <span class="opacity-50">Este es el sistema POI.</span>
                                            </div>
                                        </div><!--end .card-body -->
                                </div>
                        	</div>
                            <div class="col-sm-3">
                            	<div class="card card-outlined style-success">
									<div class="card-body">
										<form class="form">
											<div id="demo-date-inline"></div>
										</form>
									</div><!--end .card-body -->
								</div><!--end .card -->
                            </div>
                            <div class="col-sm-9" style="top: -150px;">
                            	<div class="card card-outlined">
                                	<div class="card-head">
                                    	<header>Gerencias y Subgerencias y el n&uacute;mero de actividades</header>
                                    </div>
                                	<div class="card-body">
								<div class="table-responsive">
									<table id="datatable1" class="table table-hover">
										<thead>
											<tr>
												<th>Nº de actividades</th>
												<th>Descripci&oacute;n del &aacute;rea</th>
                                                <th class="center">Generar reporte</th>
											</tr>
										</thead>
										<tbody>
                                        	
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getRanking('G')";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_array($result)){
?>
											<tr <?php if($row[0] == '0'){ ?> class="danger"<?php }else{?>class="success"<?php }?>>
												<td><?php echo $row[0]; ?></td>
												<td><?php echo $row[1]; ?></td>
                                                <td class="center"><a href="administrator/reporteexcelpoi.php?sub&ger=<?php echo $row[1]?>&ids&idg=<?php echo $row[2]?>"><button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Reporte Excel"><i class="fa fa-file-excel-o"></i></button></a></td>
											</tr>
<?php
		}
	}
	mysqli_close($link);
?>
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getRanking('S')";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_array($result)){
?>
											<tr  <?php if($row[0] == '0'){ ?> class="danger"<?php }else{?>class="success"<?php }?>>
												<td><?php echo $row[0]; ?></td>
												<td><?php echo $row[1]; ?></td>
                                                <td class="center"><a href="administrator/reporteexcelpoi.php?sub=<?php echo $row[1]?>&ger&ids=<?php echo $row[2]?>&idg"><button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Reporte Excel"><i class="fa fa-file-excel-o"></i></button></a></td>
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
                            </div>
                        </div>	
<?php
	}
?>
			<!--end .row -->
					</div><!--end .section-body -->
                    
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
							<a href="index.php" class="active">
								<div class="gui-icon"><i class="md md-home"></i></div>
								<span class="title">Inicio</span>
							</a>
						</li><!--end /menu-li -->
						<!-- END DASHBOARD -->

						<!-- BEGIN EMAIL -->

						<li>
							<a href="assets/docs/estructura_organica.pdf" target="_blank">
								<div class="gui-icon"><i class="fa fa-sitemap"></i></div>
								<span class="title">Estructura organica</span>
							</a>
						</li><!--end /menu-li -->
                        <li>
							<a href="assets/docs/objetivos_poi_2016.pdf" target="_blank">
								<div class="gui-icon"><i class="md md-share"></i></div>
								<span class="title">Objetivos POI</span>
							</a>
						</li>
                        <li>
							<a href="assets/docs/unidad_medida_metas_operativas.pdf" target="_blank" >
								<div class="gui-icon"><i class="fa fa-heartbeat"></i></div>
								<span class="title">Unidades Medida</span>
							</a>
						</li>
<?php
	if($nivel != "A") {
?>
                        <li>
							<a href="programming/activities.php">
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
								<li><a href="administrator/users.php" ><span class="title">Usuarios</span></a></li>
								<li><a href="administrator/ranking.php"><span class="title">Ranking</span></a></li>
                                <li><a href="administrator/unimedida.php"><span class="title">Unidades de Medida</span></a></li>
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
		<script src="assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="assets/js/libs/spin.js/spin.min.js"></script>
		<script src="assets/js/libs/autosize/jquery.autosize.min.js"></script>
		<script src="assets/js/libs/moment/moment.min.js"></script>
		<script src="assets/js/libs/flot/curvedLines.js"></script>
		<script src="assets/js/libs/jquery-knob/jquery.knob.min.js"></script>
		<script src="assets/js/libs/sparkline/jquery.sparkline.min.js"></script>
		<script src="assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
        <script src="assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
		<script src="assets/js/libs/d3/d3.min.js"></script>
		<script src="assets/js/libs/d3/d3.v3.js"></script>
		<script src="assets/js/libs/rickshaw/rickshaw.min.js"></script>
		<script src="assets/js/core/source/App.js"></script>
		<script src="assets/js/core/source/AppNavigation.js"></script>
		<script src="assets/js/core/source/AppOffcanvas.js"></script>
		<script src="assets/js/core/source/AppCard.js"></script>
		<script src="assets/js/core/source/AppForm.js"></script>
		<script src="assets/js/core/source/AppNavSearch.js"></script>
		<script src="assets/js/core/source/AppVendor.js"></script>
        <script src="assets/js/libs/DataTables/jquery.dataTables.min.js"></script>
        <script src="assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
		<script src="assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="assets/js/core/demo/Demo.js"></script>
        <script src="assets/js/core/demo/DemoTableDynamic.js"></script>
        <script src="assets/js/core/demo/DemoFormComponents.js"></script>
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
                    	<img src="assets/img/logo_30_30.png"/>&nbsp;<img src="assets/img/pescadito.png"/>
                    </div>
	</body>
</html>




<?php
	}
	else{
		header("Location: login.php");
	}
?>