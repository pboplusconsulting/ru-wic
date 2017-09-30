<div class="container body">


    <div class="main_container analysis_graph">

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
        
        <div class="page-title">
        
        
            <div class="title_left">
                <span class="block" style="margin-top:15px;font-size:1.6rem">Total staff : <strong style="color:#ccc;"><?php echo $staff!=null?$staff->total_staff:''?></strong>&nbsp;&nbsp;&nbsp; Available Staff : <strong style="color:#ccc;"><?php echo $staff!=null?$staff->available_staff:''?></strong>&nbsp;&nbsp;&nbsp;
				Relevant Occupancy : <?php echo $relevantOccupancy!=null?ceil($relevantOccupancy->relevant_occupancy).' %':'' ?>
				
            </div>

            <div class="title_right">
            <form method="post">
               <!--<div class="col-lg-5 col-md-4 hidden-sm hidden-xs"></div>-->
              <div class="col-lg-offset-4 col-lg-6 col-md-6 col-sm-9 col-xs-10 form-group top_search">
                <div class="input-group date date-choose" id="date-analysis">
					<input type="text" class="form-control" name="daterange" value="<?php echo $dateRange;?>" />
					<div class="input-group-addon">
					   <span class="glyphicon glyphicon-th"></span>
					</div>
                    
                </div>
              </div>
             <div class="col-lg-2 col-md-2 col-sm-3 col-xs-2"><button type="submit" class="btn btn-default form-control" name="dateFilter" id="dateFilter">Filter</button></div></form>
            </div>
        </div>
        
         
          <div class="clearfix"></div>

<div class="row guter-blk">
<div class="col-md-6 col-sm-12 col-xs-12 full-width">
              <div class="x_panel total_billing">
                <div class="x_title">
                  <h2>Total Billing</h2>
                  
                  <div class="clearfix"></div>
                </div>
               <div class="x_content">
<div class="text-center">
<ul class="list-inline bill-list">
<li>Min Billing: Rs. <?php echo $min_max_billing?floor($min_max_billing->min_billing):0;?></li>
<li>Max Billing: Rs. <?php echo $min_max_billing?floor($min_max_billing->max_billing):0;?></li>
<li>Avg Billing: Rs. <?php echo $average_billing?floor($average_billing->average):0;?></li>
<li><strong style="color:#ccc;">Today Billing: Rs. <?php echo $today_billing?floor($today_billing->todays_billing):0;?></strong></li>
</ul>
 </div>
                  <div id="mainb" style="height:300px;">
                 
                  </div>

                </div>
                
                
               
                
                
              </div>
            </div>
    <p class="clearfix visible-xs visible-sm visible-iball"></p>        
            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="x_panel guest_content">
                <div class="x_title">
                  <h2>Guest Feedback</h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <h4  class="text-right guest_served_total">No. of guest served : <strong><?php echo $noOfGuestServed!=null?$noOfGuestServed->no_of_guest_served:'' ?></strong></h4>
                <div style="height:15px;"></div>
                  <div class="col-md-5 col-sm-4">
				  
				  
				  
				  
				  <?php $average=''; if($feedback!=null){
					  $average=round(($feedback->avg1+$feedback->avg2+$feedback->avg3+$feedback->avg4+$feedback->avg5+$feedback->avg6+$feedback->avg7+$feedback->avg8+$feedback->avg9+$feedback->avg10)/10,2);
					  
					  
					  
				  } if($average >= 0 && $average < 1){ ?>
				  
				  <img src="<?php echo base_url()?>assets/analysis/images/sad-smiley.png" class="img-responsive center-block" alt=""/>
                  <?php } 
				  	else if($average >= 1 && $average < 2){ ?>
				  
				  <img src="<?php echo base_url()?>assets/analysis/images/average-smile.png" class="img-responsive center-block" alt=""/>
                  <?php } 
				  	else if($average >=2){ ?>
				  
				  <img src="<?php echo base_url()?>assets/analysis/images/smiley-ico.png" class="img-responsive center-block" alt=""/>
                  <?php } ?>
                  <span class="block text-center" style="font-size:18px;">Average Score : <strong style="font-size:18px;color:#ccc;"><?php  echo $average; ?></strong></span>
				  
                  </div>
                  <div class="col-md-7 col-sm-8">
                  	<div class="table_rating">
                    <div class="table-responsive">
                    	<table class="table">
                        	<tbody>
								
							    <?php if($feedback!=null) { ?>
                        		<tr>
                        			<td>Food Quality and Taste</td>
                        			<td><strong><?php echo $feedback->avg1==null?'':round($feedback->avg1,2); ?></strong></td>
                        		</tr>
							<!--	<tr>
                        			<td>Food Presentation</td>
                        			<td><strong><?php echo $feedback->avg2==null?'':round($feedback->avg2,2); ?></strong></td>
                        		</tr>-->
								<tr>
                        			<td>Serving Time</td>
                        			<td><strong><?php echo $feedback->avg3==null?'':round($feedback->avg3,2); ?></strong></td>
                        		</tr>
								<tr>
                        			<td>Variety in Menu</td>
                        			<td><strong><?php echo $feedback->avg4==null?'':round($feedback->avg4,2); ?></strong></td>
                        		</tr>
							<!--	<tr>
                        			<td>Reception</td>
                        			<td><strong><?php echo $feedback->avg5==null?'':round($feedback->avg5,2); ?></strong></td>
                        		</tr> -->
								<tr>
                        			<td>Staff Responsiveness</td>
                        			<td><strong><?php echo $feedback->avg6==null?'':round($feedback->avg6,2); ?></strong></td>
                        		</tr>
								<tr>
                        			<td>Restaurant Ambience</td>
                        			<td><strong><?php echo $feedback->avg7==null?'':round($feedback->avg7,2); ?></strong></td>
                        		</tr>
							<!--	<tr>
                        			<td>Cleanliness</td>
                        			<td><strong><?php echo $feedback->avg8==null?'':round($feedback->avg8,2); ?></strong></td>
                        		</tr>
								<tr>
                        			<td>Steward's Communication</td>
                        			<td><strong><?php echo $feedback->avg9==null?'':round($feedback->avg9,2); ?></strong></td>
                        		</tr>
								<tr>
                        			<td>Overall WIC Experience</td>
                        			<td><strong><?php echo $feedback->avg10==null?'':round($feedback->avg10,2); ?></strong></td>
                        		</tr>-->
								<?php } ?>
                        	</tbody>
                        </table>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
<p class="clearfix visible-iball-top"></p>
<div class="col-md-6 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Average Serve Time Per Dish</h2>
                  
                  <div class="clearfix"></div>
                </div>
               <div class="x_content">
<div class="text-center">
 </div>
                  <div id="ast" style="height:335px;">
                 
                  </div>

                </div>
                
                
               
                
                
              </div>
            </div>
  <p class="clearfix visible-xs visible-sm visible-iball"></p>    
<div class="col-md-6 col-sm-12 col-xs-12">

<div class="hot_sell">
<div class="row">
<div class="col-xs-12">
              <div class="x_panel hot_selling_dishes">
                <div class="x_title">
                  <h2>Hot Selling Dishes of Day</h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content" style="max-height:341px;overflow:auto;height:auto;">

                <?php if(count($hot_selling_dishes) > 0) { ?> 
                  <table class="table">
                  
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Amount (Rs)</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                    <?php $counter=1; foreach($hot_selling_dishes as $hot_selling_dish) { ?>
                      <tr>
                        <th scope="row"><?php echo $counter++; ?></th>
                        <td><?php echo $hot_selling_dish['MealName']; ?></td>
                        <td><?php echo $hot_selling_dish['menuName']; ?></td>
                        <td><?php echo $hot_selling_dish['total_quantity']; ?></td>
                        <td><?php echo $hot_selling_dish['total_price']; ?></td>
                      </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                <?php } else { echo "No dish to show";} ?>
                </div>
              </div>
            </div>
            
            <!--<div class="col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Staff</h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <div class="col-sm-8">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Total</th>
                        <th>Available</th>
                        <th>%</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>110</td>
                        <td>70</td>
                        <td>15%</td>
                        </tr>
                     </tbody>
                  </table>
                  </div>
                   <div class="col-sm-4">
                   <div class="text-center">
                            <span class="chart" data-percent="15">
                                            <span class="percent"></span>
                            </span>
                            </div>
                          </div>
                </div>
              </div>
            </div>-->
            
</div>
</div>

     
   </div>
<p class="clearfix visible-iball-top"></p>      
            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Menu</h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="x_content">

                  <div id="echart_bar_horizontal" style="height:350px;"></div>

                </div>
                </div>
              </div>
            </div>
            
</div>
 <div class="clearfix"></div>
 
 
          
          
        </div>

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Powered by PBOPlus Consulting services <a href="http://survey.irbureau.com/plot/">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

      </div>
      <!-- /page content -->
<div class="container body">


<div class="main_container">