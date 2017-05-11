<?php
date_default_timezone_set('America/Lima');
// $uni=$_GET["uni"];
 $timeout=10;
 $socket = fsockopen("localhost","5038", $errno, $errstr, $timeout);
 fputs($socket, "Action: Login\r\n");
 fputs($socket, "UserName: xiencias01\r\n");
 fputs($socket, "Secret: Pr1m3R4Cl4v36&&_AS331df456svd3*\r\n\r\n");
 fputs($socket, "Events: Off\r\n");
 fputs($socket, "Action: command\r\n");    
 fputs($socket, "Command: core show channels concise\r\n\r\n");
 fputs($socket, "Action: Logoff\r\n\r\n");
 $count=0;$array;
 while (!feof($socket)) {
		       $wrets = fgets($socket, 8192);$j=0; $array[$count]=explode("!",$wrets);$j++; $count++; $wrets .= '<br>';
						}
 echo "<table border=1>";
 $q=0;
 $link = mysql_connect("localhost","root","123"); if (!$link){ die('Could not connect: ' . mysql_error()); } mysql_select_db("perucall", $link);
 for($i=0;$i<$count;$i++){
	//echo $array[$i][0]."<br>";
    if( trim($array[$i][0])  != "Asterisk Call Manager/1.0" && trim($array[$i][0])  != "Response: Success" && trim($array[$i][0])  != "Response: Follows" && trim($array[$i][0])  != "Message: Authentication accepted" && trim($array[$i][0])  != "Privilege: Command" && trim($array[$i][0])  != "Name/username" && trim($array[$i][0])  != "--END COMMAND--" && trim($array[$i][0])  != "" && trim($array[$i][0])  != "Response: Goodbye" && trim($array[$i][0])  != "Message: Thanks for all the fish." && trim($array[$i][0])  != "Asterisk Call Manager/1.1"  && trim($array[$i][0])  != "Event: FullyBooted" && trim($array[$i][0])  != "Privilege: system,all" && trim($array[$i][0])  != "Status: Fully Booted"){
        //if($array[$i][2]{0} == "t"  && $array[$i][2]{1} == "1"){ echo "<tr bgcolor=green><td>".$array[$i][0]."</td><td>".$array[$i][1]."</td><td>".$array[$i][2]."</td><td>".$array[$i][3]."</td><td>".$array[$i][4]."</td><td>".$array[$i][5]."</td><td>".$array[$i][6]."</td><td>".$array[$i][7]."</td><td>".$array[$i][8]."</td><td>".$array[$i][9]."</td><td>".$array[$i][10]."</td><td>".$array[$i][11]."</td><td>".$array[$i][12]."</td></tr>"; }
        //if($array[$i][2]{3} == "t"  && $array[$i][2]{4} == "1"){ echo "<tr bgcolor=lightgreen><td>".$array[$i][0]."</td><td>".$array[$i][1]."</td><td>".$array[$i][2]."</td><td>".$array[$i][3]."</td><td>".$array[$i][4]."</td><td>".$array[$i][5]."</td><td>".$array[$i][6]."</td><td>".$array[$i][7]."</td><td>".$array[$i][8]."</td><td>".$array[$i][9]."</td><td>".$array[$i][10]."</td><td>".$array[$i][11]."</td><td>".$array[$i][12]."</td></tr>"; }
        //if($array[$i][2]{3} == "t"  && $array[$i][2]{4} == "2"){ echo "<tr bgcolor=pink><td>".$array[$i][0]."</td><td>".$array[$i][1]."</td><td>".$array[$i][2]."</td><td>".$array[$i][3]."</td><td>".$array[$i][4]."</td><td>".$array[$i][5]."</td><td>".$array[$i][6]."</td><td>".$array[$i][7]."</td><td>".$array[$i][8]."</td><td>".$array[$i][9]."</td><td>".$array[$i][10]."</td><td>".$array[$i][11]."</td><td>".$array[$i][12]."</td></tr>"; }
        if(($array[$i][2]{0} == "t" || $array[$i][2]{0} == "T")  && $array[$i][2]{1} == "2"  && $array[$i][5] == "Wait"){ 
        	           echo "<tr bgcolor=red><td>($q)".$array[$i][0]."</td><td>".$array[$i][1]."</td><td>".$array[$i][2]."</td><td>".$array[$i][3]."</td><td>".$array[$i][4]."</td><td>".$array[$i][5]."</td><td>".$array[$i][6]."</td><td>".$array[$i][7]."</td><td>".$array[$i][8]."</td><td>".$array[$i][9]."</td><td>".$array[$i][10]."</td><td>".$array[$i][11]."</td><td>".$array[$i][12]."</td></tr>";
 	      	           $a_canal[$q]=$array[$i][0];
 	      	           $a_anexo[$q]=$array[$i][2];
 	      	           $a_destino[$q]=$array[$i][7];
 	      	           $a_registro[$q]=$array[$i][8];
 	      	           $a_duracion[$q]=$array[$i][10];
                     $a_campania[$q]=substr($array[$i][2],2,strlen($array[$i][2]));
                     //$a_id[$q]=$array[$i][11];
 
                     $q++;
                   												}
                         } //--- cerrando if---
                        } //--- cerrando for---
        //echo "<tr><td>($q)</td></tr>";
 //---Calcula ACD--x campana-----------
 $qq=0;
 for($w1=0;$w1<$q;$w1++){
   $cam_fin[$qq]=$a_campania[$w1]; $acd_cam_fin[$qq]=1;
   //echo "<tr bgcolor=green><td>$cam_fin[$qq]</td><td>$a_campania[$w1]</td><td>$w1</td><td>$q</td></tr>";
   for($w3=$w1+1;$w3<$q;$w3++){ 
                //echo "<tr bgcolor=yellow><td>$w3</td><td>$w1</td><td>$q</td><td>$w3</td><td>$acd_cam_fin[$qq]</td></tr>";
                if($cam_fin[$qq]==$a_campania[$w3]){ $acd_cam_fin[$qq]=$acd_cam_fin[$qq]+1; } 
                              }
   $qq++;
                      }
//---Actualiza ACD--x campana----------- 
    //mysql_query("UPDATE filtro SET ACD=0 WHERE campania=437",$link); 
 for($w2=0;$w2<$qq;$w2++){
//    mysql_query("UPDATE filtro SET ACD=0 WHERE campania=$cam_fin[$w2]",$link); 
    mysql_query("UPDATE filtro SET ACD=$acd_cam_fin[$w2] WHERE campania=$cam_fin[$w2] and ACD<$acd_cam_fin[$w2]",$link); 
    mysql_query("UPDATE campania SET ACD=$acd_cam_fin[$w2] WHERE id=$cam_fin[$w2]",$link); 
    mysql_query("UPDATE agentescampanias SET ACD=$acd_cam_fin[$w2] WHERE campania=$cam_fin[$w2]",$link); 
    //echo "<tr bgcolor=pink><td>$w3</td><td>$w1</td><td>$q</td><td>$w3</td><td>$acd_cam_fin[$w2]</td></tr>";
                      }
 //------------------------------------
 for($w=0;$w<$q;$w++){
	$camp=$a_campania[$w]; 
    $result=mysql_query("SELECT ID_cliente,tregistro FROM ajx_pro_lla WHERE  id_ori_llamadas=$a_registro[$w]",$link); 
    while($row = mysql_fetch_array($result)){  $dni=$row["ID_cliente"]; $treg=$row["tregistro"]; }

    $result=mysql_query("SELECT b.anexo,a.agente,TIMESTAMPDIFF(SECOND,b.tinicioespera,now()) as tiempo FROM agentescampanias a LEFT JOIN agentes b on a.agente=b.id WHERE  b.estado=2 and b.anexo<>'' and (b.est_ag_predictivo=0 OR b.est_ag_predictivo=1 OR b.est_ag_predictivo is NULL) and a.campania=$camp ORDER by tinicioespera ASC LIMIT 1",$link); 
   //echo "SELECT b.anexo,a.agente,TIMESTAMPDIFF(SECOND,b.tinicioespera,now()) as tiempo FROM agentescampanias a LEFT JOIN agentes b on a.agente=b.id WHERE  b.estado=2 and b.anexo<>'' and (b.est_ag_predictivo=0 OR b.est_ag_predictivo is NULL) and a.campania=$camp ORDER by tinicioespera ASC LIMIT 1";
   	while($row = mysql_fetch_array($result)){ 
    			 $anexo="pre".$row["anexo"]; $agente=$row["agente"]; $tiempo=$row["tiempo"];
    			 //echo "<tr><td>ANX:($w)$anexo</td><td>AGE:$agente</td><td>ESP_AGE:$tiempo</td><td>ESP_LLA:$a_duracion[$w]</td><td>$a_campania[$w]</td><td>SELECT b.anexo,a.agente,TIMESTAMPDIFF(SECOND,b.tinicioespera,now()) as tiempo FROM agentescampanias a LEFT JOIN agentes b on a.agente=b.id WHERE  b.estado=2 and b.anexo<>'' and (b.est_ag_predictivo=0 OR b.est_ag_predictivo is NULL) and a.campania=$camp</td><td>UPDATE filtro SET ACD=ACD+1 WHERE campania=$a_campania[$w]</td></tr>";
           system("php-cgi -q /opt/PeruCallCTI/PROC_MOVEDOR_CLI.php numeroanexo=$anexo canal=$a_canal[$w] id_lla=$a_registro[$w] agente=$agente cam=$camp&");
//           echo "<tr><td>ANX:($w)$anexo</td><td>AGE:$agente</td><td>ESP_AGE:$tiempo</td><td>ESP_LLA:$a_duracion[$w]</td><td>$a_campania[$w]</td><td>$a_canal[$w]</td><td>php-cgi -q /opt/PeruCallCTI/PROC_MOVEDOR_CLI.php numeroanexo=$anexo canal=$a_canal[$w] &</td></tr>";
           system("curl 'localhost/lanzallamada/$agente/$treg/$dni/' &");
            $aver="localhost/lanzallamada/$agente/$treg/$dni/";
//           echo "<tr><td>curl localhost/lanzallamada/$agente/$treg/$dni/ &</td></tr>";
          						                       }
					         }
 mysql_close($link);
$fecha=date("Ymd_His");
if($aver!=""){
    $fp = fopen("/var/log/pcall/PROC_ACD.log","a");
    fwrite($fp, "$fecha($aver)()()()()()" . PHP_EOL);
    fclose($fp);
		}
?>