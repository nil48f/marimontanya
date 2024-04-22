<?php
//Amb el require requerim que s'executi l'SCRIPT "protection.php" dins la pàgina "compte.php". L'SCRIPT protection.php comprova que la sessió estigui executada i per tant que l'usuari pugui veure aquesta pàgina privada. En cas que la SESSIÓ no estigui executada, l'SCRIPT el redigirà a "exemple_session.php" perquè faci LOGIN novament. 

require("protection.php");
?>
 
<HTML>
 
<head>
<title>LOGIN COMPTE</title>
</head>
 
<body>
<h2>Menú navegació</h2>
<a href="login.html">Pàgina "exemple_session.php"</a><br><br>
<a href="compte.php">Pàgina "compte.php"</a>  

<h2>L'usuari <?php echo $_SESSION['usuari_nom'];?> ha iniciat sessió</h2>

<a href="logout.php">Tancar sessió</a>
    

</body>
</HTML>