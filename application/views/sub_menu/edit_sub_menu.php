<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div> 
    <div class="container-fluid">
    	
	<div class="hd_top">
    	<h3>Edit Sub Menu</h3>
    </div>
        <form name="f1" method="post" >
			<div class="row">
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Name</label>
                                <input value="<?php echo set_value('name', $data->sub_menu_name); ?>" required pattern="[a-zA-Z0-9]+[a-zA-Z0-9\s]+" title="Name Field does not allow special characters" name="name" class="form-control" type="text" placeholder="Name"/>
                                 <span class="red_text"><?php echo form_error('name');?></span>
                            </div>
                    </div>
                   <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Menu</label>
                                <select class="form-control" name="menu">
                                 <option value="">Select</option>
                                  <?php
									foreach($menus as $menu){?>
                                    <option value="<?php echo $menu->menu_id?>" <?php if(set_value('menu', $data->menu_id)==$menu->menu_id) echo "selected";?>><?php echo $menu->menu_name; ?></option>
									<?php } ?>
                             </select>
							 <span class="red_text"><?php echo form_error('menu');?></span>
                            </div>
                    </div>

					<div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Order Number</label>
                                <input  title="Order Number" name="ordernumber" class="form-control" type="number" min="0" value="<?php echo set_value('ordernumber', $data->order_no); ?>"/>
                                 <span class="red_text"><?php echo form_error('ordernumber');?></span>
                            </div>
                    </div>
                    
                    <div class="col-sm-4 col-md-3">
                    	<div class="form-group">
                             <button type="submit" name="edit_sub_menu" value="edit_sub_menu" class="btn btn-ru">Save</button>
                        </div>
                    </div>
            </div>
			</form>
	</div>
</div>