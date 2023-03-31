<?php
	session_start();
	unset($_SESSION['Mirlyn_id']);

	header("Location: connexion.php");
	die;

?>