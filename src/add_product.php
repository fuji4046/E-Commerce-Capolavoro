<?php
$page_name = "Aggiungi Prodotto";
include 'includes/header.php';
require_once 'php/connection.php';
?>
<section class="section-centering">
    <h2 class="title-page"><?=$page_name?></h2>
    <form class="form" action="" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required>

        <label for="id_categoria">Categoria:</label>
        <select name="id_categoria" required>
            <option value="">--Scegli categoria--</option>
            <!-- Prendere categorie dalla tabella categoria -->
            <?php
                $sql = "SELECT * FROM categorie ORDER BY nome;";
                $result = $conn->query($sql);
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
            ?>
        </select>
        
        <label for="prezzo">Prezzo:</label>
        <input type="number" name="prezzo" min="0" step="0.01" required>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" min="0" required>
        
        <input type="submit" value="Invia">
    </form>
    <?php
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = ucfirst($_POST["nome"]);
            $id_categoria = $_POST["id_categoria"];
            $prezzo = round($_POST["prezzo"], 2); // se lo smanettone toglie step
            $stock = $_POST["stock"];
            
            // Per gli smanettoni che tolgono required
            if($nome === NULL || $id_categoria === NULL || $prezzo === NULL || $stock === NULL) {
                echo "<p>Inserisci tutti i dati!</p>";
            } else{
                $sql = "INSERT INTO prodotti (nome, id_categoria, prezzo, stock) VALUES ('$nome', $id_categoria, $prezzo, $stock);";

                if($conn->query($sql) === TRUE) {
                    echo "<p>Prodotto aggiunto con successo</p>";
                } else {
                    echo "<p>Errore: {$conn->error}</p>";
                }
            }
        }
    ?>
</section>
<?php
include 'includes/footer.php';
?>