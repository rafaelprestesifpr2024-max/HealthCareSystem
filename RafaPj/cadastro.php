<?php
require_once "conexao.php";

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome       = $_POST["fullname"];
    $email      = $_POST["email"];
    $senha      = $_POST["password"];
    $confirmar  = $_POST["confirm_password"];

    if ($senha !== $confirmar) {
        $erro = "As senhas não coincidem.";
    } else {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql  = "INSERT INTO usuarios (nome, email, senha) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $erro = "Erro no banco de dados.";
        } else {
            $stmt->bind_param("sss", $nome, $email, $senhaHash);

            if ($stmt->execute()) {
                $sucesso = "Conta criada com sucesso!";
            } else {
                $erro = "Erro ao cadastrar: " . $stmt->error;
            }

            $stmt->close();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #0d47a1, #1976d2, #42a5f5);
            min-height: 100vh;
        }
        .card {
            border-radius: 20px;
            border: none;
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
        .logo {
            color: #0d6efd;
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

                                <div class="card-header text-center py-4">
                                    <h2><i class="fas fa-heart-pulse"></i> HealthSystem</h2>
                                    <p class="mb-0">Sistema de Gestão Hospitalar</p>
                                </div>

                                <div class="card-body p-4">
                                    <h4 class="text-center mb-4">Criar Conta</h4>

                                    <?php if ($erro) { ?>
                                        <div class="alert alert-danger"><?= $erro ?></div>
                                    <?php } ?>

                                    <?php if ($sucesso) { ?>
                                        <div class="alert alert-success"><?= $sucesso ?></div>
                                    <?php } ?>

                                    <form method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="fullname" type="text" placeholder="Nome" required>
                                            <label>Nome completo</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="email" type="email" placeholder="Email" required>
                                            <label>E-mail</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="password" type="password" placeholder="Senha" required>
                                            <label>Senha</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="confirm_password" type="password" placeholder="Confirmar senha" required>
                                            <label>Confirmar senha</label>
                                        </div>

                                        <button class="btn btn-primary w-100 py-3">
                                            <i class="fas fa-user-plus"></i> Criar Conta
                                        </button>
                                    </form>
                                </div>


                                <div class="card-footer text-center py-3">
                                    <div class="small">
                                        <a href="index.php">Voltar para a tela inicial</a>
                                    </div>
                                    <div class="small">
                                        <a href="login.php">Já possui uma conta? Fazer login</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <footer class="py-4 bg-light mt-auto">
            <div class="text-center small text-muted">
                Copyright © HealthSystem 2026
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
