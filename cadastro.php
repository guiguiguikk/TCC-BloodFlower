<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - BloodFlower</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(145deg, #f5f5f5, #e9ecef);
            font-family: 'Rubik', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .cadastro-box {
            background: #fff;
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.07);
            width: 100%;
            max-width: 500px;
        }

        .cadastro-box img {
            display: block;
            margin: 0 auto 15px;
            height: 100px;
        }

        .cadastro-box h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #8b0000;
            text-align: center;
            margin-bottom: 8px;
        }

        .cadastro-box p.subtitle {
            text-align: center;
            font-size: 1rem;
            color: #666;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            border-radius: 10px;
            height: 45px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
        }

        .input-group-text {
            background-color: #f1f1f1;
            border-radius: 10px 0 0 10px;
            border: 1px solid #ccc;
        }

        .toggle-password {
            cursor: pointer;
            background-color: #f1f1f1;
            border-radius: 0 10px 10px 0;
            border: 1px solid #ccc;
        }

        .btn-cadastrar {
            background-color: #8b0000;
            color: white;
            border-radius: 12px;
            height: 45px;
            font-weight: 600;
            font-size: 1rem;
            transition: 0.3s;
        }

        .btn-cadastrar:hover {
            background-color: #a40000;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
        }

        .register-link a {
            text-decoration: underline;
            color: #333;
        }

        .register-link a:hover {
            color: #000;
        }
    </style>
</head>
<body>

<div class="cadastro-box">
    <img src="imagens/LogoBloodFlower.png" alt="Logo BloodFlower">
    <h1>BloodFlower</h1>
    <p class="subtitle">Crie sua conta</p>

    <!-- Mensagem de erro -->
    <?php if (isset($_SESSION['erro_cadastro'])): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $_SESSION['erro_cadastro'] ?>
        </div>
        <?php unset($_SESSION['erro_cadastro']); ?>
    <?php endif; ?>

    <form action="cadastrar.php" method="POST">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome completo</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="cpf" name="cpf" required>
        </div>

        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="tel" class="form-control" id="telefone" name="telefone" required>
        </div>

        <div class="mb-3">
            <label for="data_nascimento" class="form-label">Data de nascimento</label>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <!-- Campo senha com botão mostrar -->
        <div class="mb-4">
            <label for="senha" class="form-label">Senha</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" class="form-control" id="senha" name="senha" required>
                <span class="input-group-text toggle-password" onclick="togglePassword()">
                    <i class="bi bi-eye-slash" id="eye-icon"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-cadastrar w-100">Cadastrar</button>

        <div class="register-link">
            Já tem uma conta? <a href="entrar.php">Entrar</a>
        </div>
    </form>
</div>

<!-- JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Mostrar/Ocultar Senha -->
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
