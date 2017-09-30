<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
    <div class="text-right">
    	<a href="<?php echo base_url()?>family/add_member" class="btn btn-ru mzero add_user">Add New</a>
    </div>
    <div class="hd_top">
    	<h3>Family Member List</h3>
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
					    <th>S.N.</th>
                		<th>Person Name </th>
                		<th>Belongs To(Member)</th>
						<th>Relation To(Member)</th>
                		<th>Email Id</th>
						<th>Contact No.</th>
					<!--	<th>Status</th>-->
                        <th class="text-center">Action</th>
                	</tr>
                </thead>
                <tbody>
					<?php $count=0;
					foreach ($data as $member){
					?>
                	<tr>
					    <td><?php echo ++$count;?></td>
                		<td style="text-transform: capitalize;">
						<?php echo $member['person_name']; ?></td>
                		<td><?php echo $member['member_name']; ?></td>
						<td><?php echo $member['relation'];?></td>
						<td><?php echo $member['email_id'];?></td>
						<td><?php echo $member['phone_number'];?></td>
                	<!--	<td><?php echo $member['status']==1?'Active':'Inactive'; ?></td>-->
                		<td class="text-center">
						<a href="<?php echo base_url()?>family/edit_member/<?php echo $member['family_member_id']; ?>" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> <a href="#memberDel<?php echo $member['family_member_id'];?>" data-toggle="modal" class="delete_btn del"  title="Delete Member"><i class="fa fa-trash"></i></a>
						</td>
                	</tr>
					
					<div id="memberDel<?php echo $member['family_member_id'];?>" class="modal fade" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete</h4>
					</div>
					<div class="modal-body">

					Are you sure want to delete this member?

					</div>
					<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">CANCEL</button>
						<a class="btn btn-danger" href="<?php echo base_url().'family/delete_member/'.$member['family_member_id'];?>" >DELETE</a>
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
