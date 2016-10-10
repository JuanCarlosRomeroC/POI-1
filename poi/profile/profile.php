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
								<li><a href="#">Mi perfil</a></li>
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
                            <li class="active">Mi perfil</li>
						</ol>
					</div>
                    <div class="section-header">
						<h2 style="color: rgb(169, 43, 46); text-shadow: 1px 1.5px rgb(51, 51, 51);">Mi perfil</h2>
					</div>
                    <div class="section-body">

<?php
	if(isset($_GET['exi'])){
?>
                        <div class="row">
                        	<div class="col-sm-12">	
                            	<div class="alert alert-success" role="alert">
                                	
                                	<strong>Exito!</strong> la contraseña se cambio correctamente.
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
                    
                    
                    
                    
<?php
	$link = $conn->conectarBD();
	if($subgerencia == ''){
		$query = "CALL sp_getProfile('G', '".substr($_SESSION['poimps'], 0,5)."')";
	}
	else{
		$query = "CALL sp_getProfile('S', '".substr($_SESSION['poimps'], 0,5)."')";
	}
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_array($result);
	}
?>
                    	<div class="row">
                        	<div class="col-md-6">
                            	<div class="card card-underline card-outlined">
                                	<div class="card-head">
                                    	<header>Datos Personales</header>
                                	</div>
									<div class="card-body">
                                        <form class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label for="dollars17" class="col-sm-4 control-label">Nombre completo</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user fa-lg"></i></span>
                                                        <div class="input-group-content">
                                                            <input type="text" class="form-control static-dirty" id="dollars17" readonly value="<?php echo $row[0];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end .form-group -->
                                            <div class="form-group">
                                                <label for="dollars17" class="col-sm-4 control-label">Email</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class=" md md-email  fa-lg"></i></span>
                                                        <div class="input-group-content">
                                                            <input type="text" class="form-control static-dirty" id="dollars17" readonly value="<?php echo $row[1];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end .form-group -->
                                        </form>
                                    </div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                            	<div class="card card-underline card-outlined">
                                	<div class="card-head">
                                    	<header>Datos Institucionales</header>
                                	</div>
									<div class="card-body">
                                        <form class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label for="dollars17" class="col-sm-4 control-label">Gerencia</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="md md-view-module   fa-lg"></i></span>
                                                        <div class="input-group-content">
                                                            <input type="text" class="form-control static-dirty" id="dollars17" readonly value="<?php echo $row[2];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end .form-group -->
                                            <div class="form-group">
                                                <label for="dollars17" class="col-sm-4 control-label">Subgerencia</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="md md-view-list  fa-lg"></i></span>
                                                        <div class="input-group-content">
                                                            <input type="text" class="form-control static-dirty" id="dollars17" readonly value="<?php if($subgerencia != ''){echo $row[3];}?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end .form-group -->
                                        </form>
                                    </div>
                                 </div>
                            </div>
                        </div><!---ffin row -->
                        <div class="row">
                        	<div class="col-md-6 col-md-offset-3">
                            	<div class="card card-underline card-outlined">
                                	<div class="card-head">
                                    	<header>Datos de Acceso</header>
                                	</div>
									<div class="card-body">
                                        <form class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label for="dollars17" class="col-sm-4 control-label">Nombre de usuario</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="md md-person-outline  fa-lg"></i></span>
                                                        <div class="input-group-content">
                                                            <input type="text" class="form-control static-dirty" id="dollars17" readonly value="<?php echo $row[4]?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end .form-group -->
                                            <div class="form-group">
                                                <label for="dollars17" class="col-sm-4 control-label">Password</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class=" md md-lock   fa-lg"></i></span>
                                                        <div class="input-group-content">
                                                        <input type="hidden" name="pass" id="pass" value="<?php echo $row[5]; mysqli_close($link);?>">
                                                            <input type="text" class="form-control static-dirty" id="dollars17" readonly value="xxxxxx">
                                                            
                                                        </div>
                                                    </div>
                                                    <p class="row">
                                                    	<div class="col-sm-6 col-sm-offset-6">
                                                    		<button type="button" class="btn btn-block ink-reaction btn-flat btn-info"  data-toggle="modal" data-target="#formModal">Cambiar password</button>
                                                        </div>
                                                    </p>
                                                </div>
                                            </div><!--end .form-group -->
                                        </form>
                                    </div>
                                 </div>
                            </div>
                        </div><!---ffin row -->
                    </div>
				</section>
			</div><!--end #content-->
			<!-- END CONTENT -->

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="formModalLabel">Cambiar passsword</h4>
			</div>
				<div class="modal-body form-horizontal" role="form">
					<div class="form-group">
						<div class="col-sm-3">
							<label for="pass" class="control-label">Ingrese su password</label>
						</div>
						<div class="col-sm-9">
							<input type="password" name="passn" id="passn" class="form-control" placeholder="Password actual y presione enter">
						</div>
					</div>
                    <div>
                    	<form class="form form-validate" novalidate method="post" action="crudpass.php" id="formpass">
                        </form>
                    </div>
                </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


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
<?php
	if($nivel != "A") {
?>
                        <li>
							<a href="../programming/activities.php">
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
        <script src="../assets/js/libs/select2/select2.min.js"></script>
        <script src="../assets/js/core/demo/DemoFormComponents.js"></script>
        <script language="javascript" type="text/javascript">  
        $(document).ready(function() 
            {    
              $('#passn').keypress(function(e){   
               if(e.which == 13){
				   var p = $('#passn').val();
				   if(p == ""){
					   alert("Ingrese su password actual");
				   }
				   else{
					   var xmlhttp;
						if (window.XMLHttpRequest){// codigo for IE7+, Firefox, Chrome, Opera, Safari
							xmlhttp=new XMLHttpRequest();
							}else{// codigo for IE6, IE5
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange=function(){
							if (xmlhttp.readyState===4 && xmlhttp.status===200){
									document.getElementById("formpass").innerHTML=xmlhttp.responseText;
								
							}
						};
						xmlhttp.open("POST","crudpass.php",true);
						xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						xmlhttp.send("v=1&p="+p);
					   }
               }   
              });    
              
           }); 
		   
    </script>
		<!-- END JAVASCRIPT -->




	</body>
</html>




<?php
	}
	else{
		header("Location: ../login.php");
	}
?>