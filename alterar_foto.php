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

  <title>TwitterPHP - Registre-se!</title>
</head>
<body style="margin:auto; width:300px; zoom:125%; background-image: url(img/bg.jpg); background-size: cover;">
<h3 style="color: white;text-align: center; letter-spacing: 3px;">Twitter<br>
	<span style="color: white; text-align: center; font-size: 9px; text-transform: uppercase;">Mude sua foto</span>
	</h3>
<?php
	if($usuario_id) {
		if(isset($_GET['url_img'])) {
			
			include "config/conexao.php";
			
			$img = $_GET['url_img'];
			
			$sql = "UPDATE usuarios SET url_img = '$img.jpg' WHERE id = $usuario_id";
			
			if ($conexao->query($sql) === TRUE) {
				echo "<div class='alert alert-success'>Alteração realizada com sucesso!</div>";
			} else {
				echo "<div class='alert alert-warning'>Um erro ocorreu! Se persistir, contate o administrador.</div>";
			}
			
			$conexao->close();
		}
		
		echo "
		<table style='margin-bottom: 10px;'>
				<tr>
					<td style='padding-right:8px;'>
						<a href='alterar_foto.php?url_img=default'>
						<img src='./img/default.jpg' style='height: 95px; width: 95px;' alt='Foto'/>
						</a>
					</td>
					<td style='padding-right:8px;'>
						<a href='alterar_foto.php?url_img=oculos'>
						<img src='./img/oculos.jpg' style='height: 95px; width: 95px;' alt='Foto'/>
						</a>
					</td>
					<td style='padding-right:8px;'>
						<a href='alterar_foto.php?url_img=empresario'>
						<img src='./img/empresario.jpg' style='height: 95px; width: 95px;' alt='Foto'/>
						</a>
					</td>
				</tr>
			</table>
			
		<table style='margin-bottom: 10px;'>
				<tr>
					<td style='padding-right:8px;'>
						<a href='alterar_foto.php?url_img=batman'>
						<img src='./img/batman.jpg' style='height: 95px; width: 95px;' alt='Foto'/>
						</a>
					</td>
					<td style='padding-right:8px;'>
						<a href='alterar_foto.php?url_img=noel'>
						<img src='./img/noel.jpg' style='height: 95px; width: 95px;' alt='Foto'/>
						</a>
					</td>
					<td style='padding-right:8px;'>
						<a href='alterar_foto.php?url_img=mulher1'>
						<img src='./img/mulher1.jpg' style='height: 95px; width: 95px;' alt='Foto'/>
						</a>
					</td>
				</tr>
			</table>
			
		<table style='margin-bottom: 10px;'>
				<tr>
					<td style='padding-right:8px;'>
						<a href='alterar_foto.php?url_img=mulher2'>
						<img src='./img/mulher2.jpg' style='height: 95px; width: 95px;' alt='Foto'/>
						</a>
					</td>
					<td style='padding-right:8px;'>
						<a href='alterar_foto.php?url_img=mulher3'>
						<img src='./img/mulher3.jpg' style='height: 95px; width: 95px;' alt='Foto'/>
						</a>
					</td>
					<td style='padding-right:8px;'>
						<a href='alterar_foto.php?url_img=mulher'>
						<img src='./img/mulher.jpg' style='height: 95px; width: 95px;' alt='Foto'/>
						</a>
					</td>
				</tr>
			</table>
		";
		
		echo "
			<div class='panel panel-default' style='margin-top: 10px !important;'>
				<div style='text-align: center;' class='panel-body'>
					<a href='.'>Início »</a> | <a href='javascript:window.history.go(-1)'>Voltar »</a> | <a href='logout.php'>Desconectar-se »</a>
				</div>
			</div>
		";
		} else {
			echo "<div class='alert alert-info'>Você precisa estar logado para alterar a sua foto.</div>";
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