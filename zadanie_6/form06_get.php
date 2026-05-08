<?php
session_start();
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista pracowników</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Lista Pracowników</h2>

    <?php
    if (isset($_SESSION['success'])) {
        echo "<div class='alert alert-success'>" . htmlspecialchars($_SESSION['success']) . "</div>";
        unset($_SESSION['success']);
    }
    
    if (isset($_SESSION['error'])) {
        echo "<div class='alert alert-error'>" . htmlspecialchars($_SESSION['error']) . "</div>";
        unset($_SESSION['error']);
    }

    try {
        $sql = "SELECT ID_PRAC, NAZWISKO FROM pracownicy ORDER BY ID_PRAC ASC";
        $result = $link->query($sql);
        
        if ($result && $result->num_rows > 0) {
            echo "<table>";
            echo "<thead>
                    <tr>
                        <th style='width: 30%;'>ID</th>
                        <th>Nazwisko</th>
                        <th style='width: 20%;'>Akcje</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            
            foreach ($result as $v) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars((string)$v["ID_PRAC"]) . "</td>";
                echo "<td>" . htmlspecialchars($v["NAZWISKO"]) . "</td>";
                echo "<td>
                        <form action='form06_redirect.php' method='POST' style='margin:0;'>
                            <input type='hidden' name='action' value='delete'>
                            <input type='hidden' name='id_prac' value='" . htmlspecialchars((string)$v["ID_PRAC"]) . "'>
                            <button type='submit' class='btn btn-delete' onclick=\"return confirm('Czy na pewno chcesz usunąć tego pracownika?');\">Usuń</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            
            echo "</tbody>";
            echo "</table>";
            $result->free();
        } else {
            echo "<p class='empty-state'>Brak pracowników w bazie danych.</p>";
        }
        $link->close();
    } catch (mysqli_sql_exception $e) {
        error_log($e->getMessage());
        echo "<div class='alert alert-error'>Przepraszamy, wystąpił problem z bazą danych.</div>";
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "<div class='alert alert-error'>Wystąpił nieoczekiwany błąd systemu.</div>";
    }
    ?>

    <a href="form06_post.php" class="btn">+ Dodaj nowego pracownika</a>
</div>

</body>
</html>