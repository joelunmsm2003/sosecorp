<?php
 $timeout=30;
 $SRVAST="127.0.0.1";
//--------------------------------------------------------------------------------------------------------------------------------
 $cadenacallerid="Callerid: ".$NumeroLlamar."\r\n\r\n"; 
 $socket = fsockopen($SRVAST,"5038", $errno, $errstr, $timeout);
 fputs($socket, "Action: Login\r\n");
 fputs($socket, "UserName: xiencias01\r\n");
 fputs($socket, "Secret: Pr1m3R4Cl4v36&&_AS331df456svd3*\r\n\r\n");
 fputs($socket, "Events: off\r\n");
 fputs($socket, "Action: command\r\n");    
 fputs($socket, "Command: core show channels verbose\r\n\r\n");
 fputs($socket, "Action: Logoff\r\n\r\n");
 $count=0;$array;
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

 $DE=0;$NA=0;$TI=0;$CH=0;$NraAnx="";$presencia=0;$monitoreo=0;$canales=0;$llamadas=0;$entrantes=0;
//--------------------------------------------------------------------------------------------------------------------------------------------------------------
 for($i=0;$i<$count;$i++){ 
  echo "$array[$i][0]<br>";

  if ( isset($array[$i][0]) &&  isset($array[$i][1])){

//-------------Canales ACTIVOS----------------------------------------------
       if(trim($array[$i][1])=="active" && trim($array[$i][2])=="channels"){$canales=$array[$i][0];
  //       mysql_query("UPDATE  tb_pbx_totales SET canales = '$canales'");
                                    }
//-------------Llamadas ACTIVAS----------------------------------------------
       if(trim($array[$i][1])=="active" && trim($array[$i][2])=="calls"){$llamadas=$array[$i][0];
   //      mysql_query("UPDATE  tb_pbx_totales SET llamadas = '$llamadas'");
                                    }
   if($array[$i][0]  != "Response:" && $array[$i][0]  != "Message:" && $array[$i][0]  != "Privilege:" && $array[$i][0]  != "Name/username" && $array[$i][0]  != "--END" && $array[$i][1]  != "active")
    {
     $NroAnx = explode("/",$array[$i][0]);
     if ( isset($array[$i][5])){
//-------------Llamadas MONITOREO----------------------------------------------
       if(trim($array[$i][5])=="ChanSpy"){$monitoreo++;
     //    mysql_query("UPDATE  tb_pbx_totales SET monitoreo = '$monitoreo'");
                                    }

//-------------Llamadas ENTRANTES----------------------------------------------
       if(trim($array[$i][1])=="from-pstn" && trim($array[$i][3]=="Up")){$entrantes++;
//       if(trim($array[$i][1])=="from-pstn"){$entrantes++;
       //  mysql_query("UPDATE  tb_pbx_totales SET entrantes = '$entrantes'");
                                    }
////-------------Llamadas entrantes a la cola----------------------------------------------
       if($array[$i][5]=="Queue" && $array[$i][4]=="Up" && $array[$i][1]=="from-pstn"){
          $NroAnx2 = explode("/",$array[$i][9]); $NroAnx1 = explode("-",$NroAnx2[1]);
          $DE=trim($array[$i][7])."-(Ent)";$NA=$NroAnx1[0];$TI=trim($array[$i][8]);$CH=$array[$i][0];
           if($TI==''){$TI=0;}
           if($anxentabla[$we1]== "$NA"){$presencia=1; 
           //     if($intentabla[$we1] == "0" ){mysql_query("UPDATE  tb_monitoreo SET age_intera=2, tie_intera= '$TI', cha_intera= '$CH', num_destino='$DE' WHERE age_anexo = $NA ");}
         //       if($intentabla[$we1] == "2" ){mysql_query("UPDATE  tb_monitoreo SET tie_intera= '$TI', num_destino='$DE' WHERE age_anexo = $NA ");}
                                        }                                            }
       if($array[$i][5]=="Dial" && $array[$i][4]=="Up" && $array[$i][1]=="nivel-1" && strlen($array[$i][7])==3){
          $DE=trim($array[$i][2])."---(S)";$NA=trim($array[$i][7]);$TI=trim($array[$i][8]);$CH=$array[$i][0];
           if($TI==''){$TI=0;}
           if($anxentabla[$we1]== "$NA"){$presencia=1; 
          //      if($intentabla[$we1] == "0" ){mysql_query("UPDATE  tb_monitoreo SET age_intera=2, tie_intera= '$TI', cha_intera= '$CH', num_destino='$DE' WHERE age_anexo = $NA ");}
          //      if($intentabla[$we1] == "2" ){mysql_query("UPDATE  tb_monitoreo SET tie_intera= '$TI', num_destino='$DE' WHERE age_anexo = $NA ");}
                                        }                                            }
//-------------Llamadas desde Discador TIPO 0----------------------------------------------
//       if($array[$i][5]=="Dial" && $array[$i][4]=="Up" && $array[$i][1]=="discador" && $array[$i][9]<>"888885"){
       if($array[$i][5]=="Dial" && $array[$i][4]=="Up" && $array[$i][1]=="from-orion" && $array[$i][9]<>"888885" && strlen($array[$i][7])>3){
          $NroAnx2 = explode("/",$array[$i][0]);// $NroAnx1 = explode("-",$NroAnx2[1]);
//------------------------------------------
          if($NroAnx2[0]=="SIP"){$NroAnx1 = explode("-",$NroAnx2[1]);}
          if($NroAnx2[0]=="DAHDI"){$NroAnx2 = explode("/",$array[$i][10]); $NroAnx1 = explode("-",$NroAnx2[1]);}
//------------------------------------------
          $DE=trim($array[$i][7])."---(D)";$NA=$NroAnx1[0];$TI=trim($array[$i][8]);$CH=$array[$i][9];
          if($TI==''){$TI=0;}
          if($anxentabla[$we1]== "$NA"){$presencia=1; 
          //  if($intentabla[$we1] == "0" ){ mysql_query("UPDATE  tb_monitoreo SET age_intera=2, tie_intera= '$TI', cha_intera= '$CH', num_destino='$DE' WHERE age_anexo = $NA ");}
          //  if($intentabla[$we1] == "2" ){ mysql_query("UPDATE  tb_monitoreo SET tie_intera= '$TI', num_destino='$DE' WHERE age_anexo = $NA ");}
                                        }                                             }

//-------------Llamadas desde Discador TIPO 2----------------------------------------------
       if($array[$i][5]=="Dial" && $array[$i][4]=="Up" && $array[$i][1]=="discador" && $array[$i][9]=="888885"){
          $NroAnx2 = explode("/",$array[$i][10]); $NroAnx1 = explode("-",$NroAnx2[1]);
//          $NroAnx2 = explode("/",$array[$i][0]); $NroAnx1 = explode("-",$NroAnx2[1]);
          $DE=trim($array[$i][7])."---(P)";$NA=$NroAnx1[0];$TI=trim($array[$i][8]);$CH=$array[$i][9];
          if($TI==''){$TI=0;}
          if($anxentabla[$we1]== "$NA"){$presencia=1; 
         //   if($intentabla[$we1] == "0" ){ mysql_query("UPDATE  tb_monitoreo SET age_intera=2, tie_intera= '$TI', cha_intera= '$CH', num_destino='$DE' WHERE age_anexo = $NA ");}
         //   if($intentabla[$we1] == "2" ){ mysql_query("UPDATE  tb_monitoreo SET tie_intera= '$TI', num_destino='$DE' WHERE age_anexo = $NA ");}
                                        }                                             }

                                         }
           }                                            }
                             }
//--------------------------------------------------------------------------------------------------------------------------------------------------------------
//    }while 1;
    //while($we1<$qw);
  mysql_close($con);



$fecha=date("Ymd_His");
$fp = fopen("/var/log/seven/PROC_PREDICTIVO.log","a");
fwrite($fp, "$fecha($cadenachannel)($cadenaexten)($accntcd)($uniqueid)($tipo)($estado)($id)($num)($NumeroLlamar)($ane)($campana)($account)($treg)($aver)($vuelta)(UPDATE  traAgen SET usuario_canal=$UIDc2, accountcode=$accntcd WHERE id_ori_usuario = $account )" . PHP_EOL);
fclose($fp);
?>