<?php

require_once('MySQLDB.php');

$host = 'localhost' ;
$dbUser ='root';
$dbPass ='';
$dbName ='disscussionforum';


$db = new MySQL( $host, $dbUser, $dbPass, $dbName ) ;
$db->selectDatabase();

