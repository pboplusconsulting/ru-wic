<?php if(count($data) > 0) { echo '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';?>
<?php foreach($data as $member){ //echo "<pre>";print_r($member);echo "</pre>";die();
	if($member['booking_status']==0){?>
    <div class="panel panel-default">
		<div class="panel-heading unbook" role="tab" id="heading_unbook<?php echo $member['id'];?>">
				<h4 class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_a<?php echo $member['id'];?>" aria-expanded="false" aria-controls="collapse2">
				  <img src="<?php echo base_url()?>assets/img/user_pic.png" class="img-circle" alt="userpic" width="30" /> <?php echo ucfirst($member['member_name']); ?>
				  
				</a>
				<!--<a href="#" class="book_now"  data-toggle="modal" data-target="#booknow<?php echo $member['id'];?>">Book Now</a>-->
			  </h4>

		</div>
	</div>
			
					
			
<?php }else if($member['booking_status']==1 && $member['member_status']!=1 && $member['member_status']!=0){
	
	$orderData=$this->Bar_tendor_model->get_order_data($member['table_booking_id']);
	$no_of_delay=$this->Bar_tendor_model->no_of_dalay_order($member['table_booking_id']);
	$no_of_complete=$this->Bar_tendor_model->no_of_complete_order($member['table_booking_id']);
	$no_of_cancel=$this->Bar_tendor_model->no_of_cancel_order($member['table_booking_id']);
	$no_of_unread=$this->Bar_tendor_model->no_of_unread_oreder($member['table_booking_id']);
	$total_orders=$this->Bar_tendor_model->total_orders($member['table_booking_id']);
	$last_order_time=$this->Bar_tendor_model->get_last_order_time($member['table_booking_id']);
	$feedback=$this->Bar_tendor_model->get_by_query_return_row("SELECT * FROM ru_feedback WHERE table_booking_id=".$member['table_booking_id']." AND status=1");
			if($member['member_status']==0){$tiles_color="#f8be5d"; } //Table relevied
			elseif($feedback != null) { $tiles_color="#f8be5d"; } //Table relevied
			else if($no_of_delay > 0){  $tiles_color="#d9534f"; } //Order Delayed 
			else if(count($orderData)>0 && count($orderData)==($no_of_complete+$no_of_cancel)){$tiles_color="#5cb85c";} //Order Served
			else if(count($orderData)==0){ $tiles_color="#FF5500";} //Table Booked
			else { $tiles_color="#d9534f"; } //Order panding
	?>

           <div class="panel panel-default">
						<div class="panel-heading <?php echo $no_of_delay>0?'inside_guest_delay':'inside_guest'?> <?php echo (count($orderData)==($no_of_complete+$no_of_cancel)?'completed_all':''); ?><?php echo $no_of_unread > 0?'new_label':'';?>" style="background:<?php echo $tiles_color; ?>" role="tab" id="heading<?php echo $member['table_booking_id'];?>">
							<h4 class="panel-title">
							   <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $member['table_booking_id'] ?>" aria-expanded="false" aria-controls="collapse<?php echo $member['table_booking_id'] ?>" class="member-order-today" data-id="<?php echo $member['table_booking_id'] ?>">
							   
							   <img src="<?php echo base_url();?>assets/img/user_pic.png" class="img-circle" alt="username" width="30" /> <?php echo strlen($member['member_name'])>9?ucfirst(substr($member['member_name'],0,8)).'..':ucfirst($member['member_name']);?>
							   <span class="badge"><?php echo $no_of_complete.'/'.($total_orders-$no_of_cancel); ?></span>
							   <span class="table_num">
                               <?php 
							   $tbl=explode(',',$member['table_name']);
							   if(count($tbl)>0) { foreach($tbl as $key=>$value) { ?>
                               <strong><?php echo $value?></strong>
                               <?php } }?>
                              </span>
							   </a>
							   <span class="mini-about ft-10">
								<b>Order: <i><?php if(count($orderData)) echo date('h:i A',strtotime($orderData[0]['order_time']));?></i></b>
								<?php if($no_of_delay > 0){ ?>
								<br><b><i><?php echo 'Order Delayed';?></i></b><br><b><i><?php echo $no_of_delay.' dish delayed';?></i></b>
								<?php }elseif($feedback != null) { 
								       echo '<br><b><i>Table Relieved</i></b>';
								} else if(count($orderData)>0 && count($orderData)==($no_of_complete+$no_of_cancel)){ echo '<br><b><i>Order Served</i></b>'; 
								} else if(count($orderData)==0){ echo '<br><b><i>Table Booked</i></b>';
								} else { echo '<br><b><i>Order Pending</i></b>'; } ?>
								</span>
							</h4>

						</div>
					   
						<div id="collapse<?php echo $member['table_booking_id'] ?>" class="panel-collapse collapse inside_guest <?php //echo $in++==0?'in':''?>" role="tabpane<?php echo $member['table_booking_id'] ?>" aria-labelledby="heading<?php echo $member['table_booking_id'] ?>">
							<div class="panel-body">
							    <!--    <div class="row">
							        <div class="col-xs-6">
									<?php 
									
									if($no_of_delay > 0){ ?>
                            	        <strong><small style="color:#d9534f;"><?php echo $no_of_delay.' dish is delayed';?></small></strong>
				                    <?php } ?>	
                                    </div>
									<div class="col-xs-6 text-right entry_time">
										<strong><small>Entry Time : <i><?php echo date('h:i A',strtotime($member['booking_time'])) ?></i></small></strong>
									</div>
									</div>-->
									<?php if(count($orderData)>0){?>
									<form method="post" action="">
								   <div class="table-responsive chef_table"> 								   
								   <table class="table table-striped">
										<tbody>
										
										
										<?php $uncompleteCount=0; 
										$gredient_array=$this->config->item('ingredients');
										foreach($orderData as $order){
											   if($order['order_status']==2){$uncompleteCount++;}
											?>
											
											
											<tr id="order-no-<?php echo $order['table_order_id']?>" data-order="<?php echo $order['table_order_id'] ?>" data-ordertime="<?php echo strtotime($order['order_time']) ?>" data-preparetime="<?php echo $order['meal_prepration_time'] ?>" data-quantity="<?php echo $order['quantity']?>">
												<td><img src="<?php echo base_url().$order['meal_image']?>" class="img-responsive"/><?php echo $order['meal_name'];?></td>
												<td><span class="quant_hai"><?php echo $order['quantity']?></span><i class="ft-11 black-txt">
												<?php 
											  $gredients = $order['gredients'];
                                              $gredients=!empty($gredients)?explode(',',$gredients):array();
												//echo $gredients; 
												if($gredients){
												foreach($gredients as $grad){
													echo $gredient_array[$grad].', ';
												}}
												?></i></td>
												<?php 
												if($order['order_status']==0){continue;
												 ?>
												<!--	<td class="queued"><a href="" class="start-processing"><i class="fa fa-play fa-lg" aria-hidden="true"></i> Start</a></td>
													<td><div class="checkbox"><label><input type="checkbox" disabled> Completed</label></div></td>-->
												<?php } 
												else if($order['order_status']==1) {?>
												<td  class="complete"><span>Completed</span><br><span><?php echo date('h:i A',strtotime($order['completed_time'])); ?><span></td>
													<td></td>
												<?php } 
												else if($order['order_status']==2){
													?>
												<td  class="incomplete">
												<span class="timer"></span>
												</a></td>
												<td><div class="checkbox"><label><input type="checkbox" name="tableorder[]" value="<?php echo $order['table_order_id'];?>" class="check_comp"> Completed</label></div></td>
										        <?php  } else if($order['order_status']==3){  ?>
                                                  <td  class="time_over">
												<span class="">Cancelled</span><br><span><?php echo date('h:i A',strtotime($order['cancel_time'])); ?>
												</a></td>
												<td></td>
                                                <?php } ?>
												
												<td><?php if($order['order_status']!=1) {?>
												    <span class="comment_btn"><i class="fa fa-pencil"></i></span>
													<div class="com_box">
													<div class="input-group">
													    <textarea name="comment" class="form-control" placeholder="Message to Steward..."></textarea>
													    <span class="input-group-btn">
														<button class="btn btn-default order_comment" type="button">Ok!</button>
													  </span>
													</div>
													</div>
                                                    
                                                 <span class="cancel_btn">
                                                     <i class="fa fa-trash" style="color:#333 !important" aria-hidden="true"></i>
                                                     </span>
                                                     <div class="cancel_box">
													<div class="input-group">
													    <textarea name="comment" id="cancelreason" class="form-control" placeholder="Cancel Reason"></textarea>
													    <span class="input-group-btn">
														<button class="btn btn-default order_cancel" type="button">Ok!</button>
													  </span>
													</div>
													</div>
                                                     
												    <?php } ?>													
												</td>
												
											</tr>
											<tr><td>Comment: </td><td colspan="5"><p class="ft-12" style="margin:0;"><?php echo $order['comment']?></p> </td></tr>
										<?php } ?>	
										<tr><td>Remark: </td><td colspan="5"><p class="ft-12" style="margin:0;"><?php echo $member['remark']?></p> </td></tr>
										</tbody>
								   </table>    
								   </div>  
										<?php if($uncompleteCount>0){ ?>
                                   <div class="err_msg" style="color:red"></div> 
									   <div class="text-right">
										<button type="submit" name="complete_order_status" class="btn btn-ru complete_proceed">Proceed</button>
									   </div> 
										<?php }?>
								   </form>
									<?php }?>		
							</div>
						</div>
				    </div>

<?php } } ?>
</div>
<?php }else{?>
	<p class='well'>Could not find any match</p>
	<?php } ?>			