<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div> 
    <div class="container-fluid">
    	
	<div class="hd_top">
    	<h3>Edit Menu Details</h3>
    </div>
        <form name="f1" method="post" >
			<div class="row">
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Name</label>
                                <input value="<?php echo set_value('name', $data->person_name); ?>" required pattern="[a-zA-Z0-9]+[a-zA-Z0-9\s]+" title="Name Field does not allow special characters" name="name" class="form-control" type="text" placeholder="Person Name"/>
                                 <span class="red_text"><?php echo form_error('person');?></span>
                            </div>
                    </div>

                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Member name</label>
                                <select class="form-control" name="member">
                                 <option value="">Select</option>
                                  <?php
									foreach($members as $member){?>
                                    <option value="<?php echo $member->id?>" <?php if(set_value('member', $data->member_id)==$member->id) echo "selected";?>><?php echo $member->member_name; ?></option>
									<?php } ?>
                             </select>
							 <span class="red_text"><?php echo form_error('member');?></span>
                            </div>
                    </div>
					
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Relation</label>
                                <input value="<?php echo set_value('relation', $data->relation); ?>" name="relation" class="form-control" type="text" placeholder="Relation"/>
                                 <span class="red_text"><?php echo form_error('relation');?></span>
                            </div>
                    </div>
					
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Email Id</label>
                                <input value="<?php echo set_value('email', $data->email_id); ?>" name="email" class="form-control" type="text" placeholder="Email Id"/>
                                 <span class="red_text"><?php echo form_error('email');?></span>
                            </div>
                    </div>
					
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Contact No</label>
                                <input value="<?php echo set_value('contact', $data->phone_number); ?>" name="contact" class="form-control" type="text" placeholder="Contact Number"/>
                                 <span class="red_text"><?php echo form_error('contact');?></span>
                            </div>
                    </div>
                  <!--  <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Status</label>
                                 <select class="form-control" name="status">
								 <option value="">Select</option>
							  <option value="1" <?php if(set_value('status', $data->status)==1) echo "selected";?>>Active</option>
							  <option value="0" <?php if(set_value('status', $data->status)==0) echo "selected";?>>Inactive</option>
								</select>
								<span class="red_text"><?php echo form_error('status');?></span>
                            </div>
                    </div>-->
                    
                    <div class="col-sm-4 col-md-3">
                    	<div class="form-group">
                             <button type="submit" name="edit_member_detail" class="btn btn-ru">Save</button>
                        </div>
                    </div>
            </div>
			</form>
	</div>
</div>