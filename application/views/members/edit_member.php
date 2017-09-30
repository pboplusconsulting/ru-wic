<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
    	
	<div class="hd_top">
    	<h3>Edit Member</h3>
    </div>
		<p class="clearfix"></p>
		<?php 
		//$status=$this->config->item('item_status');
		$marital_status=$this->config->item('marital_status');
		$membership_type_array = $this->config->item('membership_type_array');
		if($this->session->flashdata('flashError')) {?>
		<div class='alert alert-danger'> <?php echo $this->session->flashdata('flashError');?> </div>
		<?php } ?>
        <form name="f1" method="post"  enctype="multipart/form-data">
			<div class="row">
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Membership ID</label>
                                <input value="<?php echo $data->membership_id; ?>" required pattern="[a-zA-Z0-9]+[a-zA-Z0-9\s]+" title="Name Field does not allow special characters" name="membership_id" class="form-control" type="text" placeholder="ID"/>
                                 <span class="red_text"><?php echo form_error('membership_id');?></span>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Member Name</label>
                                <input value="<?php echo $data->member_name; ?>" required pattern="[a-zA-Z0-9]+[a-zA-Z0-9\s]+" title="Name Field does not allow special characters" name="member_name" class="form-control" type="text" placeholder="Name"/>
                                 <span class="red_text"><?php echo form_error('member_name');?></span>
                            </div>
                    </div>
            		<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Email Id</label>
                                <input name="email_id" type="text" class="form-control" placeholder="email id" value="<?php echo $data->email_id; ?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Valid Email Pattern">
                                <span class="red_text"><?php echo form_error('email_id');?></span>
                            </div>
                    </div>
            		<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Phone</label>
                                <input name="phone_number" type="text" class="form-control" placeholder="phone no" required pattern="[0-9]{10}" title="Ten Digit Mobile Number"  value="<?php echo $data->phone_number; ?>">
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Membership Type</label>
                                <select class="form-control" name="membership_type" required>
                                 <option value="0" style="display:none">Select</option>
								 <?php foreach ($membership_type_array as $key=>$value){ 
                                  echo '<option value="'.$key.'" '.($data->membership_type==$key?'selected':'').'>'.$value.'</option>';
							 } ?>
                             </select>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Date Of Birth</label>
                                <input type="date" name="date_of_birth" value="<?php echo $data->date_of_birth; ?>" class="form-control" required title="">
                               <span class="red_text"><?php echo form_error('date_of_birth');?></span>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Marital Status</label>
                                 <select class="form-control" name="marital_status" required id="marital_status">
								 <option value="0" style="display:none">Select</option>
							    <?php foreach ($marital_status as $key=>$value){ 
                                  echo '<option value="'.$key.'" '.($data->marital_status==$key?'selected':'').'>'.$value.'</option>';
							    } ?>
								</select>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3" >
                    		<div class="form-group" id="anniversary_date_field">
                            	<label>Anniversary Date</label>
                                <input type="date" name="anniversary_date" id="anniversary_date" value="<?php echo $data->anniversary_date; ?>" class="form-control" required title="Please enter anniversary date">
                               <span class="red_text"><?php echo form_error('anniversary_date');?></span>
                            </div>
                    </div>
                <!--    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Status</label>
                                 <select class="form-control" name="status">
								 <option value="">Select</option>
							   <?php foreach ($status as $key=>$value){ 
                                  echo '<option value="'.$key.'" '.($data->status==$key?'selected':'').'>'.$value.'</option>';
							    } ?>
								</select>
                            </div>
                    </div>-->
                    <div class="col-sm-4 col-md-3">
                    	<div class="form-group">
                             <button type="submit" name="edit_member" value="edit_member" class="btn btn-ru">Save</button>
                        </div>
                    </div>
            </div>
			</form>
	</div>
</div>