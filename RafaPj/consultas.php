<?php
include "conexao.php";
/*
|--------------------------------------------------------------------------
| BUSCA AS CONSULTAS
|--------------------------------------------------------------------------
*/
$sql = "
    SELECT *
    FROM consultas
    ORDER BY data_consulta ASC, hora_consulta ASC
";
$resultado = $conn->query($sql);
if (!$resultado) {
    die("Erro ao buscar consultas: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>Agenda de Consultas - HealthSystem</title>
    <link
        href="css/styles.css"
        rel="stylesheet"
    >
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        rel="stylesheet"
    >
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
            padding: 8px 12px;
            font-size: 13px;
        }
        .titulo {
            font-weight: 700;
        }
        .agenda-card {
            border-radius: 15px;
        }
        .horario {
            font-weight: 700;
            color: #0d6efd;
        }
        .data-consulta {
            font-weight: 600;
        }
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }
    </style>
</head>
<body class="sb-nav-fixed">
<!-- =========================================================
     MENU SUPERIOR
========================================================= -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a
        class="navbar-brand ps-3"
        href="home.php"
    >
        <i class="fas fa-hospital"></i>
        RAFAPJ
    </a>
    <div class="ms-auto me-3">
        <a
            href="home.php"
            class="btn btn-light btn-sm"
        >
            <i class="fas fa-home"></i>
            Voltar para a Home
        </a>
    </div>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <!-- =================================================
                     TÍTULO
                ================================================== -->
                <div class="mt-4 mb-4">
                    <h1 class="titulo">
                        <i class="fas fa-calendar-days text-primary"></i>
                        Agenda de Consultas
                    </h1>
                    <p class="text-muted">
                        Visualização das consultas agendadas no sistema.
                    </p>
                </div>
                <!-- =================================================
                     CARD PRINCIPAL
                ================================================== -->
                <div class="card shadow mb-4">
                    <!-- CABEÇALHO -->
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-check"></i>
                            Consultas agendadas
                        </h5>
                    </div>
                    <!-- CONTEÚDO -->
                    <div class="card-body">
                        <?php if ($resultado->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <!-- =================================================
                                         CABEÇALHO DA TABELA
                                    ================================================== -->
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Paciente</th>
                                            <th>Data</th>
                                            <th>Horário</th>
                                            <th>Especialidade</th>
                                            <th>Motivo</th>
                                            <th>Status</th>
                                            <th>Detalhes</th>
                                        </tr>
                                    </thead>
                                    <!-- =================================================
                                         LISTA DE CONSULTAS
                                    ================================================== -->
                                    <tbody>
                                    <?php while ($consulta = $resultado->fetch_assoc()): ?>
                                        <tr>
                                            <!-- PACIENTE -->
                                            <td>
                                                <strong>
                                                    <?= htmlspecialchars(
                                                        $consulta["nome_paciente"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ) ?>
                                                </strong>
                                                <br>
                                                <small class="text-muted">
                                                    <?= htmlspecialchars(
                                                        $consulta["email_paciente"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ) ?>
                                                </small>
                                            </td>
                                            <!-- DATA -->
                                            <td>
                                                <span class="data-consulta">
                                                    <?= htmlspecialchars(
                                                        $consulta["data_consulta"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ) ?>
                                                </span>
                                            </td>
                                            <!-- HORÁRIO -->
                                            <td>
                                                <span class="horario">
                                                    <i class="fas fa-clock"></i>
                                                    <?= htmlspecialchars(
                                                        substr(
                                                            $consulta["hora_consulta"],
                                                            0,
                                                            5
                                                        ),
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ) ?>
                                                </span>
                                            </td>
                                            <!-- ESPECIALIDADE -->
                                            <td>
                                                <?= htmlspecialchars(
                                                    $consulta["especialidade"],
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ) ?>
                                            </td>
                                            <!-- MOTIVO -->
                                            <td>
                                                <?= htmlspecialchars(
                                                    $consulta["motivo"],
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ) ?>
                                            </td>
                                            <!-- STATUS -->
                                            <td>
                                                <?php
                                                $status = $consulta["status"];
                                                switch ($status) {
                                                    case "agendada":
                                                        $cor = "success";
                                                        $texto = "Agendada";
                                                        break;
                                                    case "cancelada":
                                                        $cor = "danger";
                                                        $texto = "Cancelada";
                                                        break;
                                                    case "concluida":
                                                        $cor = "primary";
                                                        $texto = "Concluída";
                                                        break;
                                                    default:
                                                        $cor = "secondary";
                                                        $texto = $status;
                                                }
                                                ?>
                                                <span class="badge bg-<?= $cor ?>">
                                                    <?= htmlspecialchars(
                                                        $texto,
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ) ?>
                                                </span>
                                            </td>
                                            <!-- DETALHES -->
                                            <td>
                                                <button
                                                    class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#consulta<?= (int)$consulta["id"] ?>"
                                                >
                                                    <i class="fas fa-eye"></i>
                                                    Ver consulta
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- =================================================
                                             MODAL DA CONSULTA
                                        ================================================== -->
                                        <div
                                            class="modal fade"
                                            id="consulta<?= (int)$consulta["id"] ?>"
                                            tabindex="-1"
                                            aria-hidden="true"
                                        >
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <!-- CABEÇALHO -->
                                                    <div class="modal-header bg-dark text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-file-medical"></i>
                                                            Detalhes da Consulta
                                                        </h5>
                                                        <button
                                                            type="button"
                                                            class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal"
                                                        ></button>
                                                    </div>
                                                    <!-- CORPO -->
                                                    <div class="modal-body">
                                                        <h4>
                                                            <?= htmlspecialchars(
                                                                $consulta["nome_paciente"],
                                                                ENT_QUOTES,
                                                                "UTF-8"
                                                            ) ?>
                                                        </h4>
                                                        <hr>
                                                        <div class="row">
                                                            <!-- DATA -->
                                                            <div class="col-md-6 mb-3">
                                                                <strong>
                                                                    <i class="fas fa-calendar"></i>
                                                                    Data
                                                                </strong>
                                                                <br>
                                                                <?= htmlspecialchars(
                                                                    $consulta["data_consulta"],
                                                                    ENT_QUOTES,
                                                                    "UTF-8"
                                                                ) ?>
                                                            </div>
                                                            <!-- HORÁRIO -->
                                                            <div class="col-md-6 mb-3">
                                                                <strong>
                                                                    <i class="fas fa-clock"></i>
                                                                    Horário
                                                                </strong>
                                                                <br>
                                                                <?= htmlspecialchars(
                                                                    substr(
                                                                        $consulta["hora_consulta"],
                                                                        0,
                                                                        5
                                                                    ),
                                                                    ENT_QUOTES,
                                                                    "UTF-8"
                                                                ) ?>
                                                            </div>
                                                            <!-- ESPECIALIDADE -->
                                                            <div class="col-md-6 mb-3">
                                                                <strong>
                                                                    Especialidade
                                                                </strong>
                                                                <br>
                                                                <?= htmlspecialchars(
                                                                    $consulta["especialidade"],
                                                                    ENT_QUOTES,
                                                                    "UTF-8"
                                                                ) ?>
                                                            </div>
                                                            <!-- MOTIVO -->
                                                            <div class="col-md-6 mb-3">
                                                                <strong>
                                                                    Motivo
                                                                </strong>
                                                                <br>
                                                                <?= htmlspecialchars(
                                                                    $consulta["motivo"],
                                                                    ENT_QUOTES,
                                                                    "UTF-8"
                                                                ) ?>
                                                            </div>
                                                            <!-- E-MAIL -->
                                                            <div class="col-md-6 mb-3">
                                                                <strong>
                                                                    <i class="fas fa-envelope"></i>
                                                                    E-mail
                                                                </strong>
                                                                <br>
                                                                <?= htmlspecialchars(
                                                                    $consulta["email_paciente"],
                                                                    ENT_QUOTES,
                                                                    "UTF-8"
                                                                ) ?>
                                                            </div>
                                                            <!-- TELEFONE -->
                                                            <div class="col-md-6 mb-3">
                                                                <strong>
                                                                    <i class="fas fa-phone"></i>
                                                                    Telefone
                                                                </strong>
                                                                <br>
                                                                <?= htmlspecialchars(
                                                                    $consulta["telefone_paciente"],
                                                                    ENT_QUOTES,
                                                                    "UTF-8"
                                                                ) ?>
                                                            </div>
                                                            <!-- ENDEREÇO -->
                                                            <div class="col-12 mb-3">
                                                                <strong>
                                                                    <i class="fas fa-location-dot"></i>
                                                                    Endereço
                                                                </strong>
                                                                <br>
                                                                <?= htmlspecialchars(
                                                                    $consulta["endereco_paciente"],
                                                                    ENT_QUOTES,
                                                                    "UTF-8"
                                                                ) ?>
                                                            </div>
                                                            <!-- PROBLEMA -->
                                                            <div class="col-12 mb-3">
                                                                <strong>
                                                                    <i class="fas fa-notes-medical"></i>
                                                                    Problema / Sintomas
                                                                </strong>
                                                                <div class="mt-2 p-3 bg-light rounded">
                                                                    <?= nl2br(
                                                                        htmlspecialchars(
                                                                            $consulta["problema"],
                                                                            ENT_QUOTES,
                                                                            "UTF-8"
                                                                        )
                                                                    ) ?>
                                                                </div>
                                                            </div>
                                                            <!-- OBJETIVO -->
                                                            <div class="col-md-6 mb-3">
                                                                <strong>
                                                                    Objetivo
                                                                </strong>
                                                                <br>
                                                                <?= htmlspecialchars(
                                                                    $consulta["objetivo"],
                                                                    ENT_QUOTES,
                                                                    "UTF-8"
                                                                ) ?>
                                                            </div>
                                                            <!-- STATUS -->
                                                            <div class="col-md-6 mb-3">
                                                                <strong>
                                                                    Status
                                                                </strong>
                                                                <br>
                                                                <span class="badge bg-<?= $cor ?>">
                                                                    <?= htmlspecialchars(
                                                                        $texto,
                                                                        ENT_QUOTES,
                                                                        "UTF-8"
                                                                    ) ?>
                                                                </span>
                                                            </div>
                                                            <!-- OBSERVAÇÕES -->
                                                            <div class="col-12">
                                                                <strong>
                                                                    Observações
                                                                </strong>
                                                                <div class="mt-2 p-3 bg-light rounded">
                                                                    <?php
                                                                    if (
                                                                        trim(
                                                                            $consulta["observacoes"]
                                                                        ) !== ""
                                                                    ) {
                                                                        echo nl2br(
                                                                            htmlspecialchars(
                                                                                $consulta["observacoes"],
                                                                                ENT_QUOTES,
                                                                                "UTF-8"
                                                                            )
                                                                        );
                                                                    } else {
                                                                        echo '<span class="text-muted">
                                                                            Nenhuma observação.
                                                                        </span>';
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- RODAPÉ -->
                                                    <div class="modal-footer">
                                                        <button
                                                            type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal"
                                                        >
                                                            Fechar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <!-- =================================================
                                 NENHUMA CONSULTA
                            ================================================== -->
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                Nenhuma consulta foi agendada ainda.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<!-- =========================================================
     BOOTSTRAP JS
========================================================= -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>
</body>
</html>


