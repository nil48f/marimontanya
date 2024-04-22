<!-- PÀGINA DE VALIDACIÓ DE LES DADES D'USUARI -->
<!-- Aquesta pàgina rep les dades d'usuari de "exemple_session.php" i comprova que siguin vàlides. -->

<?php
//Dades d'usuari en un array per l'exemple. Normalment s'obtenen directament d'una Base de Dades.
$usuari["nomusuari"]="admin@gmail.com"; 
$usuari["contrasenya"]="1234";
$usuari["nom"]="ADMIN";
$usuari["telefon"]="699542312";

if(isset($_POST['usuari'], $_POST['contrasenya'])){ //Comprovem que les dades rebudes per POST existeixen 

    //Comprovem que les dades coincideixen amb les que tenim a l'array o Base de dades.
    if(($_POST['usuari']==$usuari["nomusuari"]) and ($_POST['contrasenya']==$usuari["contrasenya"])){ 

        //Executem SESSIÓ per poder guardar variables de SESSIÓ
        session_start();

        // Creem la variable de sessió del nom d'usuari. L'ideal si utilitzem Base de Dades seria guardar la id d'usuari també. Podem guardar més dades de l'usuari com el nom, la id o altres variables interessants que poden necessitar durant el que duri la sessió creant tantes variables de SESSIÓ necessitem.
        $_SESSION['usuari_mail']=$_POST['usuari'];
        $_SESSION['usuari_nom']=$usuari["nom"];
        $_SESSION['usuari_tlf']=$usuari["telefon"];
        
        //Redirigim a l'usuari a la pàgina "login.php" per accedir informació que només pot veure ell.
        header("location:perfil.php");
    } else{
        //En cas de no validar-se l'usuari, el redirigim a la pàgina "exemple_session.php" perquè pugui fer login novament.
        header("location:login.html"); 
    }
    
}
?>
