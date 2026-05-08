<?php
function custom_exception_handler($exception) {
    error_log($exception->getMessage());
    echo "<div class='alert alert-error'>Przepraszamy, wystąpił nieoczekiwany błąd systemu. Spróbuj ponownie później.</div>";
}
set_exception_handler('custom_exception_handler');

session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj pracownika</title>
    <link rel="stylesheet" href="post.css">
</head>
<body>

<div class="container">
    <h2>Dodaj Nowego Pracownika</h2>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<div class='alert alert-error'>" . htmlspecialchars($_SESSION['error']) . "</div>";
        unset($_SESSION['error']);
    }
    ?>

    <form action="form06_redirect.php" method="POST">
        <div class="form-group">
            <label for="id_prac">ID Pracownika</label>
            <input type="number" id="id_prac" name="id_prac" required placeholder="np. 123">
        </div>
        
        <div class="form-group">
            <label for="nazwisko">Nazwisko</label>
            <input type="text" id="nazwisko" name="nazwisko" required placeholder="np. Kowalski">
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Wstaw</button>
            <button type="reset" class="btn btn-secondary">Wyczyść</button>
        </div>
    </form>

    <div class="link-container">
        <a href="form06_get.php" class="link-btn">← Powrót do listy pracowników</a>
    </div>
</div>

</body>
</html>
