<?php
include "conexao.php";

$sql = "SELECT * FROM pacientes ORDER BY id DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pacientes - Sistema de Triagem</title>

    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }
        .card {
            border-radius: 15px;
            overflow: hidden;
        }
        .card-header {
            padding: 18px;
        }
        .table {
            vertical-align: middle;
        }
        .badge {
            padding: 10px 15px;
            font-size: 14px;
        }
        .titulo {
            font-weight: 700;
        }
        .info-card {
            border-radius: 15px;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">
            <i class="fas fa-hospital"></i> RAFAPJ
        </a>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="mt-4 mb-4">
                        <h1 class="titulo">
                            <i class="fas fa-user-injured text-danger"></i> Pacientes
                        </h1>
                        <p class="text-muted">Lista de pacientes cadastrados através da triagem</p>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-users"></i> Pacientes registrados
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php if ($resultado->num_rows > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Nome</th>
                                                <th>Nascimento</th>
                                                <th>Data</th>
                                                <th>Queixa principal</th>
                                                <th>Sinais vitais</th>
                                                <th>Risco</th>
                                                <th>Detalhes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($p = $resultado->fetch_assoc()): ?>
                                                <tr>
                                                    <td><strong><?= htmlspecialchars($p['nome']) ?></strong></td>
                                                    <td><?= htmlspecialchars($p['data_nascimento']) ?></td>
                                                    <td>
                                                        <?= htmlspecialchars($p['data_triagem']) ?><br>
                                                        <small class="text-muted"><?= htmlspecialchars($p['hora_triagem']) ?></small>
                                                    </td>
                                                    <td><?= htmlspecialchars($p['queixa_principal']) ?></td>
                                                    <td>
                                                        <i class="fas fa-heartbeat text-danger"></i> <?= htmlspecialchars($p['pressao']) ?><br>
                                                        🌡️ <?= htmlspecialchars($p['temperatura']) ?><br>
                                                        ❤️ <?= htmlspecialchars($p['frequencia']) ?> bpm<br>
                                                        🫁 <?= htmlspecialchars($p['saturacao']) ?>%
                                                    </td>
                                                    <td>
                                                        <?php
                                                        switch ($p['risco']) {
                                                            case "Vermelho": $cor = "danger"; break;
                                                            case "Laranja":  $cor = "orange"; break;
                                                            case "Amarelo":  $cor = "warning"; break;
                                                            case "Verde":    $cor = "success"; break;
                                                            case "Azul":     $cor = "primary"; break;
                                                            default:         $cor = "secondary";
                                                        }
                                                        ?>
                                                        <span class="badge bg-<?= $cor ?>">
                                                            <?= htmlspecialchars($p['risco']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#paciente<?= $p['id'] ?>">
                                                            <i class="fas fa-eye"></i> Ver ficha
                                                        </button>
                                                    </td>
                                                </tr>

                                                <!-- Modal ficha completa -->
                                                <div class="modal fade" id="paciente<?= $p['id'] ?>">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-dark text-white">
                                                                <h5>Ficha do paciente</h5>
                                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h5><?= htmlspecialchars($p['nome']) ?></h5>
                                                                <hr>
                                                                <p><b>Histórico:</b><br><?= htmlspecialchars($p['historico']) ?></p>
                                                                <p><b>Sintomas:</b><br><?= htmlspecialchars($p['sintomas']) ?></p>
                                                                <p><b>Medicamentos:</b> <?= htmlspecialchars($p['medicamentos']) ?></p>
                                                                <p><b>Alergias:</b> <?= htmlspecialchars($p['alergias']) ?></p>
                                                                <p><b>Dor:</b> <?= htmlspecialchars($p['dor']) ?>/10</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Nenhum paciente cadastrado ainda.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
