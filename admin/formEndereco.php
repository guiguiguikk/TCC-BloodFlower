<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin") {
    header("Location: ../index.php");
    exit;
}

include("../conexao.php");
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>BloodFlower | Cadastrar Endereço</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
        }

        .form-container {
            max-width: 500px;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #7d1d1d;
        }

        .form-container .btn-custom {
            background-color: #7d1d1d;
            color: #fff;
        }

        .form-container .btn-custom:hover {
            background-color: #5f1515;
        }

        .logo {
            display: block;
            margin: 30px auto 10px;
            height: 70px;
            margin-top: -10px;
        }
    </style>
</head>
<body>


<!-- Formulário -->
<div class="container">
    <div class="form-container">
        <img src="../imagens/logoBloodflower.png" alt="BloodFlower" class="logo">
        <h2><i class="bi bi-geo-alt-fill"></i> Novo Endereço</h2>
        <form method="POST" action="cadEndereco.php">
            <div class="mb-3">
                <label for="cep" class="form-label">CEP</label>
                <input type="text" class="form-control" id="cep" name="cep" required onblur="buscarCep(this.value)">
            </div>
            <div class="mb-3">
                <label for="rua" class="form-label">Rua</label>
                <input type="text" class="form-control" id="rua" name="rua" required>
            </div>
            <div class="mb-3">
                <label for="numero" class="form-label">Número</label>
                <input type="text" class="form-control" id="numero" name="numero" required>
            </div>
            <div class="mb-3">
                <label for="bairro" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro" required>
            </div>
            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <input type="text" class="form-control" id="estado" name="estado" required>
            </div>

            <?php
            $sql = "SELECT * FROM usuarios";
            $result = mysqli_query($conn, $sql);    

            if (mysqli_num_rows($result) > 0) {
                echo '<div class="mb-3">
                        <label for="id_usuario" class="form-label">Usuário</label>
                        <select class="form-select" id="id_usuario" name="id_usuario" required>
                            <option value="" disabled selected>Selecione um usuário</option>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['id_usuario'] . '">' . htmlspecialchars($row['nome']) . ' (' . htmlspecialchars($row['email']) . ')</option>';
                }
                echo    '</select>
                    </div>';
            } else {
                echo '<div class="alert alert-warning" role="alert">
                        Nenhum usuário cliente encontrado. Por favor, cadastre um usuário antes de adicionar um endereço.
                      </div>';
            }

            ?>

            <button type="submit" class="btn btn-custom w-100">Salvar Endereço</button>
        </form>
    </div>
</div>

<!-- Script ViaCEP -->
<script>
    function buscarCep(cep) {
        cep = cep.replace(/\D/g, '');

        // Limpa os campos antes da busca
        limparCampos();

        if (cep.length !== 8) {
            alert("CEP inválido.");
            return;
        }

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(dados => {
                if (dados.erro) {
                    alert("CEP não encontrado.");
                    limparCampos();
                    return;
                }

                document.getElementById('rua').value = dados.logradouro;
                document.getElementById('bairro').value = dados.bairro;
                document.getElementById('cidade').value = dados.localidade;
                document.getElementById('estado').value = dados.uf;

                // Torna os campos somente leitura
                document.getElementById('rua').readOnly = true;
                document.getElementById('bairro').readOnly = true;
                document.getElementById('cidade').readOnly = true;
                document.getElementById('estado').readOnly = true;
            })
            .catch(() => {
                alert("Erro ao buscar o CEP. Tente novamente.");
                limparCampos();
            });
    }

    function limparCampos() {
        const campos = ['rua', 'bairro', 'cidade', 'estado'];
        campos.forEach(id => {
            document.getElementById(id).value = "";
            document.getElementById(id).readOnly = false;
        });
    }
</script>

</body>
</html>
