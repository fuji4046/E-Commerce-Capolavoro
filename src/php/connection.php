<?php
$conn = new mysqli("localhost", "root", "", "all_shop");
if($conn->connect_error) {
    die("connection fallita: ".$conn->connect_error);
}
?>