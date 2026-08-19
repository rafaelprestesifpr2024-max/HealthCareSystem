<?php
session_start();

// Remove os dados do usuário logado
unset($_SESSION["usuario_id"]);
unset($_SESSION["usuario_nome"]);

// Encerra completamente a sessão
session_destroy();

// Redireciona para a tela de login
header("Location: index.php");
exit;
?>
