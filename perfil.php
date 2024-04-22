<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mar I Montanya - Perfil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        require("protection.php");
    ?>
    <div id="perfilgrid">
        <div>
            <img src="images/logo.webp" width="20%">
        </div>
        <div>
            <a class="linkprofile" href="index.html">Home</a>
            <a class="linkprofile" href="logout.php">Tanca Sesio</a>
        </div>
        <div>
            <h1><?php echo $_SESSION['usuari_nom'];?></h1>
            <p>Email:---</p>
            <p>Tel: ---</p>
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