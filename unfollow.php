<?php 
session_start();
$usuario_id = $_SESSION['usuario_id'];

if($_GET['userid']  && $_GET['usuario']){
	if($_GET['userid'] != $usuario_id) {
		
		$unfollow_userid = $_GET['userid'];
		$unfollow_usuario = $_GET['usuario'];
		
		include "config/conexao.php";
		
		$sql = "SELECT id
				FROM following 
				WHERE usuario1_id = '$usuario_id' AND usuario2_id = '$unfollow_userid'
				";
				
		$resultado = $conexao->query($sql);
		
		if($resultado->num_rows >= 1) {
			$sql = "DELETE FROM following 
				    WHERE usuario1_id = '$usuario_id' AND usuario2_id = '$unfollow_userid'
				    ";
					
			$conexao->query($sql);
				  
			$sql = "UPDATE usuarios
					SET seguindo = seguindo - 1
					WHERE id = '$usuario_id'
					";
					
			$conexao->query($sql);
				
			$sql = "UPDATE usuarios
					SET seguidores = seguidores - 1
					WHERE id = '$unfollow_userid'
					";
			
			$conexao->query($sql);
		}
		
		$resultado->close();
		$conexao->close();		
		header("Location: ./".$unfollow_usuario);
	}
	header("Location: ./".$unfollow_usuario);
}
?>