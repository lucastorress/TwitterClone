<?php
if ($_SERVER['SCRIPT_NAME'] == "/dashboard.php") 
    { 
        header ("Location: ./");
    } 

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
	if($usuario_id){
		include "config/conexao.php";
		$sql = "SELECT usuario, seguidores, seguindo, tweets, url_img
                FROM usuarios
                WHERE id = '$usuario_id'
                ";
		
		$resultado = $conexao->query($sql);
		
		$row = $resultado->fetch_assoc();
		$usuario = $row['usuario'];
		$tweets = $row['tweets'];
		$seguidores = $row['seguidores'];
		$seguindo = $row['seguindo'];
		$url_img = $row['url_img'];
		
		echo "
		<table>
			<tr>
				<td>
					<a href='alterar_foto.php'>
					<img src='./img/$url_img' style='width:65px;' alt='Foto'/>
					</a>
				</td>
				<td valign='top' style='padding-left: 5px;'>
					<div class='btn-group' role='group' aria-label='...'>
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
					</div>
				</td>
			</tr>
		</table>
		<form action='tweet.php' method='POST'>
			<textarea class='form-control' placeholder='O que está acontecendo?' name='tweet'></textarea>
			<button type='submit' style='float:right;margin-top:5px;' class='btn btn-info btn-xs'>
			<span class='glyphicon glyphicon-bullhorn' aria-hidden='true'></span> Tweetar
			</button>
		</form>
		<br>
		<br>
		";
		
		$sql_tweets = "SELECT id, usuario, tweet, tempoinicial
				       FROM tweets
				       WHERE usuario_id = $usuario_id OR (usuario_id IN (SELECT usuario2_id FROM following WHERE usuario1_id='$usuario_id'))
				       ORDER BY tempoinicial DESC
				       LIMIT 0, 5
				       ";
		
		$resultado_tweet = $conexao->query($sql_tweets);
					
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
			echo "<div style='font-size:10px;float:right;'><a href='deletar/".$tweet['id']."'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></div>";
			echo "</div>";
		}
		
		$resultado->close();
		$resultado_tweet->close();
        $conexao->close();
	}
?>
<div class="panel panel-default" style="margin-top: 10px !important;">
  <div class="panel-body">
    Deseja sair? <a href="logout.php">Desconectar-se »</a>
  </div>
</div>
