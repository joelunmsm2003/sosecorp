<?php
 date_default_timezone_set('America/Lima');
 $timeout=10;
 $id_lla=trim($_GET['id_lla']);
 $agente=trim($_GET['agente']);
 $cam=trim($_GET['cam']);
 $numeroanexo=trim($_GET['numeroanexo']);
 $canal=trim($_GET['canal']);
 $SRVAST="127.0.0.1";
 //$uniqueid=trim($_GET['uniq']); 
 //echo $uniqueid;
 //$canal=system("php-cgi -q /opt/XA_VOIP/PROC_CHANNEL.php uni=$uniqueid");
 //echo $canal;
 $cadenaexten="Exten: ".$numeroanexo."\r\n";
 $cadenachannel="Channel: ".$canal."\r\n\r\n";

 $socket = fsockopen($SRVAST,"5038", $errno, $errstr, $timeout);
 fputs($socket, "Action: Login\r\n");
 fputs($socket, "UserName: xiencias01\r\n");
 fputs($socket, "Secret: Pr1m3R4Cl4v36&&_AS331df456svd3*\r\n\r\n");
 fputs($socket, "Events: off\r\n");
 fputs($socket, "Action: Redirect\r\n");
 fputs($socket, $cadenaexten ); 
 fputs($socket, "Context: from-pcall\r\n");
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
$anexo=substr($numeroanexo,3);
$link = mysql_connect("localhost","root","123"); if (!$link){ die('Could not connect: ' . mysql_error()); } mysql_select_db("predictivo", $link);
mysql_query("UPDATE  ajx_pro_lla SET age_codigo=$agente,f_movedor=now(),v_tring=$anexo WHERE  id_ori_llamadas=$id_lla",$link); 
mysql_query("UPDATE filtro SET ACD=ACD-1 WHERE campania=$cam",$link); 
mysql_query("UPDATE agentes SET estado=3 WHERE id=$agente",$link); 
mysql_close($link);

$fecha=date("Ymd_His");
$fp = fopen("/var/log/pcall/PROC_MOVEDOR_CLI.log","a");
fwrite($fp, "$fecha($canal)($numeroanexo)($aver)($uniqueid)()($anexo)" . PHP_EOL);
fclose($fp);
?>
