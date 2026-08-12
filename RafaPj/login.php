<?php

session_start();

require_once "conexao.php";

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = strtolower(trim($_POST["email"]));
    $senha = $_POST["senha"];

    // Busca o usuário pelo e-mail
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {

        $erro = "Erro no banco de dados: " . $conn->error;

    } else {

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {

            $usuario = $resultado->fetch_assoc();

            // Verifica a senha
            if (password_verify($senha, $usuario["senha"])) {

                // Salva os dados do usuário na sessão
                $_SESSION["usuario_id"] = $usuario["id"];
                $_SESSION["usuario_nome"] = $usuario["nome"];
                $_SESSION["usuario_email"] = $usuario["email"];

                /*
                 * VERIFICA O TIPO PELO E-MAIL
                 */

                // Enfermeiro
                if (str_ends_with($email, "@hospital.com")) {

                    header("Location: home.php");
                    exit;

                }

                // Paciente
                if (str_ends_with($email, "@gmail.com")) {

                    header("Location: home_pacientes.php");
                    exit;

                }

                // E-mail que não pertence a nenhum dos dois tipos
                $erro = "E-mail não autorizado. Use um e-mail @hospital.com ou @gmail.com.";

            } else {

                $erro = "Senha incorreta.";
            }

        } else {

            $erro = "Usuário não encontrado.";
        }

        $stmt->close();
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - HealthSystem</title>

    <link href="css/styles.css" rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <script
        src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"
        crossorigin="anonymous">
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
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .card-header {
            background: #0d6efd;
            color: white;
            border: none;
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
            box-shadow: 0 0 0 .25rem rgba(13,110,253,.25);
        }

        .logo {
            font-size: 45px;
            color: white;
        }

    </style>

</head>

<body>

    <div id="layoutAuthentication">

        <div id="layoutAuthentication_content">

            <main>

                <div class="container">

                    <div class="row justify-content-center">

                        <div class="col-lg-5">

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


                                <!-- Corpo -->

                                <div class="card-body p-4">

                                    <h4 class="text-center mb-4">
                                        Entrar no sistema
                                    </h4>


                                    <!-- Mensagem de erro -->

                                    <?php if (!empty($erro)): ?>

                                        <div class="alert alert-danger">

                                            <?= htmlspecialchars($erro) ?>

                                        </div>

                                    <?php endif; ?>


                                    <form method="POST">

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
                                                name="senha"
                                                type="password"
                                                placeholder="Senha"
                                                required
                                            >

                                            <label>

                                                <i class="fas fa-lock"></i>

                                                Senha

                                            </label>

                                        </div>


                                        <!-- Ações -->

                                        <div class="d-flex justify-content-between align-items-center">

                                            <a
                                                class="small text-primary"
                                                href="password.php"
                                            >
                                                Esqueceu a senha?
                                            </a>

                                            <button
                                                type="submit"
                                                class="btn btn-primary px-4"
                                            >

                                                <i class="fas fa-right-to-bracket"></i>

                                                Entrar

                                            </button>

                                        </div>

                                    </form>

                                </div>


                                <!-- Rodapé do card -->

                                <div class="card-footer text-center py-3">

                                    <div class="small">

                                        <a href="cadastro.php">

                                            <i class="fas fa-user-plus"></i>

                                            Não possui uma conta?
                                            Cadastre-se!

                                        </a>

                                    </div>

                                    <div class="small mt-2">

                                        <a href="index.php">

                                            Voltar para a tela inicial

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