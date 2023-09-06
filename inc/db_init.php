<!--
    Autor: Alex Glaser
    erstellt am: 28.03.2023
-->

<?php

/******************************** Verbindungsaufbau zur Datenbank ********************************/
	$server="10.35.46.104:3306";
	$user="k208538_alexglaser";
	$pass="uI%4m355x";
	$dbase="k208538_alex_glaser";
	
/* Die MySQLi-Erweiterungen aktivieren - Als Ergebnis wird ein Objekt geliefert,
   worüber bestimmte Grundeinstellungen gleich bei der Server-/Datenbankverbindung
   erfolgen. Diese Methode spart im weiteren Verlauf PHP-Quellcode                 */
$link = mysqli_init();

/* Das Laden externer Daten in eine Tabelle ermöglichen */
mysqli_options($link, MYSQLI_OPT_LOCAL_INFILE, true);

/* Den UTF8-Zeichensatz zur korrekten Darstellung von Umlauten aktivieren */
mysqli_options($link,MYSQLI_INIT_COMMAND,'SET NAMES \'utf8\'');

/* Aufbau der Verbindung zum Datenbankserver */
    if (!$serv_verb = mysqli_real_connect($link, $server, $user, $pass)) {
        echo ("Konnte Verbindung zum Server <b>$server</b> nicht herstellen<br>");
    } else {
        //echo "Verbindung zum Server $server hergestellt.<br>";
    }
    
    $db_erstell="CREATE DATABASE IF NOT EXISTS $dbase";
    if(mysqli_query($link,$db_erstell))
        //echo "Datenbank wurde erstellt, da noch nicht vorhanden<br>";

/* Verbindung mit der Datenbank herstellen */
    if(!$db_verb=mysqli_select_db($link, $dbase)){
        echo ("Konnte Verbindung zur Datenbank <b>$dbase</b> nicht herstellen<br>");
    } else {
       // echo "<div>Verbindung zur Datenbank $dbase hergestellt.<br></div>";

    }

	/* Ausführen einer SQL Anfrage 
	$query = "SELECT * FROM $tab";
	$result = mysqli_query($link,$query) or 
		die("Anfrage fehlgeschlagen: " . mysqli_error($link));
    print_r($result);
*/
?>
