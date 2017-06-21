how to use this php huobi data recorder?
1.  run createDB.php
	a formatted db file will be create.
	this file should be executed only once.

2. 	run index.php
	here you can input the update control code 1/0
	for 1, means update action is allowed.
	for 0, is the oppsite.

3.	after set 1, run updateDB.php
	data will be recorded in db file real time.
	and if you wanna stop it, go to the index.php and set the code to 0.

others:
monitor.php: by update this file, can we know the lateast status.
updateController.conf: 1/0, updateDB.php will read the value on real time.
updateCurrent.log: update status, updated by updateDB.php on real time.
utils.php: general functions defined here.



