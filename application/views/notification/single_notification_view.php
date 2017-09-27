<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
    <div class="hd_top">
    	<h3>Notification</h3>
    </div>
    		<div class="notify_msgs">
           <div class="panel panel-default">
			  <div class="panel-heading"><b><?php echo $notificationData->name ?></b></div>
			  <div class="panel-body"><p class="clearfix"></p><?php echo $notificationData->message ?><p class="clearfix"></p></div>
			  <div class="panel-footer"><?php echo date('d M y h:i A',strtotime($notificationData->created)) ?></div>
			</div>	
	</div>
    </div>
</div>
