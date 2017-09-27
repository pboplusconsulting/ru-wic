<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div> 
    <div class="container-fluid">
    	
		<div class="hd_top">
			<h3>Occupancy Summary</h3>
		</div>
		<p class="clearfix"></p>
		<form name="occupancy_filter" method="post">
			<div class="row">
				<!--<div class="col-sm-4 col-md-3"><label>Type</label></div>-->
				<div class="col-sm-4 col-md-3"><label>Start Date</label></div>
				<div class="col-sm-8 col-md-9"><label>End Date</label></div>
			<!--	<div class="col-sm-4 col-md-3">
				    <div class="form-group">
						<select class="form-control" name="report" value="<?php echo $report ?>" required>
						    <option value="0" <?php echo $report==0?'selected':'' ?>>Billing</option>
							<option value="1" <?php echo $report==1?'selected':'' ?>>Occupancy</option>
							<option value="2" <?php echo $report==2?'selected':'' ?>>Meal Consumption</option>
						</select>    
				    </div>
				</div>-->
				<div class="col-sm-4 col-md-3">
				    <div class="form-group">
						<div class='input-group date rangeFilter' id='range1'>
							<input type="text" class="form-control" name="daterange1" value="<?php echo $daterange1 ?>" required>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
				    </div>
				</div>
                <div class="col-sm-4 col-md-3">	
				    <div class="form-group">				
						<div class='input-group date rangeFilter' id='range2'>
							<input type="text" class="form-control" name="daterange2" value="<?php echo $daterange2 ?>" required>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>
				<div class="col-sm-4 col-md-3">
					<div class="form-group">
					    <div>
						    <button type="submit" name="occupancyFilter" class="btn btn-info btn">Filter</button>
					    </div>	 
					</div>
				</div>
            </div>
	    </form>
        <p class="clearfix"></p>
		<p class="clearfix"></p>
				<p class="clearfix"></p>
		<table class="table table-hover">
			<thead>
			  <tr>
				<th>S.N.</th>
				<th>Table Name</th>
				<th>Occupancy</th>
				<th>Date</th>
				<th></th>
			  </tr>
			</thead>
		<!--	<tbody>
			<?php $rowno=1;$subamount=0;$grossamount=0; foreach($data as $row) {
            $subamount+=$row['amount'];$grossamount+=$row['final_amount'];
			?>
			  <tr>
				<td><?php echo $rowno++; ?></td>
				<td><?php echo $row['member_name']; ?></td>
				<td><?php echo $row['table_name']; ?></td>
				<td><?php echo $row['amount']; ?></td>
				<td><?php echo $row['discount']; ?></td>
				<td><?php echo $row['tax']; ?></td>
				<td><?php echo $row['final_amount']; ?></td>
				<td><?php echo date('d M Y',strtotime($row['bill_generation_time'])); ?></td>
				<td><?php if(!empty($row['bill_pdf'])){ $temp=array_reverse(explode('/',$row['bill_pdf']));$filename=$temp[0];?>
				<a href="<?php echo base_url().'manager/download_file/'.$filename?>" class="btn btn-info">Download Bill</a><?php } ?></td>
			  </tr>
			<?php } ?>  
			</tbody>-->
			<tfoot>
			  <tr>
				<th></th>
				<th>Total</th>
				<th><?php echo $grossamount; ?></th>
				<th></th>
			  </tr>
			</tfoot>
		</table>	
		
	</div>
	
</div>
