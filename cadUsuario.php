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


if(!$result) {
    echo "<script>alert('Erro ao cadastrar usuário!');</script>";
    echo "<script>window.location.href='cadastro.html';</script>";
    exit();
} else {
    // Cria o carrinho para o usuário
    $sql_carrinho = "INSERT INTO carrinhos (usuario_id) VALUES ($id_usuario)";
    mysqli_query($conn, $sql_carrinho);
    ?>

    <html>
        <form action="cadEndereco.php" method="post">
            <input type="hiden" name="id" value="<?php echo $id_usuario?>">
        </form>
    </html>

    <?php
        
        echo "<script>alert('Cadastro realizado com sucesso!');</script>";
        echo "<script>window.location.href='cadEndereco.php';</script>";

    }
   
 
   
   
