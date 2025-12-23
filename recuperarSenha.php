<?php 
session_start();

// Se o usuário já estiver logado, redireciona para a home
if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha - BloodFlower</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f8f8f8, #e2e2e2);
            font-family: 'Rubik', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-card {
            background-color: #fff;
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .login-card .logo {
            display: block;
            margin: 0 auto 25px;
            height: 110px;
            /* Caso não tenha a imagem logo aqui, o alt text aparecerá centralizado */
            object-fit: contain; 
        }

        .login-card h2 {
            font-weight: 700;
            color: #8b0000;
            text-align: center;
            margin-bottom: 10px;
        }

        .description {
            text-align: center;
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 30px;
        }

        .input-group-text {
            background-color: #f1f1f1;
            border: none;
            border-radius: 12px 0 0 12px;
            color: #8b0000;
        }

        .form-control {
            border-radius: 0 12px 12px 0;
            border: none;
            background-color: #f9f9f9;
            height: 48px;
        }

        .form-control:focus {
            box-shadow: none;
            background-color: #fff;
            border: 1px solid #e2e2e2;
        }

        .btn-login {
            background-color: #8b0000;
            color: white;
            border: none;
            border-radius: 12px;
            height: 48px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #a40000;
            box-shadow: 0 0 12px rgba(139, 0, 0, 0.2);
        }

        .link {
            font-size: 0.9rem;
            text-align: center;
            margin-top: 20px;
        }

        .link a {
            color: #8b0000;
            text-decoration: none;
            font-weight: 500;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-card">
    <!-- Logo (Certifique-se que o caminho da imagem está correto) -->
    <img src="imagens/LogoBloodFlower.png" alt="Logo BloodFlower" class="logo">

    <h2>Recuperar Senha</h2>
    <p class="description">Digite seu e-mail cadastrado e enviaremos as instruções para você.</p>

    <!-- Exibição de Mensagens de Erro ou Sucesso (Opcional, caso use sessão para feedback) -->
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-info text-center" role="alert">
            <?= $_SESSION['msg'] ?>
        </div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['erro'])): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $_SESSION['erro'] ?>
        </div>
        <?php unset($_SESSION['erro']); ?>
    <?php endif; ?>

    <form action="enviarCodigo.php" method="POST">
        <div class="mb-4 input-group">
            <span class="input-group-text"><i class="bi bi-envelope-at-fill"></i></span>
            <input 
                type="email" 
                class="form-control" 
                id="email" 
                name="email" 
                placeholder="Seu e-mail cadastrado" 
                required
            >
        </div>

        <button type="submit" class="btn btn-login w-100">Enviar Instruções</button>

        <div class="link">
            Lembrou da senha? <a href="index.php">Voltar para o Login</a>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>