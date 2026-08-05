<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$nome = $_SESSION["usuario_nome"];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - HealthSystem</title>

    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>

    <style>
        body {
            background: #f5f7fb;
        }

        .navbar {
            background: #0d6efd !important;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .dashboard-card {
            transition: .3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark">
        <a class="navbar-brand ps-4" href="home.php">
            <i class="fas fa-heart-pulse"></i> HealthSystem
        </a>

        <div class="ms-auto me-4">
            <span class="text-white me-3">Olá, <?= $nome ?></span>
        </div>
    </nav>

    <div class="container-fluid px-4 py-4">
        <h1 class="mb-2">Dados Gerais</h1>
        <p class="text-muted"> </p>
        <br>
        <br>
        <div class="row">
            <!-- Nova Triagem -->
            <div class="col-md-4">
                <div class="card shadow dashboard-card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-notes-medical fa-3x mb-3"></i>
                        <h4>Nova Triagem</h4>
                        <p>Registrar novo atendimento</p>
                        <a href="triagem.php" class="btn btn-light">Acessar</a>
                    </div>
                </div>
            </div>

            <!-- Pacientes -->
            <div class="col-md-4">
                <div class="card shadow dashboard-card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <h4>Pacientes</h4>
                        <p>Consultar pacientes cadastrados</p>
                        <a href="pacientes.php" class="btn btn-light">Acessar</a>
                    </div>
                </div>
            </div>

            <!-- Logout -->
            <div class="col-md-4">
                <div class="card shadow dashboard-card bg-danger text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-right-from-bracket fa-3x mb-3"></i>
                        <h4>Logout</h4>
                        <p>Encerrar sessão atual</p>
                        <a href="logout.php" class="btn btn-light">Sair</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <!-- Resumo do Sistema -->
        <div class="card shadow mt-5">
            <div class="card-header">
                <i class="fas fa-chart-line"></i> Resumo do Sistema
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h2 class="text-primary">0</h2>
                        <p>Triagens hoje</p>
                    </div>
                    <div class="col-md-4">
                        <h2 class="text-warning">0</h2>
                        <p>Aguardando atendimento</p>
                    </div>
                    <div class="col-md-4">
                        <h2 class="text-danger">0</h2>
                        <p>Casos de emergência</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
