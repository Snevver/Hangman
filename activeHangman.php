<?php

session_start();

// made by Felix (thnx Felix)
function getSessionValue($key, $default = null)
{
    return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
}

// Take the target word from the session
if (isset($_SESSION['word'])) {
    $targetWord = strtolower($_SESSION['word']);
} else {
    header("Location: galgje.php");
}

// Get info from session, or initiate it
$guessesRemaining = getSessionValue('guessesRemaining', 10);
$guessableLetters = getSessionValue('guessableLetters', range('a', 'z'));
$correctlyGuessedLetters = getSessionValue('correctlyGuessedLetters', []);
$incorrectlyGuessedLetters = getSessionValue('incorrectlyGuessedLetters', []);


// Everything that has to happen after a guess, happens here
if (isset($_POST['guessInput'])) {
    $currentGuess = strtolower($_POST['guessInput']);

    //check if the guess is not already guessed
    while (in_array($currentGuess, $correctlyGuessedLetters) || in_array($currentGuess, $incorrectlyGuessedLetters)) {
        echo ("Deze letter is al gegokt, probeer opnieuw!");
        break;
    }

    // Remove the guessed letter from the array of guessable letters
    if (in_array($currentGuess, $guessableLetters) && $currentGuess != '') {
        unset($guessableLetters[array_search($currentGuess, $guessableLetters)]);
    }

    // Add the guessed letter to the array of correctly or incorrectly guessed letters
    if (in_array($currentGuess, str_split($targetWord))) {
        if (!in_array($currentGuess, $correctlyGuessedLetters)) {
            $correctlyGuessedLetters[] = $currentGuess;
        }
    } else {
        if (!in_array($currentGuess, $incorrectlyGuessedLetters)) {
            $incorrectlyGuessedLetters[] = $currentGuess;
            $guessesRemaining--;
        }
    }

    // Update session
    $_SESSION['guessesRemaining'] = $guessesRemaining;
    $_SESSION['guessableLetters'] = $guessableLetters;
    $_SESSION['correctlyGuessedLetters'] = $correctlyGuessedLetters;
    $_SESSION['incorrectlyGuessedLetters'] = $incorrectlyGuessedLetters;

    // Check if the user has won
    if (count(array_unique(str_split($targetWord))) === count($correctlyGuessedLetters)) {
        $_SESSION['win'] = true;
        header("Location: endHangman.php");
        exit();
    }

    // Check if the user has lost
    if ($guessesRemaining < 1) {
        $_SESSION['win'] = false;
        header("Location: endHangman.php");
        exit();
    }
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
    <div class="flexbox">
        <div class="pictureElement">
            <h1 class="pictureElement">
                <?php

                switch ($guessesRemaining) {
                    case 10:
                        echo "";
                        break;
                    case 9:
                        echo "  <br>
                            |<br>   
                            |<br>      
                            |<br>       
                            |<br>       
                            |_ _ ";
                        break;
                    case 8:
                        echo " ____ <br>
                            |<br>      
                            |<br>      
                            |<br>       
                            |<br>       
                            |_ _ ";
                        break;
                    case 7:
                        echo " ____ <br>
                            |/<br>      
                            |<br>      
                            |<br>       
                            |<br>       
                            |_ _ ";
                        break;
                    case 6:
                        echo " ____ <br>
                            |/ |<br>      
                            |<br>      
                            |<br>       
                            |<br>       
                            |_ _ ";
                        break;
                    case 5:
                        echo " ____ <br>
                            |/ |<br>      
                            | ‎ O<br>      
                            |<br>       
                            |<br>       
                            |_ _ ";
                        break;
                    case 4:
                        echo " ____ <br>
                            |/ |<br>      
                            | ‎ O<br>      
                            | ‎ |<br>       
                            |<br>       
                            |_ _ ";
                        break;
                    case 3:
                        echo " ____ <br>
                            |/ |<br>      
                            | ‎ O<br>      
                            | ‎/|<br>       
                            |<br>       
                            |_ _ ";
                        break;
                    case 2:
                        echo " ____ <br>
                            |/ |<br>      
                            | ‎ O<br>      
                            | ‎/|\<br>       
                            |<br>       
                            |_ _ ";
                        break;
                    case 1:
                        echo " ____ <br>
                            |/ |<br>      
                            | ‎ O<br>      
                            | ‎/|\<br>       
                            | ‎/<br>       
                            |_ _ ";
                        break;
                }

                ?>
            </h1>
        </div>
        <div class="gameElement">
            <div class="header">
                <h1>Galgje</h1>
                <div class="guesses">
                    <h2 class="guessesRemaining">
                        Je hebt nog <?= $guessesRemaining ?> gokken over.
                    </h2>
                </div>
                <div>
                    <form method="POST" action="activeHangman.php">
                        <input type="text" class="inputFieldLetters" name="guessInput" id="guessInput" maxlength="1" placeholder="Voer een letter in" required>
                        <input type="submit" value="Raad!" class="submitButton">
                    </form>
                </div>
                <div>
                    <br><br><br><br>
                    <h2>
                        <!-- Print the underscores representing the letters in the user's word. -->
                        <?php
                        foreach (str_split($targetWord) as $letter) {
                            if (in_array($letter, $correctlyGuessedLetters)) {
                                echo "$letter ";
                            } else {
                                echo "_ ";
                            }
                        }
                        ?>
                    </h2>
                </div>
            </div>
            <div>
                <br>
                <div class="remainingCharacters">
                    <h3>Overige Letters</h3>
                    <p>
                        <?php
                        foreach ($guessableLetters as $letter) {
                            echo "$letter ";
                        }
                        ?>
                    </p>
                </div>
                <br>
                <div class="correctAndWrongCharacters">
                    <h3 class="correctAndWrongCharacters">Goede letters</h3>
                    <?php
                    foreach ($correctlyGuessedLetters as $letter) {
                        echo "$letter ";
                    }
                    ?>
                </div>
                <br>
                <div class="correctAndWrongCharacters">
                    <h3 class="correctAndWrongCharacters">Verkeerde letters</h3>
                    <?php
                    foreach ($incorrectlyGuessedLetters as $letter) {
                        echo "$letter ";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>