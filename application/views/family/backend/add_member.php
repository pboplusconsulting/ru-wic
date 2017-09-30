<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive" width="100px"  alt="" /></a>
    </div>
    <div class="container-fluid">
    	
	<div class="hd_top">
    	<h3>Add New Family Member</h3>
    </div>
		<p class="clearfix"></p>
		<?php 
		if($this->session->flashdata('flashError')) {?>
		<div class='alert alert-danger'> <?php echo $this->session->flashdata('flashError');?> </div>
		<?php } ?>
        <form method="post" name="addnewmember" enctype="multipart/form-data" data-parsley-validate>
			<div class="row">
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Person Name</label>
                                <input value="<?php echo set_value('name'); ?>" required pattern="[a-zA-Z0-9]+[a-zA-Z0-9\s]+" title="Name Field does not allow special characters" name="name" class="form-control" type="text" placeholder="Name"/>
                                 <span class="red_text"><?php echo form_error('name');?></span>
                            </div>
                    </div>
					
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Member Name</label>
                                <select class="form-control" name="member" required>
                                 <option value="">Select</option>
                                  <?php
									foreach($members as $member){
										?>
                                    <option value="<?php echo $member->id?>" <?php if(set_value('member')==$member->id) echo "selected";?>><?php echo $member->member_name; ?></option>
									<?php }?>
                                </select>
							 <span class="red_text"><?php echo form_error('member');?></span>
                            </div>
                    </div>
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Relation</label>
                                <input value="<?php echo set_value('relation'); ?>" required  name="relation" class="form-control" type="text" placeholder="Relation"/>
                                 <span class="red_text"><?php echo form_error('relation');?></span>
                            </div>
                    </div><div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Email Id</label>
                                <input value="<?php echo set_value('email'); ?>" name="email" class="form-control" type="text" placeholder="Email Id"/>
                                 <span class="red_text"><?php echo form_error('email');?></span>
                            </div>
                    </div>
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Contact No</label>
                                <input value="<?php echo set_value('contact'); ?>" name="contact" class="form-control" type="text" placeholder="Contact No"/>
                                 <span class="red_text"><?php echo form_error('contact');?></span>
                            </div>
                    </div>
                 <!--   <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Status</label>
                                 <select class="form-control" name="status" required>
								 <option value="">Select</option>
							  <option value="1" <?php if(set_value('status')=="1") echo "selected";?>>Active</option>
							  <option value="0" <?php if(set_value('status')=="0") echo "selected";?>>Inactive</option>
								</select>
								<span class="red_text"><?php echo form_error('status');?></span>
                            </div>
                    </div>-->
					
					<p class="clearfix"></p>	   
                    <div class="text-center">
                    	<div class="form-group">
                             <button type="submit" name="add_new_member" class="btn btn-ru">Save</button>
                        </div>
                    </div>
            </div>
			</form>
	</div>
</div>
<script>
</script>