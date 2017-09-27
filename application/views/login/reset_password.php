<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>RU</title>

    <!-- Bootstrap -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Exo+2:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/stylesheet.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="bg_login">

	<div id="login_area">
		<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1 col-lg-4 col-lg-offset-4">
		<div class="form-login">
		 <img src="<?php echo base_url()?>assets/img/logo.png" width="120" alt="" class="center-block" style="background: rgba(255,255,255,1); padding: 10px; border-radius: 5px;" /><br>
		<?php if($this->session->flashdata('flashError')) {?>
		<div class="alert alert-warning" role="alert"> <?php echo $this->session->flashdata('flashError');?> </div>
		<?php } ?>
		<?php if($this->session->flashdata('flashSuccess')) {?>
		<div class="alert alert-success" role="alert"> <?php echo $this->session->flashdata('flashSuccess');?> </div>
		<?php } ?>

      <form name="reset_password" method="post" action="<?php base_url().'login/reset_passwod';?>">
	  <label style="color:white">OTP</label>
		 <input type="password" id="ru_otp" name="otp" title="Valid OTP" class="form-control" required placeholder="" />
		 <span class="error" style="color:white"><?php echo form_error('otp');?></span>
		 <label style="color:white">Password</label>
		 <input type="password" id="ru_password" name="password" title="Password" class="form-control" required placeholder="" />
		 <span class="error" style="color:white"><?php echo form_error('password');?></span>
		 <label style="color:white">Confirm Password </label>
		 <input type="password" id="ru_conf_password" name="conf_password" title="Confirm Password" class="form-control" required placeholder="" />
           <span class="error" style="color:white"><?php echo form_error('conf_password');?></span>
		<div class="text-right"><a href="<?php echo base_url();?>" class="btn-link">Back to Login</a></div>
		<p class="clearfix"></p>
		<div class="wrapper">
		<span class="group-btn">     
		 <button type="submit" name="reset_pass" value="reset_pass" class="btn btn-success btn-lg">Submit <i class="fa fa-sign-in"></i></button><br>
			
		</span>
		</div> 
     </form>
		</div>	
		</div>
	</div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url()?>assets/js/1.12.4.jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/SmoothScroll.min.js"></script>
    
    
  </body>
</html>