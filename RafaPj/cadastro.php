<?php

require_once "conexao.php";

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome      = trim($_POST["fullname"]);
    $email     = strtolower(trim($_POST["email"]));
    $senha     = $_POST["password"];
    $confirmar = $_POST["confirm_password"];

    // Verifica se as senhas são iguais
    if ($senha !== $confirmar) {

        $erro = "As senhas não coincidem.";

    } else {

        // Cria o hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Verifica se o e-mail já está cadastrado
        $sqlVerifica = "SELECT id FROM usuarios WHERE email = ?";
        $stmtVerifica = $conn->prepare($sqlVerifica);

        if (!$stmtVerifica) {

            $erro = "Erro no banco de dados.";

        } else {

            $stmtVerifica->bind_param("s", $email);
            $stmtVerifica->execute();

            $resultado = $stmtVerifica->get_result();

            if ($resultado->num_rows > 0) {

                $erro = "Este e-mail já está cadastrado.";

            } else {

                // Cadastro normal
                $sql = "INSERT INTO usuarios (nome, email, senha)
                        VALUES (?, ?, ?)";

                $stmt = $conn->prepare($sql);

                if (!$stmt) {

                    $erro = "Erro no banco de dados.";

                } else {

                    $stmt->bind_param(
                        "sss",
                        $nome,
                        $email,
                        $senhaHash
                    );

                    if ($stmt->execute()) {

                        $sucesso = "Conta criada com sucesso!";

                    } else {

                        $erro = "Erro ao cadastrar: " . $stmt->error;
                    }

                    $stmt->close();
                }
            }

            $stmtVerifica->close();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cadastro - HealthSystem</title>

    <link href="css/styles.css" rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <script
        src="https://use.fontawesome.com/releases/v6.3.0/js/all.js">
    </script>

    <style>

        body {
            background: linear-gradient(
                135deg,
                #0d47a1,
                #1976d2,
                #42a5f5
            );

            min-height: 100vh;
        }

        .card {
            border-radius: 20px;
            border: none;
            overflow: hidden;
        }

        .card-header {
            background: #0d6efd;
            color: white;
            border-radius: 20px 20px 0 0 !important;
        }

        .btn-primary {
            background: #0d6efd;
            border: none;
        }

        .btn-primary:hover {
            background: #0b5ed7;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        }

        .logo {
            color: white;
            font-size: 40px;
        }

    </style>

</head>

<body>

    <div id="layoutAuthentication">

        <div id="layoutAuthentication_content">

            <main>

                <div class="container">

                    <div class="row justify-content-center">

                        <div class="col-lg-6">

                            <div class="card shadow-lg mt-5">

                                <!-- Cabeçalho -->

                                <div class="card-header text-center py-4">

                                    <i class="fas fa-heart-pulse logo"></i>

                                    <h2 class="mt-2">
                                        HealthSystem
                                    </h2>

                                    <p class="mb-0">
                                        Sistema de Gestão Hospitalar
                                    </p>

                                </div>


                                <!-- Formulário -->

                                <div class="card-body p-4">

                                    <h4 class="text-center mb-4">
                                        Criar Conta
                                    </h4>


                                    <!-- Mensagem de erro -->

                                    <?php if (!empty($erro)): ?>

                                        <div class="alert alert-danger">
                                            <?= htmlspecialchars($erro) ?>
                                        </div>

                                    <?php endif; ?>


                                    <!-- Mensagem de sucesso -->

                                    <?php if (!empty($sucesso)): ?>

                                        <div class="alert alert-success">
                                            <?= htmlspecialchars($sucesso) ?>
                                        </div>

                                    <?php endif; ?>


                                    <form method="POST">

                                        <!-- Nome -->

                                        <div class="form-floating mb-3">

                                            <input
                                                class="form-control"
                                                name="fullname"
                                                type="text"
                                                placeholder="Nome"
                                                required
                                            >

                                            <label>
                                                <i class="fas fa-user"></i>
                                                Nome completo
                                            </label>

                                        </div>


                                        <!-- E-mail -->

                                        <div class="form-floating mb-3">

                                            <input
                                                class="form-control"
                                                name="email"
                                                type="email"
                                                placeholder="nome@email.com"
                                                required
                                            >

                                            <label>
                                                <i class="fas fa-envelope"></i>
                                                E-mail
                                            </label>

                                        </div>


                                        <!-- Senha -->

                                        <div class="form-floating mb-3">

                                            <input
                                                class="form-control"
                                                name="password"
                                                type="password"
                                                placeholder="Senha"
                                                required
                                            >

                                            <label>
                                                <i class="fas fa-lock"></i>
                                                Senha
                                            </label>

                                        </div>


                                        <!-- Confirmar senha -->

                                        <div class="form-floating mb-3">

                                            <input
                                                class="form-control"
                                                name="confirm_password"
                                                type="password"
                                                placeholder="Confirmar senha"
                                                required
                                            >

                                            <label>
                                                <i class="fas fa-lock"></i>
                                                Confirmar senha
                                            </label>

                                        </div>


                                        <!-- Botão -->

                                        <button
                                            type="submit"
                                            class="btn btn-primary w-100 py-3"
                                        >

                                            <i class="fas fa-user-plus"></i>

                                            Criar Conta

                                        </button>

                                    </form>

                                </div>


                                <!-- Rodapé -->

                                <div class="card-footer text-center py-3">

                                    <div class="small mb-2">

                                        <a href="index.php">
                                            Voltar para a tela inicial
                                        </a>

                                    </div>

                                    <div class="small">

                                        <a href="login.php">

                                            <i class="fas fa-right-to-bracket"></i>

                                            Já possui uma conta?
                                            Fazer login

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </main>

        </div>


        <!-- Rodapé -->

        <footer class="py-4 bg-light mt-auto">

            <div class="text-center small text-muted">

                Copyright © HealthSystem 2026

            </div>

        </footer>

    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>