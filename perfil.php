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
    ?>
    <div id="perfilgrid">
        <div>
            <h1><?php echo $_SESSION['usuari_nom'];?></h1>
        </div>
        <div>
            <a class="linkprofile" href="index.html">Home</a>
            <a class="linkprofile" href="logout.php">Tanca Sesio</a>
        </div>
        <div id="informacionPerfil">
            <div id="imagenPerfil">
                <img src="images/profile_photo.jpg">
            </div>
            <p>Email: <?php echo $_SESSION['usuari_mail'];?></p>
            <p>Tel: <?php echo $_SESSION['usuari_tlf'];?></p>
            <p>Naixement: ---</p>
            <p>Comarca: ---</p><img id="regioimage" src="images/regio.png">
        </div>
        <div>
            <h2>Publicacions Recents</h2>
            <section id="divpublicaciones">
                <div class="publicaciones">
                    <img src="images/certascan.jpg">
                    <div>
                        <img src="images/perfil.png">
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>