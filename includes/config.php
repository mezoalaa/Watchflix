<?php
ob_start(); // turns on output buffering 
session_start();// 

date_default_timezone_set("Africa/Cairo");


try{

   $con= new PDO("mysql:dbname=watchflex;host=localhost","root","");
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch(PDOException $e){
    exit("connection filed ". $e->getMessage());

} 






?>