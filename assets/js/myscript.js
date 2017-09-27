$(document).ready(function() {
	/***************************************Sub Menu List*************************************/
	$('#newmenu').change(function(){
		var menu_id=$(this).find(":selected").val();//alert(menu_id);
		if(menu_id!='')
		{	
			$.ajax({
				url:base_url+'meal/sub_menu_list',
				type:'post',
				data:{menu_id:menu_id},
				success:function(result){
					if(result==0)
					{
						//alert('This menu does not have sub menu');
						$('#submenu').html('');
					}
					else
					{
						$('#submenu').html(result);
					}					
				}
			});
		}
		else
		{
			$('#submenu').html('');
		}	
	});
	$('#submenu').click(function(){
		var x=$("#newmenu").find('option:selected').val();//alert(x);
		if(!x)
		{alert('Please select a menu.');}	
	});
	/***************************************end sub menu**************************************/

	/***************************file upload preview while adding new meal**********************************/
        $("#fileUpload").on('change', function(e) {
          //Get count of selected files
          var countFiles = $(this)[0].files.length;
          var imgPath = $(this)[0].value;//alert(imgPath);
          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
          var image_holder = $("#image-holder");
		  var size=$(this)[0].files[0].size;//alert(size);
          image_holder.empty();
          if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
			 if(size < 5*1024*1024){ 
				if (typeof(FileReader) != "undefined") {
				  //loop for each file selected for uploaded.
				  for (var i = 0; i < countFiles; i++) 
				  {
					var reader = new FileReader();
					reader.onload = function(e) {
					  $("<img />", {
						"src": e.target.result,
						"class": "thumb-image"

					  }).appendTo(image_holder);
					}
					image_holder.show();
					reader.readAsDataURL($(this)[0].files[i]);
				  }
				} else {
				  alert("This browser does not support FileReader.");
				}
			 }
			else
			{
				alert("Please select images of size upto 5 mb");
				$(this).val('');
			}
			
          } else {e.preventDefault();
            alert("Please select images only.");
			$(this).val('');
          }
        });
	/************************************end file upload preview************************************/	
	
	
	/**************************************video upload validation*********************************************/
$("#videoUpload").on('change', function() {
	
        var imgPath = $(this)[0].value;//alert(imgPath);
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var video_holder = $("#video-holder");
        var size=$(this)[0].files[0].size;
		var rtrn=false;
		video_holder.empty();
        if(extn == "mp4" || extn == "avi" || extn == "wmv" || extn == "mov" || extn == "3gp") 
		{
			if(size < 50*1024*1024)
			{ 
                if(typeof(FileReader) != "undefined") 
				{
				   
                   var reader = new FileReader();
                   reader.onload = function(e) 
				   {
						$("<img />", {
						"src": base_url+'assets/img/video.png',
						"class": "thumb-image"
						}).appendTo(video_holder);
                    }
					video_holder.show();
					reader.readAsDataURL($(this)[0].files[0]);
					rtrn=true;
                }
				else 
				{
				  alert("This browser does not support FileReader.");
				}
			}
			else
			{
				  alert("Please select video of size upto 50 mb.")
				  $(this).val('');
			}
        } 
		  
		else 
		{
            alert("Please select mp4 video format only.");
			$(this).val('');
        }
		return rtrn;
        });
	/*************************************end file upload******************************************/


    /*****************************************Dashboard member search*****************************************/
	$("input[name='search_member']").keyup(function(){
		var input=$(this).val();
		input=input.trim();//alert(input);
		if(input.length > 0)
		{
			$.ajax({
				type:'post',
				data:{search:input},
				url:base_url+'dashboard/search_member',
				success: function(res){//alert(res);
					if(res==''){
						
						window.location.href = 'Login'; //Redirect to Login.
					}
					else{
					$('#start_lsiting').find('#accordion').empty();
					$('#start_lsiting').find('#accordion').html(res);
					$('.multiselect-tbl').multiselect({buttonWidth: '150px'});							
						}
			
				}
			    });
		}
        else
        {//alert(input.length);
			//location.reload();
			$.ajax({
				type:'post',
				data:{search:''},
				url:base_url+'dashboard/search_member',
				success: function(res){//alert(res);
					$('#start_lsiting').find('#accordion').empty();
					$('#start_lsiting').find('#accordion').html(res);
				}
			    });
		}	
        		
	});
	

	$('body').on('click','.load_next',function(){
		var input=$("input[name='search_member']").val();
		var pageNumber=$(this).data('page');//alert(pageNumber);
		
		if(input.length > 0)
		{
			$.ajax({
				type:'post',
				data:{search:input,pageNumber:pageNumber},
				url:base_url+'dashboard/load_pagination_data',
				success: function(res){//alert(res);
				    
					$('#start_lsiting').find('#accordion').append(res);
					$('.multiselect-tbl').multiselect({buttonWidth: '150px'});
					
				}
			    });
				$(this).hide();
				$('#start_lsiting').find('#accordion').append('<div id="loader" style="position: fixed; left: 0px; top: 0px; background: #fff; width: 100%; height: 100%; text-align: center; padding-top: 10%; display: block; z-index: 9999;"><img src="'+base_url()+'assets/img/loading.gif" alt="Please wait.." width="100px" /></div>');
		}
        else
        {//alert(input.length);
			//location.reload();
			$.ajax({
				type:'post',
				data:{search:'',pageNumber:pageNumber},
				url:base_url+'dashboard/load_pagination_data',
				success: function(res){
					$('#start_lsiting').find('#accordion').append(res);
                    
				}
			    });
				$(this).hide();
				$('#start_lsiting').find('#accordion').append('<div id="loader" style="position: fixed; left: 0px; top: 0px; background: #fff; width: 100%; height: 100%; text-align: center; padding-top: 10%; display: block; z-index: 9999;"><img src="'+base_url()+'assets/img/loading.gif" alt="Please wait.." width="100px" /></div>');
				
		}
	});
	
	
	
	$("input[name='search_member_chef']").keyup(function(){
		var input=$(this).val();
		if(input.length > 0)
		{	
			$.ajax({
				type:'post',
				data:{search:input},
				url:base_url+module+'/search_member',
				success: function(res){
					$('#start_lsiting').find('#accordion').empty();
					$('#start_lsiting').find('#accordion').html(res);
				}
			});
		}
        else
        {
			//location.reload();
			$.ajax({
				type:'post',
				data:{search:''},
				url:base_url+module+'/search_member',
				success: function(res){//alert(res);
					$('#start_lsiting').find('#accordion').empty();
					$('#start_lsiting').find('#accordion').html(res);
				}
			    });
		}			
	});
	//$('#custom-search-input').find('input[name="search_member"]').focus();
	//$('#custom-search-input').find('input[name="search_member_chef"]').focus();
	/******************************************end member search *********************************************/

    
	/*********************************************Book Table*************************************************/
	$('body').on('submit','.booknow',function(e){
		var num_guest=$(this).find('input[name="total_guest"]').val();
		//alert(num_guest);
		var tables=[];
		 $("select.avalTable option:selected").each(function(){            
           tables.push($(this).val());
        });
		num_guest=parseInt(num_guest);
	    var index=0;
		if(isNaN(num_guest))
		{
			alert('Please Enter Valid Number of Guests.');
			e.preventDefault();
		}	
		if(num_guest < 1)
		{
			alert('Please Enter Number of Guest.');
			e.preventDefault();
		}	
		else if(tables.length < 1)
		{
			alert("Please select table.");
			e.preventDefault();
		}
		else if(Math.ceil(num_guest/8) > tables.length)
		{
			alert("Please select minimum "+Math.ceil(num_guest/8)+" tables to sit all the guest.");
			e.preventDefault();
		}	
		
	});
	
	/********************************************End book Table**********************************************/
	
	
	
    /*****************************************Menu Module**add to cart************************************/
	/* $('.mealclick').click(function(){
		var meal_id=$(this).data('id');//alert(id);
		var meal_name=$(this).data('name');
		var guestCout=$('.portfolioContainer').data('membercount');
		var memberName=$('.portfolioContainer').data('membername');
		var html='<select class="form-control" name="guest" required><option value="1">'+memberName+'</option>';
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
				ingred_list='<select class="form-control multiselect-gredients" id="" name="gredients[]" multiple="multiple">';
				$.each(ingredient_list,function(i,v){
					ingred_list+='<option value="'+i+'">'+v+'</option>';
				});
				ingred_list+='</select>';
				//alert(ingred_list);
				$('#cartTable').prepend('<tr><td>'+meal_name+'</td><td>'+html+'</td><td><input type="number" name="quantity" value="1" min="1" class="form-control"></td><td>'+ingred_list+'</td><td><input type="text" name="comment" class="form-control"><input type="text" value="'+meal_id+'" name="meal" hidden></td></tr>');
					$('.multiselect-gredients').multiselect({buttonWidth: '150px'});
			}
		});
		
		//alert(ingred_list);
        
	}); */
	
	/*****************************************Menu Module**add to cart************************************/
	
    
	$(document).bind('ready ajaxComplete', function(){
		//var current_cart = $('.basket_cart > span').html();
	 
	 
	$("#cartClose").click(function(){
        location.reload();
     });
	 
/*	 $('#popup_meal').on('hidden', function () {
		$("#popup_meal > .modal-header >h4").empty();//alert(value);
		$("#popup_meal > .modal-body").html('<div class="text-center">waiting...</div>');	     
});*/
	 /*
	$('.popup_meal').click(function(e){


        var meal_id=$(this).parent().data('id');//alert(meal_id);
		$.ajax({
				type:'post',
				url:base_url+'menu/meal_data',
				data:{meal_id:meal_id},
				// async: false,
				success:function(result){
					var mealData=JSON.parse(result);//alert(mealData);
					if(mealData.meal_image!='')
					{
						$("#meal-content > .modal-header >h4").html(mealData.meal_name+' - <i>Rs '+mealData.meal_price+'</i>');//alert(value);
						$("#meal-content > .modal-body").html('<img src="'+base_url+mealData.meal_image+'" style="width:100%">');
					}
					else
					{
						$("#meal-content > .modal-header >h4").html(mealData.meal_name+' - <i>Rs '+mealData.meal_price+'</i>');//alert(value);
						$("#meal-content > .modal-body").html('<h4 style="text-align:center">No Image available</h4>');
					}
					if(mealData.meal_description!='')
					{  
					$("#meal-content > .modal-body").append('<div style="margin-top:20px;">'+mealData.meal_description+'</div>');
					}
					if(mealData.meal_video!='')
					{  
					$("#meal-content > .modal-body").append('<video controls="" src="'+base_url+''+mealData.meal_video+'" width="500" height="360" class="note-video-clip"></video>');
					
					
					}
					//$('#popup_meal').modal('show');	
				}
			});
			$("#popup_meal > .modal-body").html('<div class="text-center">waiting...</div>');
			
	}); */
	
	});
	
	/*
	$('.popup_meal').click(function(e){
		//e.preventDefault();
        var meal_id=$(this).parent().data('id');//alert(meal_id);
		$.ajax({
				type:'post',
				url:base_url+'menu/meal_data',
				data:{meal_id:meal_id},
				success:function(result){
					var mealData=JSON.parse(result);//alert(mealData);
					if(mealData.meal_image!='')
					{
						$("#meal-content > .modal-header >h4").html(mealData.meal_name+' - <i>Rs '+mealData.meal_price+'</i>');//alert(value);
						$("#meal-content > .modal-body").html('<img src="'+base_url+mealData.meal_image+'" style="width:100%">');
					}
					else
					{
						$("#meal-content > .modal-header >h4").html(mealData.meal_name+' - <i>Rs '+mealData.meal_price+'</i>');//alert(value);
						$("#meal-content > .modal-body").html('<h4 style="text-align:center">No Image available</h4>');
					}
					if(mealData.meal_description!='')
					{  
					$("#meal-content > .modal-body").append('<div style="margin-top:20px;">'+mealData.meal_description+'</div>');
					}
					if(mealData.meal_video!='')
					{  
					$("#meal-content > .modal-body").append('<video controls="" src="'+base_url+''+mealData.meal_video+'" width="500" height="360" class="note-video-clip"></video>');
					
					
					}
						
				}
			});
	}); */
    /******************************************end filter****************************************************/	
	
	
	
	/*******************************************Delete Order************************************************/
	$('.delete-order').click(function(e){e.preventDefault();
		var order_id=$(this).parent().data('orderid');
		var row_id=$(this).parent().parent().attr('id');
		if(order_id > 0)
		{
			$.ajax({
				type:'post',
				url:base_url+'menu/delete_order',
				data:{order_id:order_id},
				success:function(e){
					if(e==1)
					{
						$('#'+row_id).hide(1000,function(){
							$('#'+row_id).remove();
							}
							);
					}
					else
					{
						//alert('Error in deleting.');
					}//alert(e);	
				}
			});
		}	
		else
		{
			alert("invalid field.");
		}	
	});
    
    /**************************************End delete order**********************************************/
	
	/*****************************************Chef order Dashboard*************************************/
	/*$('.start-processing').click(function(e){
		e.preventDefault();
		var table_order_id=$(this).closest('tr').data('order');
		var container_td=$(this).closest('td');//alert();exit;
		$.ajax({
			type:'post',
			url:base_url+'chef/change_order_status',
			data:{table_order_id:table_order_id,action:'order-start'},
			success:function(result){
				if(result==1)
				{
					container_td.removeAttr('class');
					container_td.addClass('incomplete');
					container_td.html('<a href="">Processing<br><span class="timer"></span></a>');
					
					container_td.next().find('input[type="checkbox"]').removeAttr('disabled');
				}
				else
				{	
				   alert(result);
				}   
			}
		});
		});*/
		
		$('.new_label').click(function(){//preventDefault();
			var table_booking_id=$(this).data('id');
			var elem=$(this);
			//update status of unread orders
			$.ajax({
				url:base_url+module+'/update_order_status',
				type:'POST',
				data:{table_booking_id:table_booking_id},
				success:function(result){
					if(result==1)
					{//alert(result);
						elem.removeClass('new_label');
					}
				}
			});
		});
		
	/*******************************************End Chef order Dashboard************************************/
	
	/*********************************************Timer*****************************************************/
	setInterval(function() {
		var current_time;
		$.get(base_url+'notification/get_date',function(result){
			current_time=parseInt(result);//alert(typeof current_time);
			
    var active_timers= $('.timer');    
	$.each(active_timers,function(i,val){
	       var tr_id=$(val).closest('tr').attr('id');//alert(id);
		   var order_id=$(val).closest('tr').data('order');
		   var order_time=$(val).closest('tr').data('ordertime');
		   var prepare_time=$(val).closest('tr').data('preparetime');
		   var quantity=$(val).closest('tr').data('quantity');
		   
		   //current_time=isNaN(current_time)?(Math.floor(Date.now() / 1000)):current_time;
		   
		   prepare_time=prepare_time*60;
		   var countDown=order_time+prepare_time;
		   var distance = countDown - current_time;//alert(countDown+' '+current_time);
		   if(distance<1)
		   {
			   $(val).closest('td').removeAttr('class');
			   $(val).closest('td').addClass('time_over');
			   $(val).html('<span>Time Over</span>');
		   }
		   else
		   {
			   //alert(distance);
			   var hrs,min,sec;
			   var sec_rem,min_rem;
			   hrs=Math.floor(distance/(60*60));
			   sec_rem=distance%(60*60);
			   min=Math.floor(sec_rem/60);
			   sec=sec_rem%60;
			   var timeString;
			   if(hrs <10 )
				   hrs='0'+hrs;
			   if(min <10)
				   min='0'+min;
			   if(sec<10)
				   sec='0'+sec;
			   $(val).html(hrs+':'+min+':'+sec);
		   }			   
	    });
		});
		}, 1000);

	/********************************************End Timer***********************************************/
	
	/****************************************Comment On order By chef************************************/
	$('body').on('click','.order_comment',function(){//e.preventDefault();
		var that = $(this);
		var order_id=$(this).closest('tr').data('order');//alert(order_id);
		var comment=$(this).closest('td').find('textarea').val();//alert(comment);
		if(comment=='')
		{	
			alert('Please enter message.');
		}	
		else
		{
			$.ajax({
				url:base_url+module+'/order_comment',
				type:'post',
				data:{order_id:order_id,comment:comment,action:'ordercomment'},
				success:function(result){					
					if(result==1)
					{
                        $('#order-no-'+order_id).before('<tr><td colspan="6"><p class="ft-12" style="margin:0;color:green"><b>Message Delivered to Steward</b></p> </td></tr>');						
						$(that).parents('.com_box').hide();
						$(that).closest('td').find('.fa-close').removeClass('fa-close').addClass('fa-pencil');
						$(that).parents('tr').removeClass('fade_on');
						$(that).parents('.input-group').find('[name="comment"]').prop('value','');
					}	
					else
					{
						alert(result);
					}	
				}
			});
		}	
	});
	
	
	
	//view comment by waiter
	$('body').on('click','.comment_vew',function(){
		var crrent = $(this);
		var order_id=$(this).closest('tr').data('order');
		var html='';
		$.ajax({
				url:base_url+'dashboard/order_comment',
				type:'post',
				data:{order_id:order_id,action:'view_commnt'},
				success:function(result){//alert(result);	
                    result=JSON.parse(result);
                    					
					$.each(result,function(i,v){
						html+='<p><b>'+v['name']+'</b> : '+v['message']+'</p>';
						
					});
					crrent.find('i').toggleClass('fa-envelope fa-close');
					crrent.siblings('.comment_view_box').slideToggle();
					crrent.siblings('.comment_view_box').html(html);
					crrent.parents('tr').toggleClass('fade_on');
					$('#order-no-'+order_id).find('.msg_count').html('');
                }
			});
	});
	
	
	/********************************************End order comment***************************************/
	
	
	
	
	
	/*******************************************advance table booking************************************/
      $('#tablebookingdate').on("dp.change", function(){
	       var inputDate=$('input[name="bookingdate"]').val();//alert(inputDate);
		   $.ajax({
			   url:base_url+'manager/table_availability_on_date',
			   type:'post',
			   data:{inputDate:inputDate},
			   success:function(e){
				   var tables=JSON.parse(e);
				   //alert(typeof(tables));
				   var html='<option value="">Select</option>';
				   $.each(tables,function(i,value){
					   //alert(i+' , '+value);
					   if(value['Adv_book_sts']!=1 && value['booking_status']!=1)
					   {  
					      html+='<option value="'+value['id']+'">'+value['table_name']+'</option>';
                       }					   
				   });
				   $('#table-list').html(html);
			   }
		   });
			});
	//$('#table-list').
	/****************************************************end*********************************************/
	
	
	
	
	
	/**********************************************Generate Bill*****************************************/
/*	$('body').on('click','.member-bill',function(){
		
		var table_booking_id=$(this).data('bookingid');
		//alert(table_booking_id);
		$.ajax({
			url:base_url+'dashboard/generate_bill',
			type:'post',
			data:{'table_booking_id':table_booking_id,'action':'generate_bill'},
			success:function(result){
				//alert(result);
				
				$('#modal-container').html(result);
                $('#billModal').modal({show:true});
			}
		});
		//$(this).html(modalHtml);
	});*/
	$('body').on('click','.member-bill',function(e){
		
		var table_booking_id=$(this).data('bookingid');//alert(table_booking_id);
		var hrefVal=$(this).attr('href');//alert(hrefVal);
		
		elem_id=hrefVal.replace('#','')
		//alert(elem_id);
		e.preventDefault();
		$.ajax({
			url:base_url+'dashboard/generate_bill',
			type:'post',
			data:{'table_booking_id':table_booking_id,'action':'generate_bill','bill_type':'meal_bill'},
			success:function(result){
				//alert(result);
				$('#'+elem_id+'>.about_user_desc').html(result);
			}
		});
		//$(this).html(modalHtml);
	});
	
	/*bill for alcohol*/
	$('body').on('click','.member-bill2',function(e){
		
		var table_booking_id=$(this).data('bookingid');//alert(table_booking_id);
		var hrefVal=$(this).attr('href');//alert(hrefVal);
		
		elem_id=hrefVal.replace('#','')
		//alert(elem_id);
		e.preventDefault();
		$.ajax({
			url:base_url+'dashboard/generate_bill',
			type:'post',
			data:{'table_booking_id':table_booking_id,'action':'generate_bill','bill_type':'alcohol_bill'},
			success:function(result){
				//alert(result);
				$('#'+elem_id+'>.about_user_desc').html(result);
			}
		});
		//$(this).html(modalHtml);
	});

/*
	$('body').on('change',':input.discount',function(e){
         //alert();	
        var discount=parseInt($(this).val());//alert(discount);
		var parentTableId=$(this).parents('table').attr('id');//alert('#'+parentTableId+'.subtotal');
		var subTotal=parseInt($('#'+parentTableId+' td.subtotal').html());//alert(subTotal);
		var countDiscount=(float)(subTotal*discount/100);alert(countDiscount);
		var grossTotal=null;
        	
	});/*
	/**********************************************End G Bill********************************************/
	
	
	/**********************************************Make Payment*******************************************/
	$('body').on('click','button[name="make_payment"]',function(){
		    var table_booking_id=$(this).data('tablebookingid');//alert(table_booking_id);
		      $.ajax({
						url:base_url+'dashboard/pay_bill',
						type:'post',
						data:{'table_booking_id':table_booking_id,'action':'make_payment'},
						success:function(result){
							//alert(result);
							//$('#modal-container').empty();
							//$('#modal-container').html(result);
							//$('#feedbackModal').modal({show:true});
							if(result==1)
							location.reload();//(base_url+'dashboard');	
						}
					});
		});
		
	
	/***********************************************End payment*******************************************/

	
	//$('body').on('change',':input.discount'
 $('body').on('click','.comment_btn',function(){
		$('.cancel_box').hide();
		$(this).siblings('.com_box').show();
		$(this).parents('tr').addClass('fade_on');
		});
		
		 $('body').on('click','.cancel_btn',function(){
		$(this).siblings('.cancel_box').show();
		$('.com_box').css('display','none');
		$(this).parents('tr').addClass('fade_on');
		});
$(document).bind( "mouseup touchend", function(e){
    var container = $(".com_box,.cancel_box");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        container.hide();
		$(container).parents('tr').removeClass('fade_on');
    }
});
		
		
	$('#base_url_link').click(function(){
       window.location.href = base_url; 
	});	

  $('.search_meal').keyup(function(){
	 var srch_meal = $('.search_meal').val();
     //alert(srch_meal);
	 var search_html = '';
      $.ajax({
	            url:base_url+'menu/search_meal',
				type:'post',
				data:{'srch_meal':srch_meal},
				success:function(result){
				if(result != 'Not Found'){	
				var meals=JSON.parse(result);
				$.each(meals,function(i,v){
						//alert(v['meal_name']);
					var meal_id = v['meal_id'];
					var meal_name = v['meal_name'];
					var meal_image = v['meal_image'];
					var meal_price = v['meal_price'];
					if(!meal_image){
						meal_image = 'assets/img/unavailable.jpg';
					}
					
				  search_html += '<div class="col-xs-12 col-sm-4 menucls mealclick" data-id="'+meal_id+'" data-name="'+meal_name+'"><div><label class=""><input type="checkbox" class="mealselect" id="mealselect" data-id="'+meal_id+'" data-name="'+meal_name+'"/><span><img src="'+base_url+''+meal_image+'" alt="image"></span></label></div><div class="popup_meal" data-toggle="modal" data-target="#popup_meal"><div class="menu_name"><span>'+meal_name+' - <i>Rs.'+meal_price+'</i></span></div></div></div>';
					 });
				}else{
				search_html = '<div style="background:#D1D0CE; height:400px; width:400px; text-align:center;padding-top:200px;">Meal is not avalable.</div>';	
				}
					$('.portfolioContainer').html(search_html);
				   }
				});
     });
	 $('.complete_proceed').click(function(){
		 var count_chk = $('.check_comp:checked').length;
		 if(count_chk==0){
		 $(this).parent().siblings('.err_msg').html('No dish is completed yet!');
		  return false;
		 }else{
		  return true;
		 }
	 });
	 
	 
	 
	 
	/************************************Onclicking cancel booking****************************************/
	$('body').on('click','.cancel-booking',function(e){e.preventDefault();
		/* var addr=$(this).attr('href');
	    var html='<div id="cancelBooking" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Cancel Booking</h4></div><div class="modal-body"><p>Do you want to cancel the booking?</p></div><div class="modal-footer"><a href="'+addr+'" class="btn btn-success">YES</a>&nbsp;&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">NO</button></div></div></div></div>';	
		$('#modal-container').html(html);
        $('#cancelBooking').modal({show:true});*/
		
	    var addr=$(this).attr('href');
	    var html='<div id="cancelBooking" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Cancel Booking</h4></div><div class="modal-body"><p>Do you want to cancel the booking?</p></div><div class="modal-footer"><a href="'+addr+'" class="btn btn-success cancel-booking-reason">YES</a>&nbsp;&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">NO</button></div></div></div></div>';
         		
		$('#modal-container').html(html);
        $('#cancelBooking').modal({show:true});
			
	});
	$('body').on('click','.cancel-booking-reason',function(e){e.preventDefault();
		
	    var addr=$(this).attr('href');
		//$('#cancelBooking [data-dismiss="modal"]').trigger('click');
		$('.modal-backdrop').remove();
		//$('#cancelBooking').hide();
	    var html='<div id="cancelBookingReason" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><form method="post" action="'+addr+'"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Cancel Booking</h4></div><div class="modal-body"><div class="row"><div class="col-xs-2"><label>Reason : </label></div><div class="col-xs-10"><input type="text" name="booking_cancel_reason" class="form-control" required ></div></div></div><div class="modal-footer"><button type="submit" class="btn btn-success" >Submit</button>&nbsp;&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">NO</button></div></form></div></div></div>';
         		
		$('#modal-container').html(html);
        $('#cancelBookingReason').modal({show:true});
			
	});
    /******************************************end cancel booking****************************************/	
	
	$('.booked_table').each(function(){
		$(this).find('.serve_compliments').show();
	});
	 
});

jQuery(document).ready(function($) {
	"use strict";
	
    $('.menu-carousel').owlCarousel({
    loop:false,
	autoWidth: true,
    margin:0,
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
        },
        1400:{
            items:6,
            nav:true,
        }
    }
});
$('.menu-carousel a').click(function(e) {
        $('.menu-carousel a').removeClass('current');
		var savefilter = $(this).attr('data-filter');
		$(this).addClass('current');
		$('.portfolioFilter>div').addClass('hidden');
		$('.portfolioFilter>div').removeClass('show');
		$(savefilter).removeClass('hidden').addClass('show');
		$(savefilter).find('.owl-stage>div:first-child a').first().trigger('click');
		$('.portfolioFilter .owl-stage>div:nth-child(2) a').addClass('current');
		e.preventDefault();
    });


$('.title_hd').click(function(e) {
    $(this).parent().toggleClass('out');
});
});

