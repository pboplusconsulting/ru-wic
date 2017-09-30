<div id="content_block">
<style type="text/css">
body,td,th {
	font-family: Calibri, Arial, sans-serif;
	font-size: 14px;
	color: #000000;
}


.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 5px;
}
.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
  padding: 8px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top: 1px solid #ddd;
}
.table > thead > tr > th {
  vertical-align: top;
  border-bottom: 2px solid #ddd;
}
.table > caption + thead > tr:first-child > th,
.table > colgroup + thead > tr:first-child > th,
.table > thead:first-child > tr:first-child > th,
.table > caption + thead > tr:first-child > td,
.table > colgroup + thead > tr:first-child > td,
.table > thead:first-child > tr:first-child > td {
  border-top: 0;
}
.table > tbody + tbody {
  border-top: 2px solid #ddd;
}
.table .table {
  background-color: #fff;
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
  border: 1px solid #ddd;
  padding:4px;
  line-height:18px;
}
.table-bordered > thead > tr > th,
.table-bordered > thead > tr > td {
  border-bottom-width: 2px;
}
.table-bordered > thead > tr > th{
background:#fff2cc;	
color:#000;
font-size:11px;
}


.table-responsive {
  min-height: .01%;
  overflow-x: auto;
}


  
@media screen and (max-width: 767px) {
  .table-responsive {
    width: 100%;
    margin-bottom: 15px;
    overflow-y: hidden;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    border: 1px solid #ddd;
  }
  .table-responsive > .table {
    margin-bottom: 0;
  }
  .table-responsive > .table > thead > tr > th,
  .table-responsive > .table > tbody > tr > th,
  .table-responsive > .table > tfoot > tr > th,
  .table-responsive > .table > thead > tr > td,
  .table-responsive > .table > tbody > tr > td,
  .table-responsive > .table > tfoot > tr > td {
    white-space: nowrap;
  }
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
}
.clone_to table tbody {
    height: 0;
    opacity: 0;
    overflow: hidden;
    line-height: 0;
    visibility: hidden;
}
</style>

<div class="text-center"> <a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a> </div>
<div class="container-fluid">
<div class="row">
  <div class="col-md-12">
    <div class="col-md-12">
      <label>Date Range</label>
    </div>
  </div>
  <div class="col-md-6">
    <form name="" method="post" action="">
      <div class="col-md-6">
        <div class="input-group date date-choose col-md-12">
          <input type="text" class="form-control input-daterange1" name="daterange" value="<?php echo $dateRange; ?>">
          <div class="input-group-addon"> <span class="glyphicon glyphicon-th"></span> </div>
        </div>
      </div>
      <div class="col-md-2">
        <input type="submit" name="dateFilter" value="Filter" class="btn btn-default">
      </div>
    </form>
  </div>
  <div class="col-md-6">
    <div class="pull-right"> <a href="<?php echo base_url().'reports/download_feedback_report?daterange='.$dateRange;?>" class="btn btn-success">Export</a> </div>
  </div>
</div>
<p class="clearfix"></p>
<p class="clearfix"></p>
<table width="100%" border="0" class="table " align="center" cellpadding="2" cellspacing="0">
      <tbody>
        <tr>
          <td align="left" bgcolor="#92d050"><span style="display:block;padding:6px;font-size:22px;color:#fff">RU FEEDBACK REPORT</span></td>
        </tr>
        <tr>
          <td align="right">Period : <?php echo empty($dateRange)?(date('d/m/Y').' - '.date('d/m/Y')):$dateRange; ?></td>
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
                            </span>Feedback Report</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                           <div class="notify_msgs">
  <div class="table-responsive">
    
  </div>
  <div class="overflow_horizon" style="height:300px">
    <div class="clone_to">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-scroll">
        <thead>
          <tr height="">
            <th height="" align="center" valign="top">Date</th>
            <th align="center" valign="top">Time</th>
            <th align="center" valign="top">Server</th>
            <th align="center" valign="top">Table</th>
            <th align="center" valign="top">Pax</th>
            <th align="center" valign="top">Name</th>
            <th align="center" valign="top">Are you a WIC member?</th>
            <th align="center" valign="top">If yes, Membership ID</th>
            <th align="center" valign="top" style="min-width: 128px;">Else, would you like to have a tour of WIC?</th>
            <th align="center" valign="top">Mobile Number</th>
            <th align="center" valign="top">Email Address</th>
            <th align="center" valign="top" style="min-width: 128px;">Would you like us to call you for your dining experience?</th>
            <th align="center" valign="top" style="min-width: 128px;">Would you like to subscribe to WIC newsletter?</th>
            <th align="center" valign="top">Food Quality</th>
            <th align="center" valign="top">Food Presentation</th>
            <th align="center" valign="top">Serving Time</th>
            <th align="center" valign="top">Variety in Menu</th>
            <th align="center" valign="top">Reception</th>
            <th align="center" valign="top">Staff Responsiveness</th>
            <th align="center" valign="top">Ambience</th>
            <th align="center" valign="top">Cleanliness</th>
            <th align="center" valign="top">Steward's Communication</th>
            <th align="center" valign="top">Overall Experience</th>
            <th align="center" valign="top">Your Invaluable Suggestion</th>
          </tr>
        </thead>
        <tbody>
          <?php 
	$ratingArr=$this->config->item('feedback_rating');
	foreach($feedbacks as $feedback) { ?>
          <tr height="17">
            <td height="17"><?php echo date('d/m/Y',strtotime($feedback['feedback_generation_time'])); ?></td>
            <td><?php echo date('h:i A',strtotime($feedback['feedback_generation_time'])); ?></td>
            <td><?php echo $feedback['server']; ?></td>
            <td><?php echo count(explode(',',$feedback['table_booking_no'])); ?></td>
            <td><?php echo $feedback['no_of_guest']; ?></td>
            <td><?php echo $feedback['member_name']; ?></td>
            <td><?php echo $feedback['q_1']; ?></td>
            <td><?php echo $feedback['q_1']=='yes'?$feedback['membership_id']:''; ?></td>
            <td><?php echo $feedback['q_2']; ?></td>
            <td><?php echo $feedback['mobile_no']; ?></td>
            <td><?php echo $feedback['email_id']; ?></td>
            <td><?php //echo $feedback['member_name']; ?></td>
            <td><?php echo $feedback['q_3']; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_1']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_2']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_3']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_4']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_5']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_6']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_7']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_8']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_9']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_10']]; ?></td>
            <td><?php echo $feedback['text_feed_10']; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="clone_from">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-scroll">
        <thead>
          <tr height="">
            <th height="" align="center" valign="top">Date</th>
            <th align="center" valign="top">Time</th>
            <th align="center" valign="top">Server</th>
            <th align="center" valign="top">Table</th>
            <th align="center" valign="top">Pax</th>
            <th align="center" valign="top">Name</th>
            <th align="center" valign="top">Are you a WIC member?</th>
            <th align="center" valign="top">If yes, Membership ID</th>
            <th align="center" valign="top" style="min-width: 128px;">Else, would you like to have a tour of WIC?</th>
            <th align="center" valign="top">Mobile Number</th>
            <th align="center" valign="top">Email Address</th>
            <th align="center" valign="top" style="min-width: 128px;">Would you like us to call you for your dining experience?</th>
            <th align="center" valign="top" style="min-width: 128px;">Would you like to subscribe to WIC newsletter?</th>
            <th align="center" valign="top">Food Quality</th>
            <th align="center" valign="top">Food Presentation</th>
            <th align="center" valign="top">Serving Time</th>
            <th align="center" valign="top">Variety in Menu</th>
            <th align="center" valign="top">Reception</th>
            <th align="center" valign="top">Staff Responsiveness</th>
            <th align="center" valign="top">Ambience</th>
            <th align="center" valign="top">Cleanliness</th>
            <th align="center" valign="top">Steward's Communication</th>
            <th align="center" valign="top">Overall Experience</th>
            <th align="center" valign="top">Your Invaluable Suggestion</th>
          </tr>
        </thead>
        <tbody>
          <?php 
	$ratingArr=$this->config->item('feedback_rating');
	foreach($feedbacks as $feedback) { ?>
          <tr height="17">
            <td height="17"><?php echo date('d/m/Y',strtotime($feedback['feedback_generation_time'])); ?></td>
            <td><?php echo date('h:i A',strtotime($feedback['feedback_generation_time'])); ?></td>
            <td><?php echo $feedback['server']; ?></td>
            <td><?php echo count(explode(',',$feedback['table_booking_no'])); ?></td>
            <td><?php echo $feedback['no_of_guest']; ?></td>
            <td><?php echo $feedback['member_name']; ?></td>
            <td><?php echo $feedback['q_1']; ?></td>
            <td><?php echo $feedback['q_1']=='yes'?$feedback['membership_id']:''; ?></td>
            <td><?php echo $feedback['q_2']; ?></td>
            <td><?php echo $feedback['mobile_no']; ?></td>
            <td><?php echo $feedback['email_id']; ?></td>
            <td><?php //echo $feedback['member_name']; ?></td>
            <td><?php echo $feedback['q_3']; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_1']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_2']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_3']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_4']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_5']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_6']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_7']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_8']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_9']]; ?></td>
            <td><?php echo $ratingArr[$feedback['feedback_10']]; ?></td>
            <td><?php echo $feedback['text_feed_10']; ?></td>
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
