

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 



<!-- Include all compiled plugins (below), or include individual files as needed --> 

<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url()?>assets/js/jquery.easing.1.3.js"></script> 
<script src="<?php echo base_url()?>assets/js/jquery.ui.touch-punch.js"></script> 
<?php if($this->uri->segment(1)!='reports'){ ?>
<script src="<?php echo base_url()?>assets/js/SmoothScroll.min.js"></script> 
<?php } ?>
<script src="<?php echo base_url()?>assets/js/jquery.isotope.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url()?>assets/js/moment.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url()?>assets/js/daterangepicker.js"></script>
	       <script type="text/javascript" src="<?php echo base_url()?>assets/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
	  <script src="<?php echo base_url()?>assets/js/parsley.min.js"></script>
	  	  <script src="<?php echo base_url()?>assets/multiselect/js/bootstrap-multiselect.js"></script>
	  <script src="<?php echo base_url()?>assets/js/myscript.js"></script>
	  <script src="<?php echo base_url()?>assets/js/myscript_part2.js"></script>
     
      <script src="<?php echo base_url()?>assets/js/dragscroll.js"></script> 
    
<script>
$(document).ready(function(){
function fixedhead(){
var TbodyHeight =  $('.clone_from').height()+20;
var saveTbodyHeight= '-'+TbodyHeight+'px';
var theadht =  $('.clone_from thead').height();
$('.clone_to').css('height',theadht);
$( ".overflow_horizon" ).scroll(function() {
var position =$(this).scrollTop();
if(position>theadht){
$('.clone_to').css('top',position);
$('.clone_to').css('opacity',1);
$('.clone_to').css('z-index',9999);
}
else
{
$('.clone_to').css('opacity',0);
$('.clone_to').css('z-index',-1);
}
});
}
fixedhead();
$('[data-parent="#accordion"]').click(function(e) {
   setTimeout(function(){   fixedhead();},1000); 
});



	$('[data-toggle="tooltip"]').tooltip();}); 
$(document).on('click','#mealselect',function(){
	var current_cart = $('.basket_cart > span').html();
	var meal_id=$(this).attr('data-id');
	//alert(meal_id);
	if($(this).is(":checked")==true){
		$(this).removeClass("selected"+meal_id);
		$(this).addClass("mealselect");
	}else{
		$(this).addClass("selected"+meal_id);
		$(this).removeClass("mealselect");
	}
	var cart_length = $('#mealselect:checked').length;
	//alert(cart_length);
	//var cart_value = parseInt(current_cart) + parseInt(cart_length);
	$('.basket_cart > span').html(cart_length);
});

$(document).on('click','#mealselect',function(){
///$('').click(function(){
		var html = "";
		$('.mealselect:checked').each(function() { 
		var meal_id=$(this).data('id');
		$(this).addClass("selected"+meal_id);
		$(this).removeClass("mealselect");
		//alert(meal_id);
		var meal_name=$(this).data('name');
		var guestCout=$('.portfolioContainer').data('membercount');
		var memberName=$('.portfolioContainer').data('membername');
		html='<select class="form-control" name="guest[]" required><option value="1">'+memberName+'</option>';
		var i=2;
		while(i<=guestCout)
		{
			html+='<option value="'+i+'">Guest '+i+'</option>';
			i+=1;
		}
		html+='</select>';
		
		var ingred_list='';
		$.ajax({
			url:base_url+'menu/ingredient_list',
			type:'get',
			success:function(e){//alert(e);
				var ingredient_list=JSON.parse(e);
				ingred_list='<select class="form-control multiselect-gredients" id="" name="gredients'+meal_id+'[]" multiple="multiple">';
				$.each(ingredient_list,function(i,v){
					ingred_list+='<option value="'+i+'">'+v+'</option>';
				});
				ingred_list+='</select>';
				//alert(ingred_list);
				/*$('#cartTable').append('<tr id="'+meal_id+'"><td>'+meal_name+'</td><td>'+html+'</td><td><input type="number" name="quantity[]" value="1" min="1" class="form-control"></td><td>'+ingred_list+'</td><td><input type="text" name="comment[]" class="form-control"><input type="text" value="'+meal_id+'" name="meal[]" hidden></td><td data-meal_id="'+meal_id+'" ><a class="delete-order"><i class="fa fa-trash remove_tr"></i></a></td></tr>'); */
				
				$('#cartTable1').prepend('<tr id="'+meal_id+'"><td colspan="4">'+meal_name+'</td></tr><tr id="tr'+meal_id+'"><td>'+html+'</td><td class="col-xs-2"><input type="number" class="form-control" name="quantity[]" value="1" min="1" ></td><td><input type="text" class="form-control" name="comment[]" placeholder="Comment box"><input type="text" value="'+meal_id+'" name="meal[]" hidden></td><td class="text-center" data-meal_id="'+meal_id+'" ><a class="delete-order"><i class="fa fa-trash fa-lg remove_tr"></i></a></td></tr>');
				//alert($('#num_of_dish_ordrd').html());
				
				var num_of_dish_ordrd=$('#num_of_dish_ordrd').html();
				num_of_dish_ordrd=parseInt(num_of_dish_ordrd);
				$('#num_of_dish_ordrd').html(num_of_dish_ordrd+1);
				
					$('.multiselect-gredients').multiselect({buttonWidth: '150px'});
			}
		});
		
		//alert(ingred_list);
      });
	  
	});
	
$('body').on('click','.remove_tr',function(){
		var current_cart1 = $('#num_of_dish_ordrd').html();
			var this_id = $(this).closest("td").attr("data-meal_id");
			$('.selected'+this_id).attr('checked',false);
			$(this).closest("tr").remove();
			$("#"+this_id).remove();
			//alert(current_cart1);
			current_cart2 = parseInt(current_cart1)-1;
		    $('#num_of_dish_ordrd').html(current_cart2);
	
});
$('body').on('click','input[class^="selected"]',function(){
	if ($(this).prop('checked')==false){ 
			var this_id = $(this).attr("data-id");
			$('#cartTable1 > #'+this_id).remove();
			$('#cartTable1 > #tr'+this_id).remove();
			var current_cart1 = $('#num_of_dish_ordrd').html();
			current_cart2 = parseInt(current_cart1)-1;
		    $('#num_of_dish_ordrd').html(current_cart2);
    }
});
$(document).ready(function(){
    
	$('.del_pic').click(function(){
		$('.prof_url').hide();
	});
	
	  d=new Date();
	  var month = d.getMonth()+1;
      var day = d.getDate();
      var output = (day<10 ? '0' : '') + day+ '/' +
       (month<10 ? '0' : '') + month + '/' +d.getFullYear();
	  
	  $('.datetimepicker').datetimepicker({
	     format: 'DD/MM/YYYY',
		 minDate:moment()
	   });
	   $('.rangeFilter').datetimepicker({
	     format: 'DD/MM/YYYY',
	   });
	
	
	var marital_status = $('#marital_status').val();
	if(marital_status==1){
	 $('#anniversary_date_field').show();
	}else{
	 $('#anniversary_date_field').hide();
	}
      $('#anniversary_date').attr('required', false);
	$('#marital_status').change(function(){
	  if($(this).val()==1){
	   $('#anniversary_date_field').show();
      $('#anniversary_date').attr('required', true);
	  }else{
	   $('#anniversary_date_field').hide();
      $('#anniversary_date').attr('required', false);
	  }
	});
});

$(window).load(function(){
    var $container = $('.portfolioContainer');
    $container.isotope({
        filter: '*',
        animationOptions: {
            duration: 750,
			resizable: true,
            easing: 'linear',
            queue: false
        }
    });
	$(window).smartresize(function(){
$container.isotope().arrange();
  $container.isotope({
    // update columnWidth to a percentage of container width
    masonry: { columnWidth: $container.width() / 3 },
  });

});
 
    $('.portfolioFilter a').click(function(){
        $('.portfolioFilter .current').removeClass('current');
        $(this).addClass('current');
 
        var selector = $(this).attr('data-filter');//alert(selector);
        $container.isotope({
            filter: selector,
            animationOptions: {
                duration: 750,
				resizable: true,
                easing: 'linear',
                queue: false
            }
         });
		 $(window).smartresize(function(){
  $container.isotope({
    // update columnWidth to a percentage of container width
    masonry: { columnWidth: $container.width() / 3 }
  });
});
         return false;
    }); 
	
	$('.multiselect-gredients').multiselect({buttonWidth: '150px'});
	$('.multiselect-tbl').multiselect({buttonWidth: '150px'});

$(".payment_status1").each(function() {
	var payment_status=$(this).val();
	//alert(payment_status);
	if(payment_status=='1')	{
		$(this).parent('.col-xs-6').siblings('.id_name').show();
		$(this).parent('.col-xs-6').siblings('.id_tid').show();
		
	}
});
	
	$('body').on('change','.payment_status1',function(){//e.preventDefault();
	//$('.payment_status1').change(function() { 
	//alert(111);
		var this_val=$(this).val();
		//alert(this_val);
		if(this_val=='1')	{
		$(this).parent('.col-xs-6').siblings('.id_name').show();
		$(this).parent('.col-xs-6').siblings('.id_tid').show();
		
	}else{
		$(this).parent('.col-xs-6').siblings('.id_name').hide();
		$(this).parent('.col-xs-6').siblings('.id_tid').hide();
	}
	});
		
});
$(window).load(function(){
		"use strict";
	$('.portfolioFilter>div:first-child .owl-stage>div:nth-child(2) a').trigger('click');
	setTimeout(function(){
	$('#loader_menu').hide();
	},100);
	});
$(document).ready(function($){
	

	
    $('.date-choose input[name="daterange"]').daterangepicker({
		   "opens": "right",
		    "drops": "down",
		locale: {
					format: 'DD/MM/YYYY',

	        }
			
});

    $('#date-analysis input[name="daterange"]').daterangepicker({
		   "opens": "left",
		    "drops": "down",
			orientation: "auto",
		locale: {
					format: 'DD/MM/YYYY',

	        }
			
});



		
$('body').on('click','.order_cancel',function(){//e.preventDefault();
		var that = $(this);
		var order_id=$(this).closest('tr').data('order');//alert(order_id);
		var comment=$(this).closest('td').find('textarea#cancelreason').val();//alert(comment);
		if(comment=='')
		{	
			alert('Please enter message.');
		}	
		else
		{//alert(base_url+module+'/order_cancel');
			$.ajax({
				url:base_url+module+'/order_cancel',
				type:'post',
				data:{order_id:order_id,comment:comment,action:'ordercancel'},
				success:function(result){					
					if(result==1)
					{
						location.reload();
						/*
						var cancel_time = '<?php echo date('h:i A') ?>';
                        $('#order-no-'+order_id).before('<tr><td colspan="6"><p class="ft-12" style="margin:0;color:green"><b>Message Delivered to Steward</b></p> </td></tr>');
						
						$('#order-no-'+order_id).children( ".time_over" ).html('<span class="">Cancelled</span><br><span>'+cancel_time+'</span>');	
						$('#order-no-'+order_id).children( ".time_over" ).next('td').html('');	
						$(that).parents('.cancel_box').hide();
						$(that).closest('td').find('.fa-close').removeClass('fa-close').addClass('fa-trash');
						$(that).parents('tr').removeClass('fade_on');
						$(that).parents('.input-group').find('[name="comment"]').prop('value','');*/
					}	
					else
					{
						alert(result);
					}	
				}
			});
		}	
	});		

});

</script>
</body>
</html>
