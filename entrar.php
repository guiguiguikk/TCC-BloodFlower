<?php
session_start();
if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Entrar - Bloodfloewr</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(145deg, #f8f9fa, #e8ebf0);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background-color: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 400px;
        }

        .login-card h2 {
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            color: #dc3545;
        }

        .form-control {
            border-radius: 12px;
            height: 48px;
        }

        .btn-login {
            background-color: #dc3545;
            border-radius: 12px;
            height: 48px;
            font-weight: 500;
            font-size: 1rem;
        }

        .btn-login:hover {
            background-color: #c82333;
        }

        .link {
            font-size: 0.9rem;
            text-align: center;
            display: block;
            margin-top: 20px;
        }

        .link a {
            color: #444;
            text-decoration: underline;
        }

        .link a:hover {
            color: #000;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h2>bloodfloewr</h2>
    <form action="login.php" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input 
                type="email" 
                class="form-control" 
                id="email" 
                name="email" 
                placeholder="Digite seu e-mail" 
                required
            >
        </div>
        <div class="mb-4">
            <label for="senha" class="form-label">Senha</label>
            <input 
                type="password" 
                class="form-control" 
                id="senha" 
                name="password" 
                placeholder="Digite sua senha" 
                required
            >
        </div>
        <button type="submit" class="btn btn-login w-100">Entrar</button>
        <div class="link mt-3">
            Não tem uma conta? <a href="cadastro.html">Cadastre-se</a>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
