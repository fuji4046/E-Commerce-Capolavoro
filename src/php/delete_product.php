<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
} else {
    require_once 'connection.php';
    $sql = "DELETE FROM prodotti WHERE id = {$_GET['id']};";
    if($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Prodotto eliminato con successo";
        header("Location: ../message.php");
    } else {
        echo "Errore: {$conn->error}";
    }
}
?>