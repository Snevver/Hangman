<?php

session_start();

include 'randomInput.php';

// Add the word to the cookie and redirect to the game
if (isset($_POST['userDefinedWordSubmit'])) {
    $_SESSION['word'] = $_POST['userDefinedWord'];
    header("Location: activeHangman.php");
    exit();
} else if (isset($_POST['randWordSubmit'])) {
    $_SESSION['word'] = randomWord();
    header("Location: activeHangman.php");
    exit();
}

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
    <div class="beginHeader">
        <br>
        <h1 class="beginH1">Galgje</h1>
        <h3 class="beginH3">Kies een optie:</h3>
    </div>
    <div class="beginChoicesContainer">
        <form class="beginChoice" method="POST" action="galgje.php">
            <div>
                <br><br>
                <input class="beginButtonRandInput" type="submit" value="Kies een willekeurig woord" id="randWordSubmit" name="randWordSubmit">
            </div>
        </form>

        <form class="beginChoice" method="POST" action="galgje.php">
            <div>
                <br>
                <input class="beginInputField" type="text" id="userDefinedWord" name="userDefinedWord" placeholder="Woord" required>
                <br><br>
                <input class="beginButtonUserDefinedInput" type="submit" value="Kies je eigen woord" id="userDefinedWordSubmit"
                    name="userDefinedWordSubmit">
            </div>
        </form>
    </div>
</body>

</html>