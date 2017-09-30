<div class="modal fade" id="billModal" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
	    <div class="modal-content">
		    <div class="modal-header" style="background:#333;color:#fff">
		        <h4 class="modal-title"><?php echo $memberData->member_name; ?></h4>
		    </div>
            <div class="modal-body">
                <div class="table-responsive"><?php //echo "<pre>";print_r($memberData);echo "</pre>";die(); ?>
                    <table class="table">
					    <tr><td>
						    <h5 style="text-align: center;"><b>LE CLUB</b></h5>
							<p style="text-align: center;">A unit of S&N LIFESTYLE HOSPITALITY PVT LTD. Dehradun Uttaranchal</p><br>
							<p>Pan No : </p>
							<p>Tin No : </p>
							<p>Service Tax Code : </p>
							</td>
						</tr>
						<tr>
						    <td>
						     <table class="table borderless">
							     <tr>
								    <td colspan="5">Member Name : <?php echo $memberData->member_name; ?></td>
								 </tr>
								 <tr>
								    <td colspan="2">Bill ID : <?php echo $billId; ?></td>
									<td colspan="2">Time : <?php echo date('h:i A');?></td>
								 </tr>							     
								 <tr rowspan="2">
								    <td>Date<br><?php echo date('d/m/Y');?></td>
									<td>Table<br><?php echo $memberData->table_name; ?></td>
									<td>Cvr<br><?php echo $memberData->no_of_guest; ?></td>
									<td>Stw<br></td>
									<td>UID<br><?php echo $memberData->membership_id; ?></td>
								 </tr>
							 </table>
							 </td>
						</tr>
						<tr>
						    <td>
							    <table class="table borderless">
							     <tr>
								    <td colspan="2"><b>Item Name</b></td>
									<td><b>Quantity</b></td>
									<td><b>Rate</b></td>
									<td><b>Amount</b></td>
								 </tr>
								 <?php $total_no_order=0;$total_cmp_order=0;
								 foreach($orderData as $order){
									 $total_no_order++;
									 if($order['order_status']==1) 
										 $total_cmp_order=$total_cmp_order+1;
									 ?>
								 <tr>
								    <td colspan="2"><?php echo $order['meal_name'] ?></td>
									<td><?php echo $order['quantity'] ?></td>
									<td><?php echo $order['meal_price'] ?></td>
									<td><?php echo $order['amount'] ?></td>
								 </tr>
								 <?php } ?>
							    </table>
							</td>
						</tr>
						<tr>
						    <td>
							    <table class="table borderless">
							     <tr>
								    <td colspan="4">Sub Total</td>
									<td><?php echo $billingData->subtotal; ?></td>
								 </tr>
								<?php $totalTax=0;$totalDiscount=0;
								foreach($flagData as $fdata){
									if($fdata['flag_type']==0)
									{
										$totalTax=$totalTax+($billingData->subtotal*$fdata['percentage'])/100;
									}
									if($fdata['flag_type']==1)
									{
										$totalDiscount=$totalDiscount+($billingData->subtotal*$fdata['percentage'])/100;
									}	
									
									?>
								 <tr>
								    <td colspan="4"><?php echo $fdata['flag_name']?></td>
									<td><?php echo ($billingData->subtotal*$fdata['percentage'])/100;?></td>
								 </tr>
								 <?php } ?>
								 <tr>
								    <th colspan="4">Gross Amount</th>
									<th><?php echo $billingData->subtotal+$totalTax-$totalDiscount; ?></th>
								 </tr>
							    </table>
							</td>
						</tr>
						<tr>
						    <td>
							    <br><br><p>Contact Name: PBO Plus</p>
							    <p>Contact No : 54759484834</p>
							</td>
						</tr>
				    </table>
				</div> 
            </div>
            <div class="modal-footer">
                <a href="<?php echo base_url().'dashboard/download_bill/'.$memberData->table_booking_id;?>" type="button" class="btn btn-success btn-lg">Download</a>&nbsp;&nbsp;
				<?php if($memberData->member_status == 3 && $total_cmp_order==$total_no_order){?>
<button data-tablebookingid="<?php echo $memberData->table_booking_id;?>" name="make_payment" class="btn btn-primary btn-lg">Payment</button>&nbsp;&nbsp;
				<?php } ?>
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>