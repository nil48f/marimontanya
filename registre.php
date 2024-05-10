<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre - Mar i Montanya</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="bodylol">
    <div id="gridregister">
        <div><a href="index.php"><img id="bannerlink" src="images/banner.png" alt="banner de la pagina"></a></div>
        <div>
            <form method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend><h1>Registra't</h1></legend>
                    <label>Nom Complet:</label><br>
                    <input name="nombre" type="text" class="loginformline" required>
                    <br><br>
                    <label>Foto de perfil</label><br>
                    <input name="foto" type="file" class="loginformline" required>
                    <br><br>
                    <label>Correu electronic:</label><br>
                    <input name="email" type="email" class="loginformline" required>
                    <br><br>
                    <label>Clau d'accés:</label><br>
                    <input name="clau" type="password" class="loginformlinepassword" required>
                    <input name="clau2" type="password" class="loginformlinepassword" required placeholder="Confirma La Clau">
                    <br><br>
                    <input type="submit" value="Registra't" id="loginsubmitbutton">
                    <br><br>
                </fieldset>
            </form>
            <p id="registretlink">Ja tens un compte?<a href="login.html"> Inicia Sessio</a></p>
        </div>
    </div>
</body>
</html>
<?php
    if (isset($_POST['nombre']) && ($_POST['clau'] == $_POST['clau2'])) {
        //Base de dades
        require 'vendor/autoload.php';//Incluye composer

        $cliente = new MongoDB\Client("mongodb://localhost:27017");

        //echo $cliente;

        $db = $cliente->DAW1; //Base de datos
        $coleccion = $db->usuarios; //Coleccion, tablas

        $resultado = $coleccion->find();
        echo "<br><br>";
        $contador = 0;
        $usuarios = [];
        foreach ($resultado as $doc) {
            $usuarios[$contador] = $doc['email'];
            $contador += 1;
        }

        $fallo = 0;
        for ($i=0; $i < count($usuarios); $i++) {
            if ($usuarios[$i] == $_POST['email']) {
                $fallo += 1;
            }
        }

        //Insertar Datos
        if ($fallo == 0) {
            //Subir Imagen al servidor
            $directorio_destino = 'images/perfil/';

            $nombre_archivo = basename($_FILES['foto']['name']);

            $ruta_destino = $directorio_destino . $nombre_archivo;

            move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_destino);

            $coleccion->insertOne(['nombre' => $_POST['nombre'], 'contrasenya' => $_POST['clau'], 'email' => $_POST['email'], 'tlf' => '---', 'naixement' => '---', 'comarca' => '---', 'foto' => $_FILES['foto']['name']]);
            //echo "<h2 style=\"color: white; background-color: green\">Conta Creada</h2>";
            echo "<script>alert(\"Conta Creada Correctament\")</script>";
        } else {
            //echo "<h2 style=\"color: white; background-color: red\">AQUEST EMAIL JA ESTA REGISTRAT</h2>";
            echo "<script>alert(\"AQUEST EMAIL JA ESTA REGISTRAT\")</script>";
        }
    } elseif (isset($_POST['clau']) && $_POST['clau'] != $_POST['clau2']) {
        echo "
            <script>
                alert(\"Les Claus No Coincideixen\");
            </script>
        ";
    }
?>