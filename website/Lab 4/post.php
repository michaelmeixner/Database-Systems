<!DOCTYPE html>
<html>
    <head>
        <title>Graffiti Wall</title>
        <h1>Graffiti Wall</h1>
    </head>
    <body>
        <form action="post.php" method="post">
            <fieldset>
                <legend> Enter some text to post on the wall below: </legend>
                <input type="text" name="text"><br>
                <input type="submit" value="Post Graffiti"><br>
                <?php
                    $stringData = $_POST['text'];
                    $fileAppend = "graffitiPosts.txt";
                    $fa = fopen($fileAppend, 'a');
                    fwrite($fa, $stringData);
                    fwrite($fa, '<hr>');
                    fclose($fa);
                ?>
            </fieldset>
        </form>
        <br>
    </body>
</html>

<?php
    $file = "graffitiPosts.txt";
    $fh = fopen($file, 'r');
    $fileData = fread($fh, filesize($file));
    fclose($fh);
    echo $fileData;
?>