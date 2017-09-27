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
				<th>Member Name</th>
				<th>membership Id</th>
				<th>email Id</th>
				<th>Phone Number</th>
				<th>Membership Type</th>
				<th>Date of Birth</th>
				<th></th>
			  </tr>
			</thead>
			<tbody>
			<?php $rowno=1;$memberTypeArr=$this->config->item('membership_type_array');
			foreach($data as $row) {
			?>
			  <tr>
				<td><?php echo $rowno++; ?></td>
				<td><?php echo $row['member_name']; ?></td>
				<td><?php echo $row['membership_id']; ?></td>
				<td><?php echo $row['email_id']; ?></td>
				<td><?php echo $row['phone_number']; ?></td>
				<td><?php echo $memberTypeArr[$row['membership_type']]; ?></td>
				<td><?php echo $row['date_of_birth']!='0000-00-00'?date('d M Y',strtotime($row['date_of_birth'])):''; ?></td>
				<td></td>
			  </tr>
			<?php } ?>  
			</tbody>
			
		</table>	
		
	</div>
	
</div>
