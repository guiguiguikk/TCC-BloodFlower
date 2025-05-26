<?php
session_start();

session_destroy(); // Destroi a sessão atual
header("Location: index.php"); // Redireciona para a página de login
