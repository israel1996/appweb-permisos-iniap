<?php 
	session_start();

	$idper=$_POST['valor'];

	$_SESSION['id_employee_search']=$idper;

	echo $idper;

 ?>