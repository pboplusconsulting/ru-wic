<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
    	
	<div class="hd_top">
    	<h3>Add New Meal</h3>
    </div>
		<p class="clearfix"></p>
		<?php 
		if($this->session->flashdata('flashError')) {?>
		<div class='alert alert-danger'> <?php echo $this->session->flashdata('flashError');?> </div>
		<?php } ?>
        <form method="post" name="newMeal" enctype="multipart/form-data" data-parsley-validate>
			<div class="row">
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Name</label>
                                <input value="<?php echo set_value('name'); ?>" required pattern="[a-zA-Z0-9]+[a-zA-Z0-9\s]+" title="Name Field does not allow special characters" name="name" class="form-control" type="text" placeholder="Name"/>
                                 <span class="red_text"><?php echo form_error('name');?></span>
                            </div>
                    </div>
					
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Menu</label>
                                <select class="form-control" name="menu" id="newmenu" required>
                                 <option value="">Select</option>
                                  <?php
									foreach($menus as $menu){
										?>
                                    <option value="<?php echo $menu->menu_id?>" <?php if(set_value('menu')==$menu->menu_id) echo "selected";?>><?php echo $menu->menu_name; ?></option>
									<?php }?>
                                </select>
							 <span class="red_text"><?php echo form_error('menu');?></span>
                            </div>
                    </div>
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Sub Menu</label>
                                <select class="form-control" name="smenu" id="submenu">
                                 
                                </select>
							 <span class="red_text"><?php echo form_error('smenu');?></span>
                            </div>
                    </div>
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Price (Rupees)</label>
                                <input value="<?php echo set_value('price'); ?>" required data-parsley-type="digits" title="Price Field only allow digits" name="price" class="form-control" type="number" placeholder="Price" min="0"/>
                                 <span class="red_text"><?php echo form_error('price');?></span>
                            </div>
                    </div><div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Prepration Time(In Minutes)</label>
                                <input value="<?php echo set_value('prepration_time'); ?>" required data-parsley-type="digits" title="Time Field only allow digits" name="prepration_time" class="form-control" type="number" placeholder="Prepration Time" min="0"/>
                                 <span class="red_text"><?php echo form_error('prepration_time');?></span>
                            </div>
                    </div>
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Description</label>
                                <input value="<?php echo set_value('description'); ?>" title="Description Field contains text" name="description" class="form-control" type="text" placeholder="Description"/>
                                 <span class="red_text"><?php echo form_error('description');?></span>
                            </div>
                    </div>
                    
					<div class="col-sm-4 col-md-3">
								<div class="form-group">
									<label>Order Number</label>
									<input  title="Order Number" name="ordernumber" class="form-control" type="number" min="0">
									 <span class="red_text"><?php echo form_error('ordernumber');?></span>
								</div>
					</div>					
					
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Upload Image(jpg,jpeg,png)- max 5mb</label>
                                <input type="file" title="Upload Image in jpg,jpeg,png format" name="meal_image" class="form-control" placeholder="Meal Image" id="fileUpload"/>
								 <span id="image-holder"></span>
                                 <span class="red_text"><?php echo form_error('meal_image');?></span>
                            </div>
							</div>
							<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Upload Video (mp4)- Max 50mb</label>
                                <input type="file" title="Upload mp4 video format" name="meal_video" class="form-control" placeholder="Meal Video" id="videoUpload"/>
								<span id="video-holder"></span>
                                 <span class="red_text"><?php echo form_error('meal_video');?></span>
                            </div>
					       </div>
					<p class="clearfix"></p>	   
                    <div class="text-center">
                    	<div class="form-group">
                             <button type="submit" name="add_meal" class="btn btn-ru">Save</button>
                        </div>
                    </div>
            </div>
			</form>
	</div>
</div>
<script>
</script>