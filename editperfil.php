<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Mar i Montanya</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="bodylol">
    <div id="gridregister">
        <div><a href="perfil.php"><img id="bannerlink" src="images/banner.png" alt="banner de la pagina"></a></div>
        <div>
            <?php
                require("protection.php");

                // Base de dades
                require 'vendor/autoload.php'; // Incluye composer
                $cliente = new MongoDB\Client("mongodb://localhost:27017");
                $db = $cliente->DAW1; // Base de datos
                $coleccion = $db->usuarios; // Colección, tablas

                // Buscar usuario por email
                $usuario = $coleccion->findOne(['email' => $_SESSION['usuari_mail']]);

                if ($usuario) {
                    echo "
                    <form method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend><h1>Edita El Perfil</h1></legend>
                            <label>Imatge</label><br>
                            <input name=\"foto\" type=\"file\" class=\"loginformline\">
                            <br><br>
                            <label>Nom</label><br>
                            <input name=\"nombre\" type=\"text\" class=\"loginformline\" value=\"{$usuario['nombre']}\" required>
                            <br><br>
                            <label>Contrasenya</label><br>
                            <input name=\"contrasenya\" type=\"password\" class=\"loginformline\" value=\"{$usuario['contrasenya']}\" required>
                            <br><br>
                            <label>Telèfon</label><br>
                            <input name=\"tlf\" type=\"text\" class=\"loginformline\" value=\"{$usuario['tlf']}\" required>
                            <br><br>
                            <label>Naixement</label><br>
                            <input name=\"naixement\" type=\"text\" class=\"loginformline\" value=\"{$usuario['naixement']}\" required>
                            <br><br>
                            <label>Comarca</label><br>
                            <input name=\"comarca\" type=\"text\" class=\"loginformline\" value=\"{$usuario['comarca']}\" required>
                            <br><br>
                            <input type=\"hidden\" name=\"email\" value=\"{$usuario['email']}\">
                            <input type=\"submit\" value=\"Edita!\" id=\"loginsubmitbutton\">
                            <br><br>
                        </fieldset>
                    </form>
                    ";
                } else {
                    echo "Usuario no encontrado.";
                }

                if (isset($_POST['nombre'])) {
                    // Guardar los cambios
                    require 'vendor/autoload.php'; // Incluye composer
                    $cliente = new MongoDB\Client("mongodb://localhost:27017");
                    $db = $cliente->DAW1; // Base de datos
                    $coleccion = $db->usuarios; // Colección, tablas

                    $updateData = [
                        'nombre' => $_POST['nombre'],
                        'contrasenya' => $_POST['contrasenya'],
                        'tlf' => $_POST['tlf'],
                        'naixement' => $_POST['naixement'],
                        'comarca' => $_POST['comarca']
                    ];

                    // Verificar si se ha subido una nueva imagen
                    if ($_FILES['foto']['name']) {
                        $directorio_destino = 'images/';
                        $nombre_archivo = basename($_FILES['foto']['name']);
                        $ruta_destino = $directorio_destino . $nombre_archivo;

                        if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_destino)) {
                            $updateData['foto'] = $nombre_archivo;
                        } else {
                            echo "Error al pujar la imatge.";
                        }
                    }

                    // Actualizar el documento del usuario
                    $result = $coleccion->updateOne(
                        ['email' => $_POST['email']],
                        ['$set' => $updateData]
                    );

                    if ($result->getModifiedCount() > 0) {
                        echo "<script>alert('Perfil Actualitzat, torna a iniciar sessio per aplicar els cambis.');</script>";
                        session_destroy();
                        header('Location:login.html');
                    } else {
                        echo "No s'ha realitzat ningun cambi";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
