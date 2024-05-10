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
                    //Busca a los usuarios por su nombre
                    echo "<h1>Busqueda d'usuaris per nom: ".$_POST['textobusqueda']."</h1>";
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
                    //Busca a los usuarios por su email
                    echo "<h1>Busqueda d'usuaris per Email: ".$_POST['textobusqueda']."</h1>";
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
                } elseif ($_POST['filtro'] == "pub") {
                    //Este Filtro muestra las publicaciones buscandolas por su descripcion/nombre
                    echo "<h1>Busqueda de Publicacions: ".$_POST['textobusqueda']."</h1>";
                    $coleccion = $db->publicaciones;
                    $resultado = $coleccion->find(['desc' => ['$regex' => $_POST['textobusqueda'], '$options' => 'i']]);
                    
                    function ImprimirImagen($cosa) {
                        echo "
                        <div class=\"publicaciones\">
                            <div class=\"fotopublicacion\">
                                <img style=\"border-radius: 30px;\" src=\"images/publicaciones/".$cosa['foto']."\"height=\"250px\" width=\"250px\">
                            </div>
                        ";
                    }
                
                    function ImprimirTexto($cosa) {
                        echo "<div class=\"textoPublicacion\">";
                        echo "<p style=\"font-size: 80%;\">".$cosa['desc']." ".$cosa['likes']." Likes</p>";
                        echo "<p>Autor: ".$cosa['autor']."</p>";
                        echo "</div>
                        </div>";
                    }

                    $contador = 0;
                    $resultado2 = [];
                    foreach ($resultado as $doc) {
                        $contador += 1;
                        $resultado2[$contador] = $doc;
                    }

                    for ($i=0; $i < count($resultado2); $i++) {
                        $cosa = $resultado2[$i+1];
                        ImprimirImagen($cosa);
                        ImprimirTexto($cosa);
                    }
                }
                

            ?>
        </div>
    </div>
</body>
</html>