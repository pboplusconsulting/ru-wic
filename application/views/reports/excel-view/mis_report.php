<html xmlns:x="urn:schemas-microsoft-com:office:excel">
		<head>
			<!--[if gte mso 9]>
			<xml>
				<x:ExcelWorkbook>
					<x:ExcelWorksheets>
						<x:ExcelWorksheet>
							<x:Name>Sheet 1</x:Name>
							<x:WorksheetOptions>
								<x:Print>
									<x:ValidPrinterInfo/>
								</x:Print>
							</x:WorksheetOptions>
						</x:ExcelWorksheet>
					</x:ExcelWorksheets>
				</x:ExcelWorkbook>
			</xml>
			<![endif]-->
				<style type="text/css">
		body,td,th {
			font-family: "Calibri", Arial, sans-serif;
			font-size: 12px;
			color: #000000;
			line-height:18px;
		}
		</style>
		</head>
		<body>
		
		<?php
		  $date1 = '';
		  $date2 = '';
		  $memeber_id = '';
		  if(!empty($dateRange)){
			 $dtrange = explode('-',$dateRange);//print($dtrange);
			 $date1 = trim($dtrange[0]);
			 $date2 = trim($dtrange[1]);
			 $date1 = str_replace('/', '-', $date1);
			 $date2 = str_replace('/', '-', $date2);
			 $date1 = date("Y-m-d", strtotime($date1));
			 $date2 = date("Y-m-d", strtotime($date2));
			 $memeber_id = $memberId;
		  }
		    $relieved_table_booking_arr=$this->Reports_model->relieved_table_booking_id($date1,$date2,$memeber_id);
	        $relieved_table_booking_arr=implode(',',$relieved_table_booking_arr);
		  ?>
		

		<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
		  <tbody>
			<tr>
			  <td align="left" bgcolor="#92d050"><span style="display:block;padding:6px;font-size:22px;color:#fff">RU SALES REPORT</span></td>
			</tr>
			<tr>
			  <td align="left">Date Range : <?php echo !empty($dateRange)?$dateRange:(date('d/m/Y').' - '.date('d/m/Y')); ?></td>
			</tr>
			<tr>
			  <td height="15" align="right"></td>
			</tr>
			
		  </tbody>
		</table>

		<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#000000">
		 <thead>
		    <tr>
			  <th colspan="4" align="left"><strong>Billing&nbsp;Details</strong></th>
			  <th colspan="2" align="left"><strong>No of Guest Served</strong></th>
			  <th colspan="2" align="left"><strong>Customer Feedback</strong></th>
			  <th align="left"><strong>Average Service time</strong></th>
			  <th  align="left"><strong>Service Delay Cases</strong></th>
			  <th>&nbsp;</th>
			  <th>&nbsp;</th>
			  <th>&nbsp;</th>
			  <th>&nbsp;</th>
			</tr>
		 </thead>
		 
		  <tbody>
			<tr>
			  <td><strong>Billing Mode</strong></td>
			  <td><strong>Amount</strong></td>
			  <td><strong>Particulars</strong></td>
			  <td><strong>Amount</strong></td>
			  <td><strong>No. of Tables</strong></td>
			  <td><strong>No. of Guest Served</strong></td>
			  <td align="left">Delighted</td>
			  <td align="center"><?php echo $delighted=empty($relieved_table_booking_arr)?0:$this->Reports_model->get_overall_feedback($relieved_table_booking_arr,2); ?></td>
			  <td rowspan="5" align="center" valign="middle"><span style="display:block;font-size:20px;"><?php echo  empty($relieved_table_booking_arr)?0:round($this->Reports_model->average_service_time($relieved_table_booking_arr),2)?> minutes per dish</span></td>
			  <td rowspan="5" align="center" valign="middle"><strong><?php echo empty($relieved_table_booking_arr)?0:$this->Reports_model->get_delay_cases($relieved_table_booking_arr) ?></strong></td>
			  <td rowspan="5">&nbsp;</td>
			  <td rowspan="5">&nbsp;</td>
			  <td rowspan="5">&nbsp;</td>
			  <td rowspan="5">&nbsp;</td>
			</tr>
			<tr>
			  <td>Cash</td>
			  <td><?php 
	         $cashAmnt=empty($relieved_table_booking_arr)?0:$this->Reports_model->get_cash_total_amount($relieved_table_booking_arr);
	  echo empty($relieved_table_booking_arr)?0:number_format($cashAmnt,2);?></td>
			  <td>Alcoholic</td>
			  <td align="right"><?php 
	  $alcoholAmnt=empty($relieved_table_booking_arr)?0:$this->Reports_model->get_alchol_total_amount($relieved_table_booking_arr);
	  echo empty($relieved_table_booking_arr)?0:number_format($alcoholAmnt,2);?></td>
			  <td rowspan="4" align="center" valign="middle"><?php echo $this->Reports_model->get_total_tables_booked($date1,$date2,$memeber_id);?></td>
			  <td rowspan="4" align="center" valign="middle"><?php echo $this->Reports_model->get_total_quests($date1,$date2,$memeber_id);?></td>
			  <td align="left">Satisfied</td>
			  <td align="center"><?php echo $satisfy=empty($relieved_table_booking_arr)?0:$this->Reports_model->get_overall_feedback($relieved_table_booking_arr,1); ?></td>
			</tr>
			<tr>
			  <td>Card</td>
			  <td><?php 
	  $cardAmnt=empty($relieved_table_booking_arr)?0:$this->Reports_model->get_card_total_amount($relieved_table_booking_arr);
	  echo empty($relieved_table_booking_arr)?0:number_format($cardAmnt,2);?></td>
			  <td>Food&nbsp;Beverages</td>
			  <td align="right"><?php 
	    $foodAmnt=empty($relieved_table_booking_arr)?0:$this->Reports_model->get_food_total_amount($relieved_table_booking_arr);
	  echo empty($relieved_table_booking_arr)?0:number_format($foodAmnt,2);?></td>
			  <td align="left">Dissapointed</td>
			  <td align="center"><?php echo $dispoint=empty($relieved_table_booking_arr)?0:$this->Reports_model->get_overall_feedback($relieved_table_booking_arr,0); ?></td>
			</tr>
			<tr>
			  <td>Credit</td>
			  <td><?php 
	  $creditAmnt=empty($relieved_table_booking_arr)?0:$this->Reports_model->get_credit_total_amount($relieved_table_booking_arr);
	  echo empty($relieved_table_booking_arr)?0:number_format($creditAmnt,2);?></td>
			  <td>&nbsp;</td>
			  <td align="right">&nbsp;</td>
			  <td rowspan="2" align="left"><!---Average---></td>
			  <td rowspan="2" align="center"><?php // echo round((($delighted+$satisfy+$dispoint)/3),2); ?></td>
			</tr>
			<tr>
			  <td><strong>Total(Rs.)</strong></td>
			  <td><strong><?php echo number_format($cashAmnt+$cardAmnt+$creditAmnt,2) ?></strong></td>
			  <td>&nbsp;</td>
			  <td align="right"><strong><?php echo number_format($alcoholAmnt+$foodAmnt,2);?></strong></td>
			</tr>
		  </tbody>
		</table>
		<p>&nbsp;</p>
		<!--
		
		<div class="title-wrap">Detailed Customer wise Sales</div>
		<p>&nbsp;</p>-->
		<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
		  <tbody>
		  <tr>
		  <td align="left" bgcolor="#92d050"><span style="display:block;padding:6px;font-size:22px;color:#fff">Detailed Customer wise Sales</span></td>
		</tr>
		 </tbody>
		</table> 
		
		
		<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="table-single" >
		
		<thead>
			<tr>
			  <th style="border-bottom:1px solid #000000" align="left">S.No</th>
			  <th style="border-bottom:1px solid #000000" align="left">Guest Name</th>
			  <th style="border-bottom:1px solid #000000" align="left">Guest Membership ID</th>
			  <th style="border-bottom:1px solid #000000" align="left">PAX</th>
			  <th style="border-bottom:1px solid #000000" align="left">Arrival Time</th>
			  <th style="border-bottom:1px solid #000000" align="left">Time Spent ( mins)</th>
			  <th style="border-bottom:1px solid #000000" align="left">Items Ordered</th>
			  <th style="border-bottom:1px solid #000000" align="center">Rate ( Rs.)</th>
			  <th style="border-bottom:1px solid #000000" align="center">Qty</th>
			  <th style="border-bottom:1px solid #000000" align="center">Total ( Rs.)</th>
			  <th style="border-bottom:1px solid #000000" align="center">Service Time</th>
			  <th style="border-bottom:1px solid #000000" align="left">Overall Customer Feedback</th>
			  <th style="border-bottom:1px solid #000000" align="left">Suggestions</th>
			  <th style="border-bottom:1px solid #000000" align="left">Server </th>
			  <th style="border-bottom:1px solid #000000" align="left">Cancel Reason</th>
			</tr>
		</thead>
		<tbody>
		<?php $all_members=$this->Reports_model->get_member_orders($date1,$date2,$memeber_id);
	$i=0;
	foreach($all_members as $members) { //print_r($members);die();
	$i++;
	$main_menus=$this->Reports_model->get_member_mainmenu($date1,$date2,$members->table_booking_id);
	$bill_data=$this->Reports_model->get_bill_data($date1,$date2,$members->table_booking_id);
	?>
    <tr>
      <td align="left"><?php echo $i?></td>
      <td align="left"><?php echo $members->member_name?></td>
      <td align="left"><?php echo $members->membership_id?></td>
      <td align="left"><?php echo $members->no_of_guest?></td>
      <td align="left"><?php echo date('d/m/Y h:i A',strtotime($members->booking_time));?></td>
      <td align="left"><?php echo $members->time_spent>0?$members->time_spent:'';?></td>
      <td colspan="5" align="left">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="dynamic-table">
			<tbody>
			
			<?php foreach($main_menus as $menus) { 
			$sub_menus=$this->Reports_model->get_member_submenu($date1,$date2,$members->table_booking_id,$menus->menu_id);
			
			?>
			  <tr>
				<td width="26%" valign="top"><strong><?php echo $menus->menu_name?></strong></td>
				<td width="20%" align="center" valign="top">&nbsp;</td>
				<td width="10%" align="center" valign="top">&nbsp;</td>
				<td width="20%" align="center" valign="top">&nbsp;</td>
				<td width="24%" align="center" valign="top">&nbsp;</td>
			  </tr>
			  
			  <?php foreach($sub_menus as $sub_menu) {  ?>
				 <tr>
				<td valign="top"><?php echo $sub_menu->meal_name?></td>
				<td align="center" valign="top"><?php echo $sub_menu->meal_price?></td>
				<td align="center" valign="top"><?php echo $sub_menu->quantity?></td>
				<td align="center" valign="top"><?php echo $sub_menu->meal_price*$sub_menu->quantity?></td>
				<td align="center" valign="top"><?php echo $sub_menu->meal_prepration_time;?> minutes</td>
			  </tr>
			  <?php } ?>
			  
			  
			  <?php } 
			  		  if($bill_data->amount!=null){
		  ?>
          <tr>
		  <td valign="top" style="border-top: 1px dashed #000000">Sub Amount</td>
		  <td style="border-top: 1px dashed #000000"></td>
		  <td style="border-top: 1px dashed #000000"></td>
		  <td align="center" valign="top" style="border-top: 1px dashed #000000"><?php echo $bill_data->amount ?></td>
		  <td style="border-top: 1px dashed #000000"></td>
		  </tr>
		  <tr>
		  <td valign="top">Discount</td>
		  <td></td>
		  <td></td>
		  <td align="center" valign="top"><?php echo $bill_data->discount ?></td>
		  <td></td>
		  </tr>
		  <tr>
		  <td valign="top">Total Amount</td>
		  <td></td>
		  <td></td>
		  <td align="center" valign="top"><?php $total=$bill_data->amount-$bill_data->discount; echo $total; ?></td>
		  <td></td>
		  </tr>
		  <tr>
		  <td valign="top">Tax</td>
		  <td></td>
		  <td></td>
		  <td align="center" valign="top"><?php echo $bill_data->tax ?></td>
		  <td></td>
		  </tr>
          <tr>
		  <td valign="top">Payable Amount</td>
		  <td></td>
		  <td></td>
		  <td align="center" valign="top"><?php echo $total+$bill_data->tax ?></td>
		  <td></td>
		  </tr>
		  <?php } ?>
			</tbody>
		  </table>
	  </td>
      <td align="left"><?php if(empty($members->feedback_cancel_reason)) echo $members->feedback_10!=null?$this->config->item('feedback_rating')[$members->feedback_10]:'';?></td>
      <td align="left"><?php echo $members->text_feed_10!=null?$members->text_feed_10:'';?></td>
      <td align="left"><?php echo $members->waiter_name;?></td>
	  <td align="left"><?php echo $members->cancel_reason;?></td>
    </tr>
    
    <?php } ?>
			
		<!--	<tr>
			  <td>1</td>
			  <td>Mr. Gautam Taneja</td>
			  <td align="left">WIC09101</td>
			  <td align="left">4</td>
			  <td align="left">7.09 P.M</td>
			  <td>70</td>
			  <td align="left"><strong>Starters</strong></td>
			  <td align="center">&nbsp;</td>
			  <td align="center">&nbsp;</td>
			  <td align="center">&nbsp;</td>
			  <td align="center">30</td>
			  <td rowspan="10" align="center" valign="middle">DELIGHTED</td>
			  <td align="left" valign="middle">More Dishes in Veg</td>
			  <td align="center" valign="middle">Rishabh</td>
			</tr> -->

		  </tbody>
		</table>
		</body>
		</html>