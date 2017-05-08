<?php
 include("/opt/XA_VOIP/conex.php");
 $link=Conectarse();
 $id=trim($_GET['id']);
// &c_duration=27&c_billsec=15&
 $c_billsec=$_GET["c_billsec"];  
 $c_duration=$_GET["c_duration"];
 $c_dst=trim($_GET['c_dst']);
 $err=trim($_GET['err']);
 $varX3=trim($_GET['varX3']);
 $ring=$c_duration-$c_billsec;

 $result=mysql_query("SELECT age_codigo,IN_ID FROM ajx_pro_lla WHERE id_ori_llamadas='$id'",$link); while($row = mysql_fetch_array($result)) { $idin=$row["IN_ID"]; $account=$row["age_codigo"];}
 $accountID=trim($_GET['c_accountcode']); 
 if(substr($accountID, 0,2)=="I:"){$acctmp=explode(":",$accountID); $idacd=$acctmp[1];}

$idacd=$idin;

  echo "IDACD($idacd)";
 $result=mysql_query("SELECT id_ori_usuario, id_ori_campana, Numero_Llamado, anexo FROM ajx_pro_acd WHERE id_ori_acd='$idacd'",$link);
   while($row = mysql_fetch_array($result)) { 
       $account=$row["id_ori_usuario"];  $campana=$row["id_ori_campana"]; 
       $nllamado=$row["Numero_Llamado"]; $anexo=$row["anexo"]; 
          echo "USER($account)CAM($campana)";}
  mysql_query("UPDATE ajx_pro_acd SET flag=2, tie_fin=now(), fin=1,bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,tie_ing,now()) WHERE id_ori_acd='$idacd' AND duration=0 AND flag=1");

//----------------------SALIENTES BUSCADOR-t2-----------------------------
 if(substr($c_dst, 0,5)=="SEBt2"){ 
  mysql_query("UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id' AND duration=0");
  $aver=      "UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id' AND duration=0";  
  #mysql_query("UPDATE ajx_pro_bas SET tie_fin=now(), fin=1,bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,tie_ing,now()) WHERE id_ajx_pro_acd='$idin' AND duration=0");
                                                   }
//----------------------------pruebaaa---T1-----
 if(substr($c_dst, 0,5)=="SEVt1"){ 
  mysql_query("UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id' AND duration=0");
  $aver=      "UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id' AND duration=0";  
  mysql_query("UPDATE ajx_pro_acd SET tie_fin=now(), fin=1,bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,tie_ing,now()) WHERE accountcode='$id' AND duration=0");
                                  }

if(substr($c_dst, 2,3)==$anexo){ 
 if((substr($c_dst, 0,2)=="t0" && strlen($c_dst)==5) || (substr($c_dst, 0,5)=="SEVt4" && strlen($c_dst)>5)){ 
            system("php-cgi -q /var/www/seven7/agent/agentserv/escribe_barra.php new_estado=11 id=$account o_contesto_cnt=1 &");
            $aver="php-cgi -q /var/www/seven7/agent/agentserv/escribe_barra.php new_estado=11 id=$account o_contesto_cnt=1 &";
                                     }
                              }

 if((substr($c_dst, 0,2)=="t1" && strlen($c_dst)==5) || (substr($c_dst, 0,5)=="SEVt4" && strlen($c_dst)>5)){ 
            system("php-cgi -q /var/www/seven7/agent/agentserv/escribe_barra.php new_estado=11 id=$account o_contesto_cnt=1 &");
            $aver="php-cgi -q /var/www/seven7/agent/agentserv/escribe_barra.php new_estado=11 id=$account o_contesto_cnt=1 &";
                                     }
//----------------------SALIENTES PROGRESIVO-t1-----------------------------
 if(strlen($c_dst)==6 && substr($c_dst, 0,2)=="t1"){ 
  system("php-cgi -q /var/www/seven777/agent/agentserv/escribe_barra.php new_estado=11 id=$account o_contesto_cnt=1 &");
  $aver="php-cgi -q /var/www/seven777/agent/agentserv/escribe_barra.php new_estado=11 id=$account o_contesto_cnt=1 &";
  mysql_query("UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id' AND duration=0");
  $aver=      "UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id' AND duration=0";  
  mysql_query("UPDATE ajx_pro_acd SET tie_fin=now(), fin=1,bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,tie_ing,now()) WHERE id_ori_acd='$idin' AND duration=0");
                                                   }
 //-------cancelada x cliente-----------------------------
 if(strlen($c_dst)==9 && substr($c_dst, 0,5)=="SEVEE"){ 
  mysql_query("UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id' AND duration=0");
  $aver=      "UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id' AND duration=0";
                                                     }                                                     

//----------------------SALIENTES MANUALES-t0-----------------------------
 if(strlen($c_dst)>6 && substr($c_dst, 0,5)=="SEVt0"){ 
  system("php-cgi -q /var/www/seven777/agent/agentserv/escribe_barra.php new_estado=11 id=$account o_contesto_cnt=1 &");
   $aver="php-cgi -q /var/www/seven777/agent/agentserv/escribe_barra.php new_estado=11 id=$account o_contesto_cnt=1 &";}

 //-------anexo no contesta-----------------------------
 if(strlen($c_dst)==6 && substr($c_dst, 0,2)=="t0"){ //echo"111111111111";
  mysql_query("UPDATE ajx_pro_acd SET tie_fin=now(), fin=1,bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,tie_ing,now()) WHERE id_ori_acd='$idacd' AND duration=0");
  if($campana == "676"){system("php-cgi -q /var/www/seven777/agent/agentserv/escribe_barra.php new_estado=2 id=$account o_contesto_cnt=0 &");}
  if($campana != "676"){system("php-cgi -q /var/www/seven777/agent/agentserv/escribe_barra.php new_estado=11 id=$account o_contesto_cnt=0 &");}
   echo  "php-cgi -q /var/www/seven777/agent/agentserv/escribe_barra.php new_estado=11 id=$account o_contesto_cnt=1 &"; 
  mysql_query("UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id' AND duration=0");
  $aver=      "UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id' AND duration=0";
                                                     }    

//----------------------SALIENTES MANUALES F-t4-----------------------------
 if(strlen($c_dst)>6 && substr($c_dst, 0,5)=="SEVt4"){
  system("php-cgi -q /var/www/seven777/agent/agentserv/escribe_barra.php new_estado=11 id=$account o_contesto_cnt=1 &");
  $aver="php-cgi -q /var/www/seven777/agent/agentserv/escribe_barra.php new_estado=11 id=$account o_contesto_cnt=1 &"; 
  mysql_query("UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id'");
  $aver=      "UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id'";
                                                     }    
 //-------anexo no contesta-----------------------------
 if(strlen($c_dst)==6 && substr($c_dst, 0,2)=="t4"){ 
  mysql_query("UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id' AND duration=0");
  $aver=      "UPDATE ajx_pro_lla SET f_llam_fin=now(), flagFIN=1,v_retry='$err',ring='$ring',bill='$c_billsec', duration=TIMESTAMPDIFF(SECOND,f_origen,now()) WHERE id_ori_llamadas='$id' AND duration=0";
                                                     }    

//-----------------------------------------------------------------------------------------------------------------------------------------
$fecha=date("Ymd_His");
$fp = fopen("/var/log/seven/PROC_FINLLAMADA.log","a");
fwrite($fp, "$fecha($id)($c_billsec)($ring)($c_dst)($varX3)($account)()()($aver)" . PHP_EOL);
fclose($fp);
?>
