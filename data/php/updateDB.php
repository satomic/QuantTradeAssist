<?php
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

	$i = 1;
	while(true){
		// $i--;
		
		
		
		// 运行cURL，请求网页 
		$data = curl_exec($curl); 

		// 关闭URL请求 
		// curl_close($curl); 

		$kline = json_decode($data);
		// print (string)$kline;
		$time_utc = $kline->{'ts'};
		print $time_utc;
		$amount = $kline->{'tick'}->{'amount'};
		$count = $kline->{'tick'}->{'count'};
		$open = $kline->{'tick'}->{'open'};
		$close = $kline->{'tick'}->{'close'};
		$low = $kline->{'tick'}->{'low'};
		$high = $kline->{'tick'}->{'high'};
		$vol = $kline->{'tick'}->{'vol'};

	   $sql =<<<EOF
		  INSERT INTO eth_kline (time_utc,time_text,amount,count,open,close,low,high,vol)
		  VALUES ($time_utc,'none',$amount,$count,$open,$close,$low,$high,$vol);
EOF;

	   $ret = $db->exec($sql);
	   if(!$ret){
		  echo $db->lastErrorMsg();
	   } else {
		  echo "Records created successfully\n";
	   }
	   sleep(1);
	}
    $db->close();
?>