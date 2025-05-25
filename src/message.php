<?php
$page_name = "Messaggio di sistema";
include 'includes/header.php';
?>
<section class="section-centering">
    <p style="font-size: 3rem;"><?=$_SESSION['message']?></p>
</section>
<?php
    include 'includes/footer.php';
    unset($_SESSION['message']);
?>
<script>
    // Dopo 3 secondi reindirizza
    setTimeout(() => location.href = "index.php", 3000);
</script>