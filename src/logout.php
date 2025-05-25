<?php
session_start();
session_destroy();
session_start();
$_SESSION['message'] = "Sei uscito dall'account con successo";
header("Location: message.php");
?>