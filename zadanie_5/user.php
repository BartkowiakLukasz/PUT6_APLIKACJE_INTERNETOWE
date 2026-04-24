<?php session_start(); 
if (!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] != 1) {
    header("Location: index.php");
    exit();
}

if (isset($_FILES['plik_zdjecia'])) {
    //(kod 0 to UPLOAD_ERR_OK)
    if ($_FILES['plik_zdjecia']['error'] === 0) {
        
        $nazwa_pliku = basename($_FILES["plik_zdjecia"]["name"]);
        $rozszerzenie = strtolower(pathinfo($nazwa_pliku, PATHINFO_EXTENSION));
        
        $sciezka_docelowa = __DIR__ . '/' . $nazwa_pliku;
        
        if ($rozszerzenie == "jpg" || $rozszerzenie == "png" || $rozszerzenie == "jpeg") {
            
            if (move_uploaded_file($_FILES["plik_zdjecia"]["tmp_name"], $sciezka_docelowa)) {
                $_SESSION['zdjecie'] = $nazwa_pliku;
                $komunikat_uploadu = "<span style='color:green;'>Plik wgrany pomyślnie!</span>";
            } else {
                $komunikat_uploadu = "Błąd: Nie udało się przenieść pliku do folderu docelowego.";
            }
        } else {
            $komunikat_uploadu = "Dozwolone są tylko pliki JPG i PNG!";
        }
    } else {
        $komunikat_uploadu = "Błąd serwera. Kod błędu PHP: " . $_FILES['plik_zdjecia']['error'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>PHP</title>
<meta charset='UTF-8' />
</head>
<body>
<?php
require_once("funkcje.php");
echo "Zalogowano";
?>
<hr>
    
    <h3>Twój awatar:</h3>

    <?php
    if (isset($komunikat_uploadu)) {
        echo "<p style='color:red;'>$komunikat_uploadu</p>";
    }

    if (isset($_SESSION['zdjecie']) && file_exists($_SESSION['zdjecie'])) {
        $nazwa = $_SESSION['zdjecie'];
        echo "<img src='$nazwa' alt='Zdjęcie użytkownika' style='max-width: 200px; border: 2px solid black;'>";
    } else {
        echo "<img src='brak.jpg' alt='Brak zdjęcia na serwerze - wgraj własne' style='max-width: 200px;'>";
    }
echo "<br><br>";
echo $_SESSION["zalogowanyImie"];
?>
<br><br>
<a href="index.php">Powrót do formularza logowania (index.php)</a>

<fieldset>
<legend>Wgrywanie zdjecia</legend>
<form action="user.php" method="POST" enctype="multipart/form-data">
        <label for="plik_zdjecia">Wybierz zdjęcie (JPG, PNG):</label><br>
        <input type="file" name="plik_zdjecia" accept="image/png, image/jpeg" required>
        <input type="submit" value="Wgraj plik">
    </form>
</fieldset>

<br>
<form id="wyloguj" method="POST" action="index.php">
    <button id="wyloguj" name="wyloguj" value="wyloguj">Wyloguj</button>
</form>
</body>
</html>