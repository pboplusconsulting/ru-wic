<?php if(count($data) > 0) { //echo '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
 foreach($data as $member){ //echo "<pre>";print_r($member);echo "</pre>";die();
	if($member['booking_status']==0){?>
<div class="panel panel-default">
				<div class="panel-heading unbook" role="tab" id="heading_unbook<?php echo $member['id'];?>">
				<h4 class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_a<?php echo $member['id'];?>" aria-expanded="false" aria-controls="collapse2">
				  <img src="<?php echo base_url()?>assets/img/user_pic.png" class="img-circle" alt="userpic" width="30" /> <?php echo strlen($member['member_name'])>15?ucfirst(substr($member['member_name'],0,14)).'..':ucfirst($member['member_name']); ?>
				  
				</a>
				<a href="#" class="book_now"  data-toggle="modal" data-target="#booknow<?php echo $member['id'];?>">Book Now</a>
				
			  </h4>

				</div>
        <div id="collapse_a<?php echo $member['id'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_unbook<?php echo $member['id'];?>">
            <div class="panel-body">
            
            
              <div class="tabbable-panel">
				<div class="tabbable-line">
					<ul class="nav nav-tabs ">
						<li class="active">
							<a href="#tab_default_<?php echo $member['id'];?>" data-toggle="tab">
							About Guest </a>
						</li>
					</ul>
					<div class="tab-content">
						
                        <div class="tab-pane active" id="tab_default_<?php echo $member['id'];?>">
								<div class="about_user_desc">
								<h5>Member ID : <?php echo $member['membership_id'];?></h5>
                                	<div class="row">
                                    	
										<div class="col-sm-6">
                                        		<div class="fav_meal df_abu">
                                                		<h5>Favourate Meal</h5>
                                                        <?php $meals= $this->Dash_model->fevourite_meal($member['id']);
														if(count($meals)>0){
														?>
                                                        <ul class="list-unstyled">
														<?php foreach($meals as $meal){
                                                        echo "<li>".$meal['meal_name']."</li>";
														}
														?>
                                                        	
                                                        </ul>
														<?php } else{ echo "<p>No Favourite Meal Found!</p>";} ?>
                                                    
													
                                                </div>
                                        </div>
                                        <div class="col-sm-6">
                                        		<div class="fav_meal df_abu">
                                                		<h5>Preferences</h5>
                                                        <?php $meals= $this->Dash_model->preferences($member['id']);
														if(count($meals)>0){
														?>
                                                        <ul class="list-unstyled">
														<?php foreach($meals as $meal){
                                                        echo "<li>".$meal['menu_name']."</li>";
														}
														?>
                                                        	
                                                        </ul>
														<?php } else{ echo "<p>No Prefered Meal Found!</p>";} ?>
                                                    <!--    <div class="add_more_btn">
                                                        	<span><i class="fa fa-plus"></i></span>
                                                        </div>-->
                                                </div>
                                        </div>
										
										<p class="clearfix"></p>
                                        
										<div class="col-sm-6">
                                        		<div class="fav_meal df_abu">
                                                	
													<h5>Last Order</h5>
														<?php $meals= $this->Dash_model->last_meal($member['id']);
														if(count($meals)>0){
														?>
                                                        <ul class="list-unstyled">
														<?php foreach($meals as $meal){
                                                        echo "<li>".$meal['meal_name']."</li>";
														}
														?>
                                                        	
                                                        </ul>
														<?php } else{ echo "<p>Record not Found!</p>";} ?>
													
                                                </div>
                                        </div>
										<div class="col-sm-6">
                                        		<div class="fav_meal df_abu">
                                                		<h5>Table Prefered</h5>
														<?php $preferedTable= $this->Dash_model->table_prefered($member['id']);
														if(count($preferedTable)>0){
														?>
                                                        <ul class="list-unstyled">
														<?php foreach($preferedTable as $pt){
                                                        echo "<li>".$pt['table_name']."</li>";
														}
														?>
                                                        	
                                                        </ul>
														<?php } else{ echo "<p>No Booking Record Found!</p>";} ?>
                                                    <!--    <div class="add_more_btn">
                                                        	<span><i class="fa fa-plus"></i></span>
                                                        </div>-->
                                                </div>
                                        </div>
										<p class="clearfix"></p>
                                        <div class="col-sm-6">
                                        		<div class="fav_meal df_abu">
                                                    
													<h5>Last Bill</h5>
                                                        <?php $last_bill= $this->Dash_model->last_bill($member['id']);//print_r($last_bill);
														if($last_bill!=null){
														?>
                                                        <ul class="list-unstyled">
														<?php
                                                        echo "<li>Sub Total: ".$last_bill->amount."</li>"."<li>Discount: ".$last_bill->discount."</li>"."<li>Total ".($last_bill->amount-$last_bill->discount)."</li>"."<li>Tax ".$last_bill->tax."</li>"."<li>Gross Total: ".$last_bill->final_amount."</li>";
														?>
                                                        	
                                                        </ul>
														<?php } else{ echo "<p>Billig record not found!</p>";} ?>
                                                </div>
                                        </div>
										<div class="col-sm-6">
                                        		<div class="fav_meal df_abu">
                                                		<h5>Average Billing</h5>
                                                        <?php $average_billing= $this->Dash_model->average_billing($member['id']);
														if($average_billing!=null && $average_billing->attended > 0){
														?>
                                                        <ul class="list-unstyled">
														<?php
                                                        echo "<li>".floor($average_billing->total_bill/$average_billing->attended)."</li>";
													
														?>
                                                        	
                                                        </ul>
														<?php } else{ echo "<p>Billig record not found!</p>";} ?>
                                                    
                                                </div>
                                        </div>
                                	</div>
                            	</div>
						</div>
						
					</div>
				</div>
			</div>
            
            
            
            </div>
				</div>
			</div>
			
						<!-- Modal -->
			<div id="booknow<?php echo $member['id'];?>" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				<form method="post" action="" class="booknow" data-parsley-validate="">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php echo $member['member_name'];?></h4>
				  </div>
				  <div class="modal-body">
					<div class="row">
					
					    <input type="text" value="<?php echo $member['id'];?>" name="member" hidden>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Total Guest</label>
								<input type="number" name="total_guest" class="form-control numeric" placeholder="Total number of guest" required min="1">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Referral Name</label>
								<input type="text" name="guest_comment" class="form-control numeric" placeholder="Referral Name">
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="form-group">
								<label>Available Tables</label><br>
								<select class="multiselect-tbl avalTable" name="table_number[]" required  multiple>
								<!--	<option value="">select</option>-->
									<?php foreach($availableTables as $available) { 
									if(($available['table_status']==0 && $available['Advance_booking_status']==0) ||  $available['table_name']=='Parcel')
									{?>
									<option value="<?php echo $available['id'];?>"><?php echo $available['table_name'];?></option>
	                                <?php }} ?>
								</select>
							</div>
						</div>
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="submit" name="book_now" class="btn btn-success">Save</button>
				  </div>
				  </form>
				</div>

			  </div>
			</div>
			
<?php }else if($member['booking_status']==1){ //print_r($member);die();
	
	$orderData=$this->Dash_model->get_order_data($member['table_booking_id']);
	$feedback=$this->Dash_model->get_by_query_return_row("SELECT * FROM ru_feedback WHERE table_booking_id=".$member['table_booking_id']." AND status=1");
	$ratingArr=$this->config->item('feedback_rating');
	$member_status=$this->config->item('member_status');	
	$total_orders=$this->Dash_model->total_orders($member['table_booking_id']);
	$no_of_delay=$this->Dash_model->no_of_dalay_order($member['table_booking_id']);
	$no_of_complete=$this->Dash_model->no_of_complete_order($member['table_booking_id']);
	$no_of_cancel=$this->Dash_model->no_of_cancel_order($member['table_booking_id']);
	$no_of_unread=$this->Dash_model->no_of_unread_oreder($member['table_booking_id']);
    $check_bill_status=$this->Dash_model->check_bill_status($member['table_booking_id']);
	$number_of_bills_required=$this->Dash_model->number_of_bills($member['table_booking_id']);
	
    if($member['member_status']==0 || $member['member_status']==4){$tiles_color="#f8be5d"; } //Table relevied
			//elseif($feedback != null) { $tiles_color="#f8be5d"; } //Table relevied
			else if($no_of_delay > 0){ $tiles_color="#d9534f"; } //Order Delayed 
			else if(count($orderData)>0 && count($orderData)==($no_of_complete+$no_of_cancel)){$tiles_color="#5cb85c";} //Order Served
			else if(count($orderData)==0){ $tiles_color="#FF5500";} //Table Booked
			else { $tiles_color="#d9534f"; } //Order panding	
	?>

           <div class="panel panel-default">
			<div class="panel-heading <?php echo $no_of_delay>0?'inside_guest_delay':'inside_guest'?> <?php echo (count($orderData)>0 && count($orderData)==($no_of_complete+$no_of_cancel)?'completed_all':''); ?>" style="background:<?php echo $tiles_color; ?>" role="tab" id="heading<?php echo $member['table_booking_id'];?>">
		        <h4 class="panel-title"><small class="tile_msg"></small>
			        <a class="collapsed"  data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $member['table_booking_id'];?>" aria-expanded="false" aria-controls="collapse1">
			        <img src="<?php echo base_url()?>assets/img/user_pic.png" class="img-circle" alt="userpic" width="30" /> <?php echo strlen($member['member_name'])>11?ucwords(strtolower(substr($member['member_name'],0,10))).'..':ucwords(strtolower($member['member_name'])); ?>
					
					<span class="badge"><?php echo $no_of_complete.'<i class="divider"></i>'.($total_orders); ?></span>
			        <!--<span class="table_num"><strong><?php $tbl=explode(',',$member['table_name']); echo count($tbl)>2?$tbl[0].','.$tbl[1].',..':$member['table_name']; ?></strong></span>-->
                    
                    	   <span class="table_num">
                               <?php 
							   $tbl=explode(',',$member['table_name']);
							   if(count($tbl)>0) { foreach($tbl as $key=>$value) { ?>
                               <strong><?php echo $value?></strong>
                               <?php } }?>
                              </span>
                              
			        </a>
					<span class="mini-about ft-10">
				<b>Arrival: <i><?php echo date('h:i A',strtotime($member['booking_time']));?></i></b>
				
				<!-----  old running code
				<br><b><i>
				<?php if($no_of_delay > 0){echo 'Order Delayed<br>'.$no_of_delay.' dish delayed';}
				else if(count($orderData)>0 && count($orderData)==($no_of_complete+$no_of_cancel)){ echo 'Order Served';}
				else { echo $member_status[$member['member_status']];}
				?>
				</i></b> -->
				
	             <!---- Start new replaced-->
				 <?php if($member['member_status']==0){  echo '<br><b><i>'.$member_status[$member['member_status']].'</i></b>';}
				 elseif($member['member_status']==4 && $member['table_status']==0) { 
						   echo '<br><b><i>Table Relieved</i></b>';
					}
				 else if($no_of_delay > 0){ ?>
					<br><b><i><?php echo 'Order Delayed';?></i></b><br><b><i><?php echo $no_of_delay.' dish delayed';?></i></b>
					<?php }
					 else if(count($orderData)>0 && count($orderData)==($no_of_complete+$no_of_cancel)){ echo '<br><b><i>Order Served</i></b>'; 
					} else if(count($orderData)==0){ echo '<br><b><i>Table Booked</i></b>';
					} else { echo '<br><b><i>Order Pending</i></b>'; } ?>
				<!-- End comment -->
				
				
				
				</span>
		       </h4>
            </div><script>$('#multiselecttables').multiselect();</script>
          <div id="collapse<?php echo $member['table_booking_id'];?>" class="panel-collapse collapse inside_guest" role="tabpanel" aria-labelledby="heading1">
            <div class="panel-body">
            		<div class="tabbable-panel">
				<div class="tabbable-line">
					<ul class="nav nav-tabs ">
						<li>
								<a href="#tab_default2_<?php echo $member['table_booking_id']?>" data-toggle="tab">About Guest</a>
							</li>
						    <li class="active">
							   <a href="#tab_default1_<?php echo $member['table_booking_id'];?>" data-toggle="tab">Take Order</a>
						    </li>
							<li>
							   <a href="#tab_default3_<?php echo $member['table_booking_id'];?>" data-toggle="tab">Order Status</a>
						    </li>

							<li>
                                 <a href="#tab_default5_<?php echo $member['table_booking_id'];?>" data-toggle="tab" class="member-bill" data-bookingid="<?php echo $member['table_booking_id'];?>">Meal Bill</a>
						    </li>
							
							<li>
                                 <a href="#tab_default7_<?php echo $member['table_booking_id'];?>" data-toggle="tab" class="member-bill2" data-bookingid="<?php echo $member['table_booking_id'];?>">Alcohol Bill</a>
						    </li>
							
							<li>
							    <a href="#tab_default6_<?php echo $member['table_booking_id'];?>" data-toggle="tab" class="member-bill" data-bookingid="<?php echo $member['table_booking_id'];?>">Payment Status</a>
								
						    </li>
							
							<li>
							     <?php
                                if($member['member_status']!=0){
                               									
								 if($feedback == null) { 
								 //if($number_of_bills_required > 0 && ($number_of_bills_required!=$check_bill_status->generated_bills || $check_bill_status->no_of_unpaid>0))
								     //{?>
									   <!-- <a href="#tab_default4_<?php echo $member['table_booking_id'];?>" data-toggle="tab">Feedback</a> -->
								    <?php //}else {
								 ?>
							     <a href="<?php echo base_url().'dashboard/feedback/'.$member['table_booking_id']?>" data-tablebookingid="<?php echo $member['table_booking_id'];?>" class="member-feedback">Feedback</a>
								 <?php } //} 
								 
								 else { ?>
								 <a href="#tab_default4_<?php echo $member['table_booking_id'];?>" data-toggle="tab">Feedback</a>
								 <?php
								}
								} ?>
							</li>
					</ul>
					<div class="tab-content">
					
					<div class="tab-pane" id="tab_default6_<?php echo $member['table_booking_id'];?>">
                        
							  <?php  
							        $query = $this->db->query('SELECT * FROM ru_order_bill WHERE table_booking_id='.$member['table_booking_id']);
								    $payment_row=$query->row();
								    //print_r($payment_row);
								    $final_amount=$this->db->query("SELECT SUM(final_amount) AS final_amount FROM ru_order_bill WHERE table_booking_id=".$member['table_booking_id'])->row()->final_amount;
								 
								    $myrows=$query->num_rows();
								
								    $number_of_bills=$this->Dash_model->number_of_bills($member['table_booking_id']);
								    $new_meal_order=$this->Dash_model->check_new_meal_order_bill($member['table_booking_id']);
								    $new_alcohol_order=$this->Dash_model->check_new_alcohol_order_bill($member['table_booking_id']);
								    $isBillPaid=$this->Dash_model->isBillPaid($member['table_booking_id']);
								
								    if($member['member_status'] == 1){echo "<br><br><h6 style='text-align:center;'>Please add order first.</h6><br>";}
								    else if($member['member_status'] == 2){echo "<br><br><h6 style='text-align:center;'>please wait till order are completed.</h6><br>";}
								    else if($member['member_status'] == 3){
									    if($myrows < $number_of_bills) { echo "<br><br><h6 style='text-align:center;'>Please generate bill.</h6><br>";}
                                        else if($new_meal_order){
										echo "<br><br><h6 style='text-align:center;'>Please regenerate meal bill.</h6><br>";
									     }
									    else if($new_alcohol_order)
									    {
										      echo "<br><br><h6 style='text-align:center;'>Please regenerate alcohol bill.</h6><br>";
									    }	
									    else if ($isBillPaid == $number_of_bills)
									    {
								?>
								          <p class="clearfix"></p>
										  <div class="col-xs-12"><label>Payment Status</label> : <?php echo $payment_row->bill_status==1?'Paid':'Pending';?>
										  </div>
										  <div class="col-xs-12"><label>Payment Amount</label> : <?php echo $final_amount ?>
										  </div>
										  <div class="col-xs-12"><label>Payment Method</label> : <?php echo $payment_row->payment_method?>
										  </div>
										
								<?php   }
										else { ?>
										   
										   <form name="payment_form" method="post" action="<?php echo base_url().'dashboard/save_payment_status/'.$member['table_booking_id'] ?>">
										  
											<input type="hidden" name="payment_amount" id="payment_amount" value="<?php echo $final_amount ?>">
												<div class="col-xs-6">Payment Status: <select name="payment_status1" id="payment_status1"  class="form-control payment_status1"  required>
											  <option value="0" <?php if($payment_row->bill_status=='0') echo 'selected';?>>Pending</option>  
										   <option value="1" <?php if($payment_row->bill_status=='1') echo 'selected';?>>Paid</option> 
										 
											</select>
											</div>
											
										  <p class="clearfix"></p>
											<div class="col-xs-6 id_name" id="id_name" style="display:none;">Payment Amount: <input type="text" value="<?php echo $final_amount ?>" class="form-control" disabled>
											</div>
										  
											<div class="col-xs-6 id_tid" id="id_tid"  style="display:none;">Payment Method: <select name="payment_method" id="payment_method"  required class="form-control"> 
											<option value="">Select</option> 
										   <option value="Cash" <?php if($payment_row->payment_method=='Cash') echo 'selected';?>>Cash</option> 
										   <option value="Card"  <?php if($payment_row->payment_method=='Card') echo 'selected';?>>Card</option> 
											<option value="Credit" <?php if($payment_row->payment_method=='Credit') echo 'selected';?> >Credit</option>						   
											</select></div>
											<p class="clearfix"></p>
											 <div class="col-xs-5">
											 <input type="hidden" name="table_bookingid" id="table_bookingid" value="<?php echo $member['table_booking_id'];?>">
											<input type="submit" name="btn_payment_amount" value="Save" class="btn btn-success btn-lg">
											 </div>
											</form>
							
							  <?php }}

							  else if($member['member_status'] == 4) { ?>
							  <p class="clearfix"></p>
								  <div class="col-xs-12"><label>Payment Status</label> : <?php echo $payment_row->bill_status==1?'Paid':'Pending';?>
								  </div>
								  <div class="col-xs-12"><label>Payment Amount</label> : <?php echo $final_amount ?>
								  </div>
								  <div class="col-xs-12"><label>Payment Method</label> : <?php echo $payment_row->payment_method?>
								  </div>
							  <?php }
							  
							  else {
								  echo "<br><br><h6 style='text-align:center;'>Bill not available.</h6><br>";
							  }
							  ?>                            
                    </div>
					
					
						<div class="tab-pane active" id="tab_default1_<?php echo $member['table_booking_id'];?>">
						<!--    <div class="col-xs-6">
                            	<strong><small>Status : <i><?php echo $this->config->item('member_status')[$member['member_status']];?></i></small></strong>
                            </div>
							<div class="col-xs-6 text-right entry_time">
                            	<strong><small>Entry Time : <i><?php echo date('h:i A',strtotime($member['booking_time']));?></i></small></strong>
                            </div>-->
							<p class="clearfix"><p>
                         <header class="clearfix">
                        <div class="col-xs-6">
                        	<span class="t_guest">Total Guest : <strong><?php echo $member['no_of_guest'];?></strong></span>
                        </div>
                        <div class="col-xs-6">
                        	<span class="t_order">Total Order : <strong><?php echo count($orderData);?></strong></span>
                        </div>
						<p class="clearfix"><p>
								  
								  
						<?php if($member['member_status']==0){?>
								<div class="col-xs-12">
								    <label style="color:#cc0000;">Cancelled</label><p class="clearfix"></p>
                                    <label>Reason</label> : <?php echo $member['cancel_reason'];?>
								<div>	
						<?php } 
								
						else { ?>		  
						<div class="col-xs-4">
						<?php if($member['member_status']!=4 && $member['member_status']!=0){
							//$isBillPaid=$this->Dash_model->isBillPaid($member['table_booking_id']);
										//if(!$isBillPaid){
							?>
									<a href="<?php echo base_url().'menu/make_order/'.$member['table_booking_id'];?>/1" class="btn btn-success add_meal"><i class="fa fa-cutlery" aria-hidden="true"></i><span>Add meal</span></a>
						<?php } //} ?>
						</div>
                         <?php if(count($orderData)>0) { ?>
						 <div class="col-xs-8 text-right">
                                <br>
                          Order: <?php echo date('h:i A',strtotime($orderData[0]['order_time'])); ?>
						  </div>
                         <?php } 
						 
						 else { ?><div class="col-xs-4"><?php if($member['table_status']==1 && $member['member_status']!=0){ ?>
								
								<a href="<?php echo base_url().'dashboard/cancel_order/'.$member['table_booking_id'] ?>" class="btn btn-danger btn-xs cancel-booking"><i class="fa fa-close" aria-hidden="true"></i> <span>Cancel Booking</span></a>
						 <?php }?> </div> <?php } ?>
						 
								
								<?php if(count($orderData)==0 && $member['member_status']!=0) { ?>
									<div class="col-xs-4">
									<a href="#" class="btn btn-success btn-xs change_table" data-toggle="modal" data-target="#changetable<?php echo $member['table_booking_id'];?>"><i class="fa fa-retweet" aria-hidden="true"></i> <span>Change Table</span></a>
									</div>
									
										<!-- Modal -->
									<div id="changetable<?php echo $member['table_booking_id'];?>" class="modal fade" role="dialog">
									  <div class="modal-dialog">

										<!-- Modal content-->
										<div class="modal-content">
										    <form method="post" action="" class="change_table" data-parsley-validate="">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title"><?php echo $member['member_name'];?></h4>
										  </div>
                                          <div class="modal-body">
											<div class="row">
											
												<input type="text" value="<?php echo $member['table_booking_id'];?>" name="table_booking_id" hidden>
												<div class="col-sm-6">
													<div class="form-group">
														<label>Total Guest</label>
														<input type="number" name="total_guest" class="form-control numeric" placeholder="Total number of guest" value="<?php echo $member['no_of_guest'] ?>" required min="1">
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label>Available Tables</label><br>
														<select class="multiselect-tbl avalTable" name="table_number[]" required  multiple>
														<!--	<option value="">select</option>-->
															<?php
															$currentTableCheckedIds=explode(',',$member['table_ids']);
															$currentTableCheckedNames=explode(',',$member['table_name']);
															$x=0;
															foreach($currentTableCheckedIds as $currentTableCheckedId)
															{
																echo '<option value="'.$currentTableCheckedId.'" selected>'.$currentTableCheckedNames[$x].'</option>';
																$x++;
															}
															foreach($availableTables as $available) { 
															if(($available['table_status']==0 && $available['Advance_booking_status']==0) ||  $available['table_name']=='Parcel')
															{?>
															<option value="<?php echo $available['id'];?>"><?php echo $available['table_name'];?></option>
															<?php }} ?>
														</select>
													</div>
												</div>
											</div>
										  </div>
										  <div class="modal-footer">
											<button type="submit" name="changebooking" class="btn btn-success">Save</button>
										  </div>
										  </form>
										</div>

									  </div>
									</div>
									
						<?php } } ?>
						 
                        </header>
                 <div class="current_view clearfix">
                 	<div class="table-responsive">
                    	<table class="table table-bordered">
                    		<thead>
                    			<tr>
                    				<th>Name</th>
                    				<th>Total Meals</th>
                    			</tr>
                    		</thead>
                            <tbody>
							<?php  $seat=1; ?>
                            	<tr>
                            		<td><strong><?php echo $member['member_name'];?></strong></td>
                            		<td><?php foreach($orderData as $order) {
											if($order['guest_seat_no']==$seat){echo $order['quantity'];
											?>-
										<small><?php echo $order['meal_name'].', ' ?></small>
		                                <?php }} $seat++;?></td>
                            	</tr>
								<?php while($seat <= $member['no_of_guest']){ ?>
                                <tr>
                            		<td><strong>Guest <?php echo $seat;?></strong></td>
                            		<td><?php foreach($orderData as $order) {
											if($order['guest_seat_no']==$seat){echo $order['quantity'];
											?>-
										<small><?php echo $order['meal_name'].', ' ?></small>
											<?php }}?></td>
                            	</tr>
                                <?php $seat++;}?>
                            </tbody>
                    	</table>
                    </div>
                 </div>
                 
                 
						</div>
						<style>
						
						</style>
                        <div class="tab-pane" id="tab_default2_<?php echo $member['table_booking_id'];?>">
								<div class="about_user_desc">
                                	<div class="row">
                                    	<div class="col-sm-6">
                                        		<div class="fav_meal df_abu">
                                                		<h5>Favourite Meal</h5>
                                                        <?php $meals= $this->Dash_model->fevourite_meal($member['id']);
														if(count($meals)>0){
														?>
                                                        <ul class="list-unstyled">
														<?php foreach($meals as $meal){
                                                        echo "<li>".$meal['meal_name']."</li>";
														}
														?>
                                                        	
                                                        </ul>
														<?php } else{ echo "<p>Record not Found!</p>";} ?>
                                                </div>
                                        </div>
                                        <div class="col-sm-6">
                                        		<div class="fav_meal df_abu">
                                                		<h5>Preferences</h5>
                                                        <?php $meals= $this->Dash_model->preferences($member['id']);
														//print_r($meals);
														if(count($meals)>0){
														?>
                                                        <ul class="list-unstyled">
														<?php foreach($meals as $meal){
                                                        echo "<li>".$meal['menu_name']."</li>";
														}
														?>
                                                        	
                                                        </ul>
														<?php } else{ echo "<p>Record not Found!</p>";} ?>
                                                    <!--    <div class="add_more_btn">
                                                        	<span><i class="fa fa-plus"></i></span>
                                                        </div>-->
                                                </div>
                                        </div>
										<p class="clearfix"></p>
										<div class="col-sm-6">
                                        		<div class="fav_meal df_abu">
                                                    
													<h5>Last Order</h5>
														<?php $meals= $this->Dash_model->last_meal($member['id']);
														if(count($meals)>0){
														?>
                                                        <ul class="list-unstyled">
														<?php foreach($meals as $meal){
                                                        echo "<li>".$meal['meal_name']."</li>";
														}
														?>
                                                        	
                                                        </ul>
														<?php } else{ echo "<p>Record not Found!</p>";} ?>
													
                                                </div>
                                        </div>
										<div class="col-sm-6">
                                        		<div class="fav_meal df_abu">
                                                		<h5>Table Preferred</h5>
														<?php $preferedTable= $this->Dash_model->table_prefered($member['id']);
														if(count($preferedTable)>0){
														?>
                                                        <ul class="list-unstyled">
														<?php foreach($preferedTable as $pt){
                                                        echo "<li>".$pt['table_name']."</li>";
														}
														?>
                                                        	
                                                        </ul>
														<?php } else{ echo "<p>Record not Found!</p>";} ?>
                                                    <!--    <div class="add_more_btn">
                                                        	<span><i class="fa fa-plus"></i></span>
                                                        </div>-->
                                                </div>
                                        </div>
										<p class="clearfix"></p>
                                        <div class="col-sm-6">
                                        		<div class="fav_meal df_abu">
                                                    
														<h5>Last Bill</h5>
                                                        <?php $last_bill= $this->Dash_model->last_bill($member['id']);//print_r($last_bill);
														if($last_bill!=null){
														?>
                                                        <ul class="list-unstyled">
														<?php
                                                        echo "<li>Sub Total: ".$last_bill->amount."</li>"."<li>Discount: ".$last_bill->discount."</li>"."<li>Total ".($last_bill->amount-$last_bill->discount)."</li>"."<li>Tax ".$last_bill->tax."</li>"."<li>Gross Total: ".$last_bill->final_amount."</li>";
													
														?>
                                                        	
                                                        </ul>
														<?php } else{ echo "<p>Record not Found!</p>";} ?>
													
                                                </div>
                                        </div>
										<div class="col-sm-6">
                                        		<div class="fav_meal df_abu">
                                                		<h5>Average Billing</h5>
                                                        <?php $average_billing= $this->Dash_model->average_billing($member['id']);
														if($average_billing!=null && $average_billing->attended > 0){
														?>
                                                        <ul class="list-unstyled">
														<?php
                                                        echo "<li>".floor($average_billing->total_bill/$average_billing->attended)."</li>";
													
														?>
                                                        	
                                                        </ul>
														<?php } else{ echo "<p>Record not Found!</p>";} ?>
                                                    
                                                </div>
                                        </div>
                                	</div>
                            	</div>
						</div>
						
						<div class="tab-pane" id="tab_default3_<?php echo $member['table_booking_id'];?>">
						    <div class="about_user_desc">
                                <?php 
									   $order_status=$this->Dash_model->get_order_data($member['table_booking_id']);
					                   $no_of_delay=$this->Dash_model->no_of_dalay_order($member['table_booking_id']);
		                               
		                        ?>
							       <?php if(count($order_status)>0){?>
								   <div class="table-responsive chef_table">   
								   <table class="table">
										<tbody>
										<?php foreach($order_status as $order) {
											
											?>
											
											
											<tr id="order-no-<?php echo $order['table_order_id']?>" data-order="<?php echo $order['table_order_id'] ?>" data-ordertime="<?php echo strtotime($order['order_time']) ?>" data-preparetime="<?php echo $order['meal_prepration_time'] ?>" data-quantity="<?php echo $order['quantity']?>">
												<td><img src="<?php echo !empty($order['meal_image'])?base_url().$order['meal_image']:base_url().'assets/img/unavailable.jpg'?>" class="img-responsive"/></td>
												<td><?php echo $order['quantity']?></td>
												
												<?php
												if($order['order_status']==1) {?>
												<td  class="complete"><span>Completed</span><br><span><?php echo date('h:i A',strtotime($order['completed_time'])); ?><span></td>
													
												<?php } 
												else if($order['order_status']==2){?>
												<td  class="incomplete">
												<span class="timer"></span>
												</a></td>
												
										         <?php } else if($order['order_status']==3){ ?>
                                                <td  class="time_over">
												<span class="">Cancelled</span><br><span><?php echo date('h:i A',strtotime($order['cancel_time'])); ?>
												</a></td>
                                                <?php } ?>
												
												<td><span class="comment_vew"><small class="msg_count"></small><i class="fa fa-envelope"></i></span>
													<div class="comment_view_box"></div>	
												</td>
												
											</tr>
											<tr><td>Comment: </td><td colspan="5"><p class="ft-12" style="margin:0;"><?php echo $order['comment']?></p> </td></tr>
										<?php } ?>
										<tr><td>Remark: </td><td colspan="5"><p class="ft-12" style="margin:0;"><?php echo $member['remark']?></p> </td></tr>	
										</tbody>
								   </table>     
								   </div>  
								   <?php }else echo "<br><br><h6 style='text-align:center;'>Add order to Start.</h6><br>";
								   
								   ?>	
                            </div>
						</div>
						<div class="tab-pane" id="tab_default4_<?php echo $member['table_booking_id'];?>">
						    <div class="about_user_desc">
                                   <?php 
								   /*
								   if($member['member_status'] == 1){echo "<br><br><h6 style='text-align:center;'>Please add order first.</h6><br>";}
								       else if($member['member_status'] == 2){echo "<br><br><h6 style='text-align:center;'>Please wait till order are completed.</h6><br>";}
									   
								else if($number_of_bills_required > 0 && ($number_of_bills_required!=$check_bill_status->generated_bills || $check_bill_status->no_of_unpaid>0))
								{
									echo "<br><br><h6 style='text-align:center;'>Please pay your bills.</h6><br>";
								}   
                                else {*/
								   if($feedback !=null) { 
								   	  if($feedback->cancel_reason=='') { 
								   ?>
								   
								   <p class="clearfix"></p>
								      <div class="pull-right">
								         <?php $overallExp = !empty($feedback->feedback_text_10)?$feedback->feedback_text_10:'Overall WIC Experience';
								          if(isset($feedback->feedback_10)){
									       echo $overallExp.'&nbsp; &nbsp;<img class="'.$ratingArr[$feedback->feedback_10].'"/>';
									       } ?>
								</div>		   
								<p class="clearfix"></p><p class="clearfix"></p>
								
                                <table class="table">
								    <tr><td><b>Feedback</b></td><!--<td><b>Suggestion</b></td>--><td><b>Rating</b></td></tr>
									
									<tr>
									<td><?php echo !empty($feedback->feedback_text_1)?$feedback->feedback_text_1:'Food Quality and Taste';?></td>
								<!--	<td><?php echo !empty($feedback->text_feed_1)?$feedback->text_feed_1:'';?></td>-->
									<td><?php echo isset($feedback->feedback_1)?$feedback->feedback_1:'';?></td>
									</tr>
									
									<tr>
									<td><?php echo !empty($feedback->feedback_text_2)?$feedback->feedback_text_2:'Food Presentation';?></td>
								<!--	 <td><?php echo !empty($feedback->text_feed_2)?$feedback->text_feed_2:'';?></td>-->
									<td><?php echo isset($feedback->feedback_2)?$feedback->feedback_2:'';?></td>
									</tr>
									
									<tr><td><?php echo !empty($feedback->feedback_text_3)?$feedback->feedback_text_3:'Serving Time';?></td>
									<!--<td><?php echo !empty($feedback->text_feed_3)?$feedback->text_feed_3:'';?></td>-->
									<td><?php echo isset($feedback->feedback_3)?$feedback->feedback_3:'';?></td>
									</tr>
									
									<tr><td><?php echo !empty($feedback->feedback_text_4)?$feedback->feedback_text_4:'Variety in Menu';?></td>
									<!--<td><?php echo !empty($feedback->text_feed_4)?$feedback->text_feed_4:'';?></td>-->
									<td><?php echo isset($feedback->feedback_4)?$feedback->feedback_4:'';?></td></tr>
									
									<tr><td><?php echo !empty($feedback->feedback_text_5)?$feedback->feedback_text_5:'Reception';?></td>
									<!--<td><?php echo !empty($feedback->text_feed_5)?$feedback->text_feed_5:'';?></td>-->
									<td><?php echo isset($feedback->feedback_5)?$feedback->feedback_5:'';?></td></tr>
									
									<tr><td><?php echo !empty($feedback->feedback_text_6)?$feedback->feedback_text_6:'Staff Responsiveness';?></td>
									<!--<td><?php echo !empty($feedback->text_feed_6)?$feedback->text_feed_6:'';?></td>-->
									<td><?php echo isset($feedback->feedback_6)?$feedback->feedback_6:'';?></td></tr>
									
									<tr><td><?php echo !empty($feedback->feedback_text_7)?$feedback->feedback_text_7:'Ambience';?></td>
									<!--<td><?php echo !empty($feedback->text_feed_7)?$feedback->text_feed_7:'';?></td>-->
									<td><?php echo isset($feedback->feedback_7)?$feedback->feedback_7:'';?></td></tr>
									
									<tr><td><?php echo !empty($feedback->feedback_text_8)?$feedback->feedback_text_8:'Cleanliness';?></td>
									<!--<td><?php echo !empty($feedback->text_feed_8)?$feedback->text_feed_8:'';?></td>-->
									<td><?php echo isset($feedback->feedback_8)?$feedback->feedback_8:'';?></td></tr>
									
									<tr><td><?php echo !empty($feedback->feedback_text_9)?$feedback->feedback_text_9:'Steward\'s Communication';?></td>
									<!--<td><?php echo !empty($feedback->text_feed_9)?$feedback->text_feed_9:'';?></td>-->
									<td><?php echo isset($feedback->feedback_9)?$feedback->feedback_9:'';?></td></tr>
									
								    <tr><td><?php echo !empty($feedback->feedback_text_10)?$feedback->feedback_text_1:'Overall WIC Experience';?></td>
									<!--<td><?php echo !empty($feedback->text_feed_10)?$feedback->text_feed_10:'';?></td>-->
									<td><?php echo isset($feedback->feedback_10)?$feedback->feedback_10:'';?></td></tr>
								 </table>
                                 <?php } 
								 else if($feedback->cancel_reason!='')  {
								 echo "<br><p>Client didn't given the feedback :<br><br><b>Client Comment</b> : ".$feedback->cancel_reason."</p><br>"	;} 
								 
								 } else { echo "<br><br><h6 style='text-align:center;'>Feedback not available.</h6><br>";} //} ?>
                            </div>
						</div>
						<div class="tab-pane" id="tab_default5_<?php echo $member['table_booking_id'];?>">
						    <div class="about_user_desc">
                                
                            </div>
						</div>
						<div class="tab-pane" id="tab_default7_<?php echo $member['table_booking_id'];?>">
						    <div class="about_user_desc">
                                
                            </div>
						</div>
					</div>
				</div>
			</div>
			
            </div>
		</div>
		</div>

<?php } } 



if($nextPageStatus){
?>
<p class='well load_next' style="background-color:#666;color:white;cursor:pointer" data-page=<?php echo $nextPageStatus; ?>><strong>Load more members...</strong></p>
<?php } ?>
<!--</div> -->
<?php }else{?>
	<p class='well'>Could not find any result.</p>
	<?php } ?>			