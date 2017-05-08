<?php
 include("/etc/asterisk/scripts/conex.php");
 $link=Conectarse();
 $agente=trim($_GET['agente']);
 $idbase=trim($_GET['idbase']);
 $dni=trim($_GET['dni']);
 $cam=trim($_GET['cam']);

//    mysql_query("UPDATE ajx_pro_lla SET llam_estado=5 WHERE id_ori_llamadas='$id' and llam_estado=4");
    mysql_query("update `agentes` set estado = 3 where id = $agente");
  $aver=      "update `agentes` set estado = 3 where id = $agente";
  mysql_query("UPDATE filtro SET ACD=ACD+1 WHERE campania=$cam");
 //                      }

//--------------------------------LOG---------------------------------------------------------------------------------------------------------
    $fecha=date("Ymd_His");
    $fp = fopen("/var/log/pcall/aagente.log","a");
    fwrite($fp, "$fecha(I:$agente)(b:$idbase)(A:$dni)(C:$cam)" . PHP_EOL);
    fclose($fp);
?>
