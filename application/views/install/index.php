<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />

	<title>Installation | Eduo - Online School Portal</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>assets/backend/adminlte/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/backend/adminlte/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/backend/adminlte/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo base_url(); ?>assets/backend/adminlte/css/custom.css" rel="stylesheet" type="text/css" />

    <style>
    	.error{
    		color:red;
    		font-weight: normal;
    	}
    .header .logo{width: 100%;text-align: center;margin-top: 50px;}
    .header h3{width: 100%;text-align: center;}
    .header h4{width: 100%;text-align: center;}
    p{color: #949494;}

    </style>
	<script src="<?php echo base_url(); ?>assets/backend/adminlte/js/jQuery-2.1.4.min.js"></script>
</head>
<body class="skin-blue" >

<div class="page-container horizontal-menu">


	<header class="header" >
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 ">

					<!-- logo -->
					<div class="logo">
						<a href="#">
							<img src="<?php echo base_url(); ?>/uploads/logo/logo.png"  style="max-height:75px;"/>
						</a>
					</div>

					<h3 style="margin: 0;">Eduo - Online School Portal</h3>
                    <h4>Installation</h4>
				</div>
			</div>
		</div>
	</header>


	<div class="main-content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
		            <?php include 'main/'.$page_name.'.php'; ?>
		            <?php include 'footer.php'; ?>
				</div>
			</div>
		</div>
	</div>

<?php include 'scripts.php'; ?>

</body>
</html>
