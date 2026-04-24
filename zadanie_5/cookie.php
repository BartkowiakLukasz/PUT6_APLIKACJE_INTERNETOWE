<!DOCTYPE html>
<html>

<head>
    <title>PHP</title>
    <meta charset='UTF-8' http-equiv="refresh" content="5;url=index.php" />
    
    <?php require("funkcje.php") ?>
</head>

<body>
    <?php
    if (isset($_GET["utworzCookie"])) {
        $cookie_timeout = (int)$_GET["czas"];
        $cookie_name = "ciasteczko";
        $cookie_value = "sekretna wartosc ciasteczka";
        setcookie($cookie_name, $cookie_value, time() + $cookie_timeout, "/");
        echo  "<p>Pomyślnie utworzono cookie o nazwie '$cookie_name' ze zdefiniowanym czasem życia: $cookie_timeout sekund.</p>";
        echo "<p>Powrót za <span id='sekundy'>5</span> sekund...</p>";
        echo "<script>
                let s = 5;
                setInterval(() => {
                s--;
                if(s >= 0) document.getElementById('sekundy').innerText = s;
                }, 1000);
            </script>";
    }
    ?>

    <a href="index.php">Powrót do formularza logowania (index.php)</a>
</body>

</html>