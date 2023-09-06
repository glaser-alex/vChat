<!DOCTYPE html>
<!-- 
    Autor: Alexander Glaser
    Erstellt am: 24.06.2023
 -->
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <style>
        @font-face {
            font-family: Ubuntu;
            src: url(../font/Ubuntu/Ubuntu-Light.ttf);
        }
        html {
            width: 100%;
            height: 100%;
            font-family: Ubuntu, Arial, sans-serif;
            font-style: normal;
        }

        .the-box {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }

        .the-title {
            padding: 5px;
            font-size: 3em;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="the-box">
<?php
    if ($_COOKIE['username'] != 'admin') {
        echo "<div class='the-title'>Du hast keine Berechtigung</div>";
    } else {
        if ($_GET['action'] == 'anzeigen') {
            header("Location: ./loginTabelleAnzeigen.php?check=1");
        } else if ($_GET['action'] == 'erstellen') {
            header("Location: ./loginTabelleErstellen.php?check=1");
        } else if ($_GET['action'] == 'einträge') {
            header("Location: ./anmeldungen.txt");
        } else if ($_GET['action'] == 'nachrichten') {
            header("Location: ./message.txt");
        }
        echo "<div class='the-title'>Hallo Alex!<br>Was möchtest du tun?</div>";
        echo "<a style='color: cyan;' href='https://".$_SERVER['SERVER_NAME']."/administration?action=einträge'>Login Einträge</a><br>";
        echo "<a href='https://".$_SERVER['SERVER_NAME']."/administration?action=nachrichten'>Nachrichten</a><br>";
        echo "<a style='color: red;' href='https://".$_SERVER['SERVER_NAME']."/administration?action=erstellen'>Login Tabelle zurücksetzen</a><br>";
        echo "<a style='color: lime;' href='https://".$_SERVER['SERVER_NAME']."/administration?action=anzeigen'>Login Tabelle anzeigen</a>";
    }
?>
</div>
</body>
</html>
