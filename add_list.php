<?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "todo-list";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupération des données de la requête POST
    $list_name = $_POST['list_name'];

    // Ajout de la nouvelle liste à la base de données
    $sql = "INSERT INTO lists (list_name) VALUES ('$list_name')";

    if ($conn->query($sql) === TRUE) {
        echo "New list created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>