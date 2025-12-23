<?php
session_start();

// Se já estiver logado, sai fora
if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}
if (isset($_SESSION["codigo"]) && !empty($_SESSION["codigo"])) {
    if ($_SESSION["codigo"] != $_POST['codigo']) {
        $_SESSION['erro_codigo'] = "Código inválido. Tente novamente.";
        header("Location: codigoRecuperacao.php");
        exit;
    }
}

unset($_SESSION["codigo"]);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha - BloodFlower</title>
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
        }

        .form-control:focus {
            box-shadow: none;
            background-color: #fff;
            border: 1px solid #e2e2e2;
        }

        .toggle-password {
            cursor: pointer;
            border-radius: 0 12px 12px 0;
            background-color: #f1f1f1;
            border: none;
            padding: 0 12px;
            color: #6c757d;
        }

        /* Ajuste para input com toggle */
        .input-group .form-control:not(:last-child) {
            border-radius: 0;
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
    </style>
</head>

<body>

    <div class="login-card">
        <img src="imagens/LogoBloodFlower.png" alt="Logo BloodFlower" class="logo">

        <h2>Criar Nova Senha</h2>
        <p class="description">Escolha uma senha forte para proteger sua conta.</p>

        <?php if (isset($_SESSION['erro_senha'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['erro_senha']; ?>
            </div>
            <?php unset($_SESSION['erro_senha']); ?>
        <?php endif; ?>

        <form action="processaTrocaSenha.php" method="post">

            <!-- Nova Senha -->
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input
                    type="password"
                    class="form-control"
                    id="nova_senha"
                    name="nova_senha"
                    placeholder="Nova senha"
                    minlength="8"
                    required>
                <span class="input-group-text toggle-password" onclick="togglePassword('nova_senha', 'icon-1')">
                    <i class="bi bi-eye-slash" id="icon-1"></i>
                </span>
            </div>

            <!-- Confirmar Senha -->
            <div class="mb-4 input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input
                    type="password"
                    class="form-control"
                    id="confirmar_senha"
                    name="confirmar_senha"
                    placeholder="Confirmar senha"
                    required>
                <span class="input-group-text toggle-password" onclick="togglePassword('confirmar_senha', 'icon-2')">
                    <i class="bi bi-eye-slash" id="icon-2"></i>
                </span>
            </div>

            <button type="submit" class="btn btn-login w-100">Redefinir Senha</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para mostrar/ocultar senha (Reutilizável) -->
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }
    </script>
</body>

</html>