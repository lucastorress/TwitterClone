<?php 
session_start();
$usuario_id = $_SESSION['usuario_id'];

if($usuario_id) {
	if(isset($_GET['id'])) {
		
		include "config/conexao.php";
		
		$del = $_GET['id'];
		
		$sql = "UPDATE usuarios SET tweets = tweets - 1 WHERE id IN (SELECT usuario_id FROM tweets WHERE id = $del)";
		$conexao->query($sql);
		
		$sql2 = "DELETE FROM tweets WHERE id = $del";
		$conexao->query($sql2);
		
		$conexao->close();
		header("Location: ../index.php");
	}
	else {
		header("Location: ../index.php");
	}
}
?>