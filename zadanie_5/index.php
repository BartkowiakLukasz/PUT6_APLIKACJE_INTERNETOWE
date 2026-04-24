<?php session_start();?>
<!DOCTYPE html>
<html>

<head>
    <title>PHP</title>
    <meta charset='UTF-8' />
    <?php require("funkcje.php")?>
</head>

<body>
    <?php 
  if (isset($_POST["wyloguj"]))
    {
        session_unset();
        session_destroy();
    }
    ?>



    <?php echo "<h1> Nasz system </h1>"; ?>
    <hr>
<h3>Status Ciasteczka</h3>
<?php
// Sprawdzamy, czy ciasteczko o nazwie "ciasteczko" istnieje
if (isset($_COOKIE['ciasteczko'])) {
    // Jeśli istnieje, wyświetlamy jego wartość
    echo "<p>Wartość zapisanego ciasteczka: <b>" . $_COOKIE['ciasteczko'] . "</b></p>";
} else {
    // Jeśli nie istnieje (wygasło), wyświetlamy komunikat
    echo "<p>Ciasteczko nie istnieje lub wygasło.</p>";
}
?>
    <fieldset>
        <legend>Logowanie do systemu</legend>
    <form id="formularz" method="post" action="logowanie.php">
        <label for="login">Login:</label>
        <input type="text" name="login" id="login"> <br>

        <label for="password">Hasło:</label>
        <input type="password" name="haslo" id="password"> <br>

        <button type="submit" id="zaloguj" name="zaloguj">Zaloguj</button>
    </form>
    </fieldset>
    <br><br>
    <fieldset>
        <legend>Zarządzanie Ciasteczkami (Cookies)</legend>
    <form id="cookies_form" method="get" action="cookie.php">
        <label for="czas">Podaj czas życia ciasteczka (w sekundach):</label>
        <input type="number" name="czas" id="czas">
        <button type="submit" name="utworzCookie">Utwórz Cookie</button>
    </form>
    </fieldset>
    <br><br>
    <a href="user.php">Spróbuj wejść na podstronę user.php</a>
</body>

</html>