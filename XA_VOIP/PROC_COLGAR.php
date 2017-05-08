<?php
//--------------------------------------------------------------------------------------------------------------------------------
$canal=$_GET['canal'];
$cadenachannel="Channel: ".$canal."\r\n\r\n"; 
$timeout=10;

$socket = fsockopen("192.168.10.145","5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: orion01\r\n");
fputs($socket, "Secret: mysecret01\r\n\r\n");
fputs($socket, "Events: off\r\n");
fputs($socket, "Action: HangUp\r\n");
fputs($socket, $cadenachannel);
$wrets=fgets($socket,128);

$fecha=date("Ymd_His");
$fp = fopen("/var/log/seven/PROC_COLGAR.log","a");
fwrite($fp, "$fecha($canal)()($aver)()()($wrets)" . PHP_EOL);
fclose($fp);
?>