<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
    <div class="hd_top">
    	<h3>Notifications</h3>
    </div>
    		<div class="notify_msgs">
            <div class="table-responsive">
            	<table class="table table-bordered">
                <thead>
                	<tr>
                		<th>Notify by</th>
                		<th>Date</th>
                		<th>Message</th>
                	</tr>
                </thead>
                <tbody>
				    <?php foreach($notifications as $notification){ ?>
                	<tr>
                		<td><?php echo $notification['name'];?></td>
                		<td><?php echo date('d M Y',strtotime($notification['created']));?></td>
                		<td><?php echo $notification['message'];?></td>
                		
                	</tr>
					<?php } ?>
                    
                </tbody>
                </table>
            </div>	
            
            <div class="text-center">
            	<nav aria-label="Page navigation">
				  <?php echo $this->pagination->create_links(); ?>
                </nav>
            </div>		
	</div>
    </div>
</div>
