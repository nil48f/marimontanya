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
                if (isset($_POST['filtro'])) {
                    
                    require 'vendor/autoload.php';//Incluye composer
                    require 'protection.php';

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
                            $likes = iterator_to_array($cosa['likes']);
                            $userHasLiked = in_array($_SESSION['usuari_mail'], $likes);
                            echo "<div class=\"textoPublicacion\">";
                            echo "<p style=\"font-size: 80%;\">".$cosa['desc']." ".count($likes)." Likes</p>";
                            if (!$userHasLiked) {
                                echo "<form method=\"post\">
                                        <input name=\"pub_likeid\" value=\"".$cosa['id']."\" type=\"hidden\">
                                        <input type=\"submit\" value=\"Like ".$cosa['autor']."\">
                                    </form>";
                            } else {
                                echo "<p style=\"font-size: 70%;\">Ja has donat like a ".$cosa['autor']."</p>";
                            }
                            echo "</div></div>";
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
                    
                } else {
                    echo "S'ha afegit un Like a la publicacio";
                }

                if (isset($_POST['pub_likeid'])) {
                    require("protection.php");
                    require 'vendor/autoload.php';//Incluye composer

                    $cliente = new MongoDB\Client("mongodb://localhost:27017");
                    $db = $cliente->DAW1; // Base de datos
                    $coleccion = $db->publicaciones; // Colección, tablas
                
                    // Buscar la publicación por ID
                    $publicacion = $coleccion->findOne(['id' => $_POST['pub_likeid']]);
                
                    if ($publicacion) {
                        $likes = iterator_to_array($publicacion['likes']); // Convertir BSONArray a array
                
                        if (!in_array($_SESSION['usuari_mail'], $likes)) {
                            // Agregar el correo electrónico del usuario al array de likes
                            $coleccion->updateOne(
                                ['id' => $_POST['pub_likeid']],
                                ['$push' => ['likes' => $_SESSION['usuari_mail']]]
                            );
                        }
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>