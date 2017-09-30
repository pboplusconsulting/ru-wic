<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
    	
	<div class="hd_top">
    	<h3>Edit Meal Details</h3>
    </div>
		<p class="clearfix"></p>
		<?php 
		if($this->session->flashdata('flashError')) {?>
		<div class='alert alert-danger'> <?php echo $this->session->flashdata('flashError');?> </div>
		<?php } ?>
        <form method="post" name="editMeal" enctype="multipart/form-data" data-parsley-validate>
			<div class="row">
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Name</label>
                                <input value="<?php echo set_value('name',$mealData->meal_name); ?>" required pattern="[a-zA-Z0-9]+[a-zA-Z0-9\s]+" title="Name Field does not allow special characters" name="name" class="form-control" type="text" placeholder="Name"/>
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
                                    <option value="<?php echo $menu->menu_id?>" <?php if(set_value('menu',$mealData->menu_id)==$menu->menu_id) echo "selected";?>><?php echo $menu->menu_name; ?></option>
									<?php }?>
                                </select>
							 <span class="red_text"><?php echo form_error('menu');?></span>
                            </div>
                    </div>
					
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Sub Menu</label>
                                <select class="form-control" name="smenu" id="submenu">
                                    <option value="">Select</option>
                                  <?php
									foreach($submenus as $submenu){
										?>
                                    <option value="<?php echo $submenu->sub_menu_id?>" <?php if(set_value('smenu',$mealData->sub_menu_id)==$submenu->sub_menu_id) echo "selected";?>><?php echo $submenu->sub_menu_name; ?></option>
									<?php }?>
                                </select>
							 <span class="red_text"><?php echo form_error('smenu');?></span>
                            </div>
                    </div>
					
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Price (Rupees)</label>
                                <input value="<?php echo set_value('price',$mealData->meal_price); ?>" required data-parsley-type="digits" title="Price Field only allow digits" name="price" class="form-control" type="text" placeholder="Price"/>
                                 <span class="red_text"><?php echo form_error('price');?></span>
                            </div>
                    </div><div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Prepration Time(In Minutes)</label>
                                <input value="<?php echo set_value('prepration_time',$mealData->meal_prepration_time); ?>" required data-parsley-type="digits" title="Time Field only allow digits" name="prepration_time" class="form-control" type="text" placeholder="Prepration Time"/>
                                 <span class="red_text"><?php echo form_error('prepration_time');?></span>
                            </div>
                    </div>
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Description</label>
                                <input value="<?php echo set_value('description',$mealData->meal_description); ?>" title="Description Field contains text" name="description" class="form-control" type="text" placeholder="Description"/>
                                 <span class="red_text"><?php echo form_error('description');?></span>
                            </div>
                    </div>
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Order Number</label>
                                <input  title="Order Number" name="ordernumber" class="form-control" type="number" min="0" value="<?php echo set_value('ordernumber', $mealData->order_no); ?>"/>
                                 <span class="red_text"><?php echo form_error('ordernumber');?></span>
                            </div>
                    </div>
					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Upload Image(jpg,jpeg,png)- max 5mb</label>
                                <input type="file" title="Upload Image in jpg,jpeg,png format" name="meal_image" class="form-control" placeholder="Meal Image" id="fileUpload"/>
								 <span id="image-holder"><?php if(!empty($mealData->meal_image)){ ?>
								 <a href="<?php echo base_url().'Meal/delete_files/'.$mealData->meal_id.'/image'; ?>">
                                  <span class="glyphicon glyphicon-remove"></span>
                                 </a>
								 <a href="#" data-toggle="modal" data-target="#imgModal">
                                   <span class="glyphicon glyphicon-play"></span>
                                 </a>
								 <img src="<?php echo base_url().''.$mealData->meal_image; ?>" class="thumb-image"/>
								 <?php }?>
								 </span>
                                 <span class="red_text"><?php echo form_error('meal_image');?></span>
                            </div>
							</div>
							<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Upload Video(mp4)- Max 50mb</label>
                                <input type="file" title="Upload mp4 video format" name="meal_video" class="form-control" placeholder="Meal Video" id="videoUpload"/>
								<span id="video-holder"><?php if(!empty($mealData->meal_video)){ ?>
								 <a href="<?php echo base_url().'Meal/delete_files/'.$mealData->meal_id.'/video';?>">
                                  <span class="glyphicon glyphicon-remove"></span>
                                 </a>
								 <a href="#" data-toggle="modal" data-target="#videoModal">
                                   <span class="glyphicon glyphicon-play"></span>
                                 </a>
								 <img src="<?php echo base_url().'assets/img/video.png'; ?>" class="thumb-image"/>
								<?php }?>
								 </span>
                                 <span class="red_text"><?php echo form_error('meal_video');?></span>
                            </div>
					       </div>
					<p class="clearfix"></p>	   
                    <div class="text-center">
                    	<div class="form-group">
                             <button type="submit" name="edit_meal" class="btn btn-ru">Save</button>
                        </div>
                    </div>
            </div>
			</form>
	</div>
</div>

<!-- Modal to show image -->
  <div class="modal fade" id="imgModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         <!-- <h4 class="modal-title">Modal Header</h4>-->
        </div>
        <div class="modal-body">
		<img src="<?php echo base_url().''.$mealData->meal_image;?>" style="width:100%;height:100%">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
  
  <!-- Modal to Play video -->
  <div class="modal fade" id="videoModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         <!-- <h4 class="modal-title">Modal Header</h4>-->
        </div>
        <div class="modal-body">
		<!--<object width="90%" height="90%">
                      <param name="src" value="<?php echo base_url().''.$mealData->meal_video;?>">
                      <param name="autoplay" value="false">
                      <param name="controller" value="true">
                      <param name="bgcolor" value="#333333">
                      <embed type="video/mp4" src="<?php echo base_url().''.$mealData->meal_video;?>" autostart="false" loop="false" width="90%" height="90%" controller="true" bgcolor="#333333"></embed>
                      </object>-->
		<?php
            $vdoArr=array_reverse(explode('/',$mealData->meal_video));
            $ext=array_reverse(explode('.',$vdoArr[0]));
			$extType='';
            switch($ext[0])
			{
				case 'mp4':
				{
					$extType='video/mp4';
					break;
				}
				case '3gp':
				{
					$extType='video/3gp';
					break;
				}
				case '3gpp':
				{
					$extType='video/3gpp';
					break;
				}
				case 'mov':
				{
					$extType='video/mov';
					break;
				}
				case 'wmv':
				{
					$extType='video/wmv';
					break;
				}
				case 'avi':
				{
					$extType='video/avi';
					break;
				}
			}
			
		?>			  
		<video width="100%" height="100%" controls>
           <source src="<?php echo base_url().''.$mealData->meal_video;?>" type="<?php echo $extType;?>">
		   
             Your browser does not support the video.
			
        </video>
<?php  echo $extType;?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>