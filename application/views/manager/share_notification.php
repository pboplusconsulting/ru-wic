<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div> 
    <div class="container-fluid">
    	
	<div class="hd_top">
    	<h3>Share Notification</h3>
    </div>
		<p class="clearfix"></p>
		<?php 
		if($this->session->flashdata('flashError')) {?>
		<div class='alert alert-danger'> <?php echo $this->session->flashdata('flashError');?> </div>
		<?php } 
		if($this->session->flashdata('flashSuccess')) {?>
		<div class='alert alert-success'> <?php echo $this->session->flashdata('flashSuccess');?> </div>
		<?php } ?>
        <form name="f1" method="post">
			<div class="row">
			<div class="col-sm-12 col-md-12">
			<label>Enter message here to notify all the employees.</label>
			</div><p class="clearfix"></p><p class="clearfix"></p>
                    <div class="col-sm-4 col-md-3">
					<div class="form-group">
					<label>Message</label><span class="red-text">*</span>
							<input type="text" class="form-control" name="message" required>
							<?php echo form_error('message');?>
					</div>
					</div>
                    <div class="col-sm-4 col-md-3">
                    	<div class="form-group">
                             <button type="submit" name="send_notification" class="btn btn-ru">Send</button>
                        </div>
                    </div>
            </div>
			</form>
	</div>
</div>
