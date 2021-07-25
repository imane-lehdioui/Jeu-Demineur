<?php  
	
session_start();

 $_SESSION['FIRSTName'] = $_POST['FIRSTName'];
 $_SESSION['LASTName'] = $_POST['LASTName'];

 
echo   $_SESSION['FIRSTName']. ' ' .  $_SESSION['LASTName']; 



header('location:index.php');

?>