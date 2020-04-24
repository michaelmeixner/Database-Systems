<!DOCTYPE html>
<html>
    <head>
        <title>Exam Prep</title>
    </head>
    <body>
        <form action = "prep.php" method = "post">
            Last Name:<br>
            <input type="text" name="lastName"><br>
            ID:<br>
            <input type="text" name="ID"><br>
            <input type="submit" value="Submit">
        </form>
        <?php
            $serverName = "127.0.0.1";
            $userName = "webUser";
            $password = "SuperSecurePasswordHere";
            $schema = "sakila";
            $lastName = $_POST['lastName'];
            $id = $_POST['ID'];
            // create connection
            $conn = new mysqli($serverName, $userName, $password, $schema);
            // check connection
            if($conn->connect_error) {
                echo $conn->connect_error;
                die("Connection failed: ".$conn->connect_error);
            }
            // echo "<p>Connected Successfully</p>";
            // execute query
            $userFound = false;
            if($result = $conn->query("SELECT * FROM customer WHERE customer_id = $id")) {
                //process results
                while($row = $result->fetch_array(MYSQLI_BOTH)) {
                    // check that customer information is correct
                    if(strtoupper($lastName) == $row['last_name']) {
                        // echo "User Found.";
                        $userFound = true;
                    } else {
                        echo "User Not Found";
                    }
                }
                //close result set
            }

            if($userFound) {
                // echo "User found";
                $actorIDs = "SELECT a.actor_id, a.first_name, a.last_name from actor a where a.actor_id in
                                (select fa.actor_id from film_actor fa where fa.film_id in 
                                    (select i.film_id from inventory i where i.inventory_id in 
                                        (select r.inventory_id from rental r where r.customer_id = $id))) limit 3;";
                if($result = $conn->query($actorIDs)) {
                    echo "<h1>Movies by actor</h1>";
                    while($row = $result->fetch_array(MYSQLI_BOTH)) {
                        echo "<h4>".$row['first_name']." ".$row['last_name']."</h4>";
                        $actorFilms = "SELECT f.film_id, f.title, f.description from film f where f.film_id in 
                                        (select fa.film_id from film_actor fa where fa.actor_id =".$row['actor_id']." ) 
                                        AND f.film_id NOT IN 
                                            (select i.film_id from inventory i where i.inventory_id in 
                                                (select r.inventory_id from rental r where r.customer_id = $id)) limit 3;";
                        if($filmResult = $conn->query($actorFilms)) {
                            echo "<table><tr><th>Title</th><th>Description</th></tr>";
                            while($filmRow = $filmResult->fetch_array(MYSQLI_BOTH)) {
                                echo "<tr><td>".$filmRow['title']."</td><td>".$filmRow['description']."</td></tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "There was an issue with the table.";
                        }
                    }
                }
                $genreQuery = "SELECT DISTINCT c.name FROM category c WHERE c.category_id IN 
                                (SELECT fc.category_id FROM film_category fc WHERE fc.film_id IN 
                                    (SELECT i.film_id FROM inventory i WHERE i.inventory_id IN 
                                        (SELECT r.inventory_id FROM rental r WHERE r.customer_id = ".$userID."))) LIMIT 3;";
                if($genreResult = $conn->query($genreQuery)) {
                    echo "Made it here";
                    echo "<h1>Movies by genre</h1>";
                    while($genreRow = $genreResult->fetch_array(MYSQLI_BOTH)) {
                        echo "<h4>".$genreRow['name']."</h4>";
                        $genreFilms = "SELECT f.title, f.description FROM film f WHERE film_id IN 
                                        (SELECT fc.film_id FROM film_category fc WHERE category_id IN 
                                            (SELECT c.category_id FROM category c WHERE c.name LIKE ".$genreRow['name'].")) LIMIT 3;";
                        if($genreFilmResults = $conn->query($genreFilms)) {
                            echo "<table><tr><th>Title</th><th>Description</th></tr>";
                            while($resultRow = $genreFilmResults->fetch_array(MYSQLI_BOTH)) {
                                echo "<tr><td>".$resultRow['title']."</td><td>".$resultRow['description']."</td></tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "There was an issue with the table.";
                        }
                    }
                }
            }
            //close connection
            $conn->close();
            $conn = null;
        ?>
    </body>
</html>