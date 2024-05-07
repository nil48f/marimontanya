<!DOCTYPE html>
<html lang="cat">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mar I Montanya - Perfil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="bodyPerfil">
    <?php
        require("protection.php");
        require 'vendor/autoload.php';//Incluye composer

        if (isset($_POST['pub_delid'])) {
            //Base de dades

            $cliente = new MongoDB\Client("mongodb://localhost:27017");

            //echo $cliente;

            $db = $cliente->DAW1; //Base de datos
            $coleccion = $db->publicaciones; //Coleccion, tablas

            $resultado = $coleccion->find();
            $contador = 0;
            $usuarios = [];
            foreach ($resultado as $doc) {
                $usuarios[$contador] = $doc['id'];
                $contador += 1;
            }

            echo $_POST['pub_delid'];
            //Insertar Datos
            $coleccion->deleteOne(['id' => $_POST['pub_delid']]);
        }
        
    ?>
    <div id="perfilgrid">
        <div>
            <h1><?php echo $_SESSION['usuari_nom'];?></h1>
        </div>
        <div>
            <a class="linkprofile" href="index.php">Home</a>
            <a class="linkprofile" href="logout.php">Tanca Sesio</a>
        </div>
        <div id="informacionPerfil">
            <div id="imagenPerfil">
                <?php
                    $coso = $_SESSION['usuari_foto'];
                    echo "<img src=\"images/perfil/" . $coso . "\"alt=\"Siusplau Afegeixi foto de perfil\">";
                ?>
            </div>
            <p>Email: <?php echo $_SESSION['usuari_mail'];?></p>
            <p>Tel: <?php echo $_SESSION['usuari_tlf'];?></p>
            <p>Naixement: <?php echo $_SESSION['usuari_naixement'];?></p>
            <p>Comarca: <?php echo $_SESSION['usuari_comarca'];?></p>
        </div>
        <div>
            <h2>Publicacions Recents</h2>
            <section id="divpublicaciones">
                <?php
                    //Base de dades

                    $cliente = new MongoDB\Client("mongodb://localhost:27017");

                    //echo $cliente;

                    $db = $cliente->DAW1; //Base de datos
                    $coleccion = $db->publicaciones; //Coleccion, tablas

                    //echo $db."<br>";
                    //echo $coleccion."<br>";

                    //Recuprear
                    $resultado = $coleccion->find(['autor' => $_SESSION['usuari_mail']]);
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
                    //var_dump($resultado);
                    //Fin de base de datos
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
                        echo $cosa['desc'];
                        echo "<form method=\"post\"><input name=\"pub_delid\" value=\"".$cosa['id']."\" type=\"hidden\"><input type=\"submit\" value=\"Borrar\"></form>";
                        echo "<form method=\"post\" action=\"editpub.php\"><input name=\"pub_editid\" value=\"".$cosa['id']."\" type=\"hidden\"><input type=\"submit\" value=\"Editar\"></form>";
                        echo "</div>
                        </div>";
                    }
                ?>
            </section>
        </div>
    </div>
</body>
</html>