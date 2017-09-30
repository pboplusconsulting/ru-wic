<br>
<style>
table td,table th{
vertical-align:middle !important;	
}
</style>
<div class="container">
<div class="panel panel-default table-feedback">
  <div class="panel-heading">Member Feedback</div>
  <div class="panel-body" style="padding:0;">
  <header class="text-center" style="background: #eee; padding: 20px 0; margin-bottom: 20px;">
        <h5 style="margin: 0 0 20px 0; font-size: 2rem;"><b>Guest Comment Card</b></h5>
        <p>Date: <?php echo date('d/m/Y');?>&nbsp;&nbsp;&nbsp;Time: <?php echo date('h:i A');?>&nbsp;&nbsp;&nbsp;Server: <?php echo $this->session->userdata('name');?>
          &nbsp;&nbsp;&nbsp;Table: <?php echo $memberData->table_name;?></p>
      </header>
    <div class="col-xs-12">
    <form name="feedback" method="post" action="<?php echo base_url().'dashboard/feedback/'.$memberData->member_id.'/'.$memberData->table_booking_id; ?>">
        <?php //echo "<pre>";print_r($memberData);echo "</pre>";//die(); ?>
        
      
       <div class="table-responsive">
        <table class="table borderless">
          <tr>
            <td colspan="3"><label>Name : </label>
              <?php echo $memberData->member_name;?> <?php if(!empty($memberData->guest_comment)) { echo "(".$memberData->guest_comment.")";} ?></td>
          </tr>
          <tr>
            <td>Are you a WIC member</td>
            <td><input type="radio" name="radio1" value='yes'>
              <span>Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" name="radio1" value='no'>
              <span>No</span></td>
            <td></td>
          </tr>
          <tr id="not-wic-member" hidden>
            <td>If No, Would you like to have a tour of WIC?</td>
            <td><input type="radio" name="radio2" value='no'>
              <span>Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" name="radio2" value='no'>
              <span>No</span></td>
            <td></td>
          </tr>
          <tr class="no-wic-tour" hidden>
            <td colspan="3">Please provide your mobile number and email address</td>
          </tr>
          <tr class="no-wic-tour" hidden>
            <td>Mobile Number</td>
            <td><input type="text" name="textbox1" class="form-control" value="<?php echo !empty($memberData->phone_number)?$memberData->phone_number:''; ?>"></td>
            <td></td>
          </tr>
          <tr class="no-wic-tour" hidden>
            <td>Email Address</td>
            <td><input type="text" name="textbox2" class="form-control" value="<?php echo !empty($memberData->email_id)?$memberData->email_id:''; ?>"></td>
            <td></td>
          </tr>
          <tr>
            <td>Would you like to subscribe WIC newsletter?</td>
            <td><input type="radio" name="radio3" value='yes'>
              <span>Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" name="radio3" value='no'>
              <span>No</span><strong></strong></td>
            <td></td>
          </tr>
        </table>
        </div>
        <br>
        <br>
        <p>&nbsp;&nbsp;Feedback (Please tick ✔ in the boxes below)</p>
        <div class="table-responsive">
        <table class="table table-striped" style="border:1px; border-collapse: collapse;">
          <thead>
          <tr>
            <th rowspan="2">Feedback</th>
            <th rowspan="2">How can we give you better experience next time?</th>
            <th colspan="3" style="text-align:center;">Rate Us</th>
          </tr>
          <tr>
            <th>Delighted</th>
            <th>Satisfied</th>
            <th>Disappointed</th>
          </tr>
          </thead>
          <tbody valign="middle">          
          
          <tr>
            <td>Food Quality and Taste</td>
            <td><input type="text" name="box11" class="form-control"></td>
            <td style="text-align:center;"><input type="radio" name="radio11" value="2"></td>
            <td style="text-align:center;"><input type="radio" name="radio11" value="1"></td>
            <td style="text-align:center;"><input type="radio" name="radio11" value="0"></td>
          </tr>
          <tr>
            <td>Food Presentation</td>
            <td><input type="text" name="box12" class="form-control"></td>
            <td style="text-align:center;"><input type="radio" name="radio12" value="2"></td>
            <td style="text-align:center;"><input type="radio" name="radio12" value="1"></td>
            <td style="text-align:center;"><input type="radio" name="radio12" value="0"></td>
          </tr>
          <tr>
            <td>Serving Time</td>
            <td><input type="text" name="box3" class="form-control"></td>
            <td style="text-align:center;"><input type="radio" name="radio13" value="2"></td>
            <td style="text-align:center;"><input type="radio" name="radio13" value="1"></td>
            <td style="text-align:center;"><input type="radio" name="radio13" value="0"></td>
          </tr>
          <tr>
            <td>Variety in Menu</td>
            <td><input type="text" name="box14" class="form-control"></td>
            <td style="text-align:center;"><input type="radio" name="radio14" value="2"></td>
            <td style="text-align:center;"><input type="radio" name="radio14" value="1"></td>
            <td style="text-align:center;"><input type="radio" name="radio14" value="0"></td>
          </tr>
          <tr>
            <td>Reception</td>
            <td><input type="text" name="box15" class="form-control"></td>
            <td style="text-align:center;"><input type="radio" name="radio15" value="2"></td>
            <td style="text-align:center;"><input type="radio" name="radio15" value="1"></td>
            <td style="text-align:center;"><input type="radio" name="radio15" value="0"></td>
          </tr>
          <tr>
            <td>Staff Responsiveness</td>
            <td><input type="text" name="box16" class="form-control"></td>
            <td style="text-align:center;"><input type="radio" name="radio16" value="2"></td>
            <td style="text-align:center;"><input type="radio" name="radio16" value="1"></td>
            <td style="text-align:center;"><input type="radio" name="radio16" value="0"></td>
          </tr>
          <tr>
            <td>Ambience </td>
            <td><input type="text" name="box17" class="form-control"></td>
            <td style="text-align:center;"><input type="radio" name="radio17" value="2"></td>
            <td style="text-align:center;"><input type="radio" name="radio17" value="1"></td>
            <td style="text-align:center;"><input type="radio" name="radio17" value="0"></td>
          </tr>
          <tr>
            <td>Cleanliness</td>
            <td><input type="text" name="box18" class="form-control"></td>
            <td style="text-align:center;"><input type="radio" name="radio18" value="2"></td>
            <td style="text-align:center;"><input type="radio" name="radio18" value="1"></td>
            <td style="text-align:center;"><input type="radio" name="radio18" value="0"></td>
          </tr>
          <tr>
            <td>Steward's Communication</td>
            <td><input type="text" name="box19" class="form-control"></td>
            <td style="text-align:center;"><input type="radio" name="radio19" value="2"></td>
            <td style="text-align:center;"><input type="radio" name="radio19" value="1"></td>
            <td style="text-align:center;"><input type="radio" name="radio19" value="0"></td>
          </tr>
          <tr>
            <td><b>Overall WIC Experience</b></td>
            <td><input type="text" name="box20" class="form-control"></td>
            <td style="text-align:center;"><input type="radio" name="radio20" value="2"></td>
            <td style="text-align:center;"><input type="radio" name="radio20" value="1"></td>
            <td style="text-align:center;"><input type="radio" name="radio20" value="0"></td>
          </tr>
          </tbody>
        </table>
        </div>
      
      <div style="text-align:center">
        <button type="submit" class="btn btn-success btn-lg" name="save_feedback" >Submit</button>
        &nbsp;&nbsp;&nbsp;&nbsp; <!--<a href="<?php echo base_url()?>dashboard" type="button" class="btn btn-primary btn-lg" >Cancel</a>-->
        <a href="#cancelreason" data-toggle="modal"  title="Cancel Reason" type="button" class="btn btn-primary btn-lg" >Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo base_url()?>dashboard" type="button" class="btn btn-danger btn-lg" >Close</a>
        </div>
        <br><br>
    </form>
    </div>
  </div>
</div>
</div>


<div id="cancelreason" class="modal fade" role="dialog" aria-hidden="true">
<form name="f1" method="post" action="<?php echo base_url().'dashboard/cancel_reason/'.$memberData->member_id.'/'.$memberData->table_booking_id; ?>">
          <div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
					<h4 class="modal-title">Cancel Reason</h4>
			</div>
			<div class="modal-body">
	<textarea name="cancel_reason" id="cancel_reason" class="form-control" required></textarea>
				</div>
			<div class="modal-footer">
				<!--<button data-dismiss="modal" class="btn btn-primary btn-lg" type="button">CANCEL</button>-->
                <button class="btn btn-success btn-lg" type="submit">Submit</button>
				<!--		<a class="btn btn-success btn-lg" href="#" >Submit</a>-->
			</div>
			</div>
			</div>
        </div>
