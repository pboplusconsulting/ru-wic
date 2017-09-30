<?php
//dl('php_pdo_sqlsrv_56_ts.dll');  
$serverName = "DESKTOP-V4MUG3N\SQLEXPRESS"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"CABSDATA_WIC","UID"=>"sa", "PWD"=>"Ru@123$%");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

//$conn = new PDO( "sqlsrv:server=192.168.1.7 ; Database=Cabsdata_wic", "wic", "pbo@2017");  

print_r($conn);
$conn2=mysql_connect('localhost','root','');
mysql_select_db('ru_order_management',$conn2);
if( $conn ) {
    echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

//$sql="SELECT * FROM RMS_GUEST";
$sql="SELECT *  FROM  [dbo].[CLUB_MEMMAST]
 where mem_inactive=0";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$count=0;
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    	$code=$row['memno'];
		$name=$row['mem_name'];
		$email=$row['mem_peremail'];
		$phone=$row['mem_resphno'];
		
		$sql_check_duplicate="SELECT * FROM ru_membership WHERE membership_id='".$code."'";
		$res_check_duplicate=mysql_query($sql_check_duplicate);
		$num_rows = mysql_num_rows($res_check_duplicate);
		if($num_rows==0){
		$sql="INSERT INTO ru_membership (membership_id,member_name,phone_number,email_id,membership_type,status,modify_time,date_of_birth) VALUES ('".$code."','".$name."','".$phone."','".$email."',1,1,now(),'".substr($row['mem_dob'], 0, 4)."')";
		mysql_query($sql,$conn2);
		$count++;
		}
		
}
echo $count. ' members added successfully';


sqlsrv_free_stmt( $stmt);
?>


