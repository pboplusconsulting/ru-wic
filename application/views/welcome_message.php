

<div id="content_block">
	<div class="text-center">
    	<a href="<?php echo base_url(); ?>" style="display: inline-block;"><img src="<?php echo base_url()?>assets/img/logo.png" class="img-responsive center-block" width="100"  alt=""/></a>
    </div>
    <div class="container-fluid">
	<p class="clearfix"></p>
<div class="container">
  <div class="jumbotron">
    <h2>RU (Order Management)</h2> 
	<br><br>
<p class='well'><?php if($this->session->flashdata('flashError')){ echo $this->session->flashdata('flashError');} else {?>
<b>Sorry!</b>&nbsp;Something went wrong.
<?php } ?>
</p>
 </div>
</div>
    </div>
</div>