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
        <form action = "ddMenu.php" method = "post">
            <fieldset>
                <legend>Drop-down menu of grades</legend>
                <select name = "students">
                    <?php
                        $studentFile = "Students.txt";
                        $fhs = fopen($studentFile, 'r');
                        $i = 1;
                        while(!feof($fhs)) {
                            $student = explode(',', fgets($fhs));
                            echo "<option value=".$i++.">".$student[2]." ".$student[1]."</option>";
                        }
                        fclose($fhs);
                    ?>
                </select>
                <input type="submit" value="View this student's grades">
            </fieldset>
        </form>
        <?php
            if(isset($_POST['students'])){
                $ID = $_POST['students'];
                $gradeFile = "Grades.txt";
                $fhg = fopen($gradeFile, 'r');
                $grades = array();
                for($i = 0; !feof($fhg); $i++) {
                    $grades[$i] = explode(',', fgets($fhg));
                }
                $table = "<table><tr><th>Assignment #</th><th>Grade</th></tr>";
                $found = false;
                for($i = 0; $i < sizeof($grades); $i++) {
                    if($ID == $grades[$i][0]) {
                        $found = true;
                    }
                }
                $counter = 1;
                echo "<form action='ddMenu.php' method='post'>";
                if(!$found) {
                    for($i = 0; $i < 10; $i++) {
                        $table = $table."<tr><td>".$counter++."</td><td><input type='text' name='".($i + 1)."' value='Z'/></td></tr>";
                    }
                } else {
                    for($i = 0; $i < sizeof($grades); $i++) {
                        if($grades[$i][0] == $ID) {
                            $table = $table."<tr><td>".$counter."</td><td><input type='text' name='grade".$counter++."' value='".$grades[$i][2]."'/></td></tr>";
                        }
                    }
                }
                echo $table;
                echo "</table>";
                echo "<input type='hidden' name='ID' value='".$ID."'/>";
                echo "<p><input type='submit' value='Submit changes to grades'></p></form>";
                fclose($fhg);
            }
        ?>
        <?php
            $ID = $_POST['ID'];
            $tempFile = "tempFile.txt";
            $thg = fopen($tempFile, "w");
            $gradeFile = "Grades.txt";
            $fhg = fopen($gradeFile, 'r');
            //read a line from grades
            //if that line is for a different student, write to temp file
            //repeat
            while(!feof($fhg)) {
                $line = fgets($fhg);
                if(trim(substr($line, 0, 2), ',') != $ID) {
                    fwrite($thg, $line);
                }
            }
            //close grades file
            fclose($fhg);
            //write grades from form into temp file
            for($i = 1; $i < 11; $i++) {
                $string = "\n".$ID.",".$i.",".$_POST['grade'.$i];
                fwrite($thg, $string);
            }
            //close temp file
            fclose($thg);
            //rename temp over grades
            rename($tempFile, $gradeFile);
        ?>
    </body>
</html>