<!DOCTYPE html>
<html>
    <style>
        input[type=submit]{
            width: 20em;
            height: 4em;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            border: none;
            background-color: darkslategray;
            color: whitesmoke;
            font-weight: bolder;
            cursor: pointer;
        }
    </style>
    <title>Assignment 2</title>
    <body>
        <h1 style="font-family: Verdana, Geneva, Tahoma, sans-serif; color: darkslategrey; font-weight: lighter">Calculator</h1>
        <h4 style="font-family: Verdana, Geneva, Tahoma, sans-serif; color: darkslategrey; font-weight: lighter">For all your mathematical needs.</h4>
        <?php
            if(isset($_POST['firstButton'])) {
                $firstNumber = $_POST['ID'];
            } elseif(isset($_POST['secondButton'])) {
                $secondNumber = $_POST['ID'];
            }
            echo
                '<form action = "calculator_action.php" method = "post">
                    <fieldset>
                        <legend style="font-family: Verdana, Geneva, Tahoma, sans-serif; color: darkslategrey; font-weight: lighter">Calculator:</legend>
                        <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; color: darkslategrey; font-weight: lighter">First number:<br></p>
                        <input type = "text" name = "firstDigit" value="'.$firstNumber.'"><br>
                        <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; color: darkslategrey; font-weight: lighter">Second number:<br></p>
                        <input type = "text" name = "secondDigit" value="'.$secondNumber.'"><br>
                        <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; color: darkslategrey; font-weight: lighter">Select operand:<br></p>
                        <input type = "radio" name = "operand" value = "add"> Add<br>
                        <input type = "radio" name = "operand" value = "subtract"> Subtract<br>
                        <input type = "radio" name = "operand" value = "multiply"> Multiply<br>
                        <input type = "radio" name = "operand" value = "divide"> Divide<br>
                    </fieldset>
                    <input type = "submit" value = "Enter">
                </form>
                <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; color: darkslategrey; font-weight: lighter">The result of your calculation is: </h3>';
            if(isset($_POST['operand'])) {
                $first = (double) $_POST['firstDigit'];
                $second = (double) $_POST['secondDigit'];
                $operand = $_POST['operand'];
                if($operand == "add") {
                    $result = $first + $second;
                }
                if($operand == "subtract") {
                    $result = $first - $second;
                }
                if($operand == "multiply") {
                    $result = $first * $second;
                }
                if($operand == "divide") {
                    $result = $first / $second;
                }
            } else {
                $result = 0;
            }
            echo $result;
            echo 
            '<p>
                <form action="calculator_action.php" method="post">
                    <input type="submit" name="firstButton" value="Copy result into first number">
                    <input type="submit" name="secondButton" value="Copy result into second number">
                    <input type="hidden" name="ID" value='.$result.'>
                </form>
            </p>';
        ?>
    </body>
</html>
