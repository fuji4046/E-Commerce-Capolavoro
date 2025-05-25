<?php
use BcMath\Number;
$page_name = "Carrello";
include 'includes/header.php';
require_once 'php/connection.php';
if (!isset($_SESSION['client'])) {
    echo '<script>location.replace("index.php");</script>';
    exit();
}
?>
<h2 class="title-page"><?=$page_name?></h2>
<section class="section-centering">
    <form class="form-products" method="post" action="">
        <?php
            // Verifica se ci sono meno prodotti disponibli tra quelli disponibili 
            $sql = "UPDATE carrello as c JOIN prodotti p ON c.id_prodotto = p.id SET c.qt_prodotto = p.stock WHERE c.qt_prodotto > p.stock;";
            $conn->query($sql);
            
            // Visualizza carrello
            $sql = "SELECT * FROM carrello WHERE id_cliente = {$_SESSION['client']};";
            $result = $conn->query($sql);

            if($result->num_rows > 0) {
                echo "
                    <table class='table'>
                        <thead>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Prezzo Unit</th>
                            <th>Quantità</th> 
                            <th>Prezzo Tot</th>
                        </thead>
                        <tbody>
                ";

                // Totale dei prezzi degli elementi nel carrello
                $tot = number_format(0, 2);
                while($row = mysqli_fetch_assoc($result)) {
                    $sql = "SELECT p.id as id, p.nome, prezzo, c.nome as categoria FROM prodotti p JOIN categorie c on p.id_categoria = c.id WHERE p.id = {$row['id_prodotto']};";
                    $result_product = $conn->query($sql);
                    $row_product = mysqli_fetch_assoc($result_product);
                    $prezzo_tot = number_format($row_product['prezzo'], 2) * number_format($row['qt_prodotto']);
                    $tot += $prezzo_tot;
                    echo "
                        <tr>
                            <td>{$row_product['nome']}</td>
                            <td>{$row_product['categoria']}</td>
                            <td>{$row_product['prezzo']} €</td>
                            <td>{$row['qt_prodotto']}</td>
                            <td>{$prezzo_tot} €</td>
                        </tr>
                    ";
                }
                echo "
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th id='tot'>Totale:</th>
                                <td id='tot-value'>{$tot} €</td>
                            </tr>
                        </tfoot>
                    </table>
                    <input class='submit-button' type='submit' value='Conferma ordine'>
                ";

            } else {
                echo "<p>Non ci sono prodotti nel carrello</p>";
            }
        ?>
    </form>
    <?php
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            // Crea ordine
            $today = date('Y-m-d');
            $sql = "INSERT INTO ordini (id_cliente, data_ordine) VALUES ({$_SESSION['client']}, '{$today}');";
            
            if($conn->query($sql) === TRUE) {
                $id_ordine = $conn->insert_id;

                // Copia elementi del carrello in ordini_prodotti
                $sql = "INSERT INTO ordini_prodotti (id_ordine, id_prodotto, qt_prodotto) SELECT $id_ordine, id_prodotto, qt_prodotto FROM carrello WHERE id_cliente = {$_SESSION['client']};";

                if($conn->query($sql) === TRUE) {
                    // Svuota carrello
                    $sql = "DELETE FROM carrello WHERE id_cliente = 1;";
                    if($conn->query($sql) === TRUE) {
                        // Aggiorna quantità nel catalogo
                        $sql = "UPDATE ordini_prodotti as o_p JOIN ordini o on o_p.id_ordine = o.id JOIN prodotti p on o_p.id_prodotto = p.id SET p.stock = p.stock - o_p.qt_prodotto WHERE o.id = $id_ordine;";
                        if($conn->query($sql) === TRUE) {
                            $_SESSION['message'] = "Ordine effettuato con successo";
                            header("Location:message.php");
                        } else{
                            echo "<p>Errore nell'aggiornamento delle quantità:{$conn->error}</p>";
                        }
                    } else {
                        echo "<p>Errore nello svuotamento del carrello:{$conn->error}</p>";
                    }
                } else {
                    echo "<p>Errore nell'inserimento negli ordini:{$conn->error}</p>";
                }
                
            } else {
                echo "<p>Errore:{$conn->error}</p>";
            }
        }
    ?>
</section>
<?php
include 'includes/footer.php';
?>