<?php
date_default_timezone_set('America/Lima');
 $streg='';$cadenaexten111=0;$accntcd=0;$aver='';$aver1='';//$cadenavarX6=0;
 //$tdni='';
 $timeout=30;
 $id=0;
 $num=0;
 $ane=0;
 $treg=0;
 $tipo=0;
 $campana=0;
 $account=0;
 $id1=0;

 $id=$_GET['id'];       if($id==""){$id="NA";}
 $num=$_GET['num'];     if($num==""){$num="NA";}
 $ane=$_GET['ane'];     if($ane==""){$ane="NA";}
 $tipo=$_GET['tipo'];   if($tipo==""){$tipo="NA";}
 $account=$_GET['acc']; if($account==""){$account="NA";}
 $campana=$_GET['cam']; if($campana==""){$campana="NA";}
 $treg=$_GET['treg'];   if($treg==""){$treg="NA";}
 $id1=$_GET['id1'];     if($id1==""){$id1="NA";}
 $id2=$_GET['id2'];     if($id2==""){$id2="NA";}
 $id3=$_GET['id3'];     if($id3==""){$id3="NA";}
 $id4=$_GET['id4'];     if($id4==""){$id4="NA";}
 $id5=$_GET['id5'];     if($id5==""){$id5="NA";}
 $id6=$_GET['id6'];     if($id6==""){$id6="NA";}
 $id7=$_GET['id7'];     if($id7==""){$id7="NA";}
 $id8=$_GET['id8'];     if($id8==""){$id8="NA";}
 $id9=$_GET['id9'];     if($id9==""){$id9="NA";}
 $id10=$_GET['id10'];   if($id10==""){$id10="NA";}
 $audio=$_GET['audio']; if($audio==""){$audio="NA".$treg;}
 $idcliente=$_GET['idcliente'];
 $x_troncal=$_GET['x_troncal'];
 $x_ring1=$_GET['x_ring1']; 
 $x_ring2=$_GET['x_ring2']; 
 $x_pref=$_GET['x_pref']; 
 $x_grab=$_GET['x_grab'];
 $vuelta=$_GET['vuelta'];
 $ano=date('Y');$mes=date('m');$dia=date('d');$hor=date('H');$min=date('i');$seg=date('s');
 $fecha=$dia."-".$mes."-".$ano."-".$hor."-".$min."-".$seg;
// $cadenavargrabacion="Variable: var=".trim($id_univ)."-".trim($id_ejec)."-".trim($id_cu)."-".trim($id_gest)."\r\n";
 $cadenavarcampana="Variable: var1=CCNUEVO\r\n";
 $cadenavarcampana9="Variable: var9=".$account."\r\n";
 $cadenavarcampana10="Variable: var10=".$treg."\r\n";
 $cadenavarcampana11="Variable: var11=".$id."\r\n";
 $cadenavarcampana13="Variable: var13=".$treg."\r\n";
 $cadenavarcampana15="Variable: var15=".$idcliente."\r\n";
 $cadenavarX1="Variable: varX1=".$x_troncal."\r\n";
 $cadenavarX2="Variable: varX2=".$x_pref."\r\n";
 $cadenavarX3="Variable: varX3='".$id."#".$num."#".$ane."#".$treg."#".$tipo."#".$campana."#".$account."#".$id1."'\r\n";
 $cadenavarX4="Variable: varX4=".$campana."\r\n";
 $cadenavarX5="Variable: varX5=".$audio."\r\n";
 $vargrab_orionc7="Variable: var5=".trim($tdni)."-".trim($num)."-".trim($fecha)."\r\n";
 $audiofinal=$audio; //"b".trim($tdni)."-".trim($num)."-".trim($fecha);
 $NumeroLlamar=$num;
 $NumeroAnexo=$ane;


$SRVAST="127.0.0.1";

//llamadas progresivo
if($tipo=="1"){
//    if(strlen($NumeroLlamar) == 7){$NumeroLlamar = "1".$NumeroLlamar;}
    if(strlen($NumeroLlamar) == 9  && $NumeroLlamar{0} == "0"){$NumeroLlamar = substr($NumeroLlamar, 1);}
    $cadenachannel="Channel: Local/PCAt1".$NumeroLlamar."@from-pcall\r\n";
    if( $id1==1){$cadenaexten="Exten: t1".$NumeroAnexo."\r\n";}
              }

//llamadas predictivo
if($tipo=="2"){
    $cadenaexten="Exten: t2".$NumeroAnexo."\r\n";
    if(strlen($NumeroLlamar) == 8  && $NumeroLlamar{0} == "1"){$NumeroLlamar = substr($NumeroLlamar, 1); $cadenaexten="Exten: T2".$NumeroAnexo."\r\n";}
    if(strlen($NumeroLlamar) == 9  && $NumeroLlamar{0} == "0"  && $NumeroLlamar{1} == "1"){$NumeroLlamar = substr($NumeroLlamar, 2); $cadenaexten="Exten: T2".$NumeroAnexo."\r\n";}
    if(strlen($NumeroLlamar) == 8  && $NumeroLlamar{0} != "1"){$NumeroLlamar = "0".$NumeroLlamar; $cadenaexten="Exten: T2".$NumeroAnexo."\r\n";}
    if(strlen($NumeroLlamar) == 9  && $NumeroLlamar{0} == "9"){$cadenaexten="Exten: t2".$NumeroAnexo."\r\n";}

    $cadenachannel="Channel: Local/PCAt2".$NumeroLlamar."@from-pcall\r\n";
//    if( $id1==2){                  }
              }

//--------------------------------------------------------------------------------------------------------------------------------
 $cadenacallerid="Callerid: ".$NumeroLlamar."\r\n\r\n"; 
 $socket = fsockopen($SRVAST,"5038", $errno, $errstr, $timeout);
 fputs($socket, "Action: Login\r\n");
 fputs($socket, "UserName: xiencias01\r\n");
 fputs($socket, "Secret: Pr1m3R4Cl4v36&&_AS331df456svd3*\r\n\r\n");
 fputs($socket, "Events: off\r\n");
 fputs($socket, "Action: Originate\r\n");
 fputs($socket, "Timeout: 28000\r\n");
 fputs($socket, $cadenaexten );
 fputs($socket, $cadenachannel);
 fputs($socket, "Context: from-pcall\r\n");
 fputs($socket, $cadenavarcampana);
 fputs($socket, $vargrab_orionc7);
 fputs($socket, $cadenavarcampana9);
 fputs($socket, $cadenavarcampana10);
 fputs($socket, $cadenavarcampana11);
 fputs($socket, $cadenavarcampana13);
 fputs($socket, $cadenavarcampana15);
 fputs($socket, $cadenavarX1);
 fputs($socket, $cadenavarX2);
 fputs($socket, $cadenavarX3);
 fputs($socket, $cadenavarX4);
 fputs($socket, $cadenavarX5);
 fputs($socket, $cadenavarX6);
 fputs($socket, "Priority: 1\r\n");
 fputs($socket, $cadenacallerid );
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
 

$estado=0; $uniqueid=0; $canal="";
 for($i=0;$i<$count;$i++){ 
//----------------------------------------------------------------------CONTESTO---------------------------------------------------------------------------
  if(trim($array[$i][1])=="Originate" && trim($array[$i][2]) == "successfully" && trim($array[$i][1])!="" && trim($array[$i][2])!=""){$estado=4;}
  if($estado==4 && trim($array[$i][0])== "Uniqueid:"){$uniqueid=$array[$i][1];$i=$count;} 
  if($estado==4 && trim($array[$i][0])== "Channel:" && $array[$i][1]!=""){
  $canal=trim($array[$i][1]);} 
  //$aver1="if(trim(@array[$i][1])=='Originate' && trim(@array[$i][2]) == 'successfully' && trim($array[$i][1])!='' && trim($array[$i][2])!='')";
//--------------------------------------------------------------OCUPADO-NOCONTESTO-------------------------------------------------------------------

  if(trim($array[$i][1])=="Originate" && trim($array[$i][2])== "failed"){$estado=2;}
  if($estado==2 && trim($array[$i][0])== "Uniqueid:"){$uniqueid=$array[$i][1];}
    if($estado==2 && trim($array[$i][0])== "Cause-txt:" && trim($array[$i][3])== "no" && trim($array[$i][4])== "answer"){$estado=3; $i=$count;} 

  }
  $canal=trim($canal); $uniqueid=trim($uniqueid);
  $con = mysql_connect("localhost","root","d4t4B4$3p3c4ll2016*");
  if (!$con){ die('Could not connect: ' . mysql_error()); }
  mysql_select_db("perucall", $con);
//----------------------------------------------------------------------------------------------------------------------------------------------------------
  if($tipo==0){
    mysql_query("UPDATE  ajx_pro_lla SET llam_estado=$estado, llam_uniqueid='$uniqueid', canal2='$canal', audio='$audiofinal',f_llam_resuelve=now(), anexo=$ane, id_ori_seg_cola=$campana WHERE id_ori_llamadas = $id "); 
    if($estado==2 || $estado==3){mysql_query("UPDATE ajx_pro_lla SET bill='0', flagFIN=1,f_llam_fin=now() WHERE id_ori_llamadas = $id ");} 
    $ano=date('Y');$mes=date('m');$dia=date('d');$fecha=date('d-m-Y_h-i-sA');
    $grabacion=$ano."/".$mes."/".$dia."/sali/".$fecha."-".$ane."-".$num;
    if($estado==4){
          $ano=date('Y');$mes=date('m');$dia=date('d');$fecha=date('d-m-Y_h-i-sA');
          $grabacion=$ano."/".$mes."/".$dia."/sali/".$fecha."-".$ane."-".$num;
          //------------ Obtiene canal--------------------------------
          $UIDc2=system("php-cgi -q /var/www/xien/test/PROC_CHANNEL.php uni=$uniqueid");
  mysql_query("UPDATE agentes SET canal='$canal',destino='$num',duracion=now() WHERE id='$account'");

          //------------ Actualiza registro en la base----------------
          mysql_query("UPDATE  ajx_pro_lla SET canal1='$UIDc2' WHERE id_ori_llamadas = $id "); 
          //------------ Servicio barra estado ocupado----------------
          system("php-cgi -q /var/www/seven777/agent/agentserv/escribe_barra.php new_estado=10 id=$account id_cola=$campana destino=$num  canal='$UIDc2' id_llamada=$id nombredelcliente='$id2' tipo_disc=$tipo st=1 &");
          $aver="php-cgi -q /var/www/seven777/agent/agentserv/escribe_barra.php new_estado=10 id=$account id_cola=$campana destino=$num  canal='$UIDc2' id_llamada=$id nombredelcliente='$id2' tipo_disc=$tipo st=1 &";
                  }
              }
//----------------------------------------------------------------------------------------------------------------------------------------------------------
  if($tipo==1){
    mysql_query("UPDATE  ajx_pro_lla SET llam_estado=$estado, llam_uniqueid='$uniqueid', canal1='$canal', audio='$audiofinal',f_llam_resuelve=now(),anexo=$ane WHERE id_ori_llamadas = $id "); 
    mysql_query("UPDATE  base SET ProEstado=$estado, resultado_asterisk=$estado, audio='$audiofinal' WHERE id = $treg "); 
    if($estado==2 || $estado==3){mysql_query("UPDATE ajx_pro_lla SET bill='0', flagFIN=1,f_llam_fin=now() WHERE id = $id ");
                    if($estado == 2){
                         mysql_query("UPDATE campania SET o_error_cnt=o_error_cnt+1 WHERE id = $campana ");
                         mysql_query("UPDATE base SET resultadoat='Error' WHERE id = $treg ");
                          //echo "(aaa(UPDATE base SET resultadoat='Error' WHERE id = $treg ))";
                          // (aaa(UPDATE base SET resutaldoat='Error' WHERE id = 220409 ))No input file specified.
                                    }
                    if($estado == 3){
                         mysql_query("UPDATE campania SET o_nocontesto_cnt=o_nocontesto_cnt+1 WHERE id = $campana ");
                         mysql_query("UPDATE base SET resultadoat='NoContesta' WHERE id = $treg ");
                                    }
                    mysql_query("UPDATE  ajx_pro_lla SET flagFIN=1, f_llam_fin=now(),duration=TIMESTAMPDIFF(SECOND,f_llam_discador,now())WHERE id_ori_llamadas = $id "); 
                    mysql_query("UPDATE agentes SET est_ag_predictivo=0 WHERE id='$account'"); $aver="aca";
                    mysql_query("UPDATE base SET bloqueocliente=0 WHERE id_cliente='$idcliente'");
                                 } 

    if($estado==4){
          $ano=date('Y');$mes=date('m');$dia=date('d');$fecha=date('d-m-Y_h-i-sA');
          $grabacion=$ano."/".$mes."/".$dia."/sali/".$fecha."-".$ane."-".$num;
          //------------ Obtiene canal--------------------------------
  //        $UIDc2=system("php-cgi -q /var/www/xien/test/PROC_CHANNEL.php uni=$id");
          //------------ Actualiza registro en la base----------------
  //        mysql_query("UPDATE  agentes SET canal='$UIDc2', accountcode='$id' WHERE id = $account "); 
          //------------ Servicio barra estado ocupado----------------
         // $treg=76;
          print "----------------------------------anskdfajksssssssdn".$account."-".$streg;
            //        mysql_query("UPDATE agentes SET est_ag_predictivo=0 WHERE id='$account'");
              }
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------

  if($tipo==2){
     if($estado==2){
       if($vuelta==1 || $vuelta==2 || $vuelta==3){ mysql_query("UPDATE ajx_pro_lla SET llam_flag=0, llam_estado=0 WHERE id_ori_llamadas = $id ");}
       if($vuelta==4){
//         if($vuelta==1){
          mysql_query("UPDATE ajx_pro_lla SET llam_estado=$estado, llam_uniqueid='$uniqueid', canal2='$canal', audio='$audiofinal',f_llam_resuelve=now() WHERE id_ori_llamadas = $id"); 
          mysql_query("UPDATE ajx_pro_lla SET bill='0', flagFIN=1,f_llam_fin=now() WHERE id_ori_llamadas = $id ");
          //mysql_query("UPDATE ajx_pro_bas SET ti03=0, ti08=0, bi04=$estado WHERE ti10 = $id "); 
          //mysql_query("UPDATE ajx_pro_bas SET ti08=0 WHERE bi01 = '$treg' "); 
          if($estado==2){mysql_query("UPDATE campania SET o_error_cnt=o_error_cnt+1 WHERE id = $campana ");}
                       }
                    }
     if($estado==3){
          mysql_query("UPDATE ajx_pro_lla SET llam_estado=$estado, llam_uniqueid='$uniqueid', canal2='$canal', audio='$audiofinal',f_llam_resuelve=now() WHERE id_ori_llamadas = $id "); 
          mysql_query("UPDATE ajx_pro_lla SET bill='0', flagFIN=1,f_llam_fin=now() WHERE id_ori_llamadas = $id ");
      //    mysql_query("UPDATE ajx_pro_bas SET ti03=0, ti08=0, bi04=$estado WHERE ti10 = $id "); 
      //    mysql_query("UPDATE ajx_pro_bas SET ti08=0 WHERE bi01 = '$treg' "); 
          if($estado==2){mysql_query("UPDATE campania SET o_error_cnt=o_error_cnt+1 WHERE id = $campana ");}
          if($estado==3){mysql_query("UPDATE campania SET o_nocontesto_cnt=o_nocontesto_cnt+1 WHERE id = $campana ");}
                                 }
    if($estado==4){
          mysql_query("UPDATE  ajx_pro_lla SET llam_estado=$estado, llam_uniqueid='$uniqueid', canal2='$canal', audio='$audiofinal',f_llam_resuelve=now() WHERE id_ori_llamadas = $id "); 

          //------------ Obtiene canal--------------------------------
//          $UIDc2=system("php-cgi -q /var/www/xien/test/PROC_CHANNEL.php uni=$uniqueid");
          //------------ Actualiza registro en la base----------------
          mysql_query("UPDATE ajx_pro_lla SET canal1='$UIDc2' WHERE id_ori_llamadas = $id "); 
          mysql_query("UPDATE ajx_pro_bas SET ti03=0, ti09=1, bi04=$estado WHERE ti10 = $id "); 
                  }
              }
//-----------------------------------------------------------------------------------------------------------------------------------------------------------
  if($tipo==4){
    mysql_query("UPDATE  ajx_pro_lla SET llam_estado=$estado, llam_uniqueid='$uniqueid', canal2='$canal', audio='$audiofinal',f_llam_resuelve=now(),anexo=$ane WHERE id_ori_llamadas = $id "); 
    if($estado==2 || $estado==3){mysql_query("UPDATE ajx_pro_lla SET bill='0', flagFIN=1,f_llam_fin=now() WHERE id = $id ");
                    if($estado==2){mysql_query("UPDATE campania SET o_error_cnt=o_error_cnt+1 WHERE id = $id ");}
                    if($estado==3){mysql_query("UPDATE campania SET o_nocontesto_cnt=o_nocontesto_cnt+1 WHERE id = $id ");}
                                 }
    if($estado==4){
          $ano=date('Y');$mes=date('m');$dia=date('d');$fecha=date('d-m-Y_h-i-sA');
          $grabacion=$ano."/".$mes."/".$dia."/sali/".$fecha."-".$ane."-".$num;
          //------------ Obtiene canal--------------------------------
          $UIDc2=system("php-cgi -q /var/www/xien/test/PROC_CHANNEL.php uni=$uniqueid");
          //------------ Actualiza registro en la base----------------
          $accntcd="ANT_".$uniqueid;
          mysql_query("UPDATE  ajx_pro_lla SET canal1='$UIDc2' WHERE id_ori_llamadas = $id "); 
          mysql_query("UPDATE  agentes SET canal='$canal', accountcode='$id' WHERE id = $account "); 

          //------------ Servicio barra estado ocupado----------------
          system("php-cgi -q /var/www/seven7/agent/agentserv/escribe_barra.php new_estado=10 id=$account id_cola=$campana destino=$num pais=1 region=Lima canal='$canal' canal1='$UIDc2' id_llamada=$id nombredelcliente='$id2' tipo_disc=$tipo id_base=$treg st=1 &");
          $aver ="php-cgi -q /var/www/seven7/agent/agentserv/escribe_barra.php new_estado=10 id=$account id_cola=$campana destino=$num pais=1 region=Lima canal='$canal' canal1='$UIDc2' id_llamada=$id nombredelcliente='$id2' tipo_disc=$tipo id_base=$treg st=1 &";

                  }
    mysql_query("UPDATE agentes SET est_ag_predictivo=0 WHERE id='$account'");
              }
//----------------------------------------------------------------------------------------------------------------------------------------------------------
  mysql_close($con);

system("php-cgi -q /var/www/xien/test/PROC_CHANNEL.php uni=$id");

$fecha=date("Ymd_His");
$fp = fopen("/var/log/pcall/PROC_LLAMADOR.log","a");
fwrite($fp, "$fecha($cadenachannel)($cadenaexten111)($accntcd)($uniqueid)($tipo)($estado)($id)($num)($NumeroLlamar)($ane)($campana)($account)($treg)($aver)($vuelta)(UPDATE agentes SET est_ag_predictivo=0 WHERE id='$account')($aver1)" . PHP_EOL);
fclose($fp);
?>