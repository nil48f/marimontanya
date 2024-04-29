<?php
    require 'vendor/autoload.php';//Incluye composer

    $cliente = new MongoDB\Client("mongodb://localhost:27017");
    
    //echo $cliente;

    $db = $cliente->DAW1; //Base de datos
    $coleccion = $db->usuarios; //Coleccion, tablas

    //echo $db."<br>";
    //echo $coleccion."<br>";
    //var_dump($coleccion)."<br><br><br>";

    //Insertar Datos
    //$coleccion->insertOne(['nombre' => 'Miriam']);

    //Delete Datos
    //$coleccion->deleteOne(['nombre' => 'Pepe']);

    //Recuprear
    $resultado = $coleccion->find();
    echo "<br><br>";
    foreach ($resultado as $doc) {
        echo $doc['email']."<br>";
    }

    //var_dump($resultado);
?>