///////////////////////////////////////////////
// #   Script pour delete les listes a la BDD//         
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

$list_id = $_POST['list_id'];

$sql = "DELETE FROM lists WHERE list_id = '$list_id'";

if ($conn->query($sql) === TRUE) {
    echo "List deleted successfully";
} else {
    echo "Error deleting list: " . $conn->error;
}

$conn->close();
?>