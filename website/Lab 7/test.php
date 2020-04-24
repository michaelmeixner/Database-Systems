<!DOCTYPE html>
<html>
    <head>
        <title>Database Testing</title>
        <style>
            #students {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                font-variant: small-caps;
                border-collapse: collapse;
                width: 100%;
            }
            #students td, #students th {
                border: 1px solid #ddd;
                padding: 8px;
            }
            #students tr:nth-child(even) {background-color: #f2f2f2;}
            #students tr:hover {background-color: #ddd;}
            #students th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #245a54;
                color: white;
                font-size: 15px;
            }
        </style>
    </head>
    <body>
        <form action = "test.php" method = "post">
            <fieldset>
                <legend>Drop-down menu of grades</legend>
                <select name = "students">
                    <?php
                        $serverName = "127.0.0.1";
                        $userName = "webUser";
                        $password = "SuperSecurePasswordHere";
                        $schema = "csci1130";
                        // create connection
                        $conn = new mysqli($serverName, $userName, $password, $schema);
                        // check connection
                        if($conn->connect_error) {
                            echo $conn->connect_error;
                            die("Connection failed: ".$conn->connect_error);
                        }
                        echo "<p>Connected Successfully</p>";
                        // execute query
                        if($result = $conn->query("SELECT ID, last_name, first_name FROM students")) {
                            //process results
                            while($row = $result->fetch_array(MYSQLI_BOTH)) {
                                $studentID = $row[0];
                                $lastName = $row['last_name'];
                                $firstName = $row['first_name'];
                                if($studentID == $_POST['students']) {
                                    $select = "selected";
                                } else {
                                    $select = "";
                                }
                                echo "<option value=$studentID $select> $lastName, $firstName </option>";
                            }
                            //close result set
                        }
                        //close connection
                        $conn->close();
                        $conn = null;
                    ?>
                </select>
                <input type="submit" value="View this student's grades" name="Submit1">
            </fieldset>
        </form>
        <?php
            if(isset($_POST["Submit1"])) {
                echo "<table id='students'><br><tr><th>Assignment</th><th>Grade</th></tr>";
                $ID = $_POST['students'];
                $serverName = "127.0.0.1";
                $userName = "webUser";
                $password = "SuperSecurePasswordHere";
                $schema = "csci1130";
                // create connection
                $conn = new mysqli($serverName, $userName, $password, $schema);
                // check connection
                if($conn->connect_error) {
                    echo $conn->connect_error;
                    die("Connection failed: ".$conn->connect_error);
                }
                echo "<form method='post'>";
                // execute query
                $empty = false;
                if($result = $conn->query("SELECT assignment, grade, ID FROM grades where ID = $ID")) {
                    // process results
                    while($row = $result->fetch_array(MYSQLI_BOTH)) {
                        $tracker = 1;
                        $assignment = $row[0];
                        $grade = $row['grade'];
                        $DBID = $row['ID'];
                        $empty = true;
                        echo "<tr><td>$assignment</td><td>\n";
                        echo "<select name='grades'>";
                        echo "<option value='0' $select>Select a grade...</option>";
                        $array = array('A','B','C','D','F');
                        for($i = 0; $i < sizeof($array); $i++) {
                            if($grade == $array[$i]) {
                                $select = "selected";
                            } else {
                                $select = "";
                            }
                            echo "<option value=\"".$tracker."\" ".$select.">".$array[$i]."</option>";
                            $tracker++;                
                        }
                        echo "</select";
                        echo "</td></tr>\n";
                    }
                    if(!$empty) {
                        for($i = 1; $i < 11; $i++) {
                            $insert = $conn->query("INSERT INTO grades (ID, assignment, grade) VALUES ($ID, $i, 'Z')");
                        }
                    }
                    // close result set
                }
                // close connection
                $conn->close();
                $conn = null;
                echo "</form>";
                echo "<input type='hidden' name='ID' value='".$ID."'/>";
                echo "</table><br>";
                echo "<input type='submit' value='Update grades table' name='Submit10'>";   
            }
        ?>
        <?php
            if(isset($_POST["Submit10"])) {
                echo "Made it here.";
                $ID = $_POST['ID'];
                $serverName = "127.0.0.1";
                $userName = "webUser";
                $password = "SuperSecurePasswordHere";
                $schema = "csci1130";
                // create connection
                $conn = new mysqli($serverName, $userName, $password, $schema);
                // check connection
                if($conn->connect_error) {
                    echo $conn->connect_error;
                    die("Connection failed: ".$conn->connect_error);
                }
                for($i = 1; $i < 11; $i++) {
                    $gradeUpdate = $_POST['grades'];
                    echo $gradeUpdate;
                    // $update = $conn->query("UPDATE grades
                    //                         SET ASSIGNMENT = $i, GRADE = $gradeUpdate
                    //                         WHERE ID = $ID");
                    echo "Updating. ";
                }
            }
        ?>
    </body>
</html>