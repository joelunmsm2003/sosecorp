#!/usr/bin/perl

do{
     system("php-cgi -q '/var/www/html/xien1/PROC_ACD.php'");
     sleep 3;
} while(1);
