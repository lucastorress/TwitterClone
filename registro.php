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
  <form action="registro.php" method="POST" role="form" style="width:300px;">
    <h3 style="color: white;text-align: center; letter-spacing: 3px;">Twitter<br>
    <span style="color: white; text-align: center; font-size: 9px; text-transform: uppercase;">Crie já sua conta</span>
	</h3>
<?php
	if($_POST['btn'] == "submit-registro-formulario") {
	  if($_POST['usuario'] != "" && $_POST['senha'] != "" && $_POST['confirmar-senha'] != "") {
		if($_POST['senha'] == $_POST['confirmar-senha']) {
			
			include "config/conexao.php";
			$usuario = strtolower($_POST['usuario']);
			$sql = "SELECT usuario
					FROM usuarios
					WHERE usuario = '$usuario'
					";
					
			$resultado = $conexao->query($sql);
					
		  if(!($resultado->num_rows >= 1)) {
			  
			  $senha = md5($_POST['senha']);
			  
			  $sql = "INSERT INTO usuarios(usuario, senha)
					  VALUES ('$usuario', '$senha')
					  ";
				
			  if ($conexao->query($sql) == TRUE) {
						
			  echo "<div class='alert alert-success'>Sua conta foi criada com sucesso!</div>";
			  echo "<a href='index.php' style='width:300px;' class='btn btn-info'>Logar-se!</a>";
			  echo "</form>";
			  echo "</body>";
			  echo "</html>";
			  $resultado->close();
			  $conexao->close();
			  exit();
			  
			  } else {
				  echo "<div class='alert alert-danger' style='margin-bottom: 10px !important;'><b>Error: ".$conexao->error."</b><br><br>Tente novamente, caso o erro persista, contate o administrador.</div>";
				  $resultado->close();
				  $conexao->close();
			  }

		  }
		  else{
			$error_msg="Usuário já existente. Tente novamente.";
			$resultado->close();
			$conexao->close();
		  }
		}
		else{
		  $error_msg="As senhas não coincidem. Tente novamente.";
		}
	  }
	  else{
		  $error_msg="Todos os campos devem estar preenchidos.";
	  }
	}
?>
    <div class="input-group" style="margin-bottom:10px;">
      <span class="input-group-addon">@</span>
      <input type="text" class="form-control" placeholder="Nome de usuário" name="usuario" value="<?php echo $_POST['usuario']; ?>">
    </div>
    <input type="password" style="margin-bottom:10px;" class="form-control" placeholder="Senha" name="senha">
    <input type="password" style="margin-bottom:10px;" class="form-control" placeholder="Confirme a sua senha" name="confirmar-senha">
    <?php
    if($error_msg){
        echo "<div class='alert alert-danger' style='margin-bottom: 10px !important;'>".$error_msg."</div>";
    }
    ?>
    <button type="submit" style="width:300px; margin-bottom:5px;" class="btn btn-warning" name="btn" value="submit-registro-formulario">Inscreva-se</button>
  </form>
  <div class="panel panel-default" style="margin-top: 10px !important;">
  <div class="panel-body">
    Você possui uma conta? <a href="index.php">Entrar »</a>
  </div>
</div>
</body>
</html>
