<?php

include("conexao.php");
session_start();
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $email);
    $senha = $_POST["password"];
 

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conn, $sql);

    if ($resultado && mysqli_num_rows($resultado) === 1) {
        $usuario = mysqli_fetch_assoc($resultado);


        


        if (password_verify($senha, $usuario["senha"])) {
            session_regenerate_id(true);
            $_SESSION["id"] = $usuario["id_usuario"];
            $_SESSION["email"] = $usuario["email"];

            if($usuario["tipo_usuario"] == "0") {
                $_SESSION["tipo"] = "cliente";
                header("Location: index.php");
                exit;
            } elseif ($usuario["tipo_usuario"] == "1") {
                $_SESSION["tipo"] = "admin";
                header("Location: admin/inicioADM.php");
                exit;
            }
        }
        echo "<script>alert('Senha inválida');</script>";
        echo "<script>window.location.href='index.php';</script>";
        exit();
    }

    echo "<script>alert('Email não encontrado');</script>";
    echo "<script>window.location.href='index.php';</script>";
    exit();
