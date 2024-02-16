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
    $card_name = $_POST['card_name'];
    $list_id = $_POST['list_id'];

    // Ajout de la nouvelle carte à la base de données
    $sql = "INSERT INTO cards (card_name, list_id) VALUES ('$card_name', '$list_id')";

    if ($conn->query($sql) === TRUE) {
        echo "New card created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>