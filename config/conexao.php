<?php
//********************************************************************************
	$bdhost	= "localhost";
	$usuario = "root";
	$senha	= "senha";
	$bdnome	= "banco";
//********************************************************************************

	$conexao = new mysqli($bdhost, $usuario, $senha, $bdnome);

	if ($conexao->connect_errno)
			die("Falha na conexão:(".$conexao->connect_errno.") ".$conexao->connect_error);

?>