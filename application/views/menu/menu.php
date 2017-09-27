<?php //echo "<pre>";print_r($bookTableData);echo "</pre>";die();
//print_r($sub_menu_list);
?>

<div id="loader_menu" style="position: fixed; left: 0px; top: 0px; background: #fff; width: 100%; height: 100%; text-align: center; padding-top: 10%; display: block; z-index: 999999;">
     <img src="<?php echo base_url()?>assets/img/loading.gif" alt="Please wait.." width="100px" />
   </div>
<div id="wrapper" class="container-fluid" style="background: #E0E0E0;">
<!--<div class="basket_cart"  data-toggle="modal" data-target="#savemenu"><span>0</span></div>-->
<p class="clearfix"></p>
<!--- Header Start --->
<div class="header-cont">
<div class="logo_menu">
<a href="<?php echo base_url()?>"><img src="<?php echo base_url()?>assets/img/logo.png" width="80" alt="" /></a>   
</div>
<div class="menu_carousel">
<div class="menu-carousel owl-theme ">
	<?php $k =0; foreach($menu_list as $menu){  $k++; ?>
<div class="item">
    <a href="" data-filter=".menucls<?php echo $menu->menu_id;?>" <?php if($k==1) { ?>class="current"<?php } ?> style="padding-left:20px; padding-right:20px;">&nbsp;<?php echo $menu->menu_name; ?></a>
    </div>
    <?php  } ?>
</div>
</div>
<span class="search_animation" style="position:fixed;right:0;top:30px;z-index:9999px;"><input type="text" name="search_meal" class="search_meal" placeholder="Search meal"><i class="fa fa-search"></i></span>


<div class="portfolioFilter" style="position:relative;height:auto;overflow:hidden;">
	<?php  $z =0; foreach($menu_list as $menu){  $z++;  ?>
    <div class="menucls<?php echo $menu->menu_id;?> <?php if($z==1) { ?> show	<?php } else { ?> hidden<?php } ?> owls<?php echo $z?> owl-theme">
	
    <a href="" data-filter=".menucls<?php echo $menu->menu_id;?>" class="current" style="opacity:0 !important;">All</a>
	
	<?php $j=0; foreach($sub_menu_list as $sub_menu){
		if($menu->menu_id==$sub_menu->menu_id){
			$j++;
			if($j==1){?>
              <a href="" data-filter=".menucls<?php echo $menu->menu_id;?>" class="current">All</a>
            <?php } ?>
	 <a href="" data-filter=".submenucls<?php echo $sub_menu->sub_menu_id;?>"><?php echo $sub_menu->sub_menu_name; ?></a>
	<?php } } ?>
    </div>
    <?php  } ?>
    
</div>
</div>
<!--- Header End --->
<!--- Content Start --->
<div class="portfolioContainer row" data-membercount="<?php echo $bookTableData->no_of_guest ?>" data-membername="<?php echo $bookTableData->member_name ?>">

		<?php foreach($meals as $meal){
			$class='';
			$class2='';
			foreach($menu_list as $menu){
			  if($meal->menu_id==$menu->menu_id){
				$class=$menu->menu_id;
				}
			}
			foreach($menu_list as $menu){
			foreach($sub_menu_list as $sub_menu){
			  if($meal->sub_menu_id==$sub_menu->sub_menu_id && $meal->menu_id==$menu->menu_id){
				
				$class2=$sub_menu->sub_menu_id;
				}
			}
			}
			?>
			<div class="col-xs-12 col-sm-4 menucls<?php echo $class;?> submenucls<?php echo $class2;?> mealclick" data-id="<?php echo $meal->meal_id; ?>" data-name="<?php echo $meal->meal_name; ?>">
				<div>
				<label class=""><input type="checkbox" class="mealselect" id="mealselect" data-id="<?php echo $meal->meal_id; ?>" data-name="<?php echo $meal->meal_name; ?>"/><span>
				<img src="<?php echo empty($meal->meal_image)?base_url().'assets/img/unavailable.jpg':base_url().''.$meal->meal_image;?>" alt="image">
				</span>
				</label>
				</div>
				<div class="popup_meal" data-toggle="modal" data-target="#popup_meal<?php echo $meal->meal_id;?>">
					<div class="menu_name">
						<span><?php echo $meal->meal_name; ?> - <i>Rs.<?php echo $meal->meal_price; ?></i></span>
					</div>
				</div>
				 
			</div>
			
		<?php } ?>
</div>
<!--- Content End --->
</div>


<aside class="basket_area out">
		<div class="title_hd">
        <strong>Basket (<span id="num_of_dish_ordrd"><?php echo count($cartData);?></span>)</strong>
        <span class="toggle_up ft-20 pull-right"><i class="fa fa-angle-up"></i></span>
        </div>
  <form method="post" action="">
  <div class="proceed_btn">
        	<div class="clearfix">
              <textarea name="remark" rows="2" style="width: 225px; padding: 2px 5px; font-size: 12px; border-color: #ddd; box-shadow: 0px 1px 5px #ccc;" class="pull-left" placeholder="Remarks"><?php echo empty($bookTableData->remark)?'':$bookTableData->remark;?></textarea>
              <button type="submit" class="btn btn-ru btn-xs pull-right" name="order" value="save_order">Proceed</button>
            </div>
        </div>
		<div class="current_info">
        	<table class="table">
                <thead>
            		<tr>
                        <th>Guest</th>                        
            			<th>Qty</th>
                        <th>Comments</th>
                        <th>Status</th>
            		</tr>
            	</thead>
                	<tbody id="cartTable1">
					
                    <?php $i=0;
					  foreach($cartData as $order) { 
					    if($order['order_status']==0){  ?>
                        <tr id="order<?php echo $order['table_order_id'];?>">
                		  <td colspan="4"><?php echo $order['meal_name'];?></td>
						</tr>
                		<tr>
							<td>
							<select class="form-control" name="rows[<?php echo $i;?>][2]">
							<?php $k=1;//echo $k;die();
							while($k <= $bookTableData->no_of_guest){?>
								  <option value="<?php echo $k;?>" <?php if($order['guest_seat_no']==$k){echo 'selected';}?>><?php echo ($k==1)?$bookTableData->member_name:'Guest '.$k; ?></option>
							<?php $k+=1;} ?>
							</select>
							</td>
							<td><input type="text" name="rows[<?php echo $i;?>][0]" value="<?php echo $order['table_order_id'] ?>" hidden>
							<input type="number" class="form-control" value="<?php echo $order['quantity'] ?>" min="1" name="rows[<?php echo $i;?>][1]">
							</td>
							<td><input type="text" name="rows[<?php echo $i++;?>][4]" value="<?php echo $order['comment'] ?>" class="form-control">
							</td>
							<td data-orderid="<?php echo $order['table_order_id'];?>"><a href="" class="delete-order"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					<?php }else { ?>
                         <tr id="order<?php echo $order['table_order_id'];?>">
                            <td colspan="4"><?php echo $order['meal_name'];?></td>
						 </tr>
						 <tr>
						     <td><input type="text" class="form-control" value="<?php echo $order['guest_seat_no']==1?$bookTableData->member_name:'Guest'.$order['guest_seat_no'] ?>" disabled>
							 </td>
						     <td><input type="text" class="form-control" value="<?php echo $order['quantity'] ?>" disabled>
							 </td>
                            <td><input type="text" value="<?php echo $order['comment']?>" class="form-control" disabled></td>
                            <td align="center"><?php if($order['order_status']==1){?><i class="fa fa-check-circle fa-2x green_text"></i>
							<?php } else if($order['order_status']==3){?><i class="fa fa-ban fa-2x pend_icon" aria-hidden="true"></i>
						   <?php } else if($order['order_status']==2){ ?><i class="fa fa-hourglass-half fa-2x cancel_icon" aria-hidden="true"></i> <?php } ?></td>
             		     </tr>		
						<?php } ?>
                	</tr>
					<?php } ?>          
                	</tbody>
                </table>
        </div>
        
	</form>
</aside>





<?php foreach($meals as $meal){ ?>
				 <div id="popup_meal<?php echo $meal->meal_id;?>" class="meal_modal modal fade" role="dialog">
					  <div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content" id="meal-content">
						  <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><?php echo $meal->meal_name.' - Rs. '.$meal->meal_price; ?></h4>
						  </div>
						  <div class="modal-body">
						  <p class="pull-right">Prepration Time : <?php echo $meal->meal_prepration_time; ?> (Minute)</p>
						  <p class="clearfix"></p>
                          
						  <?php if(!empty($meal->meal_description)){?>	
								<p><?php echo $meal->meal_description;?></p>
						  <?php } if(!empty($meal->meal_video)){ ?>	
								<video controls src="<?php echo base_url().$meal->meal_video;?>" width="500" height="300" class="note-video-clip"></video>
						  <?php } ?>	
						  <p class="clearfix"></p>
                          <hr style="margin:0px 0 10px;">
						  <?php if(!empty($meal->meal_image)){?>
                                <img src="<?php echo base_url().$meal->meal_image;?>" style="width:100%; height:300px;">
						  <?php } else { ?>	
								<h4 style="text-align:center">Image not available</h4>
						  <?php } ?> 
						  <p class="clearfix"></p>
						  
						  </div>
						  <!--
						  <div class="modal-footer">
						   <button data-dismiss="modal" class="btn btn-success" type="button">Close</button>
							
						  </div>-->
						</div>

					  </div>
			</div>
<?php } ?>







<?php  $k =0; foreach($menu_list as $menu){  $k++;  ?>
 <script>
 $('.owls<?php echo $k?>').owlCarousel({
    loop:false,
	autoWidth: true,
    margin:3,
    nav:true,
	 items:6,
	 navText:["<span class='left-angle'><i class='fa fa-angle-left'></i></span>","<span class='right-angle'><i class='fa fa-angle-right'></i></span>"],
	 responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:3,
            nav:true
        },
        768:{
            items:4,
            nav:true
        },
        1000:{
            items:5,
            nav:true,
            loop:false
        },
        1400:{
            items:6,
            nav:true,
            loop:false
        }
    }
});
 </script>
 <?php } ?>  
 
