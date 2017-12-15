<?php
session_start();
$usuario_id = $_SESSION['usuario_id'];
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<title>TwitterPHP</title>
</head>
<body style="margin:auto; width:300px; zoom:125%; background-image: url(img/bg.jpg); background-size: cover;">
	<h3 style="color: white;text-align: center; letter-spacing: 3px;">Twitter<br>
	<span style="color: white; text-align: center; font-size: 9px; text-transform: uppercase;">Seja bem-vindo</span>
	</h3>
	<?php
	function getTime($tempo_inicial){
	$tempo_run = time() - $tempo_inicial;
	if ($tempo_run>=86400)
		$tempo_final = date("d/m/Y",$tempo_inicial);
	elseif ($tempo_run>=3600)
		$tempo_final = (floor($tempo_run/3600))." h";
	elseif ($tempo_run>=60)
		$tempo_final = (floor($tempo_run/60))." m";
	else
		$tempo_final = $tempo_run." s";
	return $tempo_final;
	}
	if(isset($_GET['usuario'])) {
		
		include "config/conexao.php";
		
		$usuario = strtolower($_GET['usuario']);
		
		$sql = "SELECT id, usuario, seguidores, seguindo, tweets, url_img
				FROM usuarios
				WHERE usuario = '$usuario'
				";
		
		$resultado1 = $conexao->query($sql);
		
		if($resultado1->num_rows >= 1) {
			
			$row = $resultado1->fetch_assoc();
			
			$id = $row['id'];
			$usuario = $row['usuario'];
			$tweets = $row['tweets'];
			$seguidores = $row['seguidores'];
			$seguindo = $row['seguindo'];
			$url_img = $row['url_img'];
			
			if($usuario_id) {
				if($usuario_id != $id) {
					$sql2 = "SELECT id
							 FROM following
							 WHERE usuario1_id = $usuario_id AND usuario2_id = $id
							";
					
					$resultado2 = $conexao->query($sql2);
					
					if($resultado2->num_rows >= 1){
						echo "<a href='unfollow.php?userid=$id&usuario=$usuario' class='btn btn-danger btn-xs' style='float:right;'>Deixar de Seguir</a>";
					} else {
						echo "<a href='follow.php?userid=$id&usuario=$usuario' class='btn btn-primary btn-xs' style='float:right;'>Seguir</a>";
					}
				}
			} else {
				echo "<a href='registro.php' class='btn btn-info btn-xs' style='float:right;'>Inscreva-se</a>";
			}
			
			echo "
			<table style='margin-bottom:5px;'>
				<tr>
					<td>
						<img src='./img/$url_img' style='width:65px;' alt='Foto'/>
					</td>
					<td valign='top' style='padding-left:8px;'>
						<h6>
					<a href='$usuario'>
					<span class='btn btn-primary' style='width: 230px; text-transform: uppercase; font-size:12px !important;'>
					<span class='glyphicon glyphicon-user' aria-hidden='true'></span> $usuario
					</span>
					</a>
					</h6>
					<h6 style='margin-top: -5px;'>
					<span class='btn btn-default' style='width: 230px; font-size:11px !important;'>Tweets: <a href='#'>$tweets</a> | Seguindo: <a href='#'>$seguindo</a> | Seguidores: <a href='#'>$seguidores</a></span>
					</h6>
					</td>
				</tr>
			</table>
			";
			
			$sql3 = "SELECT id
					 FROM following
					 WHERE usuario1_id = $id AND usuario2_id = $usuario_id
					";

			$resultado3 = $conexao->query($sql3);
			
			if($resultado3->num_rows >= 1) {
				echo "<span class='btn btn-warning' style='margin-bottom: 10px; width: 300px; font-size:11px !important;'><span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span> <i>Segue você</i></span>";
			}
			
			$sql_tweets = "SELECT usuario, tweet, tempoinicial
					   FROM tweets
					   WHERE usuario_id = $id
					   ORDER BY tempoinicial DESC
					   LIMIT 0, 5
					  ";
					  
			$resultado_tweet = $conexao->query($sql_tweets);
			
			if ($resultado_tweet->num_rows <= 0) {
				echo "<div class='alert alert-info'>Esse usuário não possue alguma postagem.</div>";
			}
			
			while($tweet = $resultado_tweet->fetch_array(MYSQLI_ASSOC)) {
				echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
				echo "<div style='font-size:10px;float:right;'>".getTime($tweet['tempoinicial'])."</div>";
				echo "<table>";
				echo "<tr>";
				echo "<td valign=top style='padding-top:4px;'>";
				echo "<img src='./img/$url_img' style='width:35px;' alt='Foto'/>";
				echo "</td>";;
				echo "<td style='padding-left:5px;word-wrap: break-word;' valign=top>";
				echo "<a style='font-size:12px;' href='./".$tweet['usuario']."'>@".$tweet['usuario']."</a>";
				echo "<p style='font-size:12px;'>".$tweet['tweet']."</p>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";
				echo "</div>";
			}

			$resultado_tweet->close();
			$conexao->close();
		} else {
			echo "<a href='javascript:window.history.go(-1)' style='text-decoration:none;'><div style='margin-top: 35px !important;' class='alert alert-danger'>Desculpe, esse usuário não existe.</div></a>";
		}
	}
	if($usuario_id) {
		echo "
			<div class='panel panel-default' style='margin-top: 10px !important;'>
				<div style='text-align: center;' class='panel-body'>
					<a href='.'>Início »</a> | <a href='javascript:window.history.go(-1)'>Voltar »</a> | <a href='logout.php'>Desconectar-se »</a>
				</div>
			</div>
		";
		} else {
			echo "
				<div class='panel panel-default' style='margin-top: 10px !important;'>
					<div class='panel-body'>
						Você possui uma conta? <a href='index.php'>Entrar »</a>
					</div>
				</div>
			";
		}
	?>
</body>
</html>
