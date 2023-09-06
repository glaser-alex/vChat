 <!--
    Autor: Alex Glaser
    erstellt am: 28.03.2023
-->

<!DOCTYPE html>
 <html lang="de">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/loginTabelle.css">
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Togin Tabelle</title>
    <style>
      body {
        width: fit-content !important;
        margin: 30px auto !important;
        padding: 30px !important;
      }
    </style>
 </head>
 <body>
    <!-- ***************************** loginUser Tabelle *****************************  -->
    <?php
        if (!isset($_GET['check'])) {
            header("Location: ./index.php");
        }
        include("../inc/db_init.php");

        $sql = "SELECT * FROM alexglaserLogin";
        $erg = mysqli_query($link, $sql);
        $anzahl = mysqli_affected_rows($link);
        if ($anzahl == 0) {
            echo "<h3 style='color: red;'>Keine Datensätze gefunden</h3>";
        } else {
            echo "<table>
                    <tr>
                    <h1 style='font-size: 30px;'>Ausgabe der Login Tabelle</h1>
                    </tr>
                    <tr>
                        <td><b>Username</b></td>
                        <td><b>Password</b></td>
                    </tr>";
            $fetch = mysqli_query($link, $sql);
            while($fetch_anzahl = mysqli_fetch_assoc($fetch)) {
            echo '<tr>
                <td>'.$fetch_anzahl['username'].'</td>
                <td>'.$fetch_anzahl['pwd'].'</td>
                </tr>';
            }
            echo '</table>';
        }
    ?>
</body>
</html>