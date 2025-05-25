<?php
$page_name = "Modifica Prodotto";
include 'includes/header.php';
if(!isset($_SESSION['admin'])) {
    header("Location: index.php");
}
require_once 'php/connection.php';
?>
<section class="section-centering">
    <h2 class="title-page"><?=$page_name?></h2>
    <?php
        $id = $_GET['id'];
        $message = "";

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = ucfirst($_POST['nome']);
            $sql = "UPDATE prodotti SET nome = '$nome', id_categoria = {$_POST['id_categoria']}, prezzo = {$_POST['prezzo']}, stock = {$_POST['stock']} WHERE id = $id;";

            if($conn->query($sql) === TRUE) {
                $message = "Prodotto modificato con successo";

            } else {
                $message =  "Errore: {$conn->error}";
            }
        }

        $sql = "SELECT p.nome, prezzo, stock, c.id as id_categoria, c.nome as categoria FROM prodotti p JOIN categorie c on p.id_categoria = c.id WHERE p.id = $id;";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    ?>

    <!-- In value faccio vedere i valori attuali -->
    <form class="form" action="" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required value="<?=$row['nome']?>">

        <label for="id_categoria">Categoria:</label>
        <select name="id_categoria" required>
            <option value="<?=$row['id_categoria']?>"><?=$row['categoria']?></option>
            <?php
                $sql = "SELECT * FROM categorie WHERE id != {$row['id_categoria']} ORDER BY nome;";
                $result = $conn->query($sql);
                while($row_c = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row_c['id']}'>{$row_c['nome']}</option>";
                }
            ?>
        </select>
        
        <label for="prezzo">Prezzo:</label>
        <input type="number" name="prezzo" min="0" step="0.01" required value="<?=$row['prezzo']?>">

        <label for="stock">Stock:</label>
        <input type="number" name="stock" min="0" required value="<?=$row['stock']?>">
        
        <input type="submit" value="Modifica">
    </form>
    <p><?=$message?></p>
</section>
<?php
include 'includes/footer.php';
?>