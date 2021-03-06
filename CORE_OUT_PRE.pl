#!/usr/bin/perl

use DBI;
do{
    registros();
    sleep 5;
   }while(1);

sub registros()
{
 $db="predictivo";$host="localhost";$userid='root';$passwd='123';$connectionInfo="dbi:mysql:$db;$host";$dbh = DBI->connect($connectionInfo,$userid,$passwd);
 ($seg, $min, $hora, $dia, $mes, $anho, @zape) = localtime(time);$mes++;$anho+=1900;$dia="0".$dia if(length($dia)==1);$mes="0".$mes if(length($mes)==1);$fecha_actual= "$anho-$mes-$dia";
 $q=0;$w=0;             # COSEG
 $e=0;$r=0;$r1=0;$t=0;  # IN
 $d=0;$f=0;$f1=0;       # OUT
 $k=0;
  @id="";@camp="";@aval_dip="";    @aval_num="";    @aval_id="";    @aval_tip="";    @aval_ane="";    @aval_acc="";    @aval_cam=""; @aval_acd="";
  @aval_treg="";@aval_id1="";@aval_id2="";@aval_id3=""; @aval_id4=""; @aval_id5="";@aval_id6="";@aval_id7="";@aval_id8=""; @aval_id9=""; @aval_id10="";
  @aval_tproyecto=""; @aval_tregistro=""; @aval_tt1=""; @aval_idusuario="";@aval_privilegio="";@aval_idcartera="";@aval_codigo="";@aval_idcliente="";
  @aval_idtelefono="";@aval_x_troncal="";@aval_x_ring1="";@aval_x_ring2="";@aval_x_pref="";@aval_x_grab="";@aval_discado=""; @aval_factor="";@aval_idtrab="";
  @actual_cartera="";@aval_Agedisc="";@aval_Agefac="";@s_cart=""; @ciud="";@segm="";@grup="";@resu="";   @ciud1="";@segm1="";@grup1="";@resu1="";
#----------------------------VERIFICA SI FILTRO ESTA ACTIVA status=0 y obtiene colas--------------------------------------------------------------------------------
##print "\n\n\n-----------------------------------------INICIO-------------------------------------------------------------\n";
 $query = "SELECT id,campania,status_f,status_h,status_g,resultado,status,ACD  FROM filtro WHERE status=0 ORDER BY campania ASC";
 $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$id,\$camp,\$ciud,\$segm,\$grup,\$resu,\$stat,\$acd);
 while($sth->fetch()) { 
    my $find = "/";  my $replace = "','"; $find = quotemeta $find; $ciud =~ s/$find/$replace/g;
    my $find = "/";  my $replace = "','"; $find = quotemeta $find; $segm =~ s/$find/$replace/g;
    my $find = "/";  my $replace = "','"; $find = quotemeta $find; $grup =~ s/$find/$replace/g;
    my $find = "/";  my $replace = "','"; $find = quotemeta $find; $resu =~ s/$find/$replace/g;
    $id[$q]=$id;  $camp[$q]=$camp; $ciud[$q]=$ciud;$segm[$q]=$segm;$grup[$q]=$grup;$resu[$q]=$resu;$stat[$q]=$stat;$aval_acd[$q]=$acd;
    ##print "IDcam(".$camp[$q].")IDfil(".$id[$q].")S:(".$segm[$q].")G:(".$grup[$q].")R:(".$resu[$q].")S:(".$stat[$q].")\n"; 
    $q++;
                      }
#----------------------------Obtiene discado y factor por campaña--------------------------------------------------------------------------------
for($w=0;$w<$q;$w++){
         $query = "SELECT discado,factor FROM campania WHERE  id=$camp[$w] AND discado = 2"; 
         $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$val_discado,\$val_factor);
         while($sth->fetch()) { @aval_discado[$w]=$val_discado;@aval_factor[$w]=$val_factor;
                                print "IDCampana_".$camp[$w]." - Discado:".$val_discado."-Factor:".$val_factor."\n";
                                }
                    }
#--------------------------------------CALCULA PENDIENTES-x-CAMPAÑA--------------------------------------------
 for($w=0;$w<$q;$w++){
         $query = "SELECT count(*) FROM agentescampanias a LEFT JOIN agentes b on a.agente=b.id WHERE  b.estado in (2,6) and b.anexo<>'' and (b.est_ag_predictivo=0 OR b.est_ag_predictivo is NULL) and a.campania=$camp[$w]"; 
         #TIMESTAMPDIFF(SECOND,b.tinicioespera,now())>10, TIMESTAMPDIFF(SECOND,b.tiniciogestion,now())>10,
         $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$val_cagentes);
         while($sth->fetch()) { $cagentes=$val_cagentes;}#  print "CANTIDAD_AGENTES_($camp[$w])_=_".$cagentes."\n";}
#         $query = "SELECT ACD FROM filtro WHERE campania=$camp[$w]"; 
#         $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$val_cacd);
#         while($sth->fetch()) { $cacd=$val_cacd; print "CANTIDAD_ACD_($camp[$w])_=_".$cacd."\n";}
         $cacd=0;
         #$query = "SELECT count(*) FROM ajx_pro_lla WHERE cam_codigo=$camp[$w] AND (llam_estado < 2 OR llam_estado is null)"; 
         $query = "SELECT count(*) FROM ajx_pro_lla WHERE cam_codigo=$camp[$w] AND llam_estado in (1,4) AND flagfin=0 AND age_codigo=999"; 
         $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$val_cpro);
         while($sth->fetch()) { $cpro=$val_cpro;  print "CANTIDAD_EN_PROCESO_($camp[$w])_=_".$cpro."\n";}
         $pendientes[$w]=(($cagentes-$cacd)*$aval_factor[$w])-($cpro);if($pendientes[$w]<0){$pendientes[$w]=0;}print "PENDIENTES_($camp[$w])_=_".$pendientes[$w]."\n";
                      }
#--------------------------------------VERIFICA SI HAY AGENTES DISPONIBLES-x-CAMPAÑA--------------------------------------------
 for($w=0;$w<$q;$w++){
         $d=0;
         #$query = "SELECT b.anexo,a.agente,a.campania FROM agentescampanias a LEFT JOIN agentes b on a.agente=b.id WHERE  b.estado=2 and b.anexo<>'' and (b.est_ag_predictivo=0 OR b.est_ag_predictivo is NULL) and a.campania=$camp[$w] and a.ACD=0 LIMIT $pendientes[$w]"; # and a.tipo_asig=2";
         $query = "SELECT b.anexo,a.agente,a.campania FROM agentescampanias a LEFT JOIN agentes b on a.agente=b.id WHERE  b.estado in (2,6) and b.anexo<>'' and (b.est_ag_predictivo=0 OR b.est_ag_predictivo is NULL) and a.campania=$camp[$w] LIMIT 1"; # and a.tipo_asig=2";
         $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$val_dip,\$val_idtrab,\$val_cartera);
         while($sth->fetch()) { @aval_Agedisc[$d]=$aval_discado[$w]; @aval_Agefac[$d]=$aval_factor[$w];
                                if($aval_Agedisc[$d]==2){ #print "entra aca?";
                                  #for($k=0;$k<$aval_factor[$w];$k++){ ##print "-----$k--$aval_Agefac[$d]--$aval_factor[$w]--";
                                  for($k=0;$k<$pendientes[$w];$k++){ ##print "-----$k--$aval_Agefac[$d]--$aval_factor[$w]--";
                                              @aval_Agedisc[$d]=$aval_discado[$w]; @aval_Agefac[$d]=$aval_factor[$w]; $idpre[$d]=$id[$w];
                                              @aval_dip[$d]=$val_cartera;@aval_idtrab[$d]=$val_idtrab;@actual_cartera[$d]=$val_cartera; 
                                              $ciud1[$d]=$ciud[$w];@segm1[$d]=$segm[$w];@grup1[$d]=$grup[$w];@resu1[$d]=$resu[$w];
                                              print "PRED--AGENTE___".$d." - AGEN:".$aval_idtrab[$d]."-CAMP:".$actual_cartera[$d]."-ANEX:".$aval_dip[$d]."-Discado:".$aval_discado[$w]."-Factor:".$aval_factor[$w]."\n";
                                              $d++;                                
                                                                    }
                                                        }
                                ##print "AGENTE___".$d." - AGEN:".$val_idtrab."-CAMP:".$val_cartera."-ANEX:".$val_dip."-Discado:".$aval_discado[$w]."-Factor:".$aval_factor[$w]."-QUERY:".$query."\n";

                              }

#$d=0;
#--------------------------------------BUSCA REGISTROS EN BASE--------------------------------------------------------------
  @aval_treg="";@aval_id1="";@aval_id2="";@aval_id3=""; @aval_id4=""; @aval_id5="";@aval_id6="";@aval_id7="";@aval_id8=""; @aval_id9=""; @aval_id10="";
  @aval_tproyecto=""; @aval_tregistro=""; @aval_tt1=""; @aval_idusuario="";@aval_privilegio="";@aval_idcartera="";@aval_codigo="";@aval_idcliente="";
  @aval_idtelefono="";@s_cart=""; 
         for($f=0;$f<$d;$f++){  print "---registros--------($f)($d)--------\n";
             if($aval_Agedisc[$f]==2){ 
                print "---PrEdIcTiVo--------($f)($d)--------\n";
                $query = "SELECT campania, id, telefono, agEnte,id_cliente FROM base WHERE (status='' or status=0) AND campania ='$actual_cartera[$f]' AND ProFlag is NULL AND ProEstado is NULL AND FiltroHdeC is NULL AND status_f in ('$ciud1[$f]PCALL_NA') AND status_h in ('$segm1[$f]PCALL_NA') AND status_g in ('$grup1[$f]PCALL_NA') AND ( resultadotxt='' OR resultadotxt in ('$resu1[$f]PCALL_NA')) AND blacklist=0 AND bloqueocliente=0 ORDER BY orden ASC, id ASC LIMIT 1"; $sth = $dbh->prepare($query);$sth->execute(); 
                $sth->bind_columns(\$val_campana,\$val_tregistro,\$val_tt1,\$val_agente,\$val_idcliente);
                #print "PRED--($query)\n";
                while($sth->fetch()) { 
                  @aval_id1[$f]=$aval_Agedisc[$f], @aval_id2[$f]=$aval_Agefac[$f];@aval_tproyecto[$f]=$val_campana; @aval_tregistro[$f]=$val_tregistro;@aval_tt1[$f]=$val_tt1;@aval_idusuario[$f]=$val_idtrab;
                  @aval_id3[$i]=$val_id3;@aval_id4[$i]=$val_id4;@aval_id5[$i]=$val_id5;@aval_id6[$i]=$val_id6;@aval_id7[$i]=$val_id7;@aval_id8[$i]=$val_id8;@aval_id9[$i]=$val_id9;@aval_id10[$i]=$val_id10;
                  @aval_privilegio[$f]=$val_privilegio;@aval_idcartera[$f]=$val_idcartera;@aval_codigo[$f]=$val_codigo;@aval_idcliente[$f]=$val_idcliente;
                  if($aval_idcliente[$f]==""){$aval_idcliente[$f]="NA";}
                  @aval_idtelefono[$f]=$val_idtelefono;@aval_x_troncal[$f]=$cose_x_troncal[$w];@aval_x_ring1[$f]=$cose_x_ring1[$w];@aval_x_ring2[$f]=$cose_x_ring2[$w];@aval_x_pref[$f]=$cose_x_pref[$w];@aval_x_grab[$f]=$cose_x_grab[$w];  
                  print "PRED--REGISTRO_".$f." - CAMP:".$aval_tproyecto[$f]."-TREG:".$aval_tregistro[$f]."-GRUP:".$aval_idcartera[$f]."-TELE:".$aval_tt1[$f]."-DISC:".$aval_id1[$f]."-FACT:".$aval_id2[$f]."-ANX:".$aval_dip[$f]."\n";
                  $s_cart[$f]=0;
                  if($aval_tt1[$f]!=''){ $s_cart[$f]=1;}
                                     }
               $query = "UPDATE base SET ProFlag=1 WHERE id='$aval_tregistro[$f]'";$sth = $dbh->prepare($query);  $sth->execute();
               $query = "UPDATE base SET bloqueocliente=1 WHERE id_cliente='$aval_idcliente[$f]'";$sth = $dbh->prepare($query);  $sth->execute();
                                     }
              $s_cart[$f]=0; if($aval_tt1[$f]!=''){ $s_cart[$f]=1;}
                               } # fin del for BUSCA REGISTROS EN BASE
               print "---Saleee de registros($f)($d)($cantPre)-----------------------------\n";
#$d=0;
#--------------------------------------ACTUALIZA-Y-ENVIA REGISTROS AL LLAMADOR---------------------------------------------------
         for($f=0;$f<$d;$f++){
           if($aval_Agedisc[$f]==2){
            if($s_cart[$f]=='1'){
              $aval_idtrab[$f]='999';
              print "PRED--DISCADO__".$f." - CAMP:".$aval_tproyecto[$f]."-TREG:".$aval_tregistro[$f]."-GRUP:".$aval_idcartera[$f]."-TELE:".$aval_tt1[$f]."-AGEN:".$aval_idtrab[$f]."-ANEX:".$aval_dip[$f]."\n";
              $audio=$aval_dip[$f]."-".$aval_tt1[$f]."-";
              $query = "INSERT INTO predictivo.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,tregistro,gestion_editid1,gestion_editid2,gestion_editid3,gestion_editid4,gestion_editid5,gestion_editid6,gestion_editid7,gestion_editid8,gestion_editid9,gestion_editid10,audio,troncal,timbrado1,timbrado2,prefijo,grabacion,filtro,ID_Cliente,v_tring) values ('@aval_dip[$f]', '@aval_idtrab[$f]','$actual_cartera[$f]', '$aval_tt1[$f]',0,0,2,now(),0,'$aval_tregistro[$f]','$aval_id1[$f]', '$aval_id2[$f]','$aval_id3[$f]','$aval_id4[$f]','$aval_id5[$f]','$aval_id6[$f]', '$aval_id7[$f]','$aval_id8[$f]','$aval_id9[$f]','$aval_id10[$f]',CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$aval_x_troncal[$f]', '$aval_x_ring1[$f]','$aval_x_ring2[$f]','$aval_x_pref[$f]','$aval_x_grab[$f]','$idpre[$f]','$aval_idcliente[$f]','999')";
              print    "PRED--INSERT INTO predictivo.ajx_pro_lla (age_ip,age_codigo,cam_codigo,llam_numero,llam_estado,llam_flag,tipo,f_origen,flagFIN,tregistro,gestion_editid1,gestion_editid2,gestion_editid3,gestion_editid4,gestion_editid5,gestion_editid6,gestion_editid7,gestion_editid8,gestion_editid9,gestion_editid10,audio,troncal,timbrado1,timbrado2,prefijo,grabacion,filtro,ID_Cliente) values ('@aval_dip[$f]', '@aval_idtrab[$f]','$actual_cartera[$f]', '$aval_tt1[$f]',0,0,2,now(),0,'$aval_tregistro[$f]','$aval_id1[$f]', '$aval_id2[$f]','$aval_id3[$f]','$aval_id4[$f]','$aval_id5[$f]','$aval_id6[$f]', '$aval_id7[$f]','$aval_id8[$f]','$aval_id9[$f]','$aval_id10[$f]',CONCAT('$audio',DATE_FORMAT(now(),'%Y-%m-%d_%H-%i-%s')),'$aval_x_troncal[$f]', '$aval_x_ring1[$f]','$aval_x_ring2[$f]','$aval_x_pref[$f]','$aval_x_grab[$f]','$id[$f]','$aval_idcliente[$f]')\n";
              $sth = $dbh->prepare($query);  $sth->execute();
              $query = "UPDATE agentes SET est_ag_predictivo=1 WHERE id='$aval_idtrab[$f]'";$sth = $dbh->prepare($query);  $sth->execute();
                               }
                                  } 
                             } # fin del for LANZA REGISTROS
                        } # fin del for
##   print "---------------------------------------------FIN---------------------------------------------------------------\n";
   #-------------------------------------------------------------------------------------------------------------------------------------------------------         
   $sth->finish();$dbh->disconnect;
   return(1);
}

