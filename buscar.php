<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuaris - Mar i Montanya</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="bodylol">
    <div id="gridregister">
        <div><a href="index.php"><img id="bannerlink" src="images/banner.png" alt="banner de la pagina"></a></div>
        <div>
            <?php
                require 'vendor/autoload.php';//Incluye composer

                $cliente = new MongoDB\Client("mongodb://localhost:27017");
                
                $db = $cliente->DAW1; //Base de datos
                $coleccion = $db->usuarios; //Coleccion, tablas

                //Recuprear
                if ($_POST['filtro'] == "nombre") {
                    echo "<h1>Busqueda d'usuaris per nom</h1>";
                    //$resultado = $coleccion->find(['nombre' => $_POST['textobusqueda']]);
                    $resultado = $coleccion->find(['nombre' => ['$regex' => $_POST['textobusqueda'], '$options' => 'i']]);
                    echo "<br><br>";
                    foreach ($resultado as $doc) {
                        echo "<p> Nom d'usuari: ".$doc['nombre']."<br>";
                        echo " Email: ". $doc['email']."<br>";
                        echo " Telefon: ".$doc['tlf']."<br>";
                        echo " Data de naixement: ".$doc['naixement']."<br>";
                        echo " Comarca: ".$doc['comarca']."</p><br>";
                        echo "<img src=\"images/perfil/".$doc['foto']."\" alt=\"sense imatge de perfil\" height=\"300px\" width=\"300px\"><br><hr>";
                    }
                } elseif ($_POST['filtro'] == "email") {
                    echo "<h1>Busqueda d'usuaris per Email</h1>";
                    $resultado = $coleccion->find(['email' => ['$regex' => $_POST['textobusqueda'], '$options' => 'i']]);
                    echo "<br><br>";
                    foreach ($resultado as $doc) {
                        echo "<p> Nom d'usuari: ".$doc['nombre']."<br>";
                        echo " Email: ". $doc['email']."<br>";
                        echo " Telefon: ".$doc['tlf']."<br>";
                        echo " Data de naixement: ".$doc['naixement']."<br>";
                        echo " Comarca: ".$doc['comarca']."</p><br>";
                        echo "<img src=\"images/perfil/".$doc['foto']."\" alt=\"sense imatge de perfil\" height=\"300px\" width=\"300px\"><br><hr>";
                    }
                }
                

            ?>
        </div>
    </div>
</body>
</html>