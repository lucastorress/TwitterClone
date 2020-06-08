<?php 
session_start();
$usuario_id = $_SESSION['usuario_id'];

if($usuario_id){
	if($_POST['tweet'] != ""){
		$tweet = $_POST['tweet'];
		
		if (strlen($tweet) > 140) {
			echo "
			<script>
			function myFunction() {
				alert('Você ultrapassou o limite de caracteres. (Máximo: 140)');
			}
			function newDoc() {
			window.location.replace('index.php');
			}
			
			myFunction();
			newDoc();
			</script>
			";
			exit();
		}
		
		$tempo = time();
		
		include "config/conexao.php";
		
		$sql = "SELECT usuario
				FROM usuarios 
				WHERE id ='$usuario_id'
				";
		$resultado = $conexao->query($sql);
		$row = $resultado->fetch_assoc();
		
		$usuario = $row['usuario'];
		
		$sql = "INSERT INTO tweets(usuario, usuario_id, tweet, tempoinicial) 
				VALUES ('$usuario', '$usuario_id', '$tweet', $tempo)";

		$resultado = $conexao->query($sql);
		
		$sql = "UPDATE usuarios
				SET tweets = tweets + 1
				WHERE id='$usuario_id'
				";
		
		$resultado = $conexao->query($sql);
		$conexao->close();
		
		header("Location: .");
	}
	else {
		//header("Location: .");
		echo "
		<script>
		function myFunction() {
			alert('Você deve preencher antes de tweetar!');
		}
		function newDoc() {
			window.location.replace('index.php');
		}
		
		myFunction();
		newDoc();
		</script>
		";
	}
}
?>