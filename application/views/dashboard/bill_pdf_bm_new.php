		    
<div style=" font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size:11px">
					    <div>
						    <h3 style="text-align: center; margin-bottom:3px">WIC India, Dehradun<br>
							<small>A Unit of S&N Lifestyle Hospitality Pvt. Ltd., Dehradun</small> </h3>
							<div style="text-align: center; margin-bottom:3px">(RU)</div>
							<div>PAN No : AANCS7744P</div>
							<div>GST No : 05AANCS7744P1ZH</div>
						</div>
					
						     <table width="100%" cellspacing="0" cellpadding="2">
							     <tr >
								    <td colspan="5" style="border-top: 1px solid #000000">MEMBER NAME : <b><?php echo strtoupper($memberData->member_name); ?></b> <?php if(!empty($memberData->guest_comment)) { echo "(".$memberData->guest_comment.")"; } ?> </td>
								 </tr>
								 <tr >
								    <td colspan="5">MEMBER ID : <?php echo $memberData->membership_id; ?></td>
								 </tr>								 
								 <tr >
								    <td colspan="2">DATE : <?php echo date('d/m/y');?></td>
									<td colspan="3" style="text-align:right">TIME : <small><?php echo date('h:i A');?></small></td>
								 </tr>							     
								 <tr >
								    <td style="text-align:left">BILL ID</td>
									<td style="text-align:center">TABLE</td>
									<td style="text-align:center">CVR</td>
									<td colspan="2" style="text-align:center">STW</td>
								 </tr>
								 <tr>
								    <td style="text-align:left; border-bottom: 1px dashed #000000"><?php echo $billId; ?></td>
									<td style="text-align:center; border-bottom: 1px dashed #000000"><?php echo $memberData->table_name; ?></td>
									<td style="text-align:center; border-bottom: 1px dashed #000000"><?php echo $memberData->no_of_guest; ?></td>
									<td colspan="2" style="text-align:center; border-bottom: 1px dashed #000000">&nbsp;</td>
								 </tr>
							 
							     <tr style="font-weight:bold">
								    <td colspan="2" style="border-bottom: 1px dashed #000000"><small>ITEM NAME</small></td>
									<td style="border-bottom: 1px dashed #000000"><small>QTY</small></td>
									<td style="border-bottom: 1px dashed #000000; text-align:right"><small>RATE</small></td>
									<td style="border-bottom: 1px dashed #000000; text-align:right"><small>AMOUNT</small></td>
								 </tr>
								 <?php foreach($orderData as $order){?>
								 <tr style="text-transform: uppercase;">
								    <td colspan="2" ><div style="width:110px"><small><?php echo $order['meal_name'] ?></small></div></td>
									<td style="text-align:center"><?php echo $order['quantity'] ?></td>
									<td style="text-align:right"><?php echo number_format($order['meal_price'],2) ?></td>
									<td style="text-align:right"><?php echo number_format($order['amount'],2) ?></td>
								 </tr>
								 <?php } $total_bill=$billingData->subtotal+$billingData->subtotalbeverage-$discount;
								 
								 $total_bill_mill=$billingData->subtotal-$discount;
								 $total_bill_subtotalbeverage=$billingData->subtotalbeverage-$discount;?>
								 
								 <tr style="font-size:1px;">
								 <td colspan="5" style="border-bottom: 1px dashed #000000">&nbsp;</td>
								 </tr>
							    
							     <tr>
								    <td colspan="3">SUB BILL</td>
									<td colspan="2" style="text-align:right"><?php echo number_format($billingData->subtotal+$billingData->subtotalbeverage ,2) ?></td>
								 </tr>
								 <?php if(!empty($discount)) {?>
								 <tr>
								    <td colspan="3" style="border-bottom: 1px dashed #000000">DISCOUNT</td>
									<td colspan="2" style="border-bottom: 1px dashed #000000;text-align:right"><?php echo number_format($discount,2)?></td>
								 </tr>
								  <?php } ?>
								 <tr>
								    <td colspan="3" style="border-bottom: 1px dashed #000000">TOTAL BILL</td>
									<td colspan="2" style="border-bottom: 1px dashed #000000; text-align:right"><?php echo number_format(($total_bill),2) ?></td>
								 </tr>
								 <?php 
								$totalTax=0;
								$totalTaxBev=0;
								foreach($flagData as $fdata){
									
										if($fdata['tax_name']=='SGST' || $fdata['tax_name']=='CGST' ){
										$totalTax=$totalTax+(($billingData->subtotal-$discount)*$fdata['tax_percent'])/100;
										}
										if($fdata['tax_name']=='CESS'){
										$totalTaxBev=$totalTaxBev+(($billingData->subtotalbeverage-$discount)*$fdata['tax_percent'])/100;
										}
										
									?>
								 <tr>
								    <td colspan="3"><?php echo $fdata['tax_name']?></td>
									
									<?php if($fdata['tax_name']=='CESS') {?>
									<td colspan="2" style="text-align:right"><?php echo number_format((($billingData->subtotalbeverage-$discount)*$fdata['tax_percent'])/100,2)?></td>
									<?php } else { ?>
									<td colspan="2" style="text-align:right"><?php echo number_format((($billingData->subtotal-$discount)*$fdata['tax_percent'])/100,2)?></td>
									<?php } ?>
								 </tr>
								 <?php } ?>
								 
								 
								 
								 
								 <tr class="spaceUpper">
								    <td colspan="3" style="border-top: 1px solid #000000;border-bottom: 3px double #000000"><b>PAYABLE BILL</b></td>
									<td colspan="2" style="border-top: 1px solid #000000;border-bottom: 3px double #000000; text-align:right"><b><?php // echo number_format(($total_bill+$totalTax),2) ?>
									<?php echo number_format(round($total_bill_mill+$total_bill_subtotalbeverage+$totalTax+$totalTaxBev), 2, '.', ',');?>
									</b>
									
									<?php  // echo $total_bill."#".$totalTax."#".$totalTaxBev."#".$discount;  ?></td>
								 </tr>
							    </table>
								<div style="text-align:center">.</div>
						<!--<div class="cntct">
						        <br><br>
							    <small>Contact Name: PBO Plus</small><br>
							    <small>Contact No : 1234567890</small>
						</div>-->
</div>