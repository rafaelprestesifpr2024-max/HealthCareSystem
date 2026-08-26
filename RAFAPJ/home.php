<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$nome = $_SESSION["usuario_nome"] ?? "Cliente";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Dashboard - HealthSystem</title>

    <link
        href="css/styles.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <script
        src="https://use.fontawesome.com/releases/v6.3.0/js/all.js">
    </script>

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

        .btn-consultas {
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-atualizar {
            border-radius: 8px;
            font-weight: 500;
        }

        .numero-resumo {
            font-size: 2.5rem;
            font-weight: bold;
        }

    </style>

</head>

<body>


    <!-- =========================================================
         NAVBAR
    ========================================================== -->

    <nav class="navbar navbar-expand navbar-dark">

        <a
            class="navbar-brand ps-4"
            href="home.php"
        >

            <i class="fas fa-heart-pulse"></i>

            HealthSystem

        </a>


        <div class="ms-auto me-4 d-flex align-items-center gap-3">

            <a
                href="consultas.php"
                class="btn btn-light btn-sm btn-consultas"
            >

                <i class="fas fa-calendar-check"></i>

                Consultas

            </a>


            <span class="text-white">

                Olá,

                <?= htmlspecialchars(
                    $nome,
                    ENT_QUOTES,
                    "UTF-8"
                ) ?>

            </span>

        </div>

    </nav>


    <!-- =========================================================
         CONTEÚDO
    ========================================================== -->

    <div class="container-fluid px-4 py-4">

        <h1 class="mb-2">
            Dados Gerais
        </h1>

        <p class="text-muted">
        </p>


        <br>
        <br>


        <!-- =====================================================
             CARDS PRINCIPAIS
        ====================================================== -->

        <div class="row">


            <!-- NOVA TRIAGEM -->

            <div class="col-md-4">

                <div
                    class="card shadow dashboard-card bg-primary text-white"
                >

                    <div class="card-body text-center">

                        <i
                            class="fas fa-notes-medical fa-3x mb-3">
                        </i>

                        <h4>
                            Nova Triagem
                        </h4>

                        <p>
                            Registrar novo atendimento
                        </p>

                        <a
                            href="triagem.php"
                            class="btn btn-light"
                        >
                            Acessar
                        </a>

                    </div>

                </div>

            </div>


            <!-- PACIENTES -->

            <div class="col-md-4">

                <div
                    class="card shadow dashboard-card bg-success text-white"
                >

                    <div class="card-body text-center">

                        <i
                            class="fas fa-users fa-3x mb-3">
                        </i>

                        <h4>
                            Pacientes
                        </h4>

                        <p>
                            Consultar pacientes cadastrados
                        </p>

                        <a
                            href="pacientes.php"
                            class="btn btn-light"
                        >
                            Acessar
                        </a>

                    </div>

                </div>

            </div>


            <!-- LOGOUT -->

            <div class="col-md-4">

                <div
                    class="card shadow dashboard-card bg-danger text-white"
                >

                    <div class="card-body text-center">

                        <i
                            class="fas fa-right-from-bracket fa-3x mb-3">
                        </i>

                        <h4>
                            Logout
                        </h4>

                        <p>
                            Encerrar sessão atual
                        </p>

                        <a
                            href="logout.php"
                            class="btn btn-light"
                        >
                            Sair
                        </a>

                    </div>

                </div>

            </div>

        </div>


        <br>
        <br>
        <br>


        <!-- =====================================================
             RESUMO DO SISTEMA
        ====================================================== -->

        <div class="card shadow mt-5">


            <!-- CABEÇALHO -->

            <div
                class="card-header d-flex justify-content-between align-items-center"
            >

                <span>

                    <i class="fas fa-chart-line"></i>

                    Resumo do Sistema

                </span>


                <!-- BOTÃO ATUALIZAR -->

                <button
                    type="button"
                    class="btn btn-primary btn-sm btn-atualizar"
                    data-bs-toggle="modal"
                    data-bs-target="#modalAtualizarDados"
                >

                    <i class="fas fa-edit"></i>

                    Atualizar dados

                </button>

            </div>


            <!-- DADOS -->

            <div class="card-body">

                <div class="row text-center">


                    <!-- TRIAGENS -->

                    <div class="col-md-4">

                        <h2
                            id="totalTriagens"
                            class="text-primary numero-resumo"
                        >
                            0
                        </h2>

                        <p>
                            Triagens já feitas
                        </p>

                    </div>


                    <!-- AGUARDANDO -->

                    <div class="col-md-4">

                        <h2
                            id="aguardandoAtendimento"
                            class="text-warning numero-resumo"
                        >
                            0
                        </h2>

                        <p>
                            Aguardando atendimento
                        </p>

                    </div>


                    <!-- EMERGÊNCIAS -->

                    <div class="col-md-4">

                        <h2
                            id="casosEmergencia"
                            class="text-danger numero-resumo"
                        >
                            0
                        </h2>

                        <p>
                            Casos de emergência
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================================================
         MODAL ATUALIZAR DADOS
    ========================================================== -->

    <div
        class="modal fade"
        id="modalAtualizarDados"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog">

            <div class="modal-content">


                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title">

                        <i class="fas fa-edit"></i>

                        Atualizar dados

                    </h5>


                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="Fechar"
                    ></button>

                </div>


                <div class="modal-body">


                    <!-- TRIAGENS -->

                    <div class="mb-3">

                        <label
                            for="inputTriagens"
                            class="form-label"
                        >
                            <i class="fas fa-notes-medical text-primary"></i>

                            Triagens já feitas

                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="inputTriagens"
                            min="0"
                            value="0"
                        >

                    </div>


                    <!-- AGUARDANDO -->

                    <div class="mb-3">

                        <label
                            for="inputAguardando"
                            class="form-label"
                        >

                            <i class="fas fa-clock text-warning"></i>

                            Aguardando atendimento

                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="inputAguardando"
                            min="0"
                            value="0"
                        >

                    </div>


                    <!-- EMERGÊNCIAS -->
                    <div class="mb-3">

                        <label
                            for="inputEmergencias"
                            class="form-label"
                        >

                            <i class="fas fa-triangle-exclamation text-danger"></i>

                            Casos de emergência

                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="inputEmergencias"
                            min="0"
                            value="0"
                        >

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancelar
                    </button>


                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="atualizarDados()"
                    >

                        <i class="fas fa-save"></i>

                        Salvar alterações

                    </button>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================================================
         BOOTSTRAP JS
    ========================================================== -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>


    <!-- =========================================================
         JAVASCRIPT
    ========================================================== -->

    <script>

        function atualizarDados() {

            const triagens =
                document.getElementById("inputTriagens").value;

            const aguardando =
                document.getElementById("inputAguardando").value;

            const emergencias =
                document.getElementById("inputEmergencias").value;


            document.getElementById("totalTriagens").textContent =
                triagens;

            document.getElementById("aguardandoAtendimento").textContent =
                aguardando;

            document.getElementById("casosEmergencia").textContent =
                emergencias;


            const modalElement =
                document.getElementById("modalAtualizarDados");

            const modal =
                bootstrap.Modal.getInstance(modalElement);

            modal.hide();

        }

    </script>


</body>

</html>