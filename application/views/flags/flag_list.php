<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
	<div class="row">
	    <div class="col-md-12"><div class="col-md-12"><label>Meal Name</label></div></div>
	   <div class="col-md-6">
    	<form name="" method="post" action="<?php echo base_url().'flag'; ?>">
		<div class="col-md-6">
             <input type="text" class="form-control" name="search_str" value="<?php echo $search_str; ?>">
		</div>
		<div class="col-sm-6">
		<input type="submit" name="search" value="search" class="btn btn-default">
		</div>
		</form>
       </div>
		<div class="col-md-6 text-right">
			<a href="<?php echo base_url()?>flag/add_flag" class="btn btn-ru mzero add_user">Add new</a>
		</div>
	</div>

    <div class="hd_top">
    	<h3>Taxes and Discounts</h3>
    </div><p class="clearfix"></p>
      
      <?php 
	   if($this->session->flashdata('flashSuccess')) {?>
           <div class='alert alert-success'> <?php echo $this->session->flashdata('flashSuccess');?> </div>
       <?php } ?>
    		<div class="notify_msgs">
            <div class="table-responsive">
            	<table class="table table-bordered">
                <thead>
                	<tr>
					    <th>S.N.</th>
                		<th>Tax Name</th>
                        <th>Product Category</th>
                        <th>Percentage</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                	</tr>
                </thead>
                <tbody>
				
				
				
				<?php
				$count=$this->uri->segment(3);
					      $count=$count?$count:0;
					foreach ($taxes as $tax){
					?>
                	<tr>
					    <td><?php echo ++$count; ?></td>
                		<td style="text-transform: capitalize;"><?php echo $tax->tax_name;?></td>
                		<td><?php echo $tax->category_name;?></td>
						<td><?php echo $tax->tax_percent;?></td>
                		<td><?php echo $tax->status==1?'Active':'Inactive'; ?></td>
                        <td class="text-center">
						<a href="<?php echo base_url()?>flag/edit_flag/<?php echo $tax->tax_id; ?>" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
						
						
						</td>
                	</tr>
					
					<div id="flagDel<?php echo $tax->tax_id; ?>" class="modal fade" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete</h4>
					</div>
					<div class="modal-body">

					Are you sure want to delete?

					</div>
					<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">CANCEL</button>
						<a class="btn btn-danger" href="<?php echo base_url().'flag/delete_flag/'.$tax->tax_id;?>" >DELETE</a>
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
