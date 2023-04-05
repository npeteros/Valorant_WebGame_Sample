<?php
    define('LOBBY', 1);
    define('TITLE', 'VALORANT');
    include('includes/header.html');
    include('includes/navbar.html');
    include('includes/footer.html');
    if(!isset($_SESSION['user'])) header("Location: index.php");     
?>