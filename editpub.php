<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Publicacio - Mar i Montanya</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="bodylol">
    <div id="gridregister">
        <div><a href="index.php"><img id="bannerlink" src="images/banner.png" alt="banner de la pagina"></a></div>
        <div>
            <?php
                if (isset($_POST['pub_editid'])) {
                    echo "
                    <form method=\"post\">
                        <fieldset>
                            <legend><h1>Edita Una Publicacio</h1></legend>
                            <label>Imatge</label><br>
                            <input name=\"foto\" type=\"file\" class=\"loginformline\" required>
                            <br><br>
                            <label>Peu De Foto</label><br>
                            <input name=\"desc\" type=\"textarea\" class=\"loginformline\" required>
                            <br><br>
                            <input hidden name=\"id\" value=\"".$_POST['pub_editid']."\">
                            <input type=\"submit\" value=\"Edita!\" id=\"loginsubmitbutton\">
                            <br><br>
                        </fieldset>
                    </form>
                    ";
                } else {
                    header("location:perfil.php");
                }
            ?>
        </div>
    </div>
</body>
</html>
<?php
    require("protection.php");
    if (isset($_POST['foto'])) {
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
        $coso = ("".($contador + 1)."");

        //Insertar Datos
        $coleccion->updateOne(
            ['id' => $_POST['id']], // Filtro para seleccionar el documento a actualizar
            ['$set' => [
                'desc' => $_POST['desc'],
                'foto' => $_POST['foto']
            ]]
        );
    }
?>