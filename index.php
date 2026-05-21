<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MD5 Cracker</title>
</head>
<body>
    <h1>MD5 Cracker</h1>
    <p>
        This application takes an MD5 hash of a two-character lowercase string
        and attempts to hash all two-character combinations to determine the
        original two characters. 
    </p>
    <pre>
        Debug Output:
        <?php
            $goodtext = "Not found";

            if(isset($_GET['md5'])){
                $time_pre = microtime(true);
                $md5 = $_GET['md5'];

                $txt = "abcdefghijklmnopqrstuvwxyz";
                $show = 15;

                for($i=0; $i<strlen($txt); $i++){
                    $ch1 = $txt[$i];
                    for($j=0; $j<strlen($txt); $j++){
                        $ch2 = $txt[$j];
                        $try = $ch1 . $ch2;

                        $check = hash('md5', $try);
                        if($check == $md5){
                            $goodtext = $try;
                            break 2;
                        }
                        if($show > 0){
                            echo "$check $try\n";
                            $show = $show -1;
                        }
                    }
                }

                $time_post = microtime(true);
                echo "Elapsed time: ";
                echo $time_post - $time_pre;
                print "\n";
            }

        ?>
    </pre>
    <p>
        Original Text <?= htmlentities($goodtext);?>
    </p>    

    <form>
        <input type="text" name="md5" size="60"/>
        <input type="submit" value="Crack MD5"/>
    </form>
    <p><a href = "md5.php">Reset</a></p>
    <p><a href = "index.php">Back to Cracking</a></p>
</body>
</html>