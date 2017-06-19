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

   $sql =<<<EOF
      CREATE TABLE eth_kline
      (time_utc REAL PRIMARY KEY     NOT NULL,
      time_text      VARCHAR    NOT NULL,
      amount         REAL     NOT NULL,
      count         REAL     NOT NULL,
      open         REAL     NOT NULL,
      close         REAL     NOT NULL,
      low         REAL     NOT NULL,
      high         REAL     NOT NULL,
      vol         REAL     NOT NULL);
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "Table created successfully\n";
   }
   $db->close();
?>