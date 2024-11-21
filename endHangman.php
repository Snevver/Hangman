<?php
session_start();

// Take the guessed word and winstate from the session
$winstate = $_SESSION['win'];
$targetWord = $_SESSION['word'];

$_SESSION['guessesRemaining'] = 10;
$_SESSION['guessableLetters'] = range('a', 'z');
$_SESSION['correctlyGuessedLetters'] = [];
$_SESSION['incorrectlyGuessedLetters'] = [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Galgje</title>
</head>

<body>
    <div>
        <h1>
            <div class='lostPicture'>
                <?php

                if ($winstate == false) {
                    echo "____ <br>
                        |/ |<br>      
                        | ‎ O<br>      
                        ‎| ‎/|\<br>       
                        ‎| ‎/ \<br>       
                        |_ _<br>";
                }
                ?>
            </div>
            <?php
            if ($winstate == true) {
                // Win state
                echo "Gefeliciteerd, je hebt gewonnen!";
            } else {
                // Lose state
                echo "Helaas, je hebt verloren.";
            }
            ?>
        </h1>
    </div>

    <div>
        <h2>Het woord was: <strong>
                <?php
                if (isset($targetWord)) {
                    echo $targetWord;
                }

                ?>
            </strong></h2>
    </div>
    <div>
        <form method="POST" action="galgje.php">
            <input type="submit" value="Speel opnieuw" class="submitButton">
        </form>
</body>

</html>