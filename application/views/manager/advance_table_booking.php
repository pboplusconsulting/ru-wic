<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div> 
    <div class="container-fluid">
    	
	<div class="hd_top">
    	<h3>Book Table</h3>
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
			<label>Please select date first to list out available table on that date</label>
			</div><p class="clearfix"></p><p class="clearfix"></p>
                    <div class="col-sm-4 col-md-3">
					<div class="form-group">
					<label>Date</label><span class="red-text">*</span>
						<div class='input-group date datetimepicker' id='tablebookingdate'>
							<input type="text" class="form-control" name="bookingdate" required>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div><?php echo form_error('bookingdate');?>
					</div>
					</div>
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Table</label><span class="red-text">*</span>
                                 <select class="form-control" name="table" id="table-list" required>
								 
								</select><?php echo form_error('table');?>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    	<div class="form-group">
                             <button type="submit" name="save_advance_table_booking" class="btn btn-ru">Save</button>
                        </div>
                    </div>
            </div>
			</form>
	</div>
</div>
