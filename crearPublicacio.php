<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Publicacio - Mar i Montanya</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="bodylol">
    <div id="gridregister">
        <div><a href="index.php"><img id="bannerlink" src="images/banner.png" alt="banner de la pagina"></a></div>
        <div>
            <form method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend><h1>Crea Una Publicacio</h1></legend>
                    <label>Imatge</label><br>
                    <input name="foto" type="file" class="loginformline" required>
                    <br><br>
                    <label>Peu De Foto</label><br>
                    <input name="desc" type="textarea" class="loginformline" maxlength="32" required>
                    <br><br>
                    <input type="submit" value="Crear" id="loginsubmitbutton">
                    <br><br>
                </fieldset>
            </form>
        </div>
    </div>
</body>
</html>
<?php
    require("protection.php");
    if (isset($_FILES['foto'])) {
        //Subir Imagen al servidor
        $directorio_destino = 'images/publicaciones/';

        $nombre_archivo = basename($_FILES['foto']['name']);

        $ruta_destino = $directorio_destino . $nombre_archivo;

        move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_destino);


        //Base de dades
        require 'vendor/autoload.php';//Incluye composer

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
        $coso = ("".(mt_rand())."");

        //Insertar Datos
        $coleccion->insertOne(['id' => ($coso), 'autor' => $_SESSION['usuari_mail'], 'foto' => $_FILES['foto']['name'], 'desc' => $_POST['desc'], 'likes' => []]);
        
    }
?>