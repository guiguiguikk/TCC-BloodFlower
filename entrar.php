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
    <title>Entrar - BloodFlower</title>
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
        }

        .login-card h2 {
            font-weight: 700;
            color: #8b0000;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group-text {
            background-color: #f1f1f1;
            border: none;
            border-radius: 12px 0 0 12px;
        }

        .form-control {
            border-radius: 0 12px 12px 0;
            border: none;
            background-color: #f9f9f9;
            height: 48px;
        }

        .form-control:focus {
            box-shadow: none;
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

        .input-group .toggle-password {
            cursor: pointer;
            border-radius: 0 12px 12px 0;
            background-color: #f1f1f1;
            border: none;
            padding: 0 12px;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <img src="imagens/LogoBloodFlower.png" alt="Logo BloodFlower" class="logo">

        <h2>Entrar na BloodFlower</h2>

        <!-- Mensagem de erro -->
        <?php if (isset($_SESSION['erro_login'])): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $_SESSION['erro_login'] ?>
            </div>
            <?php unset($_SESSION['erro_login']); ?>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                <input
                    type="email"
                    class="form-control"
                    name="email"
                    placeholder="E-mail"
                    required>
            </div>

            <div class="mb-4 input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input
                    type="password"
                    class="form-control"
                    id="senha"
                    name="password"
                    placeholder="Senha"
                    minlength="8"
                    required>
                <span class="input-group-text toggle-password" onclick="togglePassword()">
                    <i class="bi bi-eye-slash" id="eye-icon"></i>
                </span>

            </div>
            <div class="link">
                <a href="recuperarSenha.php">Esqueceu a senha?</a>
            </div>

            <button type="submit" class="btn btn-login w-100">Entrar</button>

            <div class="link">
                Não tem uma conta? <a href="cadastro.php">Cadastre-se</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS para mostrar/ocultar senha -->
    <script>
        function togglePassword() {
            const senhaInput = document.getElementById('senha');
            const eyeIcon = document.getElementById('eye-icon');

            if (senhaInput.type === 'password') {
                senhaInput.type = 'text';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            } else {
                senhaInput.type = 'password';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            }
        }
    </script>

</body>

</html>