#!/usr/bin/perl

use DBI;
do{

    registros();
    sleep 3;
}while(1);


sub registros()
{
    @aval_dip="";    @aval_num="";    @aval_id="";    @aval_tip="";    @aval_ane="";    @aval_acc="";    @aval_cam="";
    @aval_treg="";
    @aval_id1="";@aval_id2="";@aval_id3=""; @aval_id4=""; @aval_id5="";
    @aval_id6="";@aval_id7="";@aval_id8=""; @aval_id9=""; @aval_id10="";
#    print "----------INICIO-REGISTROS---------------\n";#print $var_campana."\n"; print $var_llamadas."\n";
     $db="predictivo";$host="localhost";$userid='root';$passwd='d4t4B4$3P3C4ll*';$connectionInfo="dbi:mysql:$db;$host";$dbh = DBI->connect($connectionInfo,$userid,$passwd);
#    $db="seven";$host="localhost";$userid='root';$passwd='s3rv3r';$connectionInfo="dbi:mysql:$db;$host";$dbh = DBI->connect($connectionInfo,$userid,$passwd);
    ($seg, $min, $hora, $dia, $mes, $anho, @zape) = localtime(time);$mes++;$anho+=1900;$dia="0".$dia if(length($dia)==1);$mes="0".$mes if(length($mes)==1);$fecha_actual= "$anho-$mes-$dia";
    $i=1;
    $query = "SELECT audio,age_ip,llam_numero,id_ori_llamadas,tipo,age_codigo,cam_codigo,tregistro,gestion_editid1,gestion_editid2,gestion_editid3,gestion_editid4,gestion_editid5,gestion_editid6,gestion_editid7,gestion_editid8,gestion_editid9,gestion_editid10,troncal,timbrado1,timbrado2,prefijo,grabacion,ajx_pro_lla.sql FROM ajx_pro_lla where llam_flag=0 and ajx_pro_lla.sql < 5";
    $sth = $dbh->prepare($query);$sth->execute(); $sth->bind_columns(\$val_audio,\$val_dip,\$val_num,\$val_id,\$val_tip,\$val_acc,\$val_cam,\$val_treg,\$val_id1,\$val_id2,\$val_id3,\$val_id4,\$val_id5,\$val_id6,\$val_id7,\$val_id8,\$val_id9,\$val_id10,\$x_troncal,\$x_ring1,\$x_ring2,\$x_pref,\$x_grab,\$val_sql);
    while($sth->fetch()) {
		        @aval_audio[$i]=$val_audio; @aval_dip[$i]=$val_dip; @aval_num[$i]=$val_num; @aval_id[$i]=$val_id; @aval_tip[$i]=$val_tip; @aval_acc[$i]=$val_acc; @aval_cam[$i]=$val_cam; @aval_treg[$i]=$val_treg; 
		        @aval_id1[$i]=$val_id1, @aval_id2[$i]=$val_id2,@aval_id3[$i]=$val_id3;@aval_id4[$i]=$val_id4;@aval_id5[$i]=$val_id5;@aval_id6[$i]=$val_id6;@aval_id7[$i]=$val_id7;@aval_id8[$i]=$val_id8;@aval_id9[$i]=$val_id9;@aval_id10[$i]=$val_id10;
                @cose_x_troncal[$i]=$x_troncal;@cose_x_ring1[$i]=$x_ring1;@cose_x_ring2[$i]=$x_ring2;@cose_x_pref[$i]=$x_pref;@cose_x_grab[$i]=$x_grab;
                @aval_sql[$i]=$val_sql+1;
		        $i++;
			             }
    for($k=1;$k<$i;$k++){
                $val_ane=$aval_dip[$k];
                #$naudio=$aval_id[$k]."_".$aval_num[$k]."_".$val_ane."_".$aval_acc[$k]."_".$aval_cam[$k]."_".$aval_treg[$k];
#                $query = "UPDATE ajx_pro_lla SET llam_flag=1,f_llam_discador=now(),ajx_pro_lla.sql=$aval_sql[$k] WHERE id_ori_llamadas='@aval_id[$k]'";$sth = $dbh->prepare($query);  $sth->execute();
                $query = "UPDATE ajx_pro_lla SET llam_flag=1,f_llam_discador=now(),ajx_pro_lla.sql=$aval_sql[$k], anexo=@aval_tip[$k], id_ori_seg_cola=@aval_cam[$k] WHERE id_ori_llamadas='@aval_id[$k]'";$sth = $dbh->prepare($query);  $sth->execute();
                #$query = "UPDATE traAgen SET audio='$naudio' WHERE id_ori_usuario='$aval_acc[$k]'";$sth = $dbh->prepare($query);  $sth->execute();
                system("php5-cgi -q /opt/XA_VOIP/PROC_LLAMADOR.php id=@aval_id[$k] num=@aval_num[$k] ane=$val_ane tipo=@aval_tip[$k] acc=@aval_acc[$k] cam=@aval_cam[$k] treg=@aval_treg[$k] id1='$aval_id1[$k]' id2='$aval_id2[$k]' id3='$aval_id3[$k]' id4='$aval_id4[$k]' id5='$aval_id5[$k]' id6='$aval_id6[$k]' id7='$aval_id7[$k]' id8='$aval_id8[$k]' id9='$aval_id9[$k]' id10='$aval_id10[$k]' x_troncal='$cose_x_troncal[$k]' x_ring1=$cose_x_ring1[$k] x_ring2=$cose_x_ring2[$k] x_pref='$cose_x_pref[$k]' x_grab=$cose_x_grab[$k] audio=$aval_audio[$k] vuelta=$aval_sql[$k] &");
                print  "php5-cgi -q /opt/XA_VOIP/PROC_LLAMADOR.php id=@aval_id[$k] num=@aval_num[$k] ane=$val_ane tipo=@aval_tip[$k] acc=@aval_acc[$k] cam=@aval_cam[$k] treg=@aval_treg[$k] id1='$aval_id1[$k]' id2='$aval_id2[$k]' id3='$aval_id3[$k]' id4='$aval_id4[$k]' id5='$aval_id5[$k]' id6='$aval_id6[$k]' id7='$aval_id7[$k]' id8='$aval_id8[$k]' id9='$aval_id9[$k]' id10='$aval_id10[$k]' x_troncal='$cose_x_troncal[$k]' x_ring1=$cose_x_ring1[$k] x_ring2=$cose_x_ring2[$k] x_pref='$cose_x_pref[$k]' x_grab=$cose_x_grab[$k] audio=$aval_audio[$k] vuelta=$aval_sql[$k] &";
			             }
    $sth->finish();$dbh->disconnect;
#    print "::Salio del bucle::\n";
    return(1);
}