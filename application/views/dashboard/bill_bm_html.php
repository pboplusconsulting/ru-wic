<?php	
//echo "<pre>";
//print_r($orderData);							
if(count($orderData) > 0){
	$total_no_order=0;$total_cmp_order=0;$total_cncl_order=0;
	foreach($orderData as $order){
	 $total_no_order++;
	 if($order['order_status']==1) 
		 $total_cmp_order=$total_cmp_order+1;
	 if($order['order_status']==3) 
		 $total_cncl_order=$total_cncl_order+1;
	}
	if($total_no_order == $total_cmp_order+$total_cncl_order){
	?>
<div class="table-responsive">
                        <?php 
						//$isBillPaid=$this->Dash_model->isBillPaid($orderData[0]['table_booking_id']);
						if($tableBookingData->table_status == 1){?>

                         <form method="post" class="save_print_bill">
							    <table class="table borderless" id="<?php echo $bill_type.$orderData[0]['table_booking_id']; ?>">
							     <tr>
								    <td colspan="2"><b>Item Name</b></td>
									<td><b>Quantity</b></td>
									<td><b>Rate</b></td>
									<td  align="right"><b>Amount</b></td>
								 </tr>
								 <?php $total_no_order=0;$total_cmp_order=0;$total_cncl_order=0;
								 foreach($orderData as $order){
									 $total_no_order++;
									 if($order['order_status']==3){ 
										 $total_cncl_order=$total_cncl_order+1;
										 continue;
									 }
									 if($order['order_status']==1) {
										 $total_cmp_order=$total_cmp_order+1;
									 ?>
								 <tr>
								    <td colspan="2"><?php echo $order['meal_name'] ?></td>
									<td><?php echo $order['quantity'] ?></td>
									<td><?php echo $order['meal_price'] ?></td>
									<td align="right"><?php echo number_format($order['amount'],2) ?></td>
								 </tr>
								 <?php } } ?>
								 <tr>
								    <td colspan="2"><b>Sub Total</b></td>
									<td></td>
                                    <td></td>
									<td align="right" class="subtotal"><?php echo number_format($billingData->subtotal+$billingData->subtotalbeverage,2);?></td>
								 </tr>
								 <tr>
								    <td colspan="2">Discount (INR)<?php //echo $fdata['flag_name']?></td>
									<td></td><td></td>
									<td align="right"><input type="number" class="discountbm" value="0" min="0" max="<?php echo $billingData->subtotal+$billingData->subtotalbeverage-1; ?>" class="form-control"></td>
                                <!--    <td></td> -->
								<!--	<td align="right" class="disamount"><?php echo !empty($discount)?$billingData->subtotal*$discount/100:0 ?></td> -->
								 </tr>
								 <tr>
								    <td colspan="2">Comment<?php //echo $fdata['flag_name']?></td>
									<td></td>
									<td colspan="2" align="left"><input type="text" class="commentt"></td>
                                
								 </tr>
								<tr>
								    <td colspan="2"><b>Total Bill</b></td>
									<td>
								<p class="subtotalmeal" style="display:none;"><?php echo number_format($billingData->subtotal,2);?></p>
								<p class="subtotalbev" style="display:none;"><?php echo number_format($billingData->subtotalbeverage,2);?></p>
									</td>
                                    <td></td>
									<td align="right" class="total_bill"><?php echo number_format($billingData->subtotal+$billingData->subtotalbeverage,2);?></td>
								</tr> 
								 
								<?php $totalTax=0;$totalTaxBev=0;//$totalDiscount=0;
								foreach($flagData as $fdata){
									    if($fdata['tax_name']=='SGST' || $fdata['tax_name']=='CGST' ){
										$totalTax=$totalTax+($billingData->subtotal*$fdata['tax_percent'])/100;
										}
										if($fdata['tax_name']=='CESS'){
										$totalTaxBev=$totalTaxBev+($billingData->subtotalbeverage*$fdata['tax_percent'])/100;
										}
										
									?>
								 <tr class="total_tax">
								    <td colspan="2" class="tax_name"><?php echo $fdata['tax_name']?></td>
									<td><input type="hidden" class="tax_percentage" value="<?php echo $fdata['tax_percent']; ?>" class="" /></td>
                                    <td></td>
									<td align="right" class="<?php if($fdata['tax_name']=='CESS'){ echo 'total_tax_bev_value';} else { echo 'total_tax_value';} ?>"><?php 
                                     if($fdata['tax_name']=='CESS'){
										echo number_format((($billingData->subtotalbeverage*$fdata['tax_percent'])/100),2); 
									 }
									 else{ echo number_format((($billingData->subtotal*$fdata['tax_percent'])/100),2);}
									?></td>
								 </tr>
								 <?php } ?>
								 <tr class="taxx" data-taxamount="<?php echo $totalTax+$totalTaxBev ?>"></tr>
								 <tr>
								    <th colspan="2"><b>Bill Payable</b></th>
									<td></td>
                                    <td></td>
									<td align="right" class="grossamount">
									<?php echo number_format(round($billingData->subtotal+$billingData->subtotalbeverage+$totalTax+$totalTaxBev), 2, '.', ',');?>
									<?php // echo "<br/>".number_format($billingData->subtotal+$totalTax,2); ?></td>
								 </tr>
								 
							    </table>
								<input type="hidden" class="billcategory" value="<?php echo $billcategory; ?>">
                                <p class="clearfix"></p>
								
			                        <button type="submit" name="save_print_bil" class="btn btn-success pull-right" data-bookingid="<?php echo $table_booking_id;?>">Generate Bill</button>
								
                        </form>
						<?php } else { ?>
						
							    <table class="table borderless">
							     <tr>
								    <td colspan="2"><b>Item Name</b></td>
									<td><b>Quantity</b></td>
									<td><b>Rate</b></td>
									<td  align="right"><b>Amount</b></td>
								 </tr>
								 <?php $total_no_order=0;$total_cmp_order=0;$total_cncl_order=0;
								 foreach($orderData as $order){
									 $total_no_order++;
									 if($order['order_status']==3){ 
										 $total_cncl_order=$total_cncl_order+1;
										 continue;
									 }
									 if($order['order_status']==1) {
										 $total_cmp_order=$total_cmp_order+1;
									 ?>
								 <tr>
								    <td colspan="2"><?php echo $order['meal_name'] ?></td>
									<td><?php echo $order['quantity'] ?></td>
									<td><?php echo $order['meal_price'] ?></td>
									<td align="right"><?php echo number_format($order['amount'],2) ?></td>
								 </tr>
								 <?php } } ?>
								 <tr>
								    <td colspan="2"><b>Sub Total</b></td>
									<td></td>
                                    <td></td>
									<td align="right" class="subtotal"><?php echo number_format($billingData->subtotal,2);?></td>
								 </tr>
								 <tr>
								    <td colspan="2">Discount (INR)</td>
									<td></td><td></td>
									<td align="right"><?php $discount=0; if(count($last_bills)>0){$discount=$last_bills[0]['discount'];} echo number_format($discount,2);?></td>
									
								 </tr>
								 <tr>
								    <td colspan="2">Comment<?php //echo $fdata['flag_name']?></td>
									<td></td>
									<td colspan="2" align="left"><input type="text" placeholder="<?php if(count($last_bills)>0) echo $last_bills[0]['comment'];?>" disabled></td>
                                
								 </tr>
								<tr>
								    <td colspan="2"><b>Total Bill</b></td>
									<td></td>
                                    <td></td>
									<td align="right" class="total_bill"><?php echo number_format(($billingData->subtotal-$discount),2);?></td>
								</tr> 
								 
								<?php $totalTax=0;//$totalDiscount=0;
								foreach($flagData as $fdata){
									
										$totalTax=$totalTax+(($billingData->subtotal-$discount)*$fdata['tax_percent'])/100;
									?>
								 <tr class="total_tax">
								    <td colspan="2" class="tax_name"><?php echo $fdata['tax_name']?></td>
									<td><input type="hidden" class="tax_percentage" value="<?php echo $fdata['tax_percent']; ?>" class="" /></td>
                                    <td></td>
									<td align="right" class="total_tax_value"><?php echo number_format(((($billingData->subtotal-$discount)*$fdata['tax_percent'])/100),2);?></td>
								 </tr>
								 <?php } ?>
								 <tr class="taxx" data-taxamount="<?php echo $totalTax ?>"></tr>
								 <tr>
								    <th colspan="2"><b>Bill Payable</b></th>
									<td></td>
                                    <td></td>
									<td align="right" class="grossamount"><?php echo number_format(($billingData->subtotal-$discount+$totalTax),2); ?></td>
								 </tr>
							    </table>
								<input type="hidden" class="billcategory" value="<?php echo $billcategory; ?>">
                                <p class="clearfix"></p>
								
                        </form>
						
						<?php } ?>
						<p class="clearfix"></p>
						<p class="clearfix"></p>
						<?php if(count($last_bills)>0){?>
						<p><b>Last time generated bill detail</b></p>
						<table class="table">
						<thead>
						 <tr>
							<td><b>Sub Amount</b></td>
							<td><b>Discount</b></td>
							<td><b>Total Amount</b></td>
							<td><b>Taxes</b></td>
							<td><b>Payable Amount</b></td>
						 </tr>
						</thead> <tbody>
						 <?php
							foreach($last_bills as $last_bill){?>
							
							<tr>
							<td><?php echo $last_bill['amount']; ?></td>
							<td><?php echo $last_bill['discount']; ?></a></td>
							<td><?php echo $last_bill['amount']-$last_bill['discount'];?></td>
							<td><?php echo $last_bill['tax']; ?></td>
							<td><?php // echo ($last_bill['amount']-$last_bill['discount'])+$last_bill['tax']; ?>
							<?php // echo number_format(round(($last_bill['amount']-$last_bill['discount'])+$last_bill['tax']), 2, '.', ',');?>
							
							<?php echo number_format(($last_bill['final_amount']),2);?></td>
							
							</tr>
							
							
						  <tr class="active"><td><b>Comment:</b></td><td colspan="4" style="text-align:left;"><?php echo $last_bill['comment']; ?></td></tr>
							
						<?php } ?></tbody>
						</table> 
						<?php } ?>
								 
						
	</div>
	<?php  } else{ ?>
<br><br><h6 style="text-align:center">Please wait till order are completed.</h6><br><br>
<?php }
} else { ?>
<br><br><h6 style="text-align:center">Please add order first.</h6><br><br>
<?php } ?>