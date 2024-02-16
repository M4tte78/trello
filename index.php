<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <title>Trello.Mattéo</title>
</head>
<body>
<!-- Masthead -->
<header class="masthead">

    <div class="boards-menu">

        <button class="boards-btn btn"><i class="fab fa-trello boards-btn-icon"></i>Boards</button>

        <div class="board-search">
        <input type="search" class="board-search-input" aria-label="Board Search" onfocus="showDropdown()" onblur="hideDropdown()">
        <div id="dropdown" class="dropdown-content">
            <!-- Les éléments du menu déroulant seront ajoutés ici par JavaScript -->
        </div>
        <i class="fas fa-search search-icon" aria-hidden="true"></i>
    </div>
    <script>
        var searchInput = document.querySelector('.board-search-input');
        var dropdown = document.getElementById('dropdown');
        var boardInfoBar = document.querySelector('.board-info-title'); // Ajout de cette ligne

        function showDropdown() {
            // Remplissez le menu déroulant avec les noms des listes
            var lists = document.querySelectorAll('.list');
            for (var i = 0; i < lists.length; i++) {
                var listTitle = lists[i].querySelector('.list-title').innerText;
                var a = document.createElement('a');
                a.textContent = listTitle;
                dropdown.appendChild(a);

                // Ajoutez un gestionnaire d'événements click à l'élément du menu déroulant
                a.addEventListener('click', function() {
                    // Lorsqu'un élément du menu déroulant est cliqué, affichez le titre de la liste dans la barre d'information du tableau
                    boardInfoBar.innerText = this.textContent;
                });
            }

            // Montrez le menu déroulant
            dropdown.classList.add('show');
        }

        function hideDropdown() {
            // Cachez le menu déroulant et videz-le
            dropdown.classList.remove('show');
            dropdown.innerHTML = '';
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.querySelector('.board-search-input');

            searchInput.addEventListener('input', function() {
                var searchTerm = searchInput.value.toLowerCase();

                var lists = document.querySelectorAll('.list');
                for (var i = 0; i < lists.length; i++) {
                    var listTitle = lists[i].querySelector('.list-title').innerText.toLowerCase();
                    if (listTitle.includes(searchTerm)) {
                        lists[i].style.display = 'block';
                    } else {
                        lists[i].style.display = 'none';
                    }
                }
            });
        });
    </script>

    </div>

    <div class="logo">

        <h1><i class="fab fa-trello logo-icon" aria-hidden="true"></i>Trello</h1>

    </div>

    <div class="user-settings">

        <button class="user-settings-btn btn" aria-label="Create">
            <i class="fas fa-plus" aria-hidden="true"></i>
        </button>

        <button class="user-settings-btn btn" aria-label="Information">
            <i class="fas fa-info-circle" aria-hidden="true"></i>
        </button>

        <button class="user-settings-btn btn" aria-label="Notifications">
            <i class="fas fa-bell" aria-hidden="true"></i>
        </button>

        <button class="user-settings-btn btn" aria-label="User Settings">
            <i class="fas fa-user-circle" aria-hidden="true"></i>
        </button>

    </div>

</header>
<!-- End of masthead -->


<!-- Board info bar -->
<section class="board-info-bar">

<h2>Liste de toutes les taches</h2>

    <div class="board-controls">

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

            // Récupération des listes depuis la base de données
            $sql = "SELECT * FROM lists";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Affichage des listes
                while($row = $result->fetch_assoc()) {
                    echo "<button class='list-title btn'>" . $row["list_name"] . "</button>";
                }
            } else {
                echo "0 results";
            }
            $conn->close();
        ?>

    </div>


    <div class="board-info">

        

</section>
<!-- End of board info bar -->


<!-- Lists container -->
<section class="lists-container">

    <?php
    
        // Connexion à la base de données
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Récupération des cartes pour chaque liste depuis la base de données
        $sql = "SELECT * FROM lists";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Affichage des listes
            while($row = $result->fetch_assoc()) {
                echo "<div class='list'>";
                echo "<h3 class='list-title'>" . $row["list_name"] . "</h3>";
                echo "<button class='delete-list-btn' data-list-id='" . $row["list_id"] . "'>Delete list</button>";


                $list_id = $row["list_id"];
                $sql_cards = "SELECT * FROM cards WHERE list_id = '$list_id'";
                $result_cards = $conn->query($sql_cards);

                if ($result_cards->num_rows > 0) {
                    echo "<ul class='list-items'>";
                    // Affichage des cartes
                    while($row_card = $result_cards->fetch_assoc()) {
                        echo "<li>" . $row_card["card_name"] . "<button class='delete-card-btn' data-card-id='" . $row_card["card_id"] . "'><i class='fas fa-trash'></i></button></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No cards found for this list.</p>";
                }
                
                echo "<button class='add-card-btn btn' onclick='addCard(" . $list_id . ")'>Add a card</button>";
                echo "<div id='addCardForm" . $list_id . "' style='display: none;'>
                        <input type='text' id='cardName" . $list_id . "' placeholder='Enter card name'>
                        <button onclick='submitCard(" . $list_id . ")'>Submit</button>
                      </div>";
                echo "</div>";
            }
           
        } else {
            echo "0 results";
        }
        $conn->close();
    ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var deleteButtons = document.querySelectorAll('.delete-card-btn');

    for (var i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function() {
            var cardId = this.getAttribute('data-card-id');
            deleteCard(cardId);
        });
    }
});

function deleteCard(cardId) {
    // Connexion à la base de données
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            location.reload();
        }
    };
    xhttp.open("POST", "delete_card.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("card_id=" + cardId);
}
</script>

    <button class="add-list-btn btn" onclick="addList()">Add a list</button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteButtons = document.querySelectorAll('.delete-list-btn');

            for (var i = 0; i < deleteButtons.length; i++) {
                deleteButtons[i].addEventListener('click', function() {
                    var listId = this.getAttribute('data-list-id');
                    deleteList(listId);
                });
            }
        });

        function deleteList(listId) {
            // Connexion à la base de données
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhttp.open("POST", "delete_list.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("list_id=" + listId);
        }


        function addCard(listId) {
            document.getElementById('addCardForm' + listId).style.display = 'block';
        }

        function submitCard(listId) {
            var cardName = document.getElementById('cardName' + listId).value;
            if (cardName != null && cardName != "") {
                // Connexion à la base de données
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        location.reload();
                    }
                };
                xhttp.open("POST", "add_card.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("card_name=" + cardName + "&list_id=" + listId);
            }
        }

        function addList() {
            var listName = prompt("Enter the name of the new list:");
            if (listName != null && listName != "") {
                // Connexion à la base de données
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        location.reload();
                    }
                };
                xhttp.open("POST", "add_list.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("list_name=" + listName);
            }
        }
    </script>

</section>
<!-- End of lists container -->
</body>
</html>