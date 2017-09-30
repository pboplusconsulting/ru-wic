
<div class="modal fade" id="feedbackModal" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
	    <div class="modal-content">
		    <div class="modal-header" style="background:#333;color:#fff">
		        <h4 class="modal-title">Feedback</h4>
		    </div>
			<form name="feedback" method="post" action="<?php echo base_url().'dashboard/feedback/'.$memberData->member_id.'/'.$memberData->table_booking_id; ?>">
            <div class="modal-body">
                <div class="table-responsive"><?php echo "<pre>";print_r($memberData);echo "</pre>";//die(); ?>
				
                    
						    <h5 style="text-align: center;"><b>Guest Comment Card</b></h5>
							<p style="text-align: center;">Date: <?php echo date('d/m/Y');?>&nbsp;&nbsp;&nbsp;Time: <?php echo date('h:i A');?>&nbsp;&nbsp;&nbsp;Server: <?php echo base_url();?> &nbsp;&nbsp;&nbsp;Zone: <?php ?>&nbsp;&nbsp;&nbsp;Table: <?php echo $memberData->table_name;?></p>
						
						<p class="clearfix"></p><p class="clearfix"></p><p class="clearfix"></p>
						<table class="table borderless">
						<tr><td><label>Name : </label> <?php echo $memberData->member_name;?></td></tr>
						<tr><td>Are you a WIC member</td><td><input type="radio" name="radio1" value='yes'> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="radio1" value='no'> No</td><td></td></tr>
						<tr><td>If No, Would you like to have a tour of WIC?</td><td><input type="radio" name="radio2" value='yes'> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="radio2" value='no'> No</td><td></td></tr>
						<tr><td>If No, please provide your mobile number</tr>
						<tr><td>Mobile Number</td><td><input type="text" name="textbox1" class="form-control"></td><td></td></tr>
						<tr><td>Email Address</td><td><input type="text" name="textbox2" class="form-control"></td><td></td></tr>
						<tr><td>Would you like to subscribe WIC newsletter?</td><td><input type="radio" name="radio3" value='yes'> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="radio3" value='no'> No</td><td></td></tr>
						</table>
						<p>Feedback (Please tick ✔ in the boxes below)</p>
						<table class="table" style="border:1px; border-collapse: collapse;">
						    <tr><th rowspan="2">Feedback</th><th rowspan="2">How can we give you better experience next time?</th><th colspan="3" style="text-align:center;">Rate Us</th></tr>
							<tr><th>Delighted</th><th>Satisfied</th><th>Disappointed</th></tr>

							<tr><td>Food Quality and Taste</td><td><input type="text" name="box11" class="form-control"></td><td style="text-align:center;"><input type="radio" name="radio11" value="2"></td><td style="text-align:center;"><input type="radio" name="radio11" value="1"></td><td style="text-align:center;"><input type="radio" name="radio11" value="0"></td></tr>
							<tr><td>Food Presentation</td><td><input type="text" name="box12" class="form-control"></td><td style="text-align:center;"><input type="radio" name="radio12" value="2"></td><td style="text-align:center;"><input type="radio" name="radio12" value="1"></td><td style="text-align:center;"><input type="radio" name="radio12" value="0"></td></tr>
							<tr><td>Serving Time</td><td><input type="text" name="box3" class="form-control"></td><td style="text-align:center;"><input type="radio" name="radio13" value="2"></td><td style="text-align:center;"><input type="radio" name="radio13" value="2"></td><td style="text-align:center;"><input type="radio" name="radio13" value="2"></td></tr>
							<tr><td>Variety in Menu</td><td><input type="text" name="box14" class="form-control"></td><td style="text-align:center;"><input type="radio" name="radio14" value="2"></td><td style="text-align:center;"><input type="radio" name="radio14" value="1"></td><td style="text-align:center;"><input type="radio" name="radio14" value="0"></td></tr>
							<tr><td>Reception</td><td><input type="text" name="box15" class="form-control"></td><td style="text-align:center;"><input type="radio" name="radio15" value="2"></td><td style="text-align:center;"><input type="radio" name="radio15" value="1"></td><td style="text-align:center;"><input type="radio" name="radio15" value="0"></td></tr>
							<tr><td>Staff Responsiveness</td><td><input type="text" name="box16" class="form-control"></td><td style="text-align:center;"><input type="radio" name="radio16" value="2"></td><td style="text-align:center;"><input type="radio" name="radio16" value="1"></td><td style="text-align:center;"><input type="radio" name="radio16" value="0"></td></tr>
							<tr><td>Ambience </td><td><input type="text" name="box17" class="form-control"></td><td style="text-align:center;"><input type="radio" name="radio17" value="2"></td><td style="text-align:center;"><input type="radio" name="radio17" value="1"></td><td style="text-align:center;"><input type="radio" name="radio17" value="0"></td></tr>
							<tr><td>Cleanliness</td><td><input type="text" name="box18" class="form-control"></td><td style="text-align:center;"><input type="radio" name="radio18" value="2"></td><td style="text-align:center;"><input type="radio" name="radio18" value="1"></td><td style="text-align:center;"><input type="radio" name="radio18" value="0"></td></tr>
							<tr><td>Steward's Communication</td><td><input type="text" name="box19" class="form-control"></td><td style="text-align:center;"><input type="radio" name="radio19" value="2"></td><td style="text-align:center;"><input type="radio" name="radio19" value="1"></td><td style="text-align:center;"><input type="radio" name="radio19" value="0"></td></tr>
							<tr><td>Overall WIC Experience</td><td><input type="text" name="box20" class="form-control"></td><td style="text-align:center;"><input type="radio" name="radio20" value="2"></td><td style="text-align:center;"><input type="radio" name="radio20" value="1"></td><td style="text-align:center;"><input type="radio" name="radio20" value="0"></td></tr>
						</table>					
				</div> 
            </div>
            <div class="modal-footer">
			    <button type="submit" class="btn btn-success btn-lg" name="save_feedback" >Submit</button>
                <a href="<?php echo base_url()?>dashboard" type="button" class="btn btn-primary btn-lg" >Remind me later</a>
				<a href="<?php echo base_url().'dashboard/decline_feedback/'.$memberData->table_booking_id;?>" type="button" class="btn btn-danger btn-lg" >Decline</a>
            </div>
			</form>
        </div>
    </div>
</div>