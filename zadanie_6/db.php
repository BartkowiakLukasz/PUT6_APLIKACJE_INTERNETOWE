<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$link = mysqli_connect("localhost", "scott", "tiger", "instytut");
if (!$link) {
    die("Błąd połączenia z bazą danych.");
}
?>
