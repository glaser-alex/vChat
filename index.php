<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" href="./css/style.css" type="text/css"> -->
  <link rel="shortcut icon" href="./img/flower.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>vChat ❀</title>
  <style>
        @font-face {
            font-family: Ubuntu;
            src: url(../font/Ubuntu/Ubuntu-Light.ttf);
        }
        *{
          box-sizing: border-box;
          -moz-box-sizing: border-box;
          -webkit-box-sizing: border-box;
        }
        html {
            width: 100%;
            height: 100%;
            font-family: Ubuntu, Arial, sans-serif;
            font-style: normal;
        }
        .the-box {
            width: 100%;
            text-align: center;
            position: absolute; left: 50%; top: 50%;
            transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }
        .the-title {
            padding: 5px;
            font-size: 3em;
            text-align: center;
        }
        .link {
          padding: 15px;
          margin: 0 10px;
          text-decoration: none;
        }
        .zurück {
          cursor: pointer;
          color: #fff;
          font-weight: bold;
          background-color: #000;
        }
        .cookie-reset {
          color: white;
          background-color: #009c00;
        }
        .top-nav {
          display: none;
        }
        @media only screen and (max-width: 900px) {
          .the-title {
            font-size: xx-large;
          }
        }
        @media only screen and (max-width: 500px) {
          .the-title {
            font-size: large;
          }
        }
    </style>
</head> 
<body>
<?php
    if ($_COOKIE['username'] != 'admin' && $_COOKIE['username'] != 'valentina') {
      if ($_COOKIE['username'] == "") { header('Location: ./login'); }
      echo "<div class='the-box'>";
      echo "<div class='the-title'>Sie haben keine Berechtigung</div>";
      echo "<br><a class='link zurück' onclick='history.back()'>Zurück</a>";
      echo "</div>";
    } else {
      header("Location: ./chat.php");
    }
?>
</body>
</html>