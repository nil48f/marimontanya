<!-- PÀGINA DE VALIDACIÓ DE LES DADES D'USUARI -->
<!-- Aquesta pàgina rep les dades d'usuari de "exemple_session.php" i comprova que siguin vàlides. -->

<?php
//Base de dades
require 'vendor/autoload.php';//Incluye composer

$cliente = new MongoDB\Client("mongodb://localhost:27017");

//echo $cliente;

$db = $cliente->DAW1; //Base de datos
$coleccion = $db->usuarios; //Coleccion, tablas

//echo $db."<br>";
//echo $coleccion."<br>";
//var_dump($coleccion)."<br><br><br>";

//Insertar Datos
//$coleccion->insertOne(['nombre' => 'Pepe']);

//Delete Datos
//$coleccion->deleteOne(['nombre' => 'Pepe']);

//Recuprear
$resultado = $coleccion->find();
echo "<br><br>";
$contador = 0;
$usuarios = [];
$contrasenyas = [];
$resultado2 = [];
foreach ($resultado as $doc) {
    $usuarios[$contador] = $doc['email'];
    $contrasenyas[$contador] = $doc['contrasenya'];
    $contador += 1;
    $resultado2[$contador] = $doc;
}

//var_dump($resultado);
//Fin de base de datos


//Dades d'usuari en un array per l'exemple. Normalment s'obtenen directament d'una Base de Dades.
/*
$usuari["nomusuari"]="admin@gmail.com"; 
$usuari["contrasenya"]="1234";
$usuari["nom"]="ADMIN";
$usuari["telefon"]="699542312";
*/

if(isset($_POST['usuari'], $_POST['contrasenya'])){
    for ($i=0; $i < count($usuarios); $i++) {
        $cosa = $resultado2[$i+1];
        if(($_POST['usuari']==$cosa['email']) and ($_POST['contrasenya']==$cosa['contrasenya'])){ 

            //Executem SESSIÓ per poder guardar variables de SESSIÓ
            session_start();
    
            // Creem la variable de sessió del nom d'usuari. L'ideal si utilitzem Base de Dades seria guardar la id d'usuari també. Podem guardar més dades de l'usuari com el nom, la id o altres variables interessants que poden necessitar durant el que duri la sessió creant tantes variables de SESSIÓ necessitem.
            $_SESSION['usuari_mail']=$_POST['usuari'];
            $_SESSION['usuari_nom']=$cosa["nombre"];
            $_SESSION['usuari_tlf']=$cosa['tlf'];
            $_SESSION['usuari_naixement']=$cosa['naixement'];
            $_SESSION['usuari_comarca']=$cosa['comarca'];
            $_SESSION['usuari_foto']=$cosa['foto'];
            
            //Redirigim a l'usuari a la pàgina "login.php" per accedir informació que només pot veure ell.
            break;
        } else{
            //En cas de no validar-se l'usuari, el redirigim a la pàgina "exemple_session.php" perquè pugui fer login novament.
            echo "<script>alert(\"Correu o Clau d'acces incorrecte\")</script>";
        }
    }
    header("location:perfil.php");
}
?>
