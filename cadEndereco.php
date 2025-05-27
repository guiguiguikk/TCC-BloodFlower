<?php

include ('conexao.php');

$nome = mysqli_real_escape_string($conn, trim($_POST["nome"]));
$cpf = mysqli_real_escape_string($conn, trim($_POST["cpf"]));
$telefone = mysqli_real_escape_string($conn, trim($_POST["telefone"]));
$email = mysqli_real_escape_string($conn, trim($_POST["email"]));
$email = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanitiza o email
$password = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$data_nascimento = mysqli_real_escape_string($conn, trim($_POST["data_nascimento"]));


// Verifica se o email já existe
$sql_check_email = "SELECT * FROM usuarios WHERE email = '$email'";
$result_check_email = mysqli_query($conn, $sql_check_email);
if (mysqli_num_rows($result_check_email) > 0) {
    echo "<script>alert('Email já cadastrado!');</script>";
    echo "<script>window.location.href='cadastro.html';</script>";
    exit();
}

// Verifica se o CPF já existe
$sql_check_cpf = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
$result_check_cpf = mysqli_query($conn, $sql_check_cpf);
if (mysqli_num_rows($result_check_cpf) > 0) {
    echo "<script>alert('CPF já cadastrado!');</script>";
    echo "<script>window.location.href='cadastro.html';</script>";
    exit();
}




$sql = "INSERT INTO usuarios (nome, cpf, telefone, email, senha, data_nascimento) 
VALUES ('$nome', '$cpf', '$telefone', '$email', '$password', '$data_nascimento')";



$result = mysqli_query($conn, $sql);
$id_usuario = mysqli_insert_id($conn);


if(!$result || !$id_usuario) {
    echo "<script>alert('Erro ao cadastrar usuário!');</script>";
    echo "<script>window.location.href='cadastro.html';</script>";
    exit();
} else {
    // Cria o carrinho para o usuário
    $sql_carrinho = "INSERT INTO carrinhos (usuario_id) VALUES ($id_usuario)";
    mysqli_query($conn, $sql_carrinho);


}
if (!$id_usuario) {
    echo "<script>alert('Erro ao cadastrar usuário!');</script>";
    echo "<script>window.location.href='cadastro.html';</script>";
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Bloodfloewr</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(145deg, #f5f5f5, #e9ecef);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cadastro-box {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 500px;
        }

        .cadastro-box h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #dc3545;
            text-align: center;
            margin-bottom: 10px;
        }

        .cadastro-box p.subtitle {
            text-align: center;
            font-size: 1rem;
            color: #666;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .form-control {
            border-radius: 10px;
            height: 45px;
        }

        .btn-cadastrar {
            background-color: #dc3545;
            border-radius: 12px;
            height: 45px;
            font-weight: 500;
            font-size: 1rem;
        }

        .btn-cadastrar:hover {
            background-color: #c82333;
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
    <h1>BloodFlower</h1>
    <p class="subtitle">Informe seu endereço</p>

    <form action="cadastrar.php" method="POST">
        <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
        <div class="mb-3">
            <label for="nome" class="form-label">CEP:</label>
            <input type="text" class="form-control" id="nome" name="cep" required>
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">Rua:</label>
            <input type="text" class="form-control" id="cpf" name="rua" required>
        </div>

        <div class="mb-3">
            <label for="telefone" class="form-label">Número:</label>
            <input type="text" class="form-control" id="telefone" name="numero" required>
        </div>

        <div class="mb-3">
            <label for="data_nascimento" class="form-label">Bairro:</label>
            <input type="text" class="form-control" id="data_nascimento" name="bairro" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Cidade:</label>
            <input type="text" class="form-control" id="email" name="cidade" required>
        </div>

        <div class="mb-3">
                <label for="categoria" class="form-label">Estado:</label>
                <select class="form-select" id="categoria" name="estado" required>
                    <option value="" disabled selected>Selecione a categoria</option>
                    <option value="AC">AC</option>
                    <option value="AL">AL</option>
                    <option value="AP">AP</option>
                    <option value="AM">AM</option>
                    <option value="BA">BA</option>
                    <option value="CE">CE</option>
                    <option value="DF">DF</option>
                    <option value="ES">ES</option>
                    <option value="GO">GO</option>
                    <option value="MA">MA</option>
                    <option value="MT">MT</option>
                    <option value="MS">MS</option>
                    <option value="MG">MG</option>
                    <option value="PA">PA</option>
                    <option value="PB">PB</option>
                    <option value="PR">PR</option>
                    <option value="PE">PE</option>
                    <option value="PI">PI</option>
                    <option value="RJ">RJ</option>
                    <option value="RN">RN</option>
                    <option value="RS">RS</option>
                    <option value="RO">RO</option>
                    <option value="RR">RR</option>
                    <option value="SC">SC</option>
                    <option value="SP">SP</option>
                    <option value="SE">SE</option>
                    <option value="TO">TO</option>
                </select>
            </div>

        <button type="submit" class="btn btn-cadastrar w-100">Cadastrar</button>

    </form>
</div>

</body>
</html>