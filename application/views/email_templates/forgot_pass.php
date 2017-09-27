<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>RU</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

</head>
<body>
<style>
*{
font-family: 'Open Sans', sans-serif;	
padding:0;
margin:0;	
}
</style>
<table style="width:700px;max-width:100%; margin:0 auto;" border="0" cellpadding="0" cellspacing="0" bgcolor="#f8be5d">
<tbody>
	<tr>
    	<td align="center"><img src="<?php echo base_url().'assets/img/logo.png';?>" alt=""/></td>
    </tr>
    <tr>
    	<td align="center">
        	<table class="table" cellpadding="10" cellspacing="10" border="0" bgcolor="#ffffff" width="95%">
            	<tbody>
					<tr>
						<td style="font-size:14px;color:#5b6a6f;padding:10px 25px;line-height:24px;">
							<p>Hello <?php echo ucfirst($user) ?>,</p>
							<p>Your OTP to reset your password is: <span style="color:green"><?php echo $otp;?></span></p>
						</td>
						<td style="padding:10px;"></td>
					</tr>
					<tr>
						<td style="font-size:14px;color:#5b6a6f;padding:10px 25px;line-height:24px;" colspan="2">
							<br>Thanks,<br>RU Team
						</td>
					</tr>
				</tbody>
            </table>        
    	</td>
    </tr>
	<tr><td></td></tr>
    
</tbody>

</table>

</body>
</html>
