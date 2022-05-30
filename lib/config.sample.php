<?php
/*
  config.php
*/
$strTitle     = "GPS-Trackverwaltung";
$db_server = "localhost";
$db_user   = "gps";
$db_passwd = "yourpassword";
$db =  "gpsdb";
$strUploaddir = "/var/www/html/gpx-files/";


try {
   $pdo = new PDO('mysql:host='.$db_server.';dbname='.$db.';charset=utf8mb4', $db_user, $db_passwd);
} catch (PDOException $e) {echo "Fehler: ".$e->getMessage();  die();}

$numStart=2022;