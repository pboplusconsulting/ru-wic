<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
    	
	<div class="hd_top">
    	<h3>Edit Flag</h3>
    </div>
		<p class="clearfix"></p>
		<?php //var_dump($data);die();
					$flag_type_arr_arr=$this->config->item('flag_type');
		if($this->session->flashdata('flashError')) {?>
		<div class='alert alert-danger'> <?php echo $this->session->flashdata('flashError');?> </div>
		<?php } ?>
        <form method="post">
			<div class="row">

                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Name</label>
                                <input value="<?php echo $data->tax_name; ?>" required pattern="[a-zA-Z0-9]+[a-zA-Z0-9\s]+" title="Name Field does not allow special characters" name="name" class="form-control" type="text" placeholder="Name"/>
                                 <span class="red_text"><?php echo form_error('name');?></span>
                            </div>
                    </div>
            		
                <!--    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Type</label>
                                <select class="form-control" name="category" required>
                                 <option value="0" style="display:none">Select</option>
								 
                             </select>
							  <span class="red_text"><?php echo form_error('category');?></span>
                            </div>
                    </div>-->
                    <div class="col-sm-4 col-md-3" >
                    		<div class="form-group">
                            	<label>Percentage</label>
                                <input type="number" step=".1" name="percentage" value="<?php echo $data->tax_percent; ?>" class="form-control" required title="percentage" min="0">
                               <span class="red_text"><?php echo form_error('percentage');?></span>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Status</label>
                                 <select class="form-control" name="status">
								 <option value="">Select</option>
								 <option value="1" <?php echo $data->status==1?'selected':'' ?>>Active</option>
								 <option value="0" <?php echo $data->status==0?'selected':'' ?>>Inactive</option>
								</select>
								<span class="red_text"><?php echo form_error('status');?></span>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    	<div class="form-group">
                             <button type="submit" name="edit_flag" value="edit_flag" class="btn btn-ru">Save</button>
                        </div>
                    </div>
            </div>
			</form>
	</div>
</div>