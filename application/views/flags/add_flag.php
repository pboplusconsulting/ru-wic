<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
    	
	<div class="hd_top">
    	<h3>Add Tax</h3>
    </div>
		<p class="clearfix"></p>
		<?php 
		//$status=$this->config->item('item_status');
		$flag_type_arr_arr=$this->config->item('flag_type');
		if($this->session->flashdata('flashError')) {?>
		<div class='alert alert-danger'> <?php echo $this->session->flashdata('flashError');?> </div>
		<?php } ?>
        <form method="post">
			<div class="row">

                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Tax Name</label>
                                <input value="<?php echo set_value('name'); ?>" required pattern="[a-zA-Z0-9]+[a-zA-Z0-9\s]+" title="Name Field does not allow special characters" name="name" class="form-control" type="text" placeholder="Tax Name"/>
                                 <span class="red_text"><?php echo form_error('name');?></span>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Procuct Category</label>
                                <select class="form-control" name="category" required>
                                     <option value="">Select</option>
								 <?php $i=1; foreach ($product_categories as $product_categorie){ if($i++>3) break;
                                  echo '<option value="'.$product_categorie->product_category_id.'">'.ucfirst($product_categorie->category_name).'</option>';
							      } ?>
                                </select>
							 <span class="red_text"><?php echo form_error('category');?></span>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    		<div class="form-group">
                            	<label>Percentage</label>
                                <input type="number" name="percentage" class="form-control" required title="Percentage" min="0">
                               <span class="red_text"><?php echo form_error('percentage');?></span>
                            </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                    	<div class="form-group">
                             <button type="submit" name="add_flag" value="add_flag" class="btn btn-ru">Save</button>
                        </div>
                    </div>
            </div>
			</form>
	</div>
</div>