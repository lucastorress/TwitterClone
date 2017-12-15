<?php
      session_start();
      $usuario_id = $_SESSION['usuario_id'];

      if($_POST['login-btn'] == "submit-login") {
        if($_POST['usuario'] != "" && $_POST['senha'] != "") {
			
          $user = strtolower($_POST['usuario']);
		  
          include "config/conexao.php";

          $sql = "SELECT id, senha
                  FROM usuarios
                  WHERE usuario = '$user'
                  ";

          $resultado = $conexao->query($sql);

          if($resultado->num_rows >= 1){
            $senha = md5($_POST['senha']);
            $row = $resultado->fetch_assoc();
            if($senha == $row['senha']) {
              $_SESSION['usuario_id'] = $row['id'];
              $conexao->close();
              header('Location: .');
              exit();
            }

            else{
              $error_msg = "Usuário ou senha estão incorretos.";
			  $resultado->close();
              $conexao->close();
            }
          }
          else{
            $error_msg = "O nome de usuário e a senha fornecidos não correspondem às informações em nossos registros. Verifique-as e tente novamente.";
			$resultado->close();
            $conexao->close();
          }
        }
        else{
          $error_msg = "Todos os campos devem estar preenchidos.";
        }
      }
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
  if($usuario_id){
    include "dashboard.php";
    exit;
  }
  ?>
  <form role="form" action="index.php" method="POST" style="width:300px;">
    <div class="input-group" style="margin-bottom:10px;">
      <span class="input-group-addon">@</span>
      <input type="text" class="form-control" placeholder="Nome de usuário" name="usuario">
    </div>
    <input type="password" style="margin-bottom:10px;" class="form-control" placeholder="Senha" name="senha">
    <?php
    if($error_msg){
        echo "<div class='alert alert-danger' style='margin-bottom: 10px !important;'>".$error_msg."</div>";
    }
    ?>
    <div class="btn-group">
      <button type="submit" style="width:300px;" class="btn btn-info" name="login-btn" value="submit-login">Entrar</button>
    </div>
  </form>
  <div class="panel panel-default" style="margin-top: 10px !important;">
  <div class="panel-body">
    Não tem uma conta? <a href="registro.php">Inscreva-se »</a>
  </div>
</div>
</body>
</html>
