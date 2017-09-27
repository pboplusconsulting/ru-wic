<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div> 
    <div class="container-fluid">
    	
	<div class="hd_top">
    	<h3>Edit Profile</h3>
    </div>
		<p class="clearfix"></p>
		<?php 
		if($this->session->flashdata('flashError')) {?>
		<div class='alert alert-danger'> <?php echo $this->session->flashdata('flashError');?> </div>
		<?php } 
		if($this->session->flashdata('flashSuccess')) {?>
		<div class='alert alert-success'> <?php echo $this->session->flashdata('flashSuccess');?> </div>
		<?php } ?>
        <form name="f1" method="post"  enctype="multipart/form-data">
			<div class="row">
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Name</label>
                                <input value="<?php echo set_value('name', $data->name); ?>" required pattern="[a-zA-Z0-9]+[a-zA-Z0-9\s]+" title="Name Field does not allow special characters" name="name" class="form-control" type="text" placeholder="Name"/>
                                 <span class="red_text"><?php echo form_error('name');?></span>
                            </div>
                    </div>
            		<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Email Id</label>
                                <input name="email_id" type="text" class="form-control" placeholder="email id" value="<?php echo set_value('email_id', $data->email_id); ?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Valid Email Pattern">
                                <span class="red_text"><?php echo form_error('email_id');?></span>
                            </div>
                    </div>
            		<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Phone</label>
                                <input name="contact_no" type="text" class="form-control" placeholder="phone no" required pattern="[0-9]{10}" title="Ten Digit Mobile Number"  value="<?php echo set_value('phone_number', $data->phone_number); ?>">
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Password</label>
                                <input type="password" name="user_pwd" class="form-control" placeholder="Password" pattern=".{6,}" title="Password must be 6 character long">
                               <span class="red_text"><?php echo form_error('user_pwd');?></span>
                            </div>
                    </div>
                   <!-- <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>User Role</label>
                                <select class="form-control" name="role">
                                 <option value="">Select</option>
                                  <?php
									foreach($roles as $rol){ ?>
                                    <option value="<?php echo $rol->role_id?>" <?php if(set_value('role', $data->role)==$rol->role_id) echo "selected";?>><?php echo $rol->role_name; ?></option>
									<?php } ?>
                             </select>
                            </div>
                    </div> -->
                 <!--   <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Status</label>
                                 <select class="form-control" name="status">
								 <option value="">Select</option>
							  <option value="1" <?php if(set_value('status', $data->status)==1) echo "selected";?>>Active</option>
							  <option value="0" <?php if(is_numeric(set_value('status')) && set_value('status', $data->status)==0) echo "selected";?>>Inactive</option>
								</select>
                            </div>
                    </div> -->
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Image</label>
                                <input type="file" name="profilePic" class="form-control"/>
								<span class="prof_url"><?php if($data->image){ echo $data->image; ?> <a href="#" class="del_pic"><i class="fa fa-close"></i></a> <?php } ?></span>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    	<div class="form-group">
                             <button type="submit" name="edit_profile" value="edit_profile" class="btn btn-ru">Save</button>
                        </div>
                    </div>
            </div>
			</form>
	</div>
</div>