<?php
	include 'classes/Session.php';

	session_start();
	$session = new Session;
	$session->destroy();

	header("Location:index.php");
?>
