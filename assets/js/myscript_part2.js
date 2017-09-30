$(document).ready(function(){
	
	$('body').on('change',':input.discount',function(e){
         //alert();	
        var discount=parseInt($(this).val());
		discount=discount?discount:0;	
		var parentTableId=$(this).parents('table').attr('id');//alert('#'+parentTableId+'.subtotal');
		var subTotal=$('#'+parentTableId+' td.subtotal').html();//alert(subTotal);
		//alert(discount+' '+subTotal);
		var subTotal = subTotal.replace(/,/g,''); 
		//alert(asANumber);
		if(discount>=subTotal)
		{
			alert("Dicount amount must be less than sub amount.");
		}	
		else
		{
			var totalTax=0;
			var tatalAmount=subTotal-discount;
			$('#'+parentTableId+' td.total_bill').html((tatalAmount).toFixed(2));
			
			$('#'+parentTableId).find('.total_tax').each(function() {
				var tax_percent=$(this).find('.tax_percentage').val();
				var result_tax = tatalAmount*tax_percent/100;
				$(this).find('.total_tax_value').html(result_tax);
				totalTax=totalTax+result_tax;
            });
			//alert(totalTax);
			
			$('#'+parentTableId+' td.grossamount').html(Math.round((tatalAmount+totalTax)).toFixed(2));	
			//window.print();
		}
	});
	
		$('body').on('change',':input.discountbm',function(e){
         //alert();	
        var discountbm=parseInt($(this).val());
		discountbm=discountbm?discountbm:0;	
		var parentTableId=$(this).parents('table').attr('id');//alert('#'+parentTableId+'.subtotal');
		var subTotal=$('#'+parentTableId+' td.subtotal').html();//alert(subTotal);
		var subTotalMeal=$('#'+parentTableId+' td p.subtotalmeal').html();//alert(subTotalMeal);
		var subTotalBev=$('#'+parentTableId+' td p.subtotalbev').html();//alert(subTotalBev);
		//alert(discountbm+' '+subTotal);
		var subTotal = subTotal.replace(/,/g,'');
		var subTotalMeal = subTotalMeal.replace(/,/g,'');
		var subTotalBev = subTotalBev.replace(/,/g,'');		
		// alert(asANumber);
		if(discountbm>=subTotal)
		{
			alert("Dicount amount must be less than sub amount.");
		}	
		else
		{
			var totalTaxMeal=0;
			var totalTaxBev=0;
			var tatalAmountBev=0;
			var tatalAmountMeal=0;
			
			//alert(subTotalBev);
			//alert(subTotalMeal);
			if(subTotalMeal!=0.00){
			var tatalAmountMeal=subTotalMeal-discountbm;
			}
			if(subTotalBev!=0.00){
			var tatalAmountBev=subTotalBev-discountbm;
			}
			//alert(tatalAmountMeal+'&'+tatalAmountBev);
			$('#'+parentTableId+' td.total_bill').html((tatalAmountMeal+tatalAmountBev).toFixed(2));
			
			$('#'+parentTableId).find('.total_tax').each(function() {
				
				
				var tax_percent=$(this).find('.tax_percentage').val();
				var tax_name=$(this).find('.tax_name').html();
				if(tax_name=='CESS'){
				//alert(tax_name);
				var result_tax_bev = tatalAmountBev*tax_percent/100;				
				$(this).find('.total_tax_bev_value').html(result_tax_bev);
				totalTaxBev=totalTaxBev+result_tax_bev;
				
				}
				else {
				//alert(tax_name);
				var result_tax = tatalAmountMeal*tax_percent/100;
				$(this).find('.total_tax_value').html(result_tax);
				totalTaxMeal=totalTaxMeal+result_tax;					
				}
				
            });
			//alert('Meal '+totalTaxMeal+' Tax'+tatalAmountMeal+' Bev'+totalTaxBev+' Tax'+tatalAmountBev);
			
			$('#'+parentTableId+' td.grossamount').html(Math.round((tatalAmountMeal+totalTaxMeal+tatalAmountBev+totalTaxBev)).toFixed(2));	
			//window.print();
		}
	});
	
	
	$('body').on('submit','form[class="save_print_bill"]',function(e){
        e.preventDefault();
        var discount=parseInt($(this).find(':input.discount').val());//alert(discount);
		var discountbm=parseInt($(this).find(':input.discountbm').val());//alert(discount);
		var comment=$(this).find(':input.commentt').val();
		/*
		if(discount>100 || discount<0)
		{
			alert('Dicount must be range in 0% to 100%');
			
		}	*/
		var table_booking_id=$(this).find('button[name="save_print_bil"]').data('bookingid');
		var bill_category=$(this).find('.billcategory').val();
		//alert(bill_category);
		if(bill_category=='meal')
		{	
			$.ajax({
				url:base_url+'dashboard/generate_bill',
				type:'post',
				data:{table_booking_id:table_booking_id,discount:discountbm,comment:comment,action:'save_print',bill_category:'meal'},
				success:function(result){//alert(result);
				location.reload();
					var w=window.open(base_url+result);
					$(w).on('load',function(){
					   w.print();
					});
				}
			});
		}
		else if(bill_category=='alcohol')
		{	
			$.ajax({
				url:base_url+'dashboard/generate_bill',
				type:'post',
				data:{table_booking_id:table_booking_id,discount:discount,comment:comment,action:'save_print',bill_category:'alcohol'},
				success:function(result){//alert(result);
				location.reload();
					var w=window.open(base_url+result);
					$(w).on('load',function(){
					   w.print();
					});
				}
			});
		}
	});
	
	
	
	/*********************************************Notifications******************************************/
	$('#notif_area').click(function(){
		$.ajax({
			url:base_url+'notification/notification_list',
			type:"post",
			data:{action:'total_count'},
			success:function(result){//alert((JSON.parse(result)).length);
			    var notifications=JSON.parse(result);
				var html='';
				$.each(notifications,function(i,val){
					var classs=val['is_read']==1?'':'style="background:#CCC;"';
					html+='<li><a href="'+base_url+'notification/single_notification_view/'+val['id']+'" '+classs+'><span><span>'+val['name']+'</span><span class="time">'+val['created']+'</span></span><span class="message">'+val['message']+'</span></a></li>';
				});
				html+='<li class="text-center"><a href="'+base_url+'notification">View all</a></li>';
				$('ul.msg_list').html(html);	
			}
		});
	});
	
	setInterval(function(){//alert(localStorage.getItem('lastNotificationId'));
		$.ajax({
			url:base_url+'notification/count_notifications',
			type:"post",
			data:{action:'unread_count'},
			success:function(result){//alert(result);
			    result= JSON.parse(result);
				
				if(result['refreshEventCount'].length > 0){
					currentNotificationId=result['refreshEventCount'][0]['id'];
					if(currentNotificationId > localStorage.lastNotificationId)
					{	
					    localStorage.setItem("lastNotificationId",currentNotificationId);
					    var current_url= window.location.href;
					    if(current_url==base_url+'dashboard' || current_url==base_url+'chef' || current_url==base_url+'bar_tendor')
					    {//alert('reload page');	   
					      location.reload();
					    }  
					}  
                    else
                    {
						localStorage.setItem("lastNotificationId",currentNotificationId);
					}						
				}
				
				if(result['totalUnreadNotifications']>0)
				{
					$('.fa-bell-o').next('small').removeClass();
					$('.fa-bell-o').next('small').addClass('noti_count');
					$('.fa-bell-o').next('small').html(result['totalUnreadNotifications']);
				}
				
				$.each(result['tableNotifications'],function(i,v){
				//alert()
					if(v['unread_order_notification'] > 0)
					{
						$("#tbl-"+v['id']).find("i.notification_n").html(v['unread_order_notification']);
					}	
				});
				
                $.each(result['order_read_status'],function(i,v){
				//alert()
					if(v['unread_count'] > 0)
					{
						$("#heading"+v['id']).addClass('addClass');
					}	
				});	
                /****************message notification for order message for every tile*********/
				$.each(result['bkng_wise_msg_cont'],function(i,v){
					table_booking_id = v['table_booking_id'];
					if(v['bkng_msg_cont'] > 0)
					{	
					   $('#heading'+table_booking_id).find('.tile_msg').html("<span>"+v['bkng_msg_cont']+"</span>");
					}
                    else{$('#heading'+table_booking_id).find('.tile_msg').html('');}					
				});
				
				/***************message notification for every order*************************/
                $.each(result['order_messages'],function(i,v){
					order_id=v['table_order_id'];
					$('#order-no-'+order_id).find('.msg_count').html(v['order_msg']);
				});	
			}
		});
		
		$.ajax({
			url:base_url+'notification/order_status',
			type:"post",
			data:{action:'order_status'},
			success:function(result){//alert(result);
			result=JSON.parse(result);
			$.each(result,function(i,v){
				if(v['delay'] > 0)
				{	
					$("#heading"+v['table_booking_id']).attr('class','');
					$("#heading"+v['table_booking_id']).addClass('panel-heading');
					$("#heading"+v['table_booking_id']).addClass('inside_guest_delay');
				}	
			});
			}
		});
		
	},5000);
	
	
	$.ajax({
			url:base_url+'notification/count_notifications',
			type:"post",
			data:{action:'unread_count'},
			success:function(result){
				result= JSON.parse(result);
				
				if(result['refreshEventCount'].length > 0){
					currentNotificationId=result['refreshEventCount'][0]['id'];
					   localStorage.setItem("lastNotificationId",currentNotificationId);
				}
				
				if(result['totalUnreadNotifications']>0)
				{
					$('.fa-bell-o').next('small').removeClass();
					$('.fa-bell-o').next('small').addClass('noti_count');
					$('.fa-bell-o').next('small').html(result['totalUnreadNotifications']);
				}
				$.each(result['tableNotifications'],function(i,v){
					if(v['unread_order_notification'] > 0)
					{
						$("#tbl-"+v['id']).find("i.notification_n").html(v['unread_order_notification']);
					}	
				});
				/****************message notification for order message for every tile*********/
				$.each(result['bkng_wise_msg_cont'],function(i,v){
					table_booking_id = v['table_booking_id'];
					if(v['bkng_msg_cont'] > 0)
					{	
					   $('#heading'+table_booking_id).find('.tile_msg').html("<span>"+v['bkng_msg_cont']+"</span>");
					}
                    else{$('#heading'+table_booking_id).find('.tile_msg').html('');}					
				});	
			}
		});
	/********************************************End Notification***************************************/


    /************************************************Member Feedback***************************************/
	/*
	$('body').on('click','.member-feedback',function(e){
		  var table_booking_id=$(this).data('tablebookingid');//alert(table_booking_id);
		  $.ajax({
					url:base_url+'dashboard/feedback',
					type:'post',
					data:{'table_booking_id':table_booking_id,'action':'member-feedback'},
					success:function(result){
						if ($('#modal-container').is(':empty')){
						    $('#modal-container').html(result);
							$('#feedbackModal').modal({show:true});
						}
						else
						{
							$('#modal-container').empty();
							$('#modal-container').html(result);
							$('#feedbackModal').modal({show:true});
						}
					}
				});
	});	*/
	
	//feedback form validation
	$('input[name="radio1"]','form[name="feedback"]').change(function(){
		var checkedVal=$(this).val();
		if(checkedVal)
		{
			$('#not-wic-member').show();
			if($('input[name="radio2"]:checked').val())
				$('.no-wic-tour').show();
		}
        else
        {
			$('#not-wic-member').hide();
			$('.no-wic-tour').hide();
		}			
	});
	
	$('input[name="radio2"]','form[name="feedback"]').change(function(){
		var checkedVal=$(this).val();
		if(checkedVal=='no')
		{
			$('.no-wic-tour').show();
		}
        else
        {
			$('.no-wic-tour').hide();
		}			
	});
	
	$('body').on('submit','form[name="feedback"]',function(e){
		var radio1=$('input[name="radio1"]:checked').val();
		var radio2=$('input[name="radio2"]:checked').val();
		var radio3=$('input[name="radio3"]:checked').val();
		var textbox1=$('input[name="textbox1"]').val();
		var textbox2=$('input[name="textbox2"]').val();
		
		var radio11=$('input[name="radio11"]:checked').val();
		var radio12=$('input[name="radio12"]:checked').val();
		var radio13=$('input[name="radio13"]:checked').val();
		var radio14=$('input[name="radio14"]:checked').val();
		var radio15=$('input[name="radio15"]:checked').val();
		var radio16=$('input[name="radio16"]:checked').val();
		var radio17=$('input[name="radio17"]:checked').val();
		var radio18=$('input[name="radio18"]:checked').val();
		var radio19=$('input[name="radio19"]:checked').val();
		var radio20=$('input[name="radio20"]:checked').val();
		
		var rtrn=1;
		if(typeof radio1 == 'undefined'){
			$("tr.backgroundRed").removeClass("backgroundRed");
			$(".val-msg").remove();
			$('input[name="radio1"]').parents('tr').addClass('backgroundRed');
			$('input[name="radio1"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
			rtrn = 0;
		}
		else if(radio1 == 'no')
		{
			
			if(typeof radio2=='undefined'){
				$("tr.backgroundRed").removeClass("backgroundRed");
				$(".val-msg").remove();
				$('input[name="radio2"]').parents('tr').addClass('backgroundRed');
				$('input[name="radio2"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
				rtrn = 0;
			}
			else if(radio2 == 'no')
			{
				if(textbox1=='')
				{
					$("tr.backgroundRed").removeClass("backgroundRed");
					$(".val-msg").remove();
					$('input[name="textbox1"]').parents('tr').addClass('backgroundRed');
					$('input[name="textbox1"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
					rtrn = 0;
				}
				else if(textbox2=='')
                {
					$("tr.backgroundRed").removeClass("backgroundRed");
					$(".val-msg").remove();
					$('input[name="textbox2"]').parents('tr').addClass('backgroundRed');
					$('input[name="textbox2"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
					rtrn = 0;
				}
                					
			}	
		}
		else if(typeof radio3 == "undefined")
		{
			$("tr.backgroundRed").removeClass("backgroundRed");
			$(".val-msg").remove();
			$('input[name="radio3"]').parents('tr').addClass('backgroundRed');
			$('input[name="radio3"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
			rtrn = 0;
		}
		
		if(rtrn==0)
		{	
	        e.preventDefault();
			$('html, body').animate({
         scrollTop: ($('.backgroundRed:first').top)
        },200);
			return false;
		}	
		
		if(typeof radio11 == 'undefined')
		{
			$("tr.backgroundRed").removeClass("backgroundRed");
			$(".val-msg").remove();
			$('input[name="radio11"]').parents('tr').addClass('backgroundRed');
			$('input[name="radio11"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
			e.preventDefault();
		}
		else if(typeof radio12 == 'undefined')
		{
			$("tr.backgroundRed").removeClass("backgroundRed");
			$(".val-msg").remove();
			$('input[name="radio12"]').parents('tr').addClass('backgroundRed');
			$('input[name="radio12"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
			e.preventDefault();
		}
		else if(typeof radio13 == 'undefined')
		{
			$("tr.backgroundRed").removeClass("backgroundRed");
			$(".val-msg").remove();
			$('input[name="radio13"]').parents('tr').addClass('backgroundRed');
			$('input[name="radio13"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
			e.preventDefault();
		}
		else if(typeof radio14 == 'undefined')
		{
			$("tr.backgroundRed").removeClass("backgroundRed");
			$(".val-msg").remove();
			$('input[name="radio14"]').parents('tr').addClass('backgroundRed');
			$('input[name="radio14"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
			e.preventDefault();
		}
		else if(typeof radio15 == 'undefined')
		{
			$("tr.backgroundRed").removeClass("backgroundRed");
			$(".val-msg").remove();
			$('input[name="radio15"]').parents('tr').addClass('backgroundRed');
			$('input[name="radio15"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
			e.preventDefault();
		}else if(typeof radio16 == 'undefined')
		{
			$("tr.backgroundRed").removeClass("backgroundRed");
			$(".val-msg").remove();
			$('input[name="radio16"]').parents('tr').addClass('backgroundRed');
			$('input[name="radio16"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
			e.preventDefault();
		}else if(typeof radio17 == 'undefined')
		{
			$("tr.backgroundRed").removeClass("backgroundRed");
			$(".val-msg").remove();
			$('input[name="radio17"]').parents('tr').addClass('backgroundRed');
			$('input[name="radio17"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
			e.preventDefault();
		}else if(typeof radio18 == 'undefined')
		{
			$("tr.backgroundRed").removeClass("backgroundRed");
			$(".val-msg").remove();
			$('input[name="radio18"]').parents('tr').addClass('backgroundRed');
			$('input[name="radio18"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
			e.preventDefault();
		}else if(typeof radio19 == 'undefined')
		{
			$("tr.backgroundRed").removeClass("backgroundRed");
			$(".val-msg").remove();
			$('input[name="radio19"]').parents('tr').addClass('backgroundRed');
			$('input[name="radio19"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
			e.preventDefault();
		}else if(typeof radio20 == 'undefined')
		{
			$("tr.backgroundRed").removeClass("backgroundRed");
			$(".val-msg").remove();
			$('input[name="radio20"]').parents('tr').addClass('backgroundRed');
			$('input[name="radio20"]').parents('tr').find('td:first-child').append('<p class="val-msg"><label>This field is required.</label></p>');
			e.preventDefault();
		}
        
		$('html, body').animate({
         scrollTop: ($('.backgroundRed:first').top)
        },200);		
		
	});
	/**************************************************End Feedback****************************************/	
	
	
	/*********************************************Table Notification Label**********************************/
	$('.notification_n').click(function(){
		//alert();
		var table_divid=$(this).parents('.set_table').attr('id');
		var splitArr=table_divid.split('-');
		var table_id;
		if(splitArr.length > 0)
			table_id=splitArr[1];
		//alert(table_id);
		$.ajax({
			type:'post',
			url:base_url+'notification/table_notification',
			data:{table_id:table_id,action:'table_notification'},
			success:function(result){
				if(result==0)
					alert('Request Fail');
				else
				    window.location.replace(base_url+'notification/table_notification/'+result);
				
			}
		});
	});
	/*********************************************End table Label*******************************************/
});	