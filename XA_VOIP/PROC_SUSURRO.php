<?php
//--------------------------------------------------------------------------------------------------------------------------------
  $estado=1;
  $NumeroAnexo=$_GET['sup'];
  $ExtensionAgente=$_GET['anx'];
  $SRVAST="192.168.10.145";
  if($estado==1){
  $cadenachannel="Channel: Local/SUPa".$NumeroAnexo."@from-seven\r\n";
  $cadenaexten="Exten: SUPs".$ExtensionAgente."\r\n";
  $cadenacallerid="Callerid: susurro".$ExtensionAgente."\r\n\r\n";
 	$timeout=10;
 	$socket = fsockopen($SRVAST,"5038", $errno, $errstr, $timeout);
 	fputs($socket, "Action: Login\r\n");
 	fputs($socket, "UserName: orion01\r\n");
 	fputs($socket, "Secret: mysecret01\r\n\r\n");
 	fputs($socket, "Events: off\r\n");
 	fputs($socket, "Action: Originate\r\n");
 	fputs($socket, "Timeout: 28000\r\n");
 	fputs($socket, $cadenachannel);
 	fputs($socket, "Context: from-seven\r\n");
 	fputs($socket, $cadenaexten );
 	fputs($socket, "Priority: 1\r\n");
 	fputs($socket, $cadenacallerid );
	// fputs($socket, "Action: Logoff\r\n\r\n"); 
 	$wrets=fgets($socket,128);
 	echo "Agente Monitoreado= ".$ExtensionAgente;
 	echo "Agente Monitoreado= ".$NumeroAnexo;
				}
?>
