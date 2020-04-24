<!DOCTYPE html>
<html>
    <head>
        <title>Assignment 4</title>
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
        <p style="font-size:35px;">Enter your query:</p>
        <form action = "index.php" method = "POST">
            <input type = "textfield" height = "200px" cols = "200px" name = "query">
            <input type = "submit" name = "Send Query">
        </form><br>
        <?php 
            if (isset($_POST['query'])) {
                $userQuery = $_POST['query'];
                $serverName = "127.0.0.1";
                $username = "webUser";
                $password = "SuperSecurePasswordHere";
                $schema = "csci1130";
                
                //create connection
                $conn = new mysqli($serverName, $username, $password, $schema);
                
                //check connection
                if ($conn->connect_error) {
                    echo $conn->connect_error;
                    die("Connection failed: " . $conn->connect_error);
                }

                // query the database
                $result = $conn->query($userQuery);
                $status = $result->status;
                echo '<h4>'.mysqli_affected_rows($conn).' rows affected.</h4>';
                
                // check if it worked
                if ($result) {
                    // get columns and add them to table
                    echo '<table id="students"><tr>';
                    $columnInfo = $result->fetch_fields();
                    foreach ($columnInfo as $value){
                        echo '<th>' . $value->name . '</th>';
                    }
                    echo '</tr>';
                    
                    // populate table
                    while ($row = $result->fetch_array(MYSQLI_BOTH)) {
                        echo '<tr>'; // open row
                        foreach ($columnInfo as $value) { // select $row at given column name
                            echo '<td>' . $row[$value->name] . '</td>'; // open data, add the right field from the row, close data field
                        }
                        echo '</tr>'; // close row
                    }
                    echo '</table><br>';
                } else { 
                    // if it didn't work
                    echo 'Failed! ' . $status;
                }
                
                //close connection
                $conn->close();
                $conn = null;
            }
        ?>
    </body>
</html>