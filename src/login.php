<?php
$page_name = "Accesso";
include 'includes/header.php';
// require_once 'php/connection.php';
?>
<section class="section-centering">
    <h2 class="title-page"><?=$page_name?></h2>
    <form class="form" method="POST" action="">
        <label for="email">E-mail:</label>
        <input name="email" type="email" required>

        <label for="password">Password:</label>
        <input name="password" type="password" required>

        <input type="submit" value="Accedi">
    </form>
    <?php
        $conn = new mysqli("localhost", "root", "", "all_shop");
        if($conn->connect_error) {
            die("connection fallita: ".$conn->connect_error);
        }
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            // Prima controllo se l'email può essere di un admin
            $sql = "SELECT id, password FROM admin WHERE email = '$email';";
            $result = $conn->query($sql);

            if($result->num_rows) {
                $row = $result->fetch_assoc();
                $hashed_password = $row["password"];
                if(password_verify($password, $hashed_password)) {
                    $_SESSION['admin'] = $row['id'];
                    $_SESSION['message'] = "Accesso admin eseguito con successo";
                    header("Location:message.php");
                } else {
                    echo "<p>Password errata</p>";
                }
            } else {
                // Poi se è di un cliente
                $sql = "SELECT id, password FROM clienti WHERE email = '$email';";
                $result = $conn->query($sql);

                if($result->num_rows){
                    $row = $result->fetch_assoc();
                    $hashed_password = $row["password"];
                    if(password_verify($password, $hashed_password)) {
                        $_SESSION['client'] = $row['id'];
                        $_SESSION['message'] = "Accesso eseguito con successo";
                        header("Location:message.php");
                    } else {
                        echo "<p>Password errata</p>";
                    }
                } else {
                    echo "<p>Cliente non trovato</p>";
                }
            }
        }
    ?>
</section>
<?php
include 'includes/footer.php';
?>