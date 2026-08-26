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

    <title>Área do Paciente - HealthSystem</title>

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
            min-height: 250px;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .welcome {
            margin-top: 20px;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
        }

    </style>

</head>

<body>


    <!-- NAVBAR -->

    <nav class="navbar navbar-expand navbar-dark">

        <a
            class="navbar-brand ps-4"
            href="home_pacientes.php"
        >

            <i class="fas fa-heart-pulse"></i>

            HealthSystem

        </a>


        <div class="ms-auto me-4 d-flex align-items-center gap-3">


            <!-- BOTÃO MINHAS CONSULTAS -->

            <a
                href="fila.php"
                class="btn btn-light btn-sm"
            >

                <i class="fas fa-calendar-check"></i>

                Fila de Espera

            </a>
            <a
                href="areas.php"
                class="btn btn-light btn-sm"
            >

                <i class="fas fa-calendar-check"></i>

                Áreas

            </a>


            <!-- USUÁRIO -->

            <span class="text-white">

                Olá,

                <?= htmlspecialchars($nome) ?>

            </span>


        </div>

    </nav>


    <!-- CONTEÚDO -->

    <div class="container-fluid px-4 py-4">


        <!-- TÍTULO -->

        <div class="welcome">

            <h1 class="mb-2">
                Área do Paciente
            </h1>

            <p class="text-muted">

                Bem-vindo ao HealthSystem.
                O que você deseja fazer?

            </p>

        </div>


        <br>


        <!-- OPÇÕES PRINCIPAIS -->

        <div class="row g-4">


            <!-- AGENDAR CONSULTA -->

            <div class="col-md-4">

                <div
                    class="card shadow dashboard-card bg-primary text-white"
                >

                    <div
                        class="card-body text-center d-flex flex-column justify-content-center"
                    >

                        <div
                            class="icon-circle bg-white text-primary"
                        >

                            <i class="fas fa-calendar-plus fa-2x"></i>

                        </div>


                        <h4>
                            Agendar Consulta
                        </h4>


                        <p>

                            Agende uma consulta
                            com um profissional.

                        </p>


                        <a
                            href="agendar_consulta.php"
                            class="btn btn-light mt-auto"
                        >

                            <i class="fas fa-calendar-check"></i>

                            Agendar Consulta

                        </a>

                    </div>

                </div>

            </div>


            <!-- CLASSIFICAÇÕES -->

            <div class="col-md-4">

                <div
                    class="card shadow dashboard-card bg-success text-white"
                >

                    <div
                        class="card-body text-center d-flex flex-column justify-content-center"
                    >

                        <div
                            class="icon-circle bg-white text-success"
                        >

                            <i class="fas fa-list-check fa-2x"></i>

                        </div>


                        <h4>
                            Classificações
                        </h4>


                        <p>

                            Consulte as classificações
                            de atendimento.

                        </p>


                        <a
                            href="cores.php"
                            class="btn btn-light mt-auto"
                        >

                            <i class="fas fa-circle-info"></i>

                            Ver Classificações

                        </a>

                    </div>

                </div>

            </div>


            <!-- LOGOUT -->

            <div class="col-md-4">

                <div
                    class="card shadow dashboard-card bg-danger text-white"
                >

                    <div
                        class="card-body text-center d-flex flex-column justify-content-center"
                    >

                        <div
                            class="icon-circle bg-white text-danger"
                        >

                            <i class="fas fa-right-from-bracket fa-2x"></i>

                        </div>


                        <h4>
                            Logout
                        </h4>


                        <p>

                            Encerrar sua sessão
                            no sistema.

                        </p>


                        <a
                            href="logout.php"
                            class="btn btn-light mt-auto"
                        >

                            <i class="fas fa-right-from-bracket"></i>

                            Logout

                        </a>

                    </div>

                </div>

            </div>


        </div>


        <!-- INFORMAÇÕES HOSPITALARES -->

        <div class="card shadow mt-5">

            <div class="card-header bg-white">

                <h5 class="mb-0 text-primary">

                    <i class="fas fa-hospital"></i>

                    Informações

                </h5>

            </div>


            <div class="card-body">

                <p class="text-muted">

                    O atendimento hospitalar é fundamental para garantir
                    que os pacientes recebam cuidados adequados, seguros
                    e de qualidade. Por meio de profissionais capacitados,
                    exames, medicamentos e acompanhamento médico, o hospital
                    oferece suporte para o diagnóstico, tratamento e
                    recuperação de diferentes condições de saúde.

                </p>


                <p class="mb-0 text-muted">

                    Além do tratamento, o ambiente hospitalar também
                    contribui para a prevenção de complicações e para o
                    acompanhamento da evolução do paciente. A integração
                    entre os profissionais e o uso correto das informações
                    de saúde permitem um atendimento mais organizado,
                    eficiente e humanizado, buscando sempre o bem-estar
                    e a recuperação do paciente.

                </p>

            </div>

        </div>


    </div>


    <!-- BOOTSTRAP JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>


</body>

</html>