<?php
session_start();
$usuario_id = $_SESSION['usuario_id'];
session_destroy();
header('Location: .');
?>