<?php
session_start();
session_unset(); // Destrói todas as variáveis de sessão
session_destroy(); // Destroi a sessão
header("Location: LoginUserFront.php"); // Redireciona para a página de login
exit();
?>
