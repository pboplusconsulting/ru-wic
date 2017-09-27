<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
		<div class="row">
	    <div class="col-md-12"><div class="col-md-12"><label>User Name</label></div></div>
	   <div class="col-md-6">
    	<form name="" method="post" action="<?php echo base_url().'user';?>">
		<div class="col-md-6">
             <input type="text" class="form-control" name="search_str" value="<?php echo $search_str; ?>">
		</div>
		<div class="col-sm-6">
		<input type="submit" name="search" value="search" class="btn btn-default">
		</div>
		</form>
       </div>
		<div class="col-md-6 text-right">
    	<a href="<?php echo base_url()?>user/add_user" class="btn btn-ru mzero add_user">Add new</a>
		</div>
	</div>
    <div class="hd_top">
    	<h3>Users List</h3>
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
					    <th>S.N</th>
                		<th>Username </th>
                		<th>Email Id</th>
                		<th>Phone</th>
                        <th>Role</th>
                     <!--   <th>Status</th>-->
                        <th class="text-center">Action</th>
                	</tr>
                </thead>
                <tbody>
					<?php
                     $sn=$this->uri->segment(3);
					 $sn=$sn?$sn:0;
					foreach ($roles as $rol){
						$role_arr[$rol->role_id] = $rol->role_name;
					}
					$status=array(1=>'Active',0=>'Inactive');
					foreach ($data as $user_data){
						$role_id = $user_data['role'];
						$user_status = $user_data['status'];
					?>
                	<tr><td><?php echo ++$sn; ?></td>
                		<td style="text-transform: capitalize;"><?php echo $user_data['name']; ?></td>
                		<td><?php echo $user_data['email_id']; ?></td>
                		<td><?php echo $user_data['phone_number']; ?></td>
                		<td><?php echo $role_arr[$role_id]; ?></td>
                	<!--	<td><?php echo $status[$user_status]; ?></td>-->
                        <td class="text-center">
						 <?php if($user_data['user_id']!=1 && $user_data['user_id']!=$this->session->userdata('userID')) {?>
						<a href="<?php echo base_url()?>user/edit_user/<?php echo $user_data['user_id']; ?>" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> <a href="#userDel<?php echo $user_data['user_id'];?>" data-toggle="modal" class="delete_btn del"  title="Delete User"><i class="fa fa-trash"></i></a>
						 <?php } ?>
						</td>
                	</tr>
					
					<div id="userDel<?php echo $user_data['user_id'];?>" class="modal fade" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete</h4>
					</div>
					<div class="modal-body">

					Are you sure want to delete this user?

					</div>
					<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">CANCEL</button>
						<a class="btn btn-danger" href="<?php echo base_url().'User/delete_user/'.$user_data['user_id'];?>" >DELETE</a>
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
