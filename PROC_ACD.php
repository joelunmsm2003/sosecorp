<?php
date_default_timezone_set('America/Lima');
 $uni=$_GET["uni"];
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
		       $wrets = fgets($socket, 8192);
		       $j=0;
				                       $array[$count]=explode("!",$wrets);//$token;
				                       $j++; //$token = strtok('!');
//		    				       }
			$count++;
			$wrets .= '<br>';
			}

 for($i=0;$i<$count;$i++){
//           echo $array[$i][0]."<br>";
    if( trim($array[$i][0])  != "Asterisk Call Manager/1.0" && trim($array[$i][0])  != "Response: Success" && trim($array[$i][0])  != "Response: Follows" && trim($array[$i][0])  != "Message: Authentication accepted" && trim($array[$i][0])  != "Privilege: Command" && trim($array[$i][0])  != "Name/username" && trim($array[$i][0])  != "--END COMMAND--" && trim($array[$i][0])  != "" && trim($array[$i][0])  != "Response: Goodbye" && trim($array[$i][0])  != "Message: Thanks for all the fish." && trim($array[$i][0])  != "Asterisk Call Manager/1.1"  && trim($array[$i][0])  != "Event: FullyBooted" && trim($array[$i][0])  != "Privilege: system,all" && trim($array[$i][0])  != "Status: Fully Booted"){
//        if(trim($array[$i][8])==$uni  && $array[$i][1]=="from-seven"){
           echo $array[$i][0]."---".$array[$i][1]."---".$array[$i][2]."---".$array[$i][3]."---".$array[$i][4]."---".$array[$i][5]."---".$array[$i][6]."---".$array[$i][7]."---".$array[$i][8]."---".$array[$i][9]."---".$array[$i][10]."---".$array[$i][11]."---".$array[$i][12]."<br>";
//IAX2/perucall-21937---from-pcall---t2t2433---22---Up---Wait---3---980729136---142182---3---506---(None) ---
//IAX2/perucall-21937!from-pcall!t2t2433!22!Up!Wait!3!980729136!142182!3!501!(None)



//           $con = mysql_connect("localhost","root","d4t4B4$3p3c4ll2016*"); if (!$con){ die('Could not connect: ' . mysql_error()); }   mysql_select_db("perucall", $con);
//           mysql_query("UPDATE ajx_pro_acd SET Channel_Entrante='".trim($array[$i][0])."' WHERE accountcode='".trim($uni)."'"); 
//           mysql_query("UPDATE ajx_pro_lla SET canal1='".trim($array[$i][0])."' WHERE id_ori_llamadas='".trim($uni)."'");
//           mysql_query("UPDATE agentes SET canal='".trim($array[$i][0])."' WHERE accountcode='".trim($uni)."'");
//           mysql_close($con);

//                                                                    }
	   //-------------------------------------------------------------Llamadas SALIENTES hacia USA desde Telefono/Softphone----------------------------------------------------------------
//    	   if($array[$i][5]=="AppDial" && $array[$i][4]=="Up" && $array[$i][1]=="default" && strlen($array[$i][7])>4 && trim($array[$i][11]) != "(None)" ){
//                                                    }
                         } //--- cerrando for---
//  mysql_close($con);
                        }
?>

