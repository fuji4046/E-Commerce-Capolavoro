<?php
$page_name = "Registrazione cliente";
include 'includes/header.php';
require_once 'php/connection.php';
?>
<section class="section-centering">
    <h2 class="title-page"><?=$page_name?></h2>
    <form class="form" action="" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required>

        <label for="cognome">Cognome:</label>
        <input type="text" name="cognome" required>

        <label for="email">E-mail:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>
        
        <input type="submit" value="Registrati">
    </form>
    <?php
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = $_POST["nome"];
            $cognome = $_POST["cognome"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            
            // Per gli smanettoni che tolgono required
            if($nome === NULL || $email === NULL || $password === NULL) {
                echo "<p>Inserisci tutti i dati!</p>";
            } else {
                // Controllo se c'è già un admin con la stessa email
                $sql = "SELECT id FROM admin WHERE email = '$email';";
                $result = $conn->query($sql);

                if(!$result->num_rows) {
                    $reg_date = date("Y-m-d");
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO clienti(nome, cognome, email, password, data_registrazione) VALUES('$nome', '$cognome', '$email', '$password', '$reg_date');";

                    if($conn->query($sql) === TRUE) {
                        $sql = "SELECT id FROM clienti WHERE email = '$email'";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $_SESSION["client"] = $row['id'];

                        $_SESSION['message'] = "Registrazione avvenuta con successo";
                        header("Location: message.php");
                    } else {
                        echo "<p>Errore: {$conn->error}</p>";
                    }
                } else {
                    echo "<p>Esiste già lo stesso indirirzzo e-mail nel sistema</p>";
                }
            }
        }
    ?>
</section>
<?php
include 'includes/footer.php';
?>