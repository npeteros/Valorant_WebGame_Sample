<?php
    include('includes/header.html');

	$_SESSION = []; 
	session_destroy();
    header("Location: index.php");
	
    include('includes/footer.html');
?>