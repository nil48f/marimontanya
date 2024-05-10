<!DOCTYPE html>
<html lang="cat">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Mar i montanya</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<!--
    docker exec -it MongoDB_M09 mongosh
    db.usuarios.insertOne({nombre:'Nil Balaguer',contrasenya:'1234',email:'nilbalaguer@gmail.com',tlf:'69976234',naixement:'08/07/2005',comarca:'Barcelona'})
-->
<body id="grid">
    <div id="leftheader">
        <img src="images/logo.webp" width="50%">
    </div>
    <header id="imgbanner">
        <div id="cajadebusqueda">
            <img src="images/banner.png" width="50%">
            <form method="post" action="buscar.php">
                <input type="textarea" name="textobusqueda" placeholder="Buscar">
                <select name="filtro">
                    <option value="nombre">Usuari Nom</option>
                    <option value="email">Usuari Email</option>
                    <option value="pub">Publicacion</option>
                </select>
                <label for="submitbusqueda"><img src="images/lupa.png" id="botondebusqueda" alt="Buscar" width="30px" height="30px"></label>
                <input id="submitbusqueda" type="submit" hidden value="Enviar">
            </form>
        </div>
    </header>
    <?php
        //PHP para comprobar las cookies
        if (!isset($_COOKIE['LaCookie'])) {
            echo "
            <dialog id=\"myDialog\">
                <p>Politica de Cookies</p>
                <form method=\"post\"><input hidden name=\"aceptando\" value=\"acceptar\"><input type=\"submit\" value=\"Acceptar\"></form>
                <button id=\"closeDialog\">No Acceptar</button>
            </dialog>

            <script>
                //JavaScript para ventana emergente de cookies
                const dialog = document.getElementById('myDialog');
                const closeDialogButton = document.getElementById('closeDialog');

                closeDialogButton.addEventListener('click', function() {
                    dialog.close();
                });

                window.addEventListener('load', function() {
                    dialog.showModal();
                });
            </script>
            ";

            if (isset($_POST['aceptando'])) {
                setcookie("LaCookie", "valor cookie", time() + (100));
                
                
                header('location:index.php');
            }
        }
        
    ?>
    <section id="leftmenu">
        <div>
            <a href="index.php"><img src="images/home.png"></a>
        </div>
        <div>
            <a href="login.html"><img src="images/login.png"></a>
        </div>
        <div>
            <a href="perfil.php"><img src="images/perfil.png"></a>
        </div>
    </section>
    <?php
        require("protection.php");
        require 'vendor/autoload.php';//Incluye composer

        if (isset($_POST['pub_likeid'])) {
            $cliente = new MongoDB\Client("mongodb://localhost:27017");

            //echo $cliente;

            $db = $cliente->DAW1; //Base de datos
            $coleccion = $db->publicaciones; //Coleccion, tablas

            $coleccion->updateOne(
                [ 'id' => $_POST['pub_likeid'] ],
                [ '$inc' => [ 'likes' => 1 ] ]
            );
        }
    ?>
    <section id="divpublicaciones">
        <?php
            //Base de dades

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
                echo "<form method=\"post\"><input name=\"pub_likeid\" value=\"".$cosa['id']."\" type=\"hidden\"><input type=\"submit\" value=\"Like ".$cosa['autor']."\"></form>";
                echo "</div>
                </div>";
            }

            $cliente = new MongoDB\Client("mongodb://localhost:27017");

            //echo $cliente;

            $db = $cliente->DAW1; //Base de datos
            $coleccion = $db->publicaciones; //Coleccion, tablas

            //echo $db."<br>";
            //echo $coleccion."<br>";

            //Recuprear
            $resultado = $coleccion->find();
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
        ?>
    </section>
    <div id="leftfooter">
        <a href="politques.html">Politiques<br>i<br>Privacitat</a>
    </div>
    <footer>
        <div>
            <p>Copyright 2024 &#169; Mar i Montanya <br> Tots els drets reservats</p>
        </div>
        <div>
            <a href="crearPublicacio.php">Crear Publicacio</a>
        </div>
    </footer>
</body>
</html>
