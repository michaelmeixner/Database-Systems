<html>
    <body>
        <center>
            Hi <?php echo htmlspecialchars($_POST['name']); ?>.<br>
            You are <?php echo (int)$_POST['age']; ?> years old.<br>
            You are a <?php echo htmlspecialchars($_POST['grade']); ?> at <?php echo htmlspecialchars($_POST['school']); ?><br>
            You are a <?php echo htmlspecialchars($_POST['gender']); ?> and you own the following shoes: 
            <?php 
                $shoes = $_POST['shoes'];
                if(empty($shoes)) {
                    echo "You do not own any shoes.";
                } else {
                    $N = count($shoes);
                    echo "You own $N pair(s) of shoes. They are: ";
                    for($i = 0; $i < $N; $i++) {
                        echo ($shoes[$i].", ");
                    }
                }
            ?>
        </center>
    </body>
</html>