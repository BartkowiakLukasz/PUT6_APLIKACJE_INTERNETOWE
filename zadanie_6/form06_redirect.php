<?php
session_start();
require_once 'db.php';

try {
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        if (!isset($_POST['id_prac']) || !is_numeric($_POST['id_prac'])) {
            $_SESSION['error'] = "Nieprawidłowe ID pracownika.";
            header("Location: form06_get.php");
            exit();
        }

        $sql = "DELETE FROM pracownicy WHERE id_prac = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("i", $_POST['id_prac']);
        
        try {
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $_SESSION['success'] = "Pracownik został usunięty pomyślnie.";
            } else {
                $_SESSION['error'] = "Nie znaleziono pracownika o podanym ID.";
            }
            header("Location: form06_get.php");
            exit();
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage());
            $_SESSION['error'] = "Błąd podczas usuwania pracownika. Spróbuj ponownie później.";
            header("Location: form06_get.php");
            exit();
        }
    } else {
        $nazwisko = isset($_POST['nazwisko']) ? trim($_POST['nazwisko']) : '';

        if (!isset($_POST['id_prac']) || !is_numeric($_POST['id_prac']) || empty($nazwisko)) {
            $_SESSION['error'] = "Nieprawidłowe dane formularza. Upewnij się, że wypełniono wszystkie pola poprawnie.";
            header("Location: form06_post.php");
            exit();
        }
        
        $sql = "INSERT INTO pracownicy(id_prac,nazwisko) VALUES(?,?)";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("is", $_POST['id_prac'], $nazwisko);
        
        try {
            $stmt->execute();
            $_SESSION['success'] = "Pracownik został dodany pomyślnie.";
            header("Location: form06_get.php");
            exit();
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage());
            if ($e->getCode() == 1062) {
                $_SESSION['error'] = "Pracownik o podanym ID już istnieje w bazie.";
            } else {
                $_SESSION['error'] = "Błąd podczas dodawania pracownika. Spróbuj ponownie później.";
            }
            header("Location: form06_post.php");
            exit();
        }
    }
    
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    $_SESSION['error'] = "Problem z połączeniem z bazą danych lub zapytaniem. Spróbuj ponownie później.";
    header("Location: form06_post.php");
    exit();
} catch (Exception $e) {
    error_log($e->getMessage());
    $_SESSION['error'] = "Wystąpił nieoczekiwany błąd systemu.";
    header("Location: form06_post.php");
    exit();
}
?>
