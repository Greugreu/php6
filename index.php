<?php
session_start();
include 'inc/pdo.php';
include 'functions/functions.php';
$title = 'homepage';



include 'inc/header.php';
debug($_SESSION);
?>

<h1>Home</h1>

<?php include 'inc/footer.php';
