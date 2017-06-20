<html>
<head>
	<link href="img/logo.ico" type="image/x-icon" rel="shortcut icon" />
	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8"/>
	<title>
		RecordController
	</title>

</head>
<body bgcolor="#ACD6FF">
<center>
<br/>
<br/>
<a href="monitor.php">monitor the record details with easiler refresh</a> created by satomic.in 2017/06/20
<br/>
<?php
include 'utils.php';
$content = file_get_contents('updateCurrent.log');
echo '<b>'.$content.'</b></br><br/><br/>';
if(checkFileIsSettedValue('updateController.conf','1')){
	echo 'current update config is 1';
}else{
	echo 'current update config is 0';
}
?>
<br/>
input 1/0 
<form action="" method="post">
<input type="text" name="fname">
<input type="submit" value="Confirm">
<br/>
<br/>

<?php
// include 'utils.php';
if(isset($_POST["fname"])){ 
	$input = $_POST["fname"];
	echo 'you have inputted: '.$input;
	if($input == '1'){
		writeFileWithValue('updateController.conf','1');
	}elseif($input == '0'){
		writeFileWithValue('updateController.conf','0');
	}else{
		echo 'you have inputted a illeagal value! try it again please';
	}
}
?>
<br/>
<br/>
<a href="eth_history_info.db">download the latest db file for you analysis</a>
<br/>
</form>
</center>
</body>
</html>
