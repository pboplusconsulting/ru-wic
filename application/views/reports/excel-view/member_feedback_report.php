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
<title>RU Guest Report</title>
<style type="text/css">

body,td,th {
			font-family: "Calibri", Arial, sans-serif;
			font-size: 12px;
			color: #000000;
			line-height:18px;
		}
table > thead > tr > th{
background:#fff2cc;	
color:#000;
}		

</style>
</head>

<body>
       <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
		  <tbody>
			<tr>
			  <td align="left" bgcolor="#92d050"><span style="display:block;padding:6px;font-size:22px;color:#fff">RU FEEDBACK REPORT</span></td>
			</tr>
			<tr>
			  <td align="left">Date Range: <?php echo $dateRange; ?></td>
			</tr>
			<tr>
			  <td height="15" align="right"></td>
			</tr>
			
		  </tbody>
		</table>

<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#000000">
<thead>
    <tr>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Date</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Time</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Server</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Table</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Pax</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Name</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Are you a WIC member?</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">If yes, Membership ID</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Else, would you like to have a tour of WIC?</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Mobile Number</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Email Address</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Would you like us to call you for your dining experience?</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Would you like to subscribe to WIC newsletter?</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Food Quality</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Food Presentation</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Serving Time</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Variety in Menu</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Reception</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Staff Responsiveness</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Ambience</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Cleanliness</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Steward's Communication</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Overall Experience</th>
      <th style="border-bottom:1px solid #000000;background-color:#fff2cc;">Your Invaluable Suggestion</th>
    </tr>
</thead>
  <tbody>
     
    <?php
    $ratingArr=$this->config->item('feedback_rating');
	foreach($feedbacks as $feedback) { ?>
    <tr>
      <td align="center"><?php echo date('d/m/Y',strtotime($feedback['feedback_generation_time'])); ?></td>
      <td align="center"><?php echo date('h:i A',strtotime($feedback['feedback_generation_time'])); ?></td>
      <td align="center"><?php echo $feedback['server']; ?></td>
      <td align="center"><?php echo count(explode(',',$feedback['table_booking_no'])); ?></td>
      <td align="center"><?php echo $feedback['no_of_guest']; ?></td>
      <td align="center"><?php echo $feedback['member_name']; ?></td>
      <td align="center"><?php echo $feedback['q_1']; ?></td>
      <td align="center"><?php echo $feedback['q_1']=='yes'?$feedback['membership_id']:''; ?></td>
      <td align="center"><?php echo $feedback['q_2']; ?></td>
      <td align="center"><?php echo $feedback['mobile_no']; ?></td>
      <td align="center"><?php echo $feedback['email_id']; ?></td>
      <td align="center"><?php //echo $feedback['member_name']; ?></td>
      <td align="center"><?php echo $feedback['q_3']; ?></td>
      <td align="center"><?php echo $ratingArr[$feedback['feedback_1']]; ?></td>
      <td align="center"><?php echo $ratingArr[$feedback['feedback_2']]; ?></td>
      <td align="center"><?php echo $ratingArr[$feedback['feedback_3']]; ?></td>
      <td align="center"><?php echo $ratingArr[$feedback['feedback_4']]; ?></td>
      <td align="center"><?php echo $ratingArr[$feedback['feedback_5']]; ?></td>
      <td align="center"><?php echo $ratingArr[$feedback['feedback_6']]; ?></td>
      <td align="center"><?php echo $ratingArr[$feedback['feedback_7']]; ?></td>
      <td align="center"><?php echo $ratingArr[$feedback['feedback_8']]; ?></td>
      <td align="center"><?php echo $ratingArr[$feedback['feedback_9']]; ?></td>
      <td align="center"><?php echo $ratingArr[$feedback['feedback_10']]; ?></td>
      <td><?php echo $feedback['text_feed_10']; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</body>
</html>
