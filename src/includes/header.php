<?php
if(!isset($_SESSION)){
    session_start();
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$page_name?></title>
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <style>
    <?php
    // Se non sei loggato il titolo va al centro
    if(!isset($_SESSION['client']) && !isset($_SESSION['admin'])) {
    echo "
        .title-container {
            width: 100%;
            justify-content: center;
        }";
    }
    ?>
    </style>
</head>
<body>
    <header>
        <a href="index.php" class="title-container">
            <span class="logo-container">
                <img class="logo" src="images/logo.png">
            </span>
            <h1>
                ALL<br>SHOP
            </h1>
        </a>
        <?php
        if(isset($_SESSION['client']) || isset($_SESSION['admin'])) {
            echo "
                <nav>
                    <ul>
                ";
            if(isset($_SESSION['client'])) {
                echo "<li class='nav-element'><a href='cart.php'>Carrello</a></li>";
            }
                    
            echo "
                        <li class='nav-element'><a href='logout.php'>Esci</a></li>
                    </ul>
                </nav>    
            ";
        }
        ?>
    </header>
    
