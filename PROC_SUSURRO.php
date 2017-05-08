<?php
//--------------------------------------------------------------------------------------------------------------------------------
  $estado=1;
  $NumeroAnexo=$_GET['sup'];
  $ExtensionAgente=$_GET['anx'];
  $SRVAST="localhost";
  if($estado==1){
  $cadenachannel="Channel: Local/SUPa".$NumeroAnexo."@from-pcall\r\n";
  $cadenaexten="Exten: SUPs".$ExtensionAgente."\r\n";
  $cadenacallerid="Callerid: sus_".$ExtensionAgente."\r\n\r\n";
 	$timeout=10;
 	$socket = fsockopen($SRVAST,"5038", $errno, $errstr, $timeout);
 	fputs($socket, "Action: Login\r\n");
  fputs($socket, "UserName: xiencias01\r\n");
  fputs($socket, "Secret: Pr1m3R4Cl4v36&&_AS331df456svd3*\r\n\r\n");
 	fputs($socket, "Events: off\r\n");
 	fputs($socket, "Action: Originate\r\n");
 	fputs($socket, "Timeout: 28000\r\n");
 	fputs($socket, $cadenachannel);
 	fputs($socket, "Context: from-pcall\r\n");
 	fputs($socket, $cadenaexten );
 	fputs($socket, "Priority: 1\r\n");
 	fputs($socket, $cadenacallerid );
 	$wrets=fgets($socket,128);
 	echo "Anexo Agente Susurrado= ".$ExtensionAgente;
 	echo "<br>Anexo Supervisor Susurrador= ".$NumeroAnexo;

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
 

$estado=0; $uniqueid=0; $canal="";
 for($i=0;$i<$count;$i++){ echo "array[$i][0] _ $array[$i][1]";}


               }

?>
