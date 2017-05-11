<?php
function Conectarse(){
   	if (!($link=mysql_connect('localhost','root','d4t4B4$3*'))){
      echo "Error conectando a la base de datos.";
      exit();
   	}
   	if (!mysql_select_db('predictivo',$link)){
      echo "Error seleccionando la base de datos.";
      exit();
   	}
   	return $link;
}
?>
