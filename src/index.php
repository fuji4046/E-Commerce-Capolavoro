<?php
session_start();
$page_name = isset($_SESSION['admin']) ? "Gestione Prodotti" : "Prodotti";
include 'includes/header.php';
require_once 'php/connection.php';
// Se non sei loggato
if (!isset($_SESSION['client']) && !isset($_SESSION['admin'])) {
    // Qui uso js perchè header() di php non funziona a volte dopo echo  
    echo '<script>location.replace("choose_log_sign.php");</script>';
    // Qui faccio exit perchè il codice continua
    exit();
}
?>
<style>
    .table-button {
        text-align: center;
    }
</style>
<h2 class="title-page"><?=$page_name?></h2>
<section class="section-centering">
    <!-- Tabella prodotti che fa scegliere quani -->
        <?php
            if(isset($_SESSION['client'])) {
                echo '<form class="form-products" method="post" action="">';
            }
                $sql = "SELECT p.id as id, p.nome, prezzo, stock, c.nome as categoria FROM prodotti p JOIN categorie c on p.id_categoria = c.id ORDER BY c.nome, p.nome;";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                echo "
                    <table class='table'>
                        <thead>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Prezzo</th>
                            <th>Stock</th>
                    ";
                    if(isset($_SESSION['client'])) {
                        echo "<th>Acquista</th>";
                    } elseif(isset($_SESSION['admin'])) {
                        echo "
                            <th></th>
                            <th></th>
                        ";
                    }
                echo "    
                        </thead>
                        <tbody>
                ";
                while($row = mysqli_fetch_assoc($result)) {
                    echo "
                            <tr>
                                <td>{$row['nome']}</td>
                                <td>{$row['categoria']}</td>
                                <td>{$row['prezzo']} €</td>
                                <td>{$row['stock']}</td>
                        ";
                    if(isset($_SESSION['client'])) {
                        echo "
                                <td class='input-quantity-container'><input class='input-quantity' type='number' name='{$row['id']}' min='0' max='{$row['stock']}'></td>
                        ";
                    } elseif(isset($_SESSION['admin'])) {
                        // Le img sono edit e delete
                        echo "
                                <td class='table-button'><a href='edit_product.php?id={$row['id']}'><img src='images/edit_square.svg'></a></td>
                                <td class='table-button'><a href='choose_delete_product.php?id={$row['id']}'><img src='images/delete.svg'></a></td>
                        ";
                    } 
                    echo "
                        </tr>
                    ";
                }
                echo "
                        </tbody>
                    </table>
                ";
            } else {
                echo "<p>Non ci sono prodotti nel database</p>";
            }
            if(isset($_SESSION['client'])) {
                echo "<input class='submit-button' type='submit' value='Metti prodotti selezionati nel carrello'>";
                echo '</form>';
            }
        ?>
    
    <?php
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            foreach ($_POST as $id_prodotto => $quantita) {
                // Se quantita maggiore di 0 aggiungi al carrello
                if($quantita > 0) {
                    $sql = "SELECT id FROM carrello WHERE id_prodotto = $id_prodotto and id_cliente = {$_SESSION['client']};";

                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $id_elemento = $row['id'];

                    if($id_elemento === NULL) {
                        $sql = "INSERT INTO carrello(id_prodotto, qt_prodotto, id_cliente) VALUES ($id_prodotto,   $quantita, {$_SESSION['client']});";

                        if($conn->query($sql) === FALSE) {
                            echo "<p>Errore nell'inserimento del prodotto nel carrello: {$conn->error}</p>";
                        }
                    } else {
                        $sql = "UPDATE carrello SET qt_prodotto = $quantita WHERE id = $id_elemento";

                        if($conn->query($sql) === FALSE) {
                            echo "<p>Errore nell'inserimento del prodotto nel carrello: {$conn->error}</p>";
                        }
                    }
                }
            }
            echo "<script>location.replace('cart.php')</script>";
        }
    ?>
</section>
<?php
include 'includes/footer.php';
?>