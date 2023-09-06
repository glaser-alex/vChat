<!--
    Autor: Alex Glaser
    erstellt am: 28.03.2023
-->

<?php
setcookie( 'username', null, time() - 3600, '/');
session_start();
session_destroy();
header("Location: ../index.php");
?>