#!/usr/bin/perl

use DBI;
do{
#    print "----------------Inicia procesos---------------------- \n";
    registros();
    sleep 3;
}while(1);


sub registros()
{
    @aval_id="";@aval_acc="";@aval_ori=""; @aval_des=""; @aval_can="";
    @aval_ip="";@aval_age="";@aval_gru=""; @aval_fec="";

    $db="predictivo";$host="localhost";$userid='root';$passwd='d4t4B4$3*';$connectionInfo="dbi:mysql:$db;$host";
    $dbh = DBI->connect($connectionInfo,$userid,$passwd);
    ($seg, $min, $hora, $dia, $mes, $anho, @zape) = localtime(time);
    $mes++;$anho+=1900;$dia="0".$dia if(length($dia)==1);$mes="0".$mes if(length($mes)==1);$fecha_actual= "$anho-$mes-$dia";
    $fecha_grabamanual= "$anho-$mes-$dia_$hora-$min-$seg";
    $i=1;
    $query = "SELECT id,accion,origen,destino,canal,ip,id_agente,id_campania,fechahora,id_base,id_gestion,id_llamada,empresa,accountcode FROM acciones WHERE flag=0";
    $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$val_id,\$val_acc,\$val_ori,\$val_des,\$val_can,\$val_ip,\$val_age,\$val_gru,\$val_fec,\$val_bas,\$val_ges,\$val_lla,\$val_ncli,\$val_accountc);
    while($sth->fetch()) {
               @aval_id[$i]=$val_id;@aval_acc[$i]=$val_acc;@aval_ori[$i]=$val_ori; @aval_des[$i]=$val_des; @aval_can[$i]=$val_can; @aval_ip[$i]=$val_ip;
               @aval_age[$i]=$val_age;@aval_gru[$i]=$val_gru; @aval_fec[$i]=$val_fec; @aval_bas[$i]=$val_bas; @aval_ges[$i]=$val_ges; @aval_lla[$i]=$val_lla;
               @aval_ncli[$i]=$val_ncli; @aval_accountc[$i]=$val_accountc;
		         $i++;
			}
    for($k=1;$k<$i;$k++){
        $query = "UPDATE acciones SET flag=1 WHERE id='@aval_id[$k]'";$sth = $dbh->prepare($query);  $sth->execute();
        #Agendada(1)
        if($aval_acc[$k]=="1"){ #/system("php5-cgi -q /opt/XA_VOIP/PROC.php canal='@aval_can[$k]' &"); print "Reallamada lanzada\n";
          $audio="AGENDADA-".$aval_ori[$k]."-".$aval_des[$k]."-A_".$aval_age[$k]."-C_".$aval_gru[$k]."-"; 
          # obtiene parametros de telefonia
          $query = "SELECT id, nombre,tipo,troncal,timbrado1,timbrado2,prefijo,grabacion FROM campania WHERE estado =1 ORDER BY tipo ASC";
          $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$id,\$nombre,\$tipo,\$x_troncal,\$x_ring1,\$x_ring2,\$x_pref,\$x_grab);
          while($sth->fetch()) { $cose_id[$q]=$id;  $cose_nombre[$q]=$nombre; $cose_tipo[$q]=$tipo;$cose_x_troncal[$q]=$x_troncal;$cose_x_ring1[$q]=$x_ring1;$cose_x_ring2[$q]=$x_ring2;$cose_x_pref[$q]=$x_pref;$cose_x_grab[$q]=$x_grab;}
          # obtiene datos de gestion
          $query = "SELECT g_id1,g_id2,g_id3,g_id4,g_id5,g_id6,g_id7,g_id8,g_id9,g_id10 FROM ajx_pro_bas where bi01=$aval_bas[$k]";$sth = $dbh->prepare($query);$sth->execute(); 
          $sth->bind_columns(\$val_id1,\$val_id2,\$val_id3,\$val_id4,\$val_id5,\$val_id6,\$val_id7,\$val_id8,\$val_id9,\$val_id10);
          while($sth->fetch()) { @aval_id1[$k]=$val_id1; @aval_id2[$k]=$val_id2; @aval_id3[$k]=$val_id3;@aval_id4[$k]=$val_id4;@aval_id5[$k]=$val_id5;@aval_id6[$k]=$val_id6;@aval_id7[$k]=$val_id7;@aval_id8[$k]=$val_id8;@aval_id9[$k]=$val_id9;@aval_id10[$k]=$val_id10;}
          # inserta llamada
          $query = "INSERT INTO seven.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,audio,troncal,timbrado1,timbrado2,prefijo,grabacion,gestion_editid1,gestion_editid2,gestion_editid3,gestion_editid4,gestion_editid5,gestion_editid6,gestion_editid7,gestion_editid8,gestion_editid9,gestion_editid10,tregistro) values ('@aval_ori[$k]', '@aval_age[$k]','$aval_gru[$k]', '$aval_des[$k]',0,0,4,now(),0,CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$cose_x_troncal[$f]', $cose_x_ring1[$f],$cose_x_ring2[$f],'$cose_x_pref[$f]',$cose_x_grab[$f],'$aval_id1[$k]', '$aval_ncli[$k]','$aval_id3[$k]','$aval_id4[$k]','$aval_id5[$k]','$aval_id6[$k]', '$aval_id7[$k]','$aval_id8[$k]','$aval_id9[$k]','$aval_id10[$k]',$aval_bas[$k])";
             print "INSERT INTO seven.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,audio,troncal,timbrado1,timbrado2,prefijo,grabacion,gestion_editid1,gestion_editid2,gestion_editid3,gestion_editid4,gestion_editid5,gestion_editid6,gestion_editid7,gestion_editid8,gestion_editid9,gestion_editid10,tregistro) values ('@aval_ori[$k]', '@aval_age[$k]','$aval_gru[$k]', '$aval_des[$k]',0,0,4,now(),0,CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$cose_x_troncal[$f]', $cose_x_ring1[$f],$cose_x_ring2[$f],'$cose_x_pref[$f]',$cose_x_grab[$f],'$aval_id1[$k]', '$aval_ncli[$k]','$aval_id3[$k]','$aval_id4[$k]','$aval_id5[$k]','$aval_id6[$k]', '$aval_id7[$k]','$aval_id8[$k]','$aval_id9[$k]','$aval_id10[$k]',$aval_bas[$k])";
          $sth = $dbh->prepare($query);  $sth->execute();
          print "Llamada lanzada 1\n";
                              }
        #grabar(2)
        if($aval_acc[$k]=="2"){ 
          $audio="GRABMANUAL-".$aval_ori[$k]."-".$aval_des[$k]."-A_".$aval_age[$k]."-C_".$aval_gru[$k]."-".$fecha_grabamanual; 
          $query = "UPDATE ajx_pro_lla SET audio2='$audio' WHERE id_ori_llamadas='@aval_lla[$k]'";$sth = $dbh->prepare($query);  $sth->execute();
          system("php5-cgi -q /opt/xien/seven/PROC_GRABAR.php canal='@aval_can[$k]' audio='$audio' &");print "Grabacion lanzada\n";
                              }
        #cortar(3)
        if($aval_acc[$k]=="3"){ system("php5-cgi -q /opt/xien/seven/PROC_COLGAR.php canal='@aval_can[$k]' &");print "llamada cortada\n";}
        #transferir(4)
        if($aval_acc[$k]=="4"){ 
          $query = "INSERT INTO ajx_pro_acd ( DID_Campana, Numero_Llamado, Numero_Entrante, Channel_Entrante, flag,uniqueid,tie_ing,id_ori_campana,asterisk,llam_estado,valorllamada,accountcode) values(3, '@aval_ori[$k]', '@aval_des[$k]', '@aval_can[$k]', '0', '',now(),1,0,5,'@aval_bas[$k]','@aval_accountc[$k]')"; $sth = $dbh->prepare($query);  $sth->execute();
          $query = "SELECT LAST_INSERT_ID();"; $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$ulid);while($sth->fetch()) { $ultimoid=$ulid;}
          $query = "UPDATE ajx_pro_lla SET IN_ID='$ultimoid'  WHERE id_ori_llamadas ='@aval_accountc[$k]'";$sth = $dbh->prepare($query);  $sth->execute();     
          print "transferencia lanzada\n";
                              }
        #monitorear(5)
        if($aval_acc[$k]=="5"){ system("php5-cgi -q /opt/xien/seven/PROC_MONITOR.php sup='@aval_des[$k]' anx='@aval_ori[$k]' &");print "Monitoreo lanzado\n";}
        #susurro(6)
        if($aval_acc[$k]=="6"){ system("php5-cgi -q /opt/xien/seven/PROC_SUSURRO.php sup='@aval_des[$k]' anx='@aval_ori[$k]' &");print "Susurro lanzado\n";}
        #Rellamada(7)
        if($aval_acc[$k]=="7"){
          $audio="RELLAMADA-".$aval_ori[$k]."-".$aval_des[$k]."-A_".$aval_age[$k]."-C_".$aval_gru[$k]."-"; 
          $q=0;
          $query = "SELECT id, nombre,tipo,troncal,timbrado1,timbrado2,prefijo,grabacion FROM campania WHERE estado =1 AND id=@aval_gru[$k] ORDER BY tipo ASC";
          $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$id,\$nombre,\$tipo,\$x_troncal,\$x_ring1,\$x_ring2,\$x_pref,\$x_grab);
          while($sth->fetch()) { $cose_id[$q]=$id;  $cose_nombre[$q]=$nombre; $cose_tipo[$q]=$tipo;$cose_x_troncal[$q]=$x_troncal;$cose_x_ring1[$q]=$x_ring1;$cose_x_ring2[$q]=$x_ring2;$cose_x_pref[$q]=$x_pref;$cose_x_grab[$q]=$x_grab;}
          $query = "INSERT INTO seven.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,audio,troncal,timbrado1,timbrado2,prefijo,grabacion,tregistro) values ('@aval_ori[$k]', '@aval_age[$k]','$aval_gru[$k]', '$aval_des[$k]',0,0,4,now(),0,CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$cose_x_troncal[$q]', $cose_x_ring1[$q],$cose_x_ring2[$q],'$cose_x_pref[$q]',$cose_x_grab[$q],$aval_bas[$k])";
             print "INSERT INTO seven.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,audio,troncal,timbrado1,timbrado2,prefijo,grabacion,tregistro) values ('@aval_ori[$k]', '@aval_age[$k]','$aval_gru[$k]', '$aval_des[$k]',0,0,4,now(),0,CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$cose_x_troncal[$q]', $cose_x_ring1[$q],$cose_x_ring2[$q],'$cose_x_pref[$q]',$cose_x_grab[$q],$aval_bas[$k])";
          $sth = $dbh->prepare($query);  $sth->execute();
          print "Llamada lanzada 7\n";
                              }
        #Preview(8)
        if($aval_acc[$k]=="8"){
          $audio="PREVIEW".$aval_ori[$k]."-".$aval_des[$k]."-A_".$aval_age[$k]."-C_".$aval_gru[$k]."-"; 
          $q=0;
          $query = "SELECT id, nombre,tipo,troncal,timbrado1,timbrado2,prefijo,grabacion FROM campania WHERE estado =1 AND id=@aval_gru[$k] ORDER BY tipo ASC";
          $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$id,\$nombre,\$tipo,\$x_troncal,\$x_ring1,\$x_ring2,\$x_pref,\$x_grab);
          while($sth->fetch()) { $cose_id[$q]=$id;  $cose_nombre[$q]=$nombre; $cose_tipo[$q]=$tipo;$cose_x_troncal[$q]=$x_troncal;$cose_x_ring1[$q]=$x_ring1;$cose_x_ring2[$q]=$x_ring2;$cose_x_pref[$q]=$x_pref;$cose_x_grab[$q]=$x_grab;}
          $query = "INSERT INTO seven.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,audio,troncal,timbrado1,timbrado2,prefijo,grabacion) values ('@aval_ori[$k]', '@aval_age[$k]','$aval_gru[$k]', '$aval_des[$k]',0,0,4,now(),0,CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$cose_x_troncal[$q]', $cose_x_ring1[$q],$cose_x_ring2[$q],'$cose_x_pref[$q]',$cose_x_grab[$q])";
             print "INSERT INTO seven.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,audio,troncal,timbrado1,timbrado2,prefijo,grabacion) values ('@aval_ori[$k]', '@aval_age[$k]','$aval_gru[$k]', '$aval_des[$k]',0,0,4,now(),0,CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$cose_x_troncal[$q]', $cose_x_ring1[$q],$cose_x_ring2[$q],'$cose_x_pref[$q]',$cose_x_grab[$q])";
          $sth = $dbh->prepare($query);  $sth->execute();
          print "Llamada lanzada 8\n";
                              }
        #dialpad(9)
        if($aval_acc[$k]=="9"){
          $audio="DIALPAD-".$aval_ori[$k]."-".$aval_des[$k]."-A_".$aval_age[$k]."-C_".$aval_gru[$k]."-"; 
          $q=0;
          $query = "SELECT id, nombre,tipo,troncal,timbrado1,timbrado2,prefijo,grabacion FROM campania WHERE estado =1 AND id=@aval_gru[$k] ORDER BY tipo ASC";
          $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$id,\$nombre,\$tipo,\$x_troncal,\$x_ring1,\$x_ring2,\$x_pref,\$x_grab);
          while($sth->fetch()) { $cose_id[$q]=$id;  $cose_nombre[$q]=$nombre; $cose_tipo[$q]=$tipo;$cose_x_troncal[$q]=$x_troncal;$cose_x_ring1[$q]=$x_ring1;$cose_x_ring2[$q]=$x_ring2;$cose_x_pref[$q]=$x_pref;$cose_x_grab[$q]=$x_grab;}
          $query = "INSERT INTO seven.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,audio,troncal,timbrado1,timbrado2,prefijo,grabacion) values ('@aval_ori[$k]', '@aval_age[$k]','$aval_gru[$k]', '$aval_des[$k]',0,0,4,now(),0,CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$cose_x_troncal[$q]', $cose_x_ring1[$q],$cose_x_ring2[$q],'$cose_x_pref[$q]',$cose_x_grab[$q])";
             print "INSERT INTO seven.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,audio,troncal,timbrado1,timbrado2,prefijo,grabacion) values ('@aval_ori[$k]', '@aval_age[$k]','$aval_gru[$k]', '$aval_des[$k]',0,0,4,now(),0,CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$cose_x_troncal[$q]', $cose_x_ring1[$q],$cose_x_ring2[$q],'$cose_x_pref[$q]',$cose_x_grab[$q])";
          $sth = $dbh->prepare($query);  $sth->execute();
          print "Llamada lanzada 9\n";
                              }
        #ServicioLlamar(10)
        if($aval_acc[$k]=="10"){
          $audio="EXTERNO-".$aval_ori[$k]."-".$aval_des[$k]."-A_".$aval_age[$k]."-C_".$aval_gru[$k]."-"; 
          $q=0;
          $query = "SELECT id, nombre,tipo,troncal,timbrado1,timbrado2,prefijo,grabacion FROM campania WHERE estado =1 AND id=@aval_gru[$k] ORDER BY tipo ASC";
          $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$id,\$nombre,\$tipo,\$x_troncal,\$x_ring1,\$x_ring2,\$x_pref,\$x_grab);
          while($sth->fetch()) { $cose_id[$q]=$id;  $cose_nombre[$q]=$nombre; $cose_tipo[$q]=$tipo;$cose_x_troncal[$q]=$x_troncal;$cose_x_ring1[$q]=$x_ring1;$cose_x_ring2[$q]=$x_ring2;$cose_x_pref[$q]=$x_pref;$cose_x_grab[$q]=$x_grab;}
          $query = "INSERT INTO predictivo.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,audio,troncal,timbrado1,timbrado2,prefijo,grabacion,tregistro) values ('@aval_ori[$k]', '@aval_age[$k]','$aval_gru[$k]', '$aval_des[$k]',0,0,4,now(),0,CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$cose_x_troncal[$q]', $cose_x_ring1[$q],$cose_x_ring2[$q],'$cose_x_pref[$q]',$cose_x_grab[$q],@aval_ges[$k])";
             print "INSERT INTO predictivo.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,audio,troncal,timbrado1,timbrado2,prefijo,grabacion,tregistro) values ('@aval_ori[$k]', '@aval_age[$k]','$aval_gru[$k]', '$aval_des[$k]',0,0,4,now(),0,CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$cose_x_troncal[$q]', $cose_x_ring1[$q],$cose_x_ring2[$q],'$cose_x_pref[$q]',$cose_x_grab[$q],@aval_ges[$k])";
          $sth = $dbh->prepare($query);  $sth->execute();
          print "Llamada lanzada 10\n";
                              }
        #ver(11)
        if($aval_acc[$k]=="11"){ print "Vista lanzada\n";}
        #DIALPAD_GESTION(1)
        if($aval_acc[$k]=="12"){ #/system("php5-cgi -q /opt/seven777/PROC.php canal='@aval_can[$k]' &"); print "Reallamada lanzada\n";
          $audio="DIALPADG-".$aval_ori[$k]."-".$aval_des[$k]."-A_".$aval_age[$k]."-C".$aval_gru[$k]."-"; 
          # obtiene parametros de telefonia
          $query = "SELECT id, nombre,tipo,troncal,timbrado1,timbrado2,prefijo,grabacion FROM campania WHERE estado =1 ORDER BY tipo ASC";
          $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$id,\$nombre,\$tipo,\$x_troncal,\$x_ring1,\$x_ring2,\$x_pref,\$x_grab);
          while($sth->fetch()) { $cose_id[$q]=$id;  $cose_nombre[$q]=$nombre; $cose_tipo[$q]=$tipo;$cose_x_troncal[$q]=$x_troncal;$cose_x_ring1[$q]=$x_ring1;$cose_x_ring2[$q]=$x_ring2;$cose_x_pref[$q]=$x_pref;$cose_x_grab[$q]=$x_grab;}
          if($cose_x_ring1[$q]==""){$cose_x_ring1[$q]=0;} if($cose_x_ring2[$q]==""){$cose_x_ring2[$q]=0;}if($cose_x_grab[$q]==""){$cose_x_grab[$q]=0;}
          # obtiene datos de gestion
          $query = "SELECT g_id1,g_id2,g_id3,g_id4,g_id5,g_id6,g_id7,g_id8,g_id9,g_id10 FROM ajx_pro_bas where bi01=$aval_bas[$k]";$sth = $dbh->prepare($query);$sth->execute(); 
          $sth->bind_columns(\$val_id1,\$val_id2,\$val_id3,\$val_id4,\$val_id5,\$val_id6,\$val_id7,\$val_id8,\$val_id9,\$val_id10);
          while($sth->fetch()) { @aval_id1[$k]=$val_id1; @aval_id2[$k]=$val_id2; @aval_id3[$k]=$val_id3;@aval_id4[$k]=$val_id4;@aval_id5[$k]=$val_id5;@aval_id6[$k]=$val_id6;@aval_id7[$k]=$val_id7;@aval_id8[$k]=$val_id8;@aval_id9[$k]=$val_id9;@aval_id10[$k]=$val_id10;}
          # inserta llamada
          $query = "INSERT INTO predictivo.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,audio,troncal,timbrado1,timbrado2,prefijo,grabacion,gestion_editid1,gestion_editid3,gestion_editid4,gestion_editid5,gestion_editid6,gestion_editid7,gestion_editid8,gestion_editid9,gestion_editid10,tregistro,gestion_editid2) values ('@aval_ori[$k]', '@aval_age[$k]','$aval_gru[$k]', '$aval_des[$k]',0,0,4,now(),0,CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$cose_x_troncal[$f]', $cose_x_ring1[$f],$cose_x_ring2[$f],'$cose_x_pref[$f]',$cose_x_grab[$f],'$aval_id1[$k]', '$aval_id3[$k]','$aval_id4[$k]','$aval_id5[$k]','$aval_id6[$k]', '$aval_id7[$k]','$aval_id8[$k]','$aval_id9[$k]','$aval_id10[$k]',$aval_bas[$k],'$aval_ncli[$k]')";
           print "\nINSERT INTO predictivo.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,audio,troncal,timbrado1,timbrado2,prefijo,grabacion,gestion_editid1,gestion_editid3,gestion_editid4,gestion_editid5,gestion_editid6,gestion_editid7,gestion_editid8,gestion_editid9,gestion_editid10,tregistro,gestion_editid2) values ('@aval_ori[$k]', '@aval_age[$k]','$aval_gru[$k]', '$aval_des[$k]',0,0,4,now(),0,CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$cose_x_troncal[$f]', $cose_x_ring1[$f],$cose_x_ring2[$f],'$cose_x_pref[$f]',$cose_x_grab[$f],'$aval_id1[$k]', '$aval_id3[$k]','$aval_id4[$k]','$aval_id5[$k]','$aval_id6[$k]', '$aval_id7[$k]','$aval_id8[$k]','$aval_id9[$k]','$aval_id10[$k]',$aval_bas[$k],'$aval_ncli[$k]')";
          $sth = $dbh->prepare($query);  $sth->execute();
          print "\nLlamada lanzada 1\n";
                              }
        #susurro cliente(13)
        if($aval_acc[$k]=="13"){ 
        $query = "SELECT llam_uniqueid from ajx_pro_lla where id_ori_llamadas=$aval_lla[$k]";
         $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$val_unilla); while($sth->fetch()) { $uniid=$val_unilla;}
          #quita llamada al cliente y se la pasa al manager
          system("php5-cgi -q /opt/xien/seven/PROC_MOVEDOR_CLI.php canal='@aval_can[$k]' sup='@aval_des[$k]' uniq='$uniid' &");
          print "jala llamada ($uniid)($aval_lla[$k])\n";
                                 }
			 }
    $sth->finish();$dbh->disconnect;
    return(1);
}

