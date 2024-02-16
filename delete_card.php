///////////////////////////////////////////////
// #   Script pour delete les cartes a la BDD//         
//////////////////////////////////////////////

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todo-list";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$card_id = $_POST['card_id'];

$sql = "DELETE FROM cards WHERE card_id = '$card_id'";

if ($conn->query($sql) === TRUE) {
    echo "Card deleted successfully";
} else {
    echo "Error deleting card: " . $conn->error;
}

$conn->close();
?>