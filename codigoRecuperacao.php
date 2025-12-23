<?php
session_start();

// Se o usuário já estiver logado, redireciona para a home
if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;


}

if(!isset($_SESSION["codigo"]) || empty($_SESSION["codigo"])) {
    header("Location: recuperarSenha.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Código de Recuperação - BloodFlower</title>
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
            /* Estilo específico para input de código */
            text-align: center; 
            letter-spacing: 5px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .form-control:focus {
            box-shadow: none;
            background-color: #fff;
            border: 1px solid #e2e2e2;
        }

        /* Remove as setinhas do input type number */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        input[type=number] {
            -moz-appearance: textfield;
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
            cursor: pointer;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-card">
    <img src="imagens/LogoBloodFlower.png" alt="Logo BloodFlower" class="logo">

    <h2>Verificar Código</h2>
    <p class="description">Insira o código de segurança enviado para o seu e-mail.</p>

    <!-- Exibe erro se o código for inválido (lógica deve estar no PHP) -->
    <?php if (isset($_SESSION['erro_codigo'])): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $_SESSION['erro_codigo'] ?>
        </div>
        <?php unset($_SESSION['erro_codigo']); ?>
    <?php endif; ?>

    <form method="post" action="trocarSenha.php">
        <div class="mb-4 input-group">
            <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
            <input 
                type="number" 
                class="form-control" 
                id="codigo" 
                name="codigo" 
                placeholder="000000" 
                required
                minlength="6"
                maxlength="6"
            >
        </div>

        <button type="submit" class="btn btn-login w-100">Verificar Código</button>

        <div class="link">
            Não recebeu o código? <a href="reenviarCodigo.php">Reenviar</a>
        </div>
        
        <div class="link mt-2">
            <a href="recuperarSenha.php" class="text-secondary small">Voltar</a>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>