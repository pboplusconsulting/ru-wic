<div id="content_block">
<style type="text/css">
th,td{
	font-family: "Calibri", Arial, sans-serif;
	font-size: 12px;
	color: #000000;
	line-height:18px;
}

.table-bordered {
  border: 1px solid #ddd;
}
.table-bordered > thead > tr > th,
.table-bordered > tbody > tr > th,
.table-bordered > tfoot > tr > th,
.table-bordered > thead > tr > td,
.table-bordered > tbody > tr > td,
.table-bordered > tfoot > tr > td {
  border: 1px solid #000;
  padding:4px;
  line-height:18px;
}
.table-bordered > thead > tr > th,
.table-bordered > thead > tr > td {
  border-bottom-width: 1px;
}


/*-----table-single-line*/
.table-single {

}
.table-single > thead > tr > th,
.table-single > tbody > tr > th,
.table-single > tfoot > tr > th,
.table-single > thead > tr > td,
.table-single > tbody > tr > td,
.table-single > tfoot > tr > td {
  padding:4px;
  line-height:18px;
}
.table-single > thead > tr > th
{
	border-bottom:1px solid #000;
  border-bottom-width: 2px;
}

.no-pad-bor{
padding:0 !important;
borde:0 !important;	
}

.dynamic-table{

}

.dynamic-table tbody tr td{
padding:2px;
}
.dynamic-table tbody tr td:last-child{

}

div.title_wrap{
background:#ddd9c4;color:#000;	margin-top:20px;
}

.table-scroll thead tr th{
min-width:50px;	
word-wrap:normal;
}

.table-scroll tbody tr td{
font-size:11px;	
}

.overflow_horizon {
    overflow: auto;
    position: relative;
    width: 100%;
    margin-top: 20px;
}
.clone_to {
    position: absolute;
    overflow: hidden;
    min-width: 100%;
    z-index: -1;
    opacity: 0;
	background:#eee;
}
.clone_to table tbody {
    height: 0;
    opacity: 0;
    overflow: hidden;
    line-height: 0;
    visibility: hidden;
}

.panel-title>a{
display:block;	
}
</style>
<?php //echo print_r($_POST)?>
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
		<div class="row">	    
	   <div class="col-md-8">
    	<form name="" method="post" action="">
		<div class="col-md-3">
		<div class="form-group">
		<label>Date Range</label>
		 <div class="input-group date date-choose">		 
					<input type="text" class="form-control" name="daterange" value="<?php echo $dateRange; ?>">
					<div class="input-group-addon">
					   <span class="glyphicon glyphicon-th"></span>
					</div>
		</div>
		</div>
        </div>
		<!--- Member List Start --->
		
		<div class="col-md-3">
		<div class="form-group">
		<label>Member</label>
		 <div class="input-group">		 
					<select name="members" class="form-control" style="text-transform:capitalize;">
		  <option value="">---Select Member---</option>
		  <?php foreach($members as $members){?>
		  <option value="<?php echo $members['id']; ?>" <?php if(!empty($_POST['members'])) { if($_POST['members']==$members['id']){ echo "selected";}} ?>><?php echo $members['member_name']; ?></option>
		  <?php }?>
		</select> 
		
		</div>
		</div>
        
		</div>

		
		<!--- Member List End --->
		
		<div class="col-md-2">
		<div class="form-group">
		<label>&nbsp;</label>
		 <div class="input-group">		 
			<input type="submit" name="dateFilter" value="Filter" class="btn btn-default">		
		
		</div>
		</div>
        
		</div>
		</form>
       </div>
	   <div class="col-md-4">
		<div class="pull-right">
		
		 <a href="<?php echo base_url().'reports/download_mis_report?daterange='.$dateRange.'&memberid='.$memberId;?>" class="btn btn-success">Export</a></div>
       </div>
		
	</div>
    <p class="clearfix"></p>
    <p class="clearfix"></p>
  <?php
  $date1 = '';
  $date2 = '';
  $memeber_id = '';
  if(isset($_POST['dateFilter'])){
	 $daterange = $_POST['daterange'];
	 $dtrange = explode(' - ',$daterange);
	 $date1 = $dtrange[0];
	 $date2 = $dtrange[1];
     $date1 = str_replace('/', '-', $date1);
     $date2 = str_replace('/', '-', $date2);
     $date1 = date("Y-m-d", strtotime($date1));
     $date2 = date("Y-m-d", strtotime($date2));
	 $memeber_id = $_POST['members'];
	 
  }
    $relieved_table_booking_arr=$this->Reports_model->relieved_table_booking_id($date1,$date2,$memeber_id);
	$relieved_table_booking_arr=implode(',',$relieved_table_booking_arr);//var_dump($relieved_table_booking_arr);
	 //var_dump($relieved_table_booking_arr);die();
  ?>
    
    <div class="notify_msgs">
      <div class="table-responsive">
    
    <table width="100%" border="0" class="table " align="center" cellpadding="2" cellspacing="0">
  <tbody>
    <tr>
      <td align="left" bgcolor="#92d050"><span style="display:block;padding:6px;font-size:22px;color:#fff">RU SALES REPORT</span></td>
    </tr>
    <tr>
      <td align="right">Period : <?php echo isset($daterange)?$daterange:(date('d/m/Y').' - '.date('d/m/Y')); ?></td>
    </tr>
    <tr>
      <td height="15" align="right"></td>
    </tr>
    
  </tbody>
</table>
<div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-file">
                            </span> Sales Summary</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                           <table  align="center" cellpadding="0" cellspacing="0" class="table table-bordered">
 <thead>
    <tr>
      <th colspan="4"><strong>Billing  Details </strong></th>
      <th colspan="2"><strong>No of Guest Served</strong></th>
      <th colspan="2"><strong>Customer Feedback</strong></th>
      <th><strong>Average Service time</strong></th>
      <th align="left"><strong>Service Delay Cases</strong></th>
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
      <td rowspan="5" align="center" valign="middle"><?php echo  empty($relieved_table_booking_arr)?0:round($this->Reports_model->average_service_time($relieved_table_booking_arr),2)?> minutes per dish</td>
      <td rowspan="5" align="center" valign="middle"><strong><?php echo empty($relieved_table_booking_arr)?0:$this->Reports_model->get_delay_cases($relieved_table_booking_arr)?></strong></td>
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
      <td>Food & Beverages</td>
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
      <td></td>
      <td align="right"></td>
      <td rowspan="2" align="left"><!--Average---></td>
      <td rowspan="2" align="center"><?php // echo round((($delighted+$satisfy+$dispoint)/3),2); ?></td>
    </tr>
    <tr>
      <td><strong>Total (Rs.)</strong></td>
      <td><strong><?php echo number_format($cashAmnt+$cardAmnt+$creditAmnt,2) ?></strong></td>
      <td>&nbsp;</td>
      <td align="right"><strong><?php echo number_format($alcoholAmnt+$foodAmnt,2);?></strong></td>
    </tr>
  </tbody>
</table>
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                
                
                
                
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="glyphicon glyphicon-th-list">
                            </span> Detailed Customer wise Sales</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <!--<div class="title_wrap" style="font-size:14px;padding:8px;">Detailed Customer wise Sales</div>-->
<div class="overflow_horizon" style="height:200px">
<div class="clone_to">
<table  border="0" align="center" cellpadding="0" cellspacing="0" class="table-single table table-bordered table-scroll" >
  <thead>
    <tr>
      <th align="left" valign="top">S.No</th>
      <th align="left" valign="top">Guest Name</th>
      <th align="left" valign="top">Guest Membership ID</th>
      <th align="left" valign="top">PAX</th>
      <th align="left" valign="top">Arrival Time</th>
      <th align="left" valign="top">Time Spent ( mins) </th>
      <th align="left" valign="top">Items Ordered</th>
      <th align="left" valign="top">Rate( Rs.)</th>
      <th align="left" valign="top">Qty</th>
      <th align="left" valign="top">Total ( Rs.)</th>
      <th align="left" valign="top">Service Time</th>
      <th align="left" valign="top">Overall Customer Feedback</th>
      <th align="left" valign="top">Suggestions</th>
      <th align="left" valign="top">Server</th>
	  <th align="left" valign="top">Cancel Reason</th>
    </tr>
  </thead>
  <tbody>
    <?php 
	
	$all_members=$this->Reports_model->get_member_orders($date1,$date2,$memeber_id);
	$i=0;
	foreach($all_members as $members) { //print_r($members);die();
	$i++;
	$main_menus=$this->Reports_model->get_member_mainmenu($date1,$date2,$members->table_booking_id);
	?>
    <tr>
      <td align="left" valign="top"><?php echo $i?></td>
      <td align="left" valign="top"><?php echo $members->member_name?></td>
      <td align="left" valign="top"><?php echo $members->membership_id?></td>
      <td align="left" valign="top"><?php echo $members->no_of_guest?></td>
      <td align="left" valign="top"><?php echo date('d/m/Y h:i A',strtotime($members->booking_time));?></td>
      <td align="left" valign="top"><?php echo $members->time_spent>0?$members->time_spent:'';?></td>
      <td colspan="5" align="left" valign="top" class="no-pad-bor">
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
          
          
          <?php } ?>
       
       
        </tbody>
      </table></td>
      <td align="left" valign="top"><?php echo $members->feedback_10!=null?$this->config->item('feedback_rating')[$members->feedback_10]:'';?></td>
      <td align="left" valign="top"><?php echo $members->text_feed_10!=null?$members->text_feed_10:'';?></td>
      <td align="left" valign="top"><?php echo $members->waiter_name;?></td>
	  <td align="left" valign="top"><?php echo $members->cancel_reason ?></td>
    </tr>
    
    <?php } ?>
   
    
  </tbody>
</table>
</div>

        <div class="clone_from">
<table  border="0" align="center" cellpadding="0" cellspacing="0" class="table-single table table-bordered table-scroll" >
  <thead>
    <tr>
      <th align="left" valign="top">S.No</th>
      <th align="left" valign="top">Guest Name</th>
      <th align="left" valign="top">Guest Membership ID</th>
      <th align="left" valign="top">PAX</th>
      <th align="left" valign="top">Arrival Time</th>
      <th align="left" valign="top">Time Spent ( mins) </th>
      <th align="left" valign="top">Items Ordered</th>
      <th align="left" valign="top">Rate ( Rs.)</th>
      <th align="left" valign="top">Qty</th>
      <th align="left" valign="top">Total ( Rs.)</th>
      <th align="left" valign="top">Service Time</th>
      <th align="left" valign="top">Overall Customer Feedback</th>
      <th align="left" valign="top">Suggestions</th>
      <th align="left" valign="top">Server </th>
	  <th align="left" valign="top">Cancel Reason</th>
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
      <td align="left" valign="top"><?php echo $i?></td>
      <td align="left" valign="top"><?php echo $members->member_name?></td>
      <td align="left" valign="top"><?php echo $members->membership_id?></td>
      <td align="left" valign="top"><?php echo $members->no_of_guest?></td>
      <td align="left" valign="top"><?php echo date('d/m/Y h:i A',strtotime($members->booking_time));?></td>
      <td align="left" valign="top"><?php echo $members->time_spent>0?$members->time_spent:'';?></td>
      <td colspan="5" align="left" valign="top" class="no-pad-bor">
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
      </table></td>
      <td align="left" valign="top"><?php if(empty($members->feedback_cancel_reason)) echo $members->feedback_10!=null?$this->config->item('feedback_rating')[$members->feedback_10]:'';?></td>
      <td align="left" valign="top"><?php echo $members->text_feed_10!=null?$members->text_feed_10:'';?></td>
      <td align="left" valign="top"><?php echo $members->waiter_name;?></td>
	  <td align="left" valign="top"><?php echo $members->cancel_reason ?></td>
    </tr>
    
    <?php } ?>
   
    
  </tbody>
</table>
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
