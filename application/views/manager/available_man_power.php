<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div> 
    <div class="container-fluid">
    	
		<div class="hd_top">
			<h3>Member List</h3>
		</div>
        <p class="clearfix"></p>
		<p class="clearfix"></p>
				<p class="clearfix"></p>
		<table class="table table-hover">
			<thead>
			  <tr>
				<th>S.N.</th>
				<th>User Image</th>
				<th>Name</th>
				<th>email Id</th>
				<th>Role</th>
				<th></th>
			  </tr>
			</thead>
			<tbody>
			<?php $rowno=1;$memberTypeArr=$this->config->item('membership_type_array');
			foreach($data as $row) {
			?>
			  <tr>
				<td><?php echo $rowno++; ?></td>
				<td> <img src="<?php echo empty($row['image'])?base_url().'assets/img/user_pic.png':base_url().'images/users/'.$row['image'] ?>" height="40px" width="40px"></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['email_id']; ?></td>
				<td><?php if($row['role']==3) echo 'Waiter'; if($row['role']==4) echo 'Chef' ?></td>
				<td></td>
			  </tr>
			<?php } ?>  
			</tbody>
			
		</table>	
		
	</div>
	
</div>
