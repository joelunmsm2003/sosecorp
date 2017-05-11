#!/usr/bin/perl

use DBI;
do{
    registros();
    sleep 3;
   }while(1);

sub registros()
{
 $db="predictivo";$host="localhost";$userid='root';$passwd='d4t4B4$3*';$connectionInfo="dbi:mysql:$db;$host";$dbh = DBI->connect($connectionInfo,$userid,$passwd);
 ($seg, $min, $hora, $dia, $mes, $anho, @zape) = localtime(time);$mes++;$anho+=1900;$dia="0".$dia if(length($dia)==1);$mes="0".$mes if(length($mes)==1);$fecha_actual= "$anho-$mes-$dia";
 $q=0;$w=0;             # COSEG
 $e=0;$r=0;$r1=0;$t=0;  # IN
 $d=0;$f=0;$f1=0;       # OUT
#----------------------------VERIFICA SI FILTRO ESTA ACTIVA status=0 y obtiene colas--------------------------------------------------------------------------------
print "\n\n\n-----------------------------------------INICIO-------------------------------------------------------------\n";

 $query = "SELECT id,campania,ciudad,segmento,grupo,resultado,status  FROM filtro WHERE status=0 ORDER BY campania ASC";
 # id, nombre,tipo,discado,factor,troncal,timbrado1,timbrado2,prefijo,grabacion,t1,t2,t3,htinicio,htfin FROM campania WHERE status=1 ORDER BY tipo ASC";
 $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$id,\$camp,\$ciud,\$segm,\$grup,\$resu,\$stat);
 while($sth->fetch()) { $id[$q]=$id;  $camp[$q]=$camp; $ciud[$q]=$ciud;$segm[$q]=$segm;$grup[$q]=$grup;$resu[$q]=$resu;$stat[$q]=$stat;
                        print "N:(".$camp[$q].")ID:(".$id[$q].")S:(".$segm[$q].")G:(".$grup[$q].")R:(".$resu[$q].")S:(".$stat[$q].")\n";
                        $q++;}

#--------------------------------------VERIFICA SI HAY AGENTES DISPONIBLES---------------------------------------------------
 for($w=0;$w<$q;$w++){
         $d=0;
         $query = "SELECT b.anexo,a.agente,a.campania FROM agentescampanias a LEFT JOIN agentes b on a.agente=b.id WHERE  b.estado=2 and b.anexo<>'' and b.est_ag_predictivo=0 and a.campania=$camp[$w]"; # and a.tipo_asig=2";
         #print "($query)";
         $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$val_dip,\$val_idtrab,\$val_cartera);
         while($sth->fetch()) { @aval_dip[$d]=$val_dip;@aval_idtrab[$d]=$val_idtrab;@actual_cartera[$d]=$cose_id[$w];
                                print "AGENTE___".$d." - AGEN:".$val_idtrab."-CAMP:".$val_cartera."-ANEX:".$val_dip."\n";$d++;}
#                print "Entra a registros\n";

#--------------------------------------BUSCA REGISTROS EN BASE--------------------------------------------------------------
         for($f=0;$f<$d;$f++){
#            $query = "SELECT base.campana,base.id,base.TelefonoMarcado2,base.agente,idservicio,servicio,carteraempresa.privilegio,carteraempresa.id,carteraempresa.cartera,codigo,carteraempresa.empresa,idtelefono FROM predictivo.base, predictivo.carteraempresa where base.status=0 AND base.campana=$cose_id[$w] AND base.ProFlag=0 and base.ProEstado=0 AND base.FiltroHdeC=0 ORDER by base.id ASC LIMIT 1"; $sth = $dbh->prepare($query);$sth->execute(); 
            $query = "SELECT campania, id, telefono, agEnte FROM base WHERE status=0 AND campania =61 AND ProFlag =0 AND ProEstado =0 AND FiltroHdeC =0 ORDER BY id ASC LIMIT 1"; $sth = $dbh->prepare($query);$sth->execute(); 

            $sth->bind_columns(\$val_campana,\$val_tregistro,\$val_tt1,\$val_agente,\$val_orden,\$val_servicio,\$val_privilegio,\$val_idcliente_cartera,\$val_idcartera,\$val_codigo,\$val_idcliente,\$val_idtelefono,\$val_id1,\$val_id2,\$val_id3,\$val_id4,\$val_id5,\$val_id6,\$val_id7,\$val_id8,\$val_id9,\$val_id10);
            print "($query)\n";
            while($sth->fetch()) { 
              @aval_id1[$i]=$val_id1, @aval_id2[$i]=$val_id2,@aval_id3[$i]=$val_id3;@aval_id4[$i]=$val_id4;@aval_id5[$i]=$val_id5;@aval_id6[$i]=$val_id6;@aval_id7[$i]=$val_id7;@aval_id8[$i]=$val_id8;@aval_id9[$i]=$val_id9;@aval_id10[$i]=$val_id10;
              @aval_tproyecto[$f]=$val_campana; @aval_tregistro[$f]=$val_tregistro;@aval_tt1[$f]=$val_tt1;@aval_idusuario[$f]=$val_idtrab;
              @aval_privilegio[$f]=$val_privilegio;@aval_idcartera[$f]=$val_idcartera;@aval_codigo[$f]=$val_codigo;@aval_idcliente[$f]=$val_idcliente;
              @aval_idtelefono[$f]=$val_idtelefono;         

              @aval_x_troncal[$f]=$cose_x_troncal[$w];@aval_x_ring1[$f]=$cose_x_ring1[$w];@aval_x_ring2[$f]=$cose_x_ring2[$w];@aval_x_pref[$f]=$cose_x_pref[$w];@aval_x_grab[$f]=$cose_x_grab[$w];
                                 }
            if($aval_tt1[$f]!=''){ $s_cart[$f]=1;}
            print "REGISTRO_".$f." - CAMP:".$aval_tproyecto[$f]."-TREG:".$aval_tregistro[$f]."-GRUP:".$aval_idcartera[$f]."-TELE:".$aval_tt1[$f]."\n";
                               } # fin del for BUSCA REGISTROS
#                print "Sale de registros\n";
#--------------------------------------ACTUALIZA-Y-ENVIA REGISTROS AL LLAMADOR---------------------------------------------------
         for($f=0;$f<$d;$f++){
            if($s_cart[$f]=='1'){
              print "DISCADO__".$f." - CAMP:".$aval_tproyecto[$f]."-TREG:".$aval_tregistro[$f]."-GRUP:".$aval_idcartera[$f]."-TELE:".$aval_tt1[$f]."-AGEN:".$aval_idtrab[$f]."-ANEX:".$aval_dip[$f]."\n";
              $audio=$aval_id4[$f]."-".$aval_tt1[$f]."-";
#              $query = "INSERT INTO predictivo.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,tregistro,gestion_editid1,gestion_editid2,gestion_editid3,gestion_editid4,gestion_editid5,gestion_editid6,gestion_editid7,gestion_editid8,gestion_editid9,gestion_editid10,audio,troncal,timbrado1,timbrado2,prefijo,grabacion) values ('@aval_dip[$f]', '@aval_idtrab[$f]','$actual_cartera[$f]', '$aval_tt1[$f]',0,0,1,now(),0,'$aval_tregistro[$f]','$aval_id1[$f]', '$aval_id2[$f]','$aval_id3[$f]','$aval_id4[$f]','$aval_id5[$f]','$aval_id6[$f]', '$aval_id7[$f]','$aval_id8[$f]','$aval_id9[$f]','$aval_id10[$f]',CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$aval_x_troncal[$f]', '$aval_x_ring1[$f]','$aval_x_ring2[$f]','$aval_x_pref[$f]','$aval_x_grab[$f]')";
              print    "INSERT INTO predictivo.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,tregistro,gestion_editid1,gestion_editid2,gestion_editid3,gestion_editid4,gestion_editid5,gestion_editid6,gestion_editid7,gestion_editid8,gestion_editid9,gestion_editid10,audio,troncal,timbrado1,timbrado2,prefijo,grabacion) values ('@aval_dip[$f]', '@aval_idtrab[$f]','$actual_cartera[$f]', '$aval_tt1[$f]',0,0,1,now(),0,'$aval_tregistro[$f]','$aval_id1[$f]', '$aval_id2[$f]','$aval_id3[$f]','$aval_id4[$f]','$aval_id5[$f]','$aval_id6[$f]', '$aval_id7[$f]','$aval_id8[$f]','$aval_id9[$f]','$aval_id10[$f]',CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$aval_x_troncal[$f]', '$aval_x_ring1[$f]','$aval_x_ring2[$f]','$aval_x_pref[$f]','$aval_x_grab[$f]')";
              $sth = $dbh->prepare($query);  $sth->execute();
                               }
                             } # fin del for LANZA REGISTROS
         #print "---------------------------------------SEGMENTO-FIN-($cose_nombre[$w])($cose_id[$w])-----------------------------------------------------------\n";
      #-------------------------------------------------------------------------------------------------------------------------------------------------------        
            } # fin del for
   print "---------------------------------------------FIN---------------------------------------------------------------\n";
   #-------------------------------------------------------------------------------------------------------------------------------------------------------         
   $sth->finish();$dbh->disconnect;
   return(1);
}