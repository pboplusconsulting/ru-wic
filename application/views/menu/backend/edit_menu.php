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
                                <input value="<?php echo set_value('name', $data->menu_name); ?>" required pattern="[a-zA-Z0-9]+[a-zA-Z0-9\s]+" title="Name Field does not allow special characters" name="name" class="form-control" type="text" placeholder="Name"/>
                                 <span class="red_text"><?php echo form_error('name');?></span>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Product category</label>
                                <select class="form-control" name="mealAll">
                                 <option value="">Select</option>
                                  <?php
								   $result=$this->db->get_where('ru_product_category','status=1');
								  $mealAll=$result->result();
									foreach($mealAll as $ma){?>
                                    <option value="<?php echo $ma->product_category_id?>" <?php if(set_value('mealAll', $data->product_category_id)==$ma->product_category_id) echo "selected";?>><?php echo $ma->category_name; ?></option>
									<?php } ?>
                             </select>
							 <span class="red_text"><?php echo form_error('mealAll');?></span>
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
                             <button type="submit" name="edit_menu" value="edit_menu" class="btn btn-ru">Save</button>
                        </div>
                    </div>
            </div>
			</form>
	</div>
</div>