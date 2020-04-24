<!DOCTYPE html>
<html>
    <head>
        <title>Parse Program</title>
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
        <table id="students">
            <tr>
                <th>ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Grades</th>
            </tr>
            <?php
                $studentFile = "Students.txt";
                $gradeFile = "Grades.txt";
                $fhs = fopen($studentFile, 'r');
                $fhg = fopen($gradeFile, 'r');
                $grades = array();
                for($i = 0; !feof($fhg); $i++) {
                    $grades[$i] = explode(',', fgets($fhg));
                }
                $counter = 0;
                while(!feof($fhs)) {
                    echo "<tr>";
                        $student = explode(',', fgets($fhs));
                        for($i = 0; $i < sizeof($student); $i++) {
                            echo "<td>".$student[$i]."</td>";
                        }
                        echo "<td>";
                            if($grades[$counter][0] == $student[0]) {
                                for($i = 0; $i < 10; $i++) {
                                    echo $grades[$counter][1]." = ".$grades[$counter][2].", ";
                                    $counter++;
                                }
                            } else {
                                echo "No Grades Entered";
                            }
                        echo "</td>";
                    echo "</tr>";
                }
                fclose($fhs);
                fclose($fhg);
            ?>
        </table>
    </body>
</html>