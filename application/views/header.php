<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

<title>RU</title>

<!-- Bootstrap -->

<link href="<?php echo base_url()?>assets/open-sans1.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/exo1.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/css/owl.carousel.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/css/isotope.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url()?>assets/css/daterangepicker.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url()?>assets/datetimepicker/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/multiselect/css/bootstrap-multiselect.css" type="text/css"/>

<?php if($this->uri->segment(1) == 'analysis') { ?>
<link href="<?php echo base_url()?>assets/analysis/css/animate.min.css" rel="stylesheet">
 
  <link href="<?php echo base_url()?>assets/analysis/css/icheck/flat/green.css" rel="stylesheet">
<?php } ?>

<link href="<?php echo base_url()?>assets/css/stylesheet.css" rel="stylesheet">
 <?php if($this->uri->segment(1)=='analysis') { ?>
 <link href="<?php echo base_url()?>assets/analysis/css/custom.css" rel="stylesheet">
 <?php } ?>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

<!--[if lt IE 9]>

      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
<script>var base_url= "<?php echo base_url()?>";
var module="<?php echo $this->uri->segment(1)?>";
</script>

<script src="<?php echo base_url()?>assets/js/1.12.4.jquery.min.js"></script> 
 <script src="<?php echo base_url()?>assets/js/owl.carousel.min.js"></script> 
</head>

<body <?php if($this->uri->segment(1)=='analysis') echo "class=\"nav-md\""; ?>>
<?php
if($this->uri->segment(2)!='make_order'){?>
<header id="main_header" <?php if($this->uri->segment(1)=='analysis') echo "class=\"analysis\""; ?>>
<div class="container-fluid">
	<span class="user_name"><strong>Hi,</strong> <?php echo $_SESSION['name']; ?></span>
    <ul class="text-right list-inline pull-right">
	    
    	<li><a href="<?php echo $this->session->userdata('userRole')==4?base_url().'chef':base_url()?>"><i class="fa fa-home fa-lg"></i> <span>Home</span></a></li>
        <?php if($this->session->userdata('userRole')==1) {?>
        <li><a href="<?php echo base_url().'analysis';?>"><i class="fa fa-bar-chart"></i> <span>Analysis</span></a></li>
		<li class="dropdown"><a href="#"  class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file"></i> Reports</a>
		<ul class="dropdown-menu list-unstyled">
		<li><a href="<?php echo base_url()?>reports"><i class="fa fa-file"></i> <span>RU Sales Report</span></a></li>
		<li><a href="<?php echo base_url()?>reports/feedback_report"><i class="fa fa-file"></i> <span>RU Feedback Report</span></a></li>
		</ul>
		</li>
		<li class="dropdown"><a href="#"  class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog fa-lg"></i> Setting</a>
		<ul class="dropdown-menu list-unstyled">
		<li><a href="<?php echo base_url()?>chef"><i class="fa fa-hand-o-left"></i> <span>Switch to Chef</span></a></li>
		<li><a href="<?php echo base_url()?>bar_tendor"><i class="fa fa-hand-o-left"></i> <span>Switch to Bartender</span></a></li>
		<li><a href="<?php echo base_url()?>bistro"><i class="fa fa-hand-o-left"></i> <span>Switch to Bistro</span></a></li>
        <li><a href="<?php echo base_url()?>user"><i class="fa fa-user"></i> <span>User List</span></a></li>
    	<li><a href="<?php echo base_url()?>members"><i class="fa fa-users"></i> <span>Member List</span></a></li>
		<li><a href="<?php echo base_url()?>family"><i class="fa fa-user-plus"></i><span> Family Member</span></a></li>
        <li><a href="<?php echo base_url()?>menu/menu_list"><i class="fa fa-th-list"></i> <span>Menu List</span></a></li>
		<li><a href="<?php echo base_url()?>sub_menu"><i class="fa fa-th-list"></i> <span>Sub Menu List</span></a></li>
		<li><a href="<?php echo base_url()?>meal/meal_list"><i class="fa fa-cutlery"></i> <span>Meal List</span></a></li>
		<li><a href="<?php echo base_url()?>flag"><i class="fa fa-life-ring"></i> <span>Tax and Discounts</span></a></li>
        
        </ul>
		</li>
        <?php }
        else if($this->session->userdata('userRole')==2){?>
		 <li><a href="<?php echo base_url().'analysis';?>"><i class="fa fa-bar-chart"></i> <span>Analysis</span></a></li>
		<li class="dropdown"><a href="#"  class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file"></i> Reports</a>
		<ul class="dropdown-menu list-unstyled">
		<li><a href="<?php echo base_url()?>reports"><i class="fa fa-file"></i> <span>RU Sales Report</span></a></li>
		<li><a href="<?php echo base_url()?>reports/feedback_report"><i class="fa fa-file"></i> <span>RU Feedback Report</span></a></li>
		</ul>
		</li>
		
		<li  class="dropdown"><a href="#"  class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog fa-lg"></i> Setting</a>
		<ul class="dropdown-menu list-unstyled">
            <li><a href="<?php echo base_url()?>chef"><i class="fa fa-hand-o-left"></i> <span>Switch to Chef</span></a></li>
			<li><a href="<?php echo base_url()?>bar_tendor"><i class="fa fa-hand-o-left"></i> <span>Switch to Bartender</span></a></li>
			<li><a href="<?php echo base_url()?>bistro"><i class="fa fa-hand-o-left"></i> <span>Switch to Bistro</span></a></li>
			<li><a href="<?php echo base_url()?>manager/member_list"><i class="fa fa-user"></i> <span>Member List</span></a></li>
			<li><a href="<?php echo base_url()?>manager"><i class="fa fa-list-alt"></i> <span>Order Summary</span></a></li>
		<!--	<li><a href="<?php echo base_url()?>manager/occupancy"><i class="fa fa-list-alt"></i> <span>Occupancy Summary</span></a></li>-->
			<li><a href="<?php echo base_url()?>manager/best_selling_dish"><i class="fa fa-list-alt"></i> <span>Best Selling Dish</span></a></li>
			<li><a href="<?php echo base_url()?>manager/available_man_power"><i class="fa fa-list-alt"></i> <span>Available Man Power</span></a></li>
			<li><a href="<?php echo base_url()?>manager/advance_table_booking"><i class="fa fa-calendar-check-o"></i> <span>Advance Table Booking</span></a></li>
			<li><a href="<?php echo base_url()?>manager/share_notification"><i class="fa fa-share"></i><span> Share notification</span></a></li>
        </ul>
		</li>
		<?php }	?>
        <li  class="dropdown"><a href="#"  class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> My Account</a>
        <ul class="dropdown-menu list-unstyled ">
            <li><a href="<?php echo base_url()?>profile/edit_profile"><i class="fa fa-gear"></i> <span>Edit Profile</span></a></li>
            <li><a href="<?php echo base_url()?>welcome/logout"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
        </ul>
        </li>
        <li  class="dropdown" id="notif_area"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o"></i>
			<small></small>
			</a>
			<ul class="dropdown-menu list-unstyled msg_list">
            </ul>
        </li>
    </ul>
</div>
</header>
<?php } ?>