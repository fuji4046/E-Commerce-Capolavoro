<?php
$page_name = "Elimina Prodotto";
include 'includes/header.php';
if(!isset($_SESSION['admin'])) {
    header("Location: index.php");
}
require_once 'php/connection.php';
?>
<!-- Pagina di conferma eliminazione prodotto -->
<h2 class="title-page"><?=$page_name?></h2>
<section class="section-centering">
    <?php
        $id = $_GET['id'];
        $sql = "SELECT p.nome, prezzo, stock, c.id as id_categoria, c.nome as categoria FROM prodotti p JOIN categorie c on p.id_categoria = c.id WHERE p.id = $id;";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    ?>
    <h3>Sei sicuro di voler eliminare il prodotto?</h3>
    <table class='table'>
        <thead>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Prezzo</th>
            <th>Stock</th>
        </thead>
        <tbody>
            <tr>
                <td><?=$row['nome']?></td>
                <td><?=$row['categoria']?></td>
                <td><?=$row['prezzo']?></td>
                <td><?=$row['stock']?></td>
            </tr>
        </tbody>
    </table>
    <div class="button-container">
        <a class="button" href="php/delete_product.php?id=<?=$id?>">Si</a>
        <a class="button" href="index.php">No</a>
    </div>
</section>
<?php
include 'includes/footer.php';
?>