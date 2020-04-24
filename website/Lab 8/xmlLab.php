<!DOCTYPE html>
<html>
    <head>
        <title>Database Testing</title>
        <style>
            #students {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
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
                background-color: #4CAF50;
                color: white;
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
                <input type="submit" value="View this student's grades">
            </fieldset>
        </form>
        <?php
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
            // execute query
            if($result = $conn->query("SELECT assignment, grade FROM grades where ID = $ID")) {
                //process results
                while($row = $result->fetch_array(MYSQLI_BOTH)) {
                    $assignment = $row[0];
                    $grade = $row['grade'];
                    echo "<tr><td>$assignment</td><td>$grade</td></tr>";
                }
                //close result set
            }
            //close connection
            $conn->close();
            $conn = null;
        ?>
        </table>
    </body>
</html>