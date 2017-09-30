
	  <script src="<?php echo base_url()?>assets/js/myscript.js"></script>
<script src="<?php echo base_url()?>assets/js/1.12.4.jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script> 

<script src="<?php echo base_url()?>assets/js/jquery.easing.1.3.js"></script> 
<script src="<?php echo base_url()?>assets/js/SmoothScroll.min.js"></script> 
<script src="<?php echo base_url()?>assets/js/jquery.isotope.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url()?>assets/js/moment.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url()?>assets/js/daterangepicker.js"></script>
	       <script type="text/javascript" src="<?php echo base_url()?>assets/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
	  <script src="<?php echo base_url()?>assets/js/parsley.min.js"></script>
	  	  <script src="<?php echo base_url()?>assets/multiselect/js/bootstrap-multiselect.js"></script>
	  <script src="<?php echo base_url()?>assets/js/myscript_part2.js"></script>


  

  <script src="<?php echo base_url()?>assets/analysis/js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="<?php echo base_url()?>assets/analysis/js/icheck/icheck.min.js"></script>
  <script src="<?php echo base_url()?>assets/analysis/js/custom.js"></script>
  <script src="<?php echo base_url()?>assets/analysis/js/pace/pace.min.js"></script>
    <script src="<?php echo base_url()?>assets/analysis/js/easypie/jquery.easypiechart.min.js"></script>


    <script>
	    $('.chart').easyPieChart({
        easing: 'easeOutBounce',
        lineWidth: '6',
        barColor: '#75BCDD',
        onStep: function(from, to, percent) {
          $(this.el).find('.percent').text(Math.round(percent));
        }
      });
      var chart = window.chart = $('.chart').data('easyPieChart');
      $('.js_update').on('click', function() {
        chart.update(Math.random() * 200 - 100);
      });
	</script>
    
  <!-- echart -->
  <script src="<?php echo base_url()?>assets/analysis/js/echart/echarts-all.js"></script>
  <script src="<?php echo base_url()?>assets/analysis/js/echart/green.js"></script>
  
  <!-- bootstrap datepicker-->

  <script>
$(function(){  

var myChart9 = echarts.init(document.getElementById('mainb'), theme);
    myChart9.setOption({   tooltip : {
        trigger: 'axis'
    },
 
    toolbox: {
        show : true,
        feature : {
            mark : {show: false},
            dataView : {show: false, readOnly: false},
            magicType: {show: false, type: ['line', 'bar']},
            restore : {show: false},
            saveAsImage : {show: false},
           barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
        }
    },
    calculable : true,
    legend: {
        data:['','',''],
       color:'#fff',
    },
    xAxis : [
        {
            type : 'category',
          color:'#fff',
		 data : ['Min Billing','Max Billing','Avg Billing','Today Billing']
      
        }
    ],
    yAxis : [
        {
            type : 'value',
            name : '',
            color:'#fff',
            axisLabel : {
            formatter: '{value}'
            }
        }
    ],
    series : [

        {
            name:'',
            type:'bar',
            data:[<?php echo $min_max_billing?floor($min_max_billing->min_billing):0;?>, <?php echo $min_max_billing?floor($min_max_billing->max_billing):0;?>, <?php echo $average_billing?floor($average_billing->average):0;?>, <?php echo $today_billing?floor($today_billing->todays_billing):0;?>]
        }
    ]});
	
	
	
	
	
	
	
var myChart1 = echarts.init(document.getElementById('ast'), theme);
    myChart1.setOption({   tooltip : {
        trigger: 'bar'
    },
 
    toolbox: {
        show : true,
        feature : {
            mark : {show: false},
            dataView : {show: false, readOnly: false},
            magicType: {show: false, type: ['line', 'bar']},
            restore : {show: false},
            saveAsImage : {show: false},
           barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
        }
    },
    calculable : true,
    legend: {
        data:['','',''],
       color:'#fff',
    },
    xAxis : [
        {
            type : 'category',
          color:'#fff',
		 data : ['Average']
      
        }
    ],
    yAxis : [
        {
            type : 'value',
            name : 'Time(Minute)',
            color:'#fff',
            axisLabel : {
            formatter: '{value}'
            }
        }
    ],
    series : [
        <?php foreach($average_serve_time as $avg_serve_time) { ?>

        {
            name:"<?php echo date('d M',strtotime($avg_serve_time['date'])); ?>",
            type:'bar',
            data:[<?php echo $avg_serve_time['average']?floor($avg_serve_time['average']):0;?>]
        },
        <?php } ?>
    ]});
  
 });

</script>
 
   <!-- bootstrap progress js -->
  <script src="<?php echo base_url()?>assets/analysis/js/progressbar/bootstrap-progressbar.min.js"></script>
  <!-- icheck -->
    <script src="<?php echo base_url()?>assets/analysis/js/chartjs/chart.min.js"></script>

  <!-- sparkline -->
  <script src="<?php echo base_url().'assets/analysis/js/sparkline/jquery.sparkline.min.js';?>"></script>



  <!-- pace -->
  <script src="<?php echo base_url().'assets/analysis/js/pace/pace.min.js';?>"></script>
  <!-- easypie -->

  
 <script>
    Chart.defaults.global.legend = {
      enabled: false
    };



//Menu
 var myChart = echarts.init(document.getElementById('echart_bar_horizontal'), theme);
    myChart.setOption({
      title: {
        text: 'Items'
             },
      tooltip: {
        trigger: 'axis'
      },
      legend: {
        data: ['',''],
		textStyle: {
          color: '#fff',
          fontSize: 15
        }

      },
      toolbox: {
        show: false,
        feature: {
          saveAsImage: {
            show: false
          }
        }
      },
      calculable: true,
      xAxis: [{
        type: 'value',
        boundaryGap: [0,1]
      }],
      yAxis: [{
		  type: 'category',
       data: [<?php foreach($menu as $mn){echo "'".(strlen($mn['menu_name'])<8?$mn['menu_name']:substr($mn['menu_name'],0,7).'..')."',";} ?>]
      }],
      series: [{
        name: 'Item--',
        type: 'bar',
        data: [<?php foreach($menu as $mn) { echo $mn['sold_meal_count'].',';} ?>],
		textStyle: {
          color: 'yellow',
          fontSize: 15
        }
		
      }]
    });

  
    
	// Bar chart
    var ctx = document.getElementById("mybarChart");
    var mybarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ["9-11", "11-1", "1-3", "3-5", "5-7", "7-9", "9-11"],
        datasets: [{
          label: '# of Guests',
          backgroundColor: "#26B99A",
		  color:'#fff',
          data: [10, 5, 40, 28, 92, 50, 45]
        }]
      },

      options: {
		  legend: {labels:{fontColor:"red", fontSize: 18}},
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
	

  </script>
  
<script type="text/javascript">
$(function() {
    $('.date-choose input[name="daterange"]').daterangepicker({
		locale: {
					format: 'DD/MM/YYYY',

	        }
});
});

$(document).ready(function(){
	$('#dateFilter').click(function(e){
		var dateRange=$('.date-choose input[name="daterange"]').val();
		   var result = dateRange.split('-');
           var date1=new Date(result[0].trim());
           var date2=new Date(result[1].trim());//alert(date1+' '+date2);
           if(date1 > date2)
           {
               alert("First date should not be greater last date.");
               e.preventDefault();
           }//alert('hello');
           
		});
});

</script>

</body>

</html>
