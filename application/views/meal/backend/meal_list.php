<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
	
	<!--
	<div class="row">
	    <div class="col-md-12"><div class="col-md-12"><label>Menu</label></div></div>
	   <div class="col-md-6">
    	<form name="" method="post" action="">
		<div class="col-md-6">
		<select name="menu" class="form-control">
		  <option value="">Select</option>
		  <?php foreach($menus as $menu){?>
		  <option value="<?php echo $menu->menu_id?>" <?php echo $filter==$menu->menu_id?'selected':'' ?>><?php echo $menu->menu_name?></option>
		  <?php }?>
		</select> 
		</div>
		<div class="col-sm-6">
		<input type="submit" name="menu_filter" value="Filter" class="btn btn-default">
		</div>
		</form>
       </div>
		<div class="col-md-6 text-right">
			<a href="<?php echo base_url()?>meal/add_meal" class="btn btn-ru mzero add_user">Add New</a>
		</div>
	</div>
	-->
	<?php //echo $_SESSION['page_uri']; ?>
	
	<div class="row">
	    <div class="col-md-12"><div class="col-md-12"><label>Meal Name</label></div></div>
	   <div class="col-md-6">
    	<form name="" method="post" action="<?php echo base_url().'meal/meal_list'; ?>">
		<div class="col-md-6">
             <input type="text" class="form-control" name="search_str" value="<?php echo $search_str; ?>">
		</div>
		<div class="col-sm-6">
		<input type="submit" name="search" value="search" class="btn btn-default">
		</div>
		</form>
       </div>
		<div class="col-md-6 text-right">
			<a href="<?php echo base_url()?>meal/add_meal" class="btn btn-ru mzero add_user">Add New</a>
		</div>
	</div>
	
    <div class="hd_top">
    	<h3>Meal List</h3>
    </div>
	<p class="clearfix"></p>
      
      <?php 
	   if($this->session->flashdata('flashSuccess')) {?>
           <div class='alert alert-success'> <?php echo $this->session->flashdata('flashSuccess');?> </div>
       <?php } 
	   if($this->session->flashdata('flashError')) {?>
           <div class='alert alert-danger'> <?php echo $this->session->flashdata('flashError');?> </div>
       <?php } ?>
    		<div class="notify_msgs">
            <div class="table-responsive">
            	<table class="table table-bordered">
                <thead>
                	<tr>
					    <th>S.N.</th>
                		<th>Meal Name </th>
                		<th>Category  Name</th>
						<th>Sub Category</th>
                		<th>Meal Price</th>
						<th>Meal Prepration Time</th>
						<th>Meal Description</th>
						<th>Meal Image</th>
						<th>Order Number</th>
                        <th class="text-center">Action</th>
                	</tr>
                </thead>
                <tbody>
					<?php $count=$this->uri->segment(3);
					      $count=$count?$count:0;
					foreach ($data as $meal){
					?>
                	<tr>
					    <td><?php echo ++$count;?></td>
                		<td style="text-transform: capitalize;">
						<?php echo $meal['meal_name']; ?></td>
                		<td><?php echo $meal['menu_name']; ?></td>
						<td><?php echo $meal['sub_menu_name']; ?></td>
						<td><?php echo $meal['meal_price'];?></td>
						<td><?php echo $meal['meal_prepration_time'];?></td>
						<td><?php echo $meal['meal_description'];?></td>
						<td><?php  if(!empty($meal['meal_image'])){?>
						<img src="<?php echo base_url().$meal['meal_image'];?>" class="img-thumbnail" width="80" height="80">
						<?php }?></td>
                		<td><?php echo $meal['order_no']; ?></td>
                		<td class="text-center">
						<a href="<?php echo base_url()?>meal/edit_meal/<?php echo $meal['meal_id']; ?>" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> <a href="#mealDel<?php echo $meal['meal_id'];?>" data-toggle="modal" class="delete_btn del"  title="Delete Meal"><i class="fa fa-trash"></i></a>
						</td>
                	</tr>
					
					<div id="mealDel<?php echo $meal['meal_id'];?>" class="modal fade" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete</h4>
					</div>
					<div class="modal-body">

					Are you sure want to delete this menu?

					</div>
					<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">CANCEL</button>
						<a class="btn btn-danger" href="<?php echo base_url().'meal/delete_meal/'.$meal['meal_id'];?>" >DELETE</a>
					</div>
					</div>
					</div>
					</div>
					
					<?php } ?>
                    
                </tbody>
                </table>
            </div>	
            
			
				<div class="text-center">
			<?php echo $this->pagination->create_links();?>
			</div>
	
	</div>
    </div>
</div>
