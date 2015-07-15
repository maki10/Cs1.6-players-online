<?php
session_start();
include "function.php";
// Number of player

$masina="127.0.0.1"; // ip adress
$user['port']="27070"; // Port of you game

$igraci = cs_scan("$masina", "$user[port]"); //one server

echo "<li style=\"margin-left: 10px;\">Ime servera: <li id=\"rezultat\">".$igraci['hostname']."</li></li>"; //Host name
echo "<li style=\"margin-left: 10px;\">Trenutna Mapa: <li id=\"rezultat\">".$igraci['mapname']."</li></li>"; //Map name
echo "<li style=\"margin-left: 10px;\">Broj Igraca: <li id=\"rezultat\">".$server['players']."/".$server['maxplayers']."</li></li>"; //Players on server
?>
