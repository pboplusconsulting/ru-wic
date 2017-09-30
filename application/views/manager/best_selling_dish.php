<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div> 
    <div class="container-fluid">
    	
		<div class="hd_top">
			<h3>Best Selling Dish</h3>
		</div>
		<p class="clearfix"></p>
		<form name="dish_filter" method="post">
			<div class="row">
				<div class="col-sm-12 col-md-12"><label>Date Range</label></div>
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
						    <button type="submit" name="dishFilter" class="btn btn-info btn">Filter</button>
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
				<th>Dish Name</th>
				<th>Sold Quantity</th>
				<th></th>
			  </tr>
			</thead>
			<tbody>
			<?php $rowno=1;$memberTypeArr=$this->config->item('membership_type_array');
			foreach($data as $row) {
			?>
			  <tr>
				<td><?php echo $rowno++; ?></td>
				<td><?php echo $row['meal_name']; ?></td>
				<td><?php echo $row['total_quantity']; ?></td>
				<td></td>
			  </tr>
			<?php } ?>  
			</tbody>
			
		</table>	
		
	</div>
	
</div>
