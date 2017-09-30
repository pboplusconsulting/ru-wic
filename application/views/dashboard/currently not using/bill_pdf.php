<style>  
.table{width:100%;}
.table tr{border:1px solid black;}
.table th,.table td {
    border-bottom: 1px solid #ddd;
    margin
}
.borderless tr,.borderless td{
    border: none !important;
}
tr.spaceUnder > td
{
  padding-bottom: 1em;
}
tr.spaceUpper > td
{
  padding-top: .5em;
}
td
{
  padding-top: .3em;
}

 tr.print-friendly{page-break-before:always;}

</style>
		    
<div class="container">
                <div class="table-responsive"><?php //echo "<pre>";print_r($billingData);echo "</pre>"; ?>
                    <table class="table print-friendly">
					    <tr><td>
						    <h5 style="text-align: center;"><b>LE CLUB</b></h5>
							<p style="text-align: center;">A Unit of S&N LIFESTYLE HOSPITALITY PVT LTD. Dehradun Uttaranchal</p><br>
							<p>Pan No : </p>
							<p>Tin No : </p>
							<p>Service Tax Code : </p>
							</td>
						</tr>
						<tr class="spaceUnder">
						    <td>
						     <table class="table borderless">
							     <tr class="spaceUpper">
								    <td colspan="5">Member Name : <?php echo $memberData->member_name; ?></td>
								 </tr>
								 <tr class="spaceUpper">
								    <td colspan="2">Bill ID : <?php echo $billId; ?></td>
									<td colspan="2">Time : <?php echo date('h:i A');?></td>
								 </tr>							     
								 <tr class="spaceUpper">
								    <td>Date</td>
									<td>Table</td>
									<td>Cvr</td>
									<td>Stw</td>
									<td>UID</td>
								 </tr>
								 <tr class="spaceUpper">
								    <td><?php echo date('d/m/Y');?></td>
									<td><?php echo $memberData->table_name; ?></td>
									<td><?php echo $memberData->no_of_guest; ?></td>
									<td></td>
									<td><?php echo $memberData->membership_id; ?></td>
								 </tr>
							 </table>
							 </td>
						</tr>
						<tr class="spaceUnder">
						    <td>
							    <table class="table borderless">
							     <tr>
								    <td colspan="2"><b>Item Name</b></td>
									<td><b>Quantity</b></td>
									<td><b>Rate</b></td>
									<td><b>Amount</b></td>
								 </tr>
								 <?php foreach($orderData as $order){?>
								 <tr class="spaceUpper">
								    <td colspan="2"><?php echo $order['meal_name'] ?></td>
									<td><?php echo $order['quantity'] ?></td>
									<td><?php echo $order['meal_price'] ?></td>
									<td><?php echo $order['amount'] ?></td>
								 </tr>
								 <?php } ?>
							    </table>
							</td>
						</tr>
						<tr class="spaceUnder">
						    <td>
							    <table class="table borderless">
							     <tr>
								    <td colspan="4"><b>Sub Total</b></td>
									<td><b><?php echo $billingData->subtotal; ?></b></td>
								 </tr>
								<?php $totalTax=0;
									$totalDiscount=$billingData->subtotal*$discount/100;
								foreach($flagData as $fdata){
									if($fdata['flag_type']==0)
									{
										$totalTax=$totalTax+($billingData->subtotal*$fdata['percentage'])/100;
									}
									?>
								 <tr class="spaceUpper">
								    <td colspan="4"><?php echo $fdata['flag_name']?></td>
									<td><?php echo ($billingData->subtotal*$fdata['percentage'])/100;?></td>
								 </tr>
								 
								 <?php } ?>
								 <tr class="spaceUpper">
								    <td colspan="4"><b>Total Bill</b></th>
									<td><b><?php echo $billingData->subtotal+$totalTax; ?></b></td>
								 </tr>
								 <tr>
								    <td colspan="4" class="spaceUpper">Discount</td>
									<td><?php echo $totalDiscount;?></td>
								 </tr>
								 
								 <tr class="spaceUpper">
								    <td colspan="4"><b>Payable Bill</b></th>
									<td><b><?php echo $billingData->subtotal+$totalTax-$totalDiscount; ?></b></td>
								 </tr>
							    </table>
							</td>
						</tr>
						<tr>
						    <td>
							    <p>Contact Name: PBO Plus</p>
							    <p>Contact No : 54759484834</p>
							</td>
						</tr>
				    </table>
				</div> 
</div>