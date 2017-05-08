<?php
//--------------------------------------------------------------------------------------------------------------------------------
$canal=$_GET['canal'];
$audio=$_GET['audio'];
$cadenachannel="Channel: ".$canal."\r\n"; 
$an=date("Y");$me=date("m");$di=date("d");
$cadenaaudio="File: /var/spool/asterisk/monitor/seven/".$an."/".$me."/".$di."/".$audio."\r\n"; 
$timeout=10;

$socket = fsockopen("192.168.10.145","5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: orion01\r\n");
fputs($socket, "Secret: mysecret01\r\n\r\n");
fputs($socket, "Events: off\r\n");
fputs($socket, "Action: Monitor\r\n");
fputs($socket, "Format: gsm\r\n");
fputs($socket, $cadenachannel);
fputs($socket, $cadenaaudio);
fputs($socket, "Mix: 1\r\n\r\n");
$wrets=fgets($socket,128);

$fecha=date("Ymd_His");
$fp = fopen("/var/log/seven/PROC_GRABAR.log","a");
fwrite($fp, "$fecha($canal)($audio)($aver)()()($wrets)" . PHP_EOL);
fclose($fp);
?>