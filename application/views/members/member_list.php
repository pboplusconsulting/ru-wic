<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
    <div class="text-right">
    <!--	<a href="<?php echo base_url()?>members/add_member" class="btn btn-ru mzero add_user">Add new</a>-->
    </div>
    <div class="hd_top">
    	<h3>Member List</h3>
    </div><p class="clearfix"></p>
      
      <?php 
	   if($this->session->flashdata('flashSuccess')) {?>
           <div class='alert alert-success'> <?php echo $this->session->flashdata('flashSuccess');?> </div>
       <?php } ?>
    		<div class="notify_msgs">
            <div class="table-responsive">
            	<table class="table table-bordered">
                <thead>
                	<tr><th>S.N</th>
                		<th>Membership ID </th>
                		<th>Member Name</th>
                		<th>Email Id</th>
                		<th>Phone</th>
                        <th>Membership Type</th>
                        <th>D.O.B</th>
                        <th>Marital Status</th>
                        <th>Anniversary Date</th>
                    <!--    <th>Status</th>-->
                    <!--    <th class="text-center">Action</th> -->
                	</tr>
                </thead>
                <tbody>
					<?php 
					$sn=$this->uri->segment(3);
					 $sn=$sn?$sn:0;
					//$status=$this->config->item('item_status');
					$marital_status_arr=$this->config->item('marital_status');
					$membership_type_array = $this->config->item('membership_type_array');
					foreach ($data as $member_data){
						$member_status = $member_data->status;
						$membership_type = $member_data->membership_type;
						$marital_status = $member_data->marital_status;
					?>
                	<tr><td><?php echo ++$sn; ?></td>
                		<td><?php echo $member_data->membership_id; ?></td>
                		<td style="text-transform: capitalize;"><?php echo $member_data->member_name; ?></td>
                		<td><?php echo $member_data->email_id; ?></td>
                		<td><?php echo $member_data->phone_number; ?></td>
                		<td><?php echo $membership_type_array[$membership_type]; ?></td>
                		<td><?php echo $member_data->date_of_birth=='0000-00-00'?'':date('d/m/y',strtotime($member_data->date_of_birth)); ?></td>
                		<td><?php echo $marital_status_arr[$marital_status]; ?></td>
                		<td><?php echo $member_data->anniversary_date=='0000-00-00'?'':date('d/m/y',strtotime($member_data->anniversary_date)); ?></td>
                	<!--	<td><?php echo $status[$member_status]; ?></td>-->
                    <!--    <td class="text-center">
						<a href="<?php echo base_url()?>members/edit_member/<?php echo $member_data->id; ?>" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> <a href="#memberDel<?php echo $member_data->id; ?>" data-toggle="modal" class="delete_btn del"  title="Delete Member"><i class="fa fa-trash"></i></a>
						
						</td> -->
                	</tr>
					
					<div id="memberDel<?php echo $member_data->id; ?>" class="modal fade" role="dialog" aria-hidden="true">
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
						<a class="btn btn-danger" href="<?php echo base_url().'members/delete_member/'.$member_data->id;?>" >DELETE</a>
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
