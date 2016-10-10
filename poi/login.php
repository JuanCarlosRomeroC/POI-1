<?php
	session_start();
	if(isset($_GET['logout'])){
		session_destroy();
	}
	else if(isset($_SESSION['poimps'])){
		header('Location: index.php');
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
		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
	</head>
	<body class="menubar-hoverable header-fixed ">

		<!-- BEGIN LOGIN SECTION -->
		<section class="section-account">
			<!--div class="img-backdrop" style="background-image: url('assets/img/img16.jpg')"></div-->
            <div class="card card-outlined col-sm-4 col-sm-offset-4">
				<div class="card-body">
                	<center><h1 style="color: rgb(214, 228, 81); text-shadow: 3px 3px 3px rgb(33, 31, 7);">SISTEMA POI</h1></center>
                </div>
            </div>
			
			<div class="card card-outlined col-sm-4 col-sm-offset-4">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12">
							<br/>
							<span class="text-lg text-bold" style="color: rgb(169, 43, 46); text-shadow: 0.9px 1px rgb(105, 111, 65);">ACCESO AL SISTEMA&nbsp;<i class="md md-lock "></i></span>
							
<?php
	if(isset($_GET['errn'])){
?>
                        <div class="row">
                        	<div class="col-sm-12" style="margin-bottom: -30px;">	
                            	<div class="alert alert-danger" role="alert">
                                	<strong><i class="md md-error"></i>&nbsp;ERROR!</strong> usuario no existe.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            </div>
                        </div>
<?php
	}else if(isset($_GET['errb'])){
?>
					 	<div class="row">
                        	<div class="col-sm-12" style="margin-bottom: -30px;">	
                            	<div class="alert alert-danger" role="alert">
                                	<strong><i class="md md-error"></i>&nbsp;ERROR!</strong> usuario actualmente bloqueado.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            </div>
                        </div>
<?php
	}else if(isset($_GET['erri'])){
?>
					 	<div class="row">
                        	<div class="col-sm-12" style="margin-bottom: -30px;">	
                            	<div class="alert alert-danger" role="alert">
                                	<strong><i class="md md-error"></i>&nbsp;ERROR!</strong> usuario y/o contraseña incorrectos
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            </div>
                        </div>
<?php
	}
?>

                            
                            
							<form class="form floating-label form-validate novalidate" action="validate/vusuario.php" accept-charset="utf-8" method="post">
								<div class="form-group">
									<input type="text" class="form-control" id="username" name="username" required>
									<label for="username">Nombre de Usuario</label>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="password" name="password" required>
									<label for="password">Password</label>
									<!--p class="help-block"><a href="#">Forgotten?</a></p-->
								</div>
								<br/>
								<div class="row">
									<!--div class="col-xs-6 text-left">
										<div class="checkbox checkbox-inline checkbox-styled">
											<label>
												<input type="checkbox"> <span>Remember me</span>
											</label>
										</div>
									</div><!--end .col -->
									<div class="col-xs-6 text-right col-sm-offset-6">
										<button class="btn btn-danger btn-raised" type="submit" name="acceso">Acceder&nbsp;<i class="fa fa-unlock"></i></button>
									</div><!--end .col -->
								</div><!--end .row -->
							</form>
						</div><!--end .col -->
						<!--div class="col-sm-5 col-sm-offset-1 text-center">
							<br><br>
								<h3 class="text-light">
									No account yet?
								</h3>
								<a class="btn btn-block btn-raised btn-primary" href="#">Sign up here</a>
								<br><br>
									<h3 class="text-light">
										or
									</h3>
									<p>
										<a href="#" class="btn btn-block btn-raised btn-info"><i class="fa fa-facebook pull-left"></i>Login with Facebook</a>
									</p>
									<p>
										<a href="#" class="btn btn-block btn-raised btn-info"><i class="fa fa-twitter pull-left"></i>Login with Twitter</a>
									</p>
								</div><!--end .col -->
							</div><!--end .row -->
						</div><!--end .card-body -->
					</div><!--end .card -->
                    <div class="col-sm-4 col-sm-offset-4">
						<small>
							<center><span class="opacity-75">Copyright &copy; <?php if(date('Y') == "2015"){echo date('Y'); } else { echo "2015 - ".date('Y'); } ?></span> <strong>MUNICIPALIDAD PROVINCIAL DEL SANTA</strong></center>
						</small>
					</div>
				</section>
				<!-- END LOGIN SECTION -->

				<!-- BEGIN JAVASCRIPT -->
				<script src="assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
				<script src="assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
				<script src="assets/js/libs/bootstrap/bootstrap.min.js"></script>
				<script src="assets/js/libs/spin.js/spin.min.js"></script>
				<script src="assets/js/libs/autosize/jquery.autosize.min.js"></script>
                <script src="assets/js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
				<script src="assets/js/libs/jquery-validation/dist/additional-methods.min.js"></script>
				<script src="assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
				<script src="assets/js/core/source/App.js"></script>
				<script src="assets/js/core/source/AppNavigation.js"></script>
				<script src="assets/js/core/source/AppOffcanvas.js"></script>
				<script src="assets/js/core/source/AppCard.js"></script>
				<script src="assets/js/core/source/AppForm.js"></script>
				<script src="assets/js/core/source/AppNavSearch.js"></script>
				<script src="assets/js/core/source/AppVendor.js"></script>
				<script src="assets/js/core/demo/Demo.js"></script>
				<!-- END JAVASCRIPT -->

                    <div id="flotante3">
                    	<img src="assets/img/logo_30_30.png"/>&nbsp;<img src="assets/img/pescadito.png"/>
                    </div>
			</body>
		</html>
