<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
	<div class="row">
	    <div class="col-md-12"><div class="col-md-12"><label>Meal Name</label></div></div>
	   <div class="col-md-6">
    	<form name="" method="post" action="<?php echo base_url().'menu/menu_list'; ?>">
		<div class="col-md-6">
             <input type="text" class="form-control" name="search_str" value="<?php echo $search_str; ?>">
		</div>
		<div class="col-sm-6">
		<input type="submit" name="search" value="search" class="btn btn-default">
		</div>
		</form>
       </div>
		<div class="col-md-6 text-right">
			<a href="<?php echo base_url()?>menu/add_menu" class="btn btn-ru mzero add_user">Add New</a>
		</div>
	</div>
    <div class="hd_top">
    	<h3>Menu List</h3>
    </div><p class="clearfix"></p>
      
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
                		<th>Name </th>
                		<th>Product Category</th>
                		<th>Order Number</th>
                        <th class="text-center">Action</th>
                	</tr>
                </thead>
                <tbody>
					<?php
					foreach ($data as $menu){
					?>
                	<tr>
                		<td style="text-transform: capitalize;">
						<?php echo $menu['menu_name']; ?></td>
                		<td><?php echo $menu['category_name'];?></td>
                		<td><?php echo $menu['order_no']; ?></td>
                		<td class="text-center">
						<a href="<?php echo base_url()?>menu/edit_menu/<?php echo $menu['menu_id']; ?>" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> <a href="#menuDel<?php echo $menu['menu_id'];?>" data-toggle="modal" class="delete_btn del"  title="Delete Menu"><i class="fa fa-trash"></i></a>
						</td>
                	</tr>
					
					<div id="menuDel<?php echo $menu['menu_id'];?>" class="modal fade" role="dialog" aria-hidden="true">
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
						<a class="btn btn-danger" href="<?php echo base_url().'menu/delete_menu/'.$menu['menu_id'];?>" >DELETE</a>
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
			
			
           <!-- <div class="text-center">
            	<nav aria-label="Page navigation">
  <ul class="pagination">
    <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">«</span>
      </a>
    </li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">»</span>
      </a>
    </li>
  </ul>
</nav>
            </div>	-->	
	</div>
    </div>
</div>
