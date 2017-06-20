<?php
	
	include 'utils.php';

	//设置exceed时间为无限
	set_time_limit(0);
	
	try{
		class MyDB extends SQLite3
		{
			function __construct()
			{
			 $this->open('eth_history_info.db');
			}
		}
		$db = new MyDB();
		if(!$db){
			echo $db->lastErrorMsg();
		} else {
			echo "Opened database successfully\n";
		}
	   
		// 初始化一个 cURL 对象 
		$curl = curl_init(); 
		// 设置你需要抓取的URL 
		curl_setopt($curl, CURLOPT_URL, 'http://be.huobi.com/market/kline?symbol=ethcny&period=1min'); 

		// 设置header 响应头是否输出
		curl_setopt($curl, CURLOPT_HEADER, 0); 

		// 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
		// 1如果成功只将结果返回，不自动输出任何内容。如果失败返回FALSE 
		// 0如果成功返回1
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 

		$time_start = date('Y-m-d H:i:s',time());
		$index = 0;
		while(true){
			// 检测开关文件，如果检测到内容为1，继续，如果为0，则跳出，停止
			if(checkFileIsSettedValue('updateController.conf','1')){
				//do nothing
				$index++;
				$log = 'now is recording, start from '.$time_start.' for '.$index.' secs';
				writeFileWithValue('updateCurrent.log',$log);
			}else{
				$time_stop = date('Y-m-d H:i:s',time());
				$log = 'now is stopped, start from '.$time_start.' for '.$index.' secs, end with '.$time_stop;
				writeFileWithValue('updateCurrent.log',$log);
				break;
			}
			
			// 运行cURL，请求网页 
			$data = curl_exec($curl); 

			// 关闭URL请求 
			// curl_close($curl); 

			$kline = json_decode($data);
			// print (string)$kline;
			$time_utc = $kline->{'ts'};
			$time_text = convertUTC2TimeStamp($time_utc);
			$amount = $kline->{'tick'}->{'amount'};
			$count = $kline->{'tick'}->{'count'};
			$open = $kline->{'tick'}->{'open'};
			$close = $kline->{'tick'}->{'close'};
			$low = $kline->{'tick'}->{'low'};
			$high = $kline->{'tick'}->{'high'};
			$vol = $kline->{'tick'}->{'vol'};

			$sql =<<<EOF
				INSERT INTO eth_kline (time_utc,time_text,amount,count,open,close,low,high,vol)
				VALUES ($time_utc,'$time_text',$amount,$count,$open,$close,$low,$high,$vol);
EOF;
			// echo $sql;
			$ret = $db->exec($sql);
			if(!$ret){
				echo $db->lastErrorMsg();
			} else {
				//echo "Records created successfully\n";
			}
			sleep(1);
		}
		$db->close();
		$time_stop = date('Y-m-d H:i:s',time());
		$log = 'now is stopped, start from '.$time_start.' for '.$index.' secs, end with '.$time_stop;
		writeFileWithValue('updateCurrent.log',$log);
	}catch (Exception $e) {   
		$error_info = $e->getMessage();   
		writeFileWithValue('updateCurrent.log',$error_info);
		exit();   
	}   
?>