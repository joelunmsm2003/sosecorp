<?php
 $timeout=10;
 $numeroanexo=trim($_GET['sup']);
 //$canal=trim($_GET['canal']);
 $uniqueid=trim($_GET['uniq']); 
 echo $uniqueid;
 $canal=system("php-cgi -q /opt/XA_VOIP/PROC_CHANNEL.php uni=$uniqueid");
echo $canal;
// $cadenaexten="Exten: ".$numeroanexo."\r\n";
 $cadenaexten="Exten: ".$numeroanexo."\r\n";
 $cadenachannel="Channel: ".$canal."\r\n\r\n";

 $socket = fsockopen("192.168.10.145","5038", $errno, $errstr, $timeout);
 fputs($socket, "Action: Login\r\n");
 fputs($socket, "UserName: orion01\r\n");
 fputs($socket, "Secret: mysecret01\r\n\r\n");
 fputs($socket, "Action: Redirect\r\n");
 fputs($socket, $cadenaexten ); 
 fputs($socket, "Context: from-seven\r\n");
 fputs($socket, "Priority: 1\r\n");
 fputs($socket, $cadenachannel); 
 fputs($socket, "Action: Logoff\r\n\r\n");
 $count=0;$array="";
 while (!feof($socket)) {
		       $wrets = fgets($socket, 8192);
		       $token = strtok($wrets,' ');
		       $j=0;
		       while($token!=false & $count>=1){
				                       $array[$count][$j]=$token;
				                       $j++; $token = strtok(' ');
		    				       }
			$count++;
			$wrets .= '<br>';
			
			          }

$fecha=date("Ymd_His");
$fp = fopen("/var/log/seven/PROC_MOVEDOR_CLI.log","a");
fwrite($fp, "$fecha($canal)($numeroanexo)($aver)($uniqueid)()()" . PHP_EOL);
fclose($fp);
?>
