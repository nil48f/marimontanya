<?php
//L'SCRIPT protection.php comprova que la sessió estigui executada i per tant que l'usuari pugui veure aquesta pàgina privada. En cas que la SESSIÓ no estigui executada, l'SCRIPT el redigirà a "exemple_session.php" perquè faci LOGIN novament. 

session_start();

if(!isset($_SESSION['usuari_mail'])){
    header("location:login.html");
}
?>
